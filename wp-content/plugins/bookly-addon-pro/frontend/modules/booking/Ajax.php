<?php
namespace BooklyPro\Frontend\Modules\Booking;

use Bookly\Frontend\Components\Booking\InfoText;
use Bookly\Frontend\Modules\Booking\Lib\Steps;
use Bookly\Lib as BooklyLib;
use Bookly\Lib\Config;
use Bookly\Lib\Entities\Payment;
use Bookly\Lib\UserBookingData;
use Bookly\Frontend\Modules\Booking\Lib\Errors;
use BooklyPro\Lib\Bbb\BigBlueButton;
use BooklyPro\Lib\Payment\PayPal;
use BooklyPro\Lib\Entities\GiftCard;

/**
 * Class Ajax
 * @package BooklyPro\Frontend\Modules\Booking
 */
class Ajax extends BooklyLib\Base\Ajax
{
    /**
     * @inheritDoc
     */
    protected static function permissions()
    {
        return array( '_default' => 'anonymous' );
    }

    /**
     * Apply tips
     */
    public static function applyTips()
    {
        $userData = new UserBookingData( self::parameter( 'form_id' ) );

        if ( $userData->load() && get_option( 'bookly_app_show_tips' ) ) {

            $tips = self::parameter( 'tips' );
            if ( $tips >= 0 ) {
                $userData->setTips( $tips );
                $response = array( 'success' => true );
            } else {
                $response = array(
                    'success' => false,
                    'error' => BooklyLib\Utils\Common::getTranslatedOption( 'bookly_l10n_tips_error' ),
                );
            }
            $userData->sessionSave();

            // Output JSON response.
            wp_send_json( $response );
        }

        Errors::sendSessionError();
    }

    /**
     * Save cart items as pending appointments.
     */
    public static function savePendingAppointment()
    {
        if ( ( Config::payuLatamActive() && get_option( 'bookly_payu_latam_enabled' ) ) || get_option( 'bookly_paypal_enabled' ) == PayPal::TYPE_PAYMENTS_STANDARD ) {
            $userData = new UserBookingData( self::parameter( 'form_id' ) );
            if ( $userData->load() ) {
                $failed_cart_key = $userData->cart->getFailedKey();
                if ( $failed_cart_key === null ) {
                    $coupon = $userData->getCoupon();
                    if ( $coupon ) {
                        $coupon->claim();
                        $coupon->save();
                    }
                    $payment = new Payment();
                    $cart_info = $userData->cart->getInfo( self::parameter( 'payment_type' ) );
                    switch ( self::parameter( 'payment_type' ) ) {
                        case  Payment::TYPE_PAYPAL:
                            $cart_info->setGatewayTaxCalculationRule( 'tax_increases_the_cost' );
                            break;
                        case  Payment::TYPE_PAYULATAM:
                            $cart_info->setGatewayTaxCalculationRule( 'tax_in_the_price' );
                            break;
                    }

                    $payment
                        ->setType( self::parameter( 'payment_type' ) )
                        ->setStatus( Payment::STATUS_PENDING )
                        ->setCartInfo( $cart_info )
                        ->save();
                    $payment_id = $payment->getId();
                    $order = $userData->save( $payment );
                    $payment->setDetailsFromOrder( $order, $cart_info )->save();
                    $response = array(
                        'success' => true,
                        'payment_id' => $payment_id,
                    );
                } else {
                    $response = array(
                        'success' => false,
                        'failed_cart_key' => $failed_cart_key,
                        'error' => Errors::CART_ITEM_NOT_AVAILABLE,
                    );
                }

                $userData->sessionSave();

                wp_send_json( $response );
            }

            Errors::sendSessionError();
        }

        wp_send_json( array( 'success' => false, 'error' => Errors::INVALID_GATEWAY ) );
    }

    /**
     * Log in with Facebook.
     */
    public static function facebookLogin()
    {
        if ( get_current_user_id() ) {
            // Do nothing for logged in users.
            wp_send_json( array( 'success' => false, 'error' => Errors::ALREADY_LOGGED_IN ) );
        }

        $facebook_id = self::parameter( 'id' );

        $userData = new BooklyLib\UserBookingData( self::parameter( 'form_id' ) );

        if ( $userData->load() ) {
            $customer = new BooklyLib\Entities\Customer();
            if ( $customer->loadBy( array( 'facebook_id' => $facebook_id ) ) ) {
                $user_info = array(
                    'email' => $customer->getEmail(),
                    'full_name' => $customer->getFullName(),
                    'first_name' => $customer->getFirstName(),
                    'last_name' => $customer->getLastName(),
                    'phone' => $customer->getPhone(),
                    'country' => $customer->getCountry(),
                    'state' => $customer->getState(),
                    'postcode' => $customer->getPostcode(),
                    'city' => $customer->getCity(),
                    'street' => $customer->getStreet(),
                    'street_number' => $customer->getStreetNumber(),
                    'additional_address' => $customer->getAdditionalAddress(),
                    'birthday' => $customer->getBirthday(),
                    'info_fields' => json_decode( $customer->getInfoFields() ),
                );
            } else {
                $user_info = array(
                    'email' => self::parameter( 'email' ),
                    'full_name' => self::parameter( 'name' ),
                    'first_name' => self::parameter( 'first_name' ),
                    'last_name' => self::parameter( 'last_name' ),
                );
            }
            $userData->fillData( $user_info + array( 'facebook_id' => $facebook_id ) );
            $response = array(
                'success' => true,
                'data' => $user_info,
            );
            $userData->sessionSave();

            // Output JSON response.
            wp_send_json( $response );
        }

        Errors::sendSessionError();
    }

    /**
     * Cancel appointments using token.
     */
    public static function cancelAppointments()
    {
        $token = self::parameter( 'token' );
        $succeed = false;
        if ( $token !== null ) {
            $customer_appointments = BooklyLib\Entities\CustomerAppointment::query( 'ca' )
                ->leftJoin( 'Order', 'o', 'o.id = ca.order_id' )
                ->where( 'o.token', $token )
                ->find();

            /** @var BooklyLib\Entities\CustomerAppointment $customer_appointment */
            foreach ( $customer_appointments as $customer_appointment ) {
                if ( $customer_appointment->cancelAllowed() ) {
                    $customer_appointment->cancel();
                    $succeed = true;
                }
            }
        }

        BooklyLib\Utils\Common::cancelAppointmentRedirect( $succeed );
    }

    /**
     * Create BigBlueButton online meeting
     *
     * @return void
     */
    public static function bbb()
    {
        $meeting_id = self::parameter( 'meeting_id' );
        $token = self::parameter( 'token' );
        $errors = array();
        if ( $meeting_id ) {
            $row = BooklyLib\Entities\Appointment::query( 'a' )
                ->select( 'a.online_meeting_data, st.full_name AS moderator_name, s.title AS service_name' )
                ->leftJoin( 'Staff', 'st', 'st.id = a.staff_id' )
                ->leftJoin( 'Service', 's', 's.id = a.service_id' )
                ->where( 'a.online_meeting_provider', 'bbb' )
                ->where( 'a.online_meeting_id', $meeting_id )
                ->fetchRow();
            if ( $row ) {
                $data = json_decode( $row['online_meeting_data'], true );
                $moderator_pw = isset( $data['staff_pw'] ) ? $data['staff_pw'] : '';
                $attendee_pw = isset( $data['client_pw'] ) ? $data['client_pw'] : '';
                $bbb = new BigBlueButton( $meeting_id );
                if ( $bbb->create( $row['service_name'], $moderator_pw, $attendee_pw ) ) {
                    if ( $token == $moderator_pw ) {
                        // Staff
                        $name = $row['moderator_name'];
                        $password = $moderator_pw;
                    } else {
                        // Client
                        /** @var BooklyLib\Entities\Customer $customer */
                        $customer = BooklyLib\Entities\Customer::query()
                            ->where( 'email', self::parameter( 'email' ) )
                            ->findOne();
                        $name = $customer ? $customer->getFullName() : 'User-' . mt_rand( 100, 999 );
                        $password = $attendee_pw;
                    }

                    $url = $bbb->getJoinMeetingRedirectUrl( $name, $password );
                    wp_redirect( $url );
                    BooklyLib\Utils\Common::redirect( $url );
                    exit;
                } else {
                    $errors = $bbb->errors();
                }
            } else {
                $errors[] = __( 'Invalid online meeting url', 'bookly' );
            }
        } else {
            $errors[] = __( 'Invalid online meeting url', 'bookly' );
        }

        echo implode( '<br>', $errors );
        exit;
    }

    /**
     * @return void
     */
    public static function applyGiftCard()
    {
        $userData = new BooklyLib\UserBookingData( self::parameter( 'form_id' ) );

        if ( $userData->load() ) {
            if ( Config::giftEnabled() ) {
                $gift_code = self::parameter( 'gift_card' );
                $gift_card = new GiftCard();
                $gift_card->loadBy( array(
                    'code' => $gift_code,
                ) );

                $error = BooklyLib\Utils\Common::getTranslatedOption( 'bookly_l10n_cloud_gift_error_invalid' );
                // Check usage.
                if ( $gift_card->isLoaded() ) {
                    // Check start date.
                    if ( $gift_card->started() ) {
                        // Check end date.
                        if ( $gift_card->expired() ) {
                            $error = BooklyLib\Utils\Common::getTranslatedOption( 'bookly_l10n_cloud_gift_error_expired' );
                        } else {
                            $cart_info = $userData->cart->getInfo( BooklyLib\Entities\Payment::TYPE_CLOUD_GIFT, true );
                            if ( $gift_card->getBalance() >= $cart_info->getPayNow() ) {
                                // Check customer.
                                $customer = $userData->getCustomer();
                                if ( ( ! $customer->isLoaded() ) || $gift_card->validForCustomer( $customer ) ) {
                                    // Check cart.
                                    if ( $gift_card->validForCart( $userData->cart ) ) {
                                        // Gift is valid.
                                        $userData->setGiftCode( $gift_code );
                                        $error = null;
                                    }
                                }
                            } else {
                                $error = BooklyLib\Utils\Common::getTranslatedOption( 'bookly_l10n_cloud_gift_error_low_balance' );
                            }
                        }
                    }
                } else {
                    $error = BooklyLib\Utils\Common::getTranslatedOption( 'bookly_l10n_cloud_gift_error_not_found' );
                }
            } else {
                $error = BooklyLib\Utils\Common::getTranslatedOption( 'bookly_l10n_cloud_gift_error_invalid' );
            }

            if ( $error === null ) {
                $userData->sessionSave();
                wp_send_json_success();
            } else {
                // Gift card is invalid.
                $userData->setGiftCode( null );
                $userData->sessionSave();

                // Output JSON response.
                wp_send_json( array(
                    'success' => false,
                    'error' => $error,
                    'text' => InfoText::prepare( Steps::PAYMENT, '', $userData ),
                ) );
            }
        }

        Errors::sendSessionError();
    }

    /**
     * Override parent method to exclude actions from CSRF token verification.
     *
     * @param string $action
     * @return bool
     */
    protected static function csrfTokenValid( $action = null )
    {
        $excluded_actions = array(
            'cancelAppointments',
            'bbb',
        );

        return in_array( $action, $excluded_actions ) || parent::csrfTokenValid( $action );
    }
}