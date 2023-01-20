<?php
namespace BooklyPro\Frontend\Modules\WooCommerce;

use Bookly\Frontend\Modules\Booking\Lib\Errors;
use Bookly\Frontend\Modules\Booking\Proxy;
use Bookly\Lib as BooklyLib;

/**
 * Class Controller
 * @package BooklyPro\Frontend\Modules\WooCommerce
 */
class Controller extends BooklyLib\Base\Ajax
{
    /**
     * Event data structure.
     *
     * @since bookly-addon-pro v1.0
     *
     * @version 1.1
     *  add key 'wc_checkout' with values 'billing_country', 'billing_address_1', 'billing_address_2', 'billing_city', 'billing_state', 'billing_postcode', 'billing_first_name', 'billing_last_name', 'billing_email', 'billing_phone'
     */
    const VERSION = '1.1';

    protected static $checkout_info = array();

    /**
     * @inheritDoc
     */
    public static function init()
    {
        $wc_loaded = class_exists( 'WooCommerce', false );
        // Register hooks when WooCommerce class loaded.
        // To protect against themes which call WooCommerce hooks when WC not used.
        if ( $wc_loaded && get_option( 'bookly_wc_enabled' ) ) {
            /** @var self $self */
            $self = get_called_class();
            add_action( 'woocommerce_check_cart_items', array( $self, 'checkAvailableTimeForCart' ), 10, 0 );
            add_action( 'woocommerce_checkout_create_order_line_item', array( $self, 'createOrderLineItem' ), 10, 4 );
            add_action( 'woocommerce_after_order_itemmeta', array( $self, 'orderItemMeta' ), 11, 1 );
            add_action( 'woocommerce_before_calculate_totals', array( $self, 'beforeCalculateTotals' ), 10, 1 );
            add_action( 'woocommerce_order_item_meta_end', array( $self, 'orderItemMeta' ), 10, 1 );
            add_action( 'woocommerce_order_status_cancelled', array( $self, 'cancelOrder' ), 10, 1 );
            add_action( 'woocommerce_order_status_completed', array( $self, 'paymentComplete' ), 100, 1 );
            add_action( 'woocommerce_order_status_on-hold', array( $self, 'paymentComplete' ), 100, 1 );
            add_action( 'woocommerce_order_status_processing', array( $self, 'paymentComplete' ), 100, 1 );
            add_action( 'woocommerce_order_status_refunded', array( $self, 'cancelOrder' ), 10, 1 );
            add_action( 'woocommerce_after_calculate_totals', array( $self, 'afterCalculateTotals' ), 10, 1 );

            add_filter( 'woocommerce_checkout_get_value', array( $self, 'checkoutValue' ), 10, 2 );
            add_filter( 'woocommerce_get_item_data', array( $self, 'getItemData' ), 10, 2 );
            add_filter( 'woocommerce_quantity_input_args', array( $self, 'quantityArgs' ), 10, 2 );
            add_filter( 'woocommerce_cart_item_price', array( $self, 'getCartItemPrice' ), 10, 3 );
            add_filter( 'woocommerce_calculate_item_totals_taxes', array( $self, 'calculateItemTotalsTaxes' ), 99, 3 );

            parent::init();
        }
    }

    /**
     * Calculate item tax.
     *
     * @param array           $taxes
     * @param \stdClass       $item
     * @param \WC_Cart_Totals $wc_cart_totals
     * @return array
     */
    public static function calculateItemTotalsTaxes( $taxes, $item, $wc_cart_totals )
    {
        if ( property_exists( $item, 'object' )
            && array_key_exists( 'bookly', $item->object )
            && BooklyLib\Config::taxesActive()
        ) {
            $userData = new BooklyLib\UserBookingData( null );
            $userData->fillData( $item->object['bookly'] );
            $userData->cart->setItemsData( $item->object['bookly']['items'] );
            $info = $userData->cart->getInfo();
            $tax_rates_id = 1;
            if ( ! empty( $taxes ) ) {
                $tax_rates_id = key( $taxes );
            }

            return array( $tax_rates_id => $info->getTotalTax() * 100 );
        }

        return $taxes;
    }

    /**
     * Verifies the availability of all appointments that are in the cart
     */
    public static function checkAvailableTimeForCart()
    {
        $recalculate_totals = false;
        foreach ( WC()->cart->get_cart() as $wc_key => $wc_item ) {
            if ( array_key_exists( 'bookly', $wc_item ) ) {
                if ( self::_migration( $wc_key, $wc_item ) === false ) {
                    // Removed item from cart.
                    continue;
                }
                $userData = new BooklyLib\UserBookingData( null );
                $userData->fillData( $wc_item['bookly'] );
                $userData->cart->setItemsData( $wc_item['bookly']['items'] );
                if ( self::checkIfServiceIsProvided( $userData ) ) {
                    if ( $wc_item['quantity'] > 1 ) {
                        foreach ( $userData->cart->getItems() as $cart_item ) {
                            // Equal appointments increase quantity
                            $cart_item->setNumberOfPersons( $cart_item->getNumberOfPersons() * $wc_item['quantity'] );
                        }
                    }
                    // Check if appointment's time is still available
                    $failed_cart_key = $userData->cart->getFailedKey();
                    if ( $failed_cart_key !== null ) {
                        $cart_item = $userData->cart->get( $failed_cart_key );
                        $slot      = $cart_item->getSlots();
                        wc_add_notice( strtr( __( 'Sorry, the time slot %date_time% for %service% has been already occupied.', 'bookly' ),
                            array(
                                '%service%'   => '<strong>' . $cart_item->getService()->getTranslatedTitle() . '</strong>',
                                '%date_time%' => BooklyLib\Utils\DateTime::formatDateTime( $slot[0][2] ),
                            ) ), 'error' );
                        WC()->cart->set_quantity( $wc_key, 0, false );
                        $recalculate_totals = true;
                    } else {
                        $now = BooklyLib\Slots\DatePoint::now();
                        foreach ( $userData->cart->getItems() as $cart_item ) {
                            $slot = $cart_item->getSlots();
                            if ( $now->gte( BooklyLib\Slots\DatePoint::fromStr( $slot[0][2] )->modify( - BooklyLib\Proxy\Pro::getMinimumTimePriorBooking( $cart_item->getServiceId() ) ) ) ) {
                                wc_add_notice( strtr( __( 'The selected slot for service {service_name} at {appointment_time} is not available anymore. Please select another time slot or contact the service provider', 'bookly' ),
                                    array(
                                        '{service_name}' => '<strong>' . $cart_item->getService()->getTranslatedTitle() . '</strong>',
                                        '{appointment_time}' => BooklyLib\Utils\DateTime::formatDateTime( $slot[0][2] ),
                                    ) ), 'error' );
                                WC()->cart->set_quantity( $wc_key, 0, false );
                                $recalculate_totals = true;
                                break;
                            }
                        }
                    }
                } else {
                    wc_add_notice( __( 'This service is no longer provided.', 'bookly' ), 'error' );
                    WC()->cart->set_quantity( $wc_key, 0, false );
                    $recalculate_totals = true;
                }
            }
        }
        if ( $recalculate_totals ) {
            WC()->cart->calculate_totals();
        }
    }

    /**
     * Set subtotal and subtotal_tax for bookly items.
     *
     * @param \WC_Cart $cart_object
     */
    public static function afterCalculateTotals( $cart_object )
    {
        if ( BooklyLib\Config::taxesActive() ) {
            foreach ( $cart_object->cart_contents as $wc_key => &$wc_item ) {
                if ( isset ( $wc_item['bookly'] ) ) {
                    $wc_item['line_subtotal']     = $wc_item['line_total'];
                    $wc_item['line_subtotal_tax'] = $wc_item['line_tax'];
                }
            }
        }
    }

    /**
     * Assign checkout value from appointment.
     *
     * @param $null
     * @param $field_name
     * @return string|null
     */
    public static function checkoutValue( $null, $field_name )
    {
        if ( empty( self::$checkout_info ) && class_exists( 'WooCommerce', false ) && ! is_null( WC()->cart ) ) {
            foreach ( WC()->cart->get_cart() as $wc_key => $wc_item ) {
                if ( array_key_exists( 'bookly', $wc_item ) ) {
                    foreach ( $wc_item['bookly']['wc_checkout'] as $key => $value ) {
                        if ( $value != '' ) {
                            self::$checkout_info[ $key ] = $value;
                        }
                    }
                    break;
                }
            }
        }
        if ( array_key_exists( $field_name, self::$checkout_info ) ) {
            return self::$checkout_info[ $field_name ];
        }

        return $null;
    }

    /**
     * Do bookings after checkout.
     *
     * @param string $order_id
     */
    public static function paymentComplete( $order_id )
    {
        $transient_name = 'bookly_wc_lock_order_id_' . $order_id;
        $lock = (int) get_transient( $transient_name );
        if ( $lock + 30 < time() ) {
            set_transient( $transient_name, time(), 30 );

            $wc_order = new \WC_Order( $order_id );
            $address = array(
                // WC address | Bookly Customer address
                'country' => 'country',
                'state' => 'state',
                'city' => 'city',
                'address_1' => 'street',
                'address_2' => 'additional_address',
                'postcode' => 'postcode',
            );
            /** @var \WC_Countries $countries */
            $countries = WC()->countries;

            foreach ( $wc_order->get_items() as $item_id => $order_item ) {
                $data = wc_get_order_item_meta( $item_id, 'bookly' );
                if ( $data && ! isset ( $data['processed'] ) ) {
                    $userData = new BooklyLib\UserBookingData( null );
                    foreach ( $address as $wc_part => $bookly_part ) {
                        $method_name = 'get_billing_' . $wc_part;
                        if ( method_exists( $wc_order, $method_name ) ) {
                            // WC checkout address
                            $value = $wc_order->$method_name();
                            if ( $wc_part == 'country' ) {
                                $value = isset( $countries->countries[ $value ] )
                                    ? $countries->countries[ $value ]
                                    : $value;
                            } elseif ( $wc_part == 'state' ) {
                                $country_code = $wc_order->get_billing_country();
                                $value = isset( $countries->states[ $country_code ][ $value ] )
                                    ? $countries->states[ $country_code ][ $value ]
                                    : $value;
                            }
                            $data[ $bookly_part ] = $value;
                        }
                    }
                    $data['street_number'] = '';
                    $userData->fillData( $data );
                    $userData->cart->setItemsData( $data['items'] );
                    if ( $order_item['qty'] > 1 ) {
                        foreach ( $userData->cart->getItems() as $cart_item ) {
                            $cart_item->setNumberOfPersons( $cart_item->getNumberOfPersons() * $order_item['qty'] );
                        }
                    }
                    $cart_info = $userData->cart->getInfo();
                    $payment = new BooklyLib\Entities\Payment();
                    $payment
                        ->setType( BooklyLib\Entities\Payment::TYPE_WOOCOMMERCE )
                        ->setStatus( BooklyLib\Entities\Payment::STATUS_COMPLETED )
                        ->setCartInfo( $cart_info )
                        ->save();
                    $order = $userData->save( $payment );
                    $payment->setDetailsFromOrder( $order, $cart_info, array( 'reference_id' => $order_id ) )->save();
                    if ( get_option( 'bookly_cst_create_account' ) && $order->getCustomer()->getWpUserId() ) {
                        update_post_meta( $order_id, '_customer_user', $order->getCustomer()->getWpUserId() );
                    }
                    // Mark item as processed.
                    $data['processed'] = true;
                    $data['ca_ids'] = array();
                    foreach ( $order->getFlatItems() as $item ) {
                        $data['ca_ids'][] = $item->getCA()->getId();
                    }
                    wc_update_order_item_meta( $item_id, 'bookly', $data );
                    current( $order->getItems() )->getCA()->setJustCreated( true );
                    BooklyLib\Notifications\Cart\Sender::send( $order );
                }
            }
        }
    }

    /**
     * Cancel appointments on WC order cancelled.
     *
     * @param string $order_id
     */
    public static function cancelOrder( $order_id )
    {
        $order = new \WC_Order( $order_id );
        foreach ( $order->get_items() as $item_id => $order_item ) {
            $data = wc_get_order_item_meta( $item_id, 'bookly' );
            if ( isset ( $data['processed'], $data['ca_ids'] ) && $data['processed'] ) {
                /** @var BooklyLib\Entities\CustomerAppointment[] $ca_list */
                $ca_list = BooklyLib\Entities\CustomerAppointment::query()->whereIn( 'id', $data['ca_ids'] )->find();
                foreach ( $ca_list as $ca ) {
                    $ca->cancel();
                }
                $data['ca_ids'] = array();
                wc_update_order_item_meta( $item_id, 'bookly', $data );
            }
        }
    }

    /**
     * Change attr for WC quantity input
     *
     * @param array       $args
     * @param \WC_Product $product
     * @return array
     */
    public static function quantityArgs( $args, $product )
    {
        $wc_product_ids = self::getFromCache( 'wc_product_ids', null );
        if ( $wc_product_ids === null ) {
            $wc_product_ids = BooklyLib\Entities\Service::query()
                ->whereNot( 'wc_product_id', 0 )
                ->fetchCol( 'DISTINCT(wc_product_id)' );
            $wc_product_ids[] = get_option( 'bookly_wc_product' );
            self::putInCache( 'wc_product_ids', $wc_product_ids );
        }

        if ( in_array( $product->get_id(), $wc_product_ids ) ) {
            $args['max_value'] = $args['input_value'];
            $args['min_value'] = $args['input_value'];
        }

        return $args;
    }

    /**
     * Change item price in cart.
     *
     * @param \WC_Cart $cart_object
     */
    public static function beforeCalculateTotals( $cart_object )
    {
        foreach ( $cart_object->cart_contents as $wc_key => $wc_item ) {
            if ( isset ( $wc_item['bookly'] ) ) {
                $userData = new BooklyLib\UserBookingData( null );
                $userData->fillData( $wc_item['bookly'] );
                $userData->cart->setItemsData( $wc_item['bookly']['items'] );
                $cart_info = $userData->cart->getInfo();
                /** @var \WC_Product $product */
                $product   = $wc_item['data'];
                if ( $product->is_taxable() && BooklyLib\Config::taxesActive() && ! wc_prices_include_tax() ) {
                    $product->set_price( $cart_info->getPayNow() - $cart_info->getPayTax() );
                } else {
                    $product->set_price( $cart_info->getPayNow() );
                }
            }
        }
    }

    /**
     * Update meta data for current product.
     *
     * @param \WC_Order_Item_Product $item
     * @param string $cart_item_key
     * @param array $values
     * @param \WC_Order $order
     */
    public static function createOrderLineItem( $item, $cart_item_key, $values, $order )
    {
        if ( isset ( $values['bookly'] ) ) {
            $item->update_meta_data( 'bookly', $values['bookly'] );
        }
    }

    /**
     * Get item data for cart.
     *
     * @param array $other_data
     * @param $wc_item
     * @return array
     */
    public static function getItemData( $other_data, $wc_item )
    {
        if ( isset ( $wc_item['bookly'] ) ) {
            $userData = new BooklyLib\UserBookingData( null );
            $info = array();
            if ( isset ( $wc_item['bookly']['version'] ) && $wc_item['bookly']['version'] == self::VERSION ) {
                $userData->fillData( $wc_item['bookly'] );
                if ( BooklyLib\Config::useClientTimeZone() ) {
                    $userData->applyTimeZone();
                }
                $userData->cart->setItemsData( $wc_item['bookly']['items'] );
                $cart_info = $userData->cart->getInfo();
                $cart_items = $userData->cart->getItems();
                foreach ( $cart_items as $cart_item ) {
                    $service = $cart_item->getService();
                    $staff = $cart_item->getStaff();
                    $slots = $cart_item->getSlots();
                    $appointment_start_client_dp = $appointment_end_client_dp = null;
                    if ( $slots[0][2] !== null ) {
                        $appointment_start_client_dp = BooklyLib\Slots\DatePoint::fromStr( $slots[0][2] )->toClientTz();
                        if ( $service ) {
                            $appointment_end_client_dp = $appointment_start_client_dp->modify( $cart_item->getUnits() * $service->getDuration() + $cart_item->getExtrasDuration() );
                        }
                    }
                    $category = $service && $service->getCategoryId()
                        ? BooklyLib\Entities\Category::find( $service->getCategoryId() )
                        : false;
                    $codes = array(
                        'amount_due' => BooklyLib\Utils\Price::format( $cart_info->getDue() ),
                        'amount_to_pay' => BooklyLib\Utils\Price::format( $cart_info->getPayNow() ),
                        'appointment_date' => $appointment_start_client_dp ? $appointment_start_client_dp->formatI18nDate() : __( 'N/A', 'bookly' ),
                        'appointment_end_date' => $appointment_end_client_dp ? $appointment_end_client_dp->formatI18nDate() : __( 'N/A', 'bookly' ),
                        'appointment_end_time' => $appointment_end_client_dp ? $appointment_end_client_dp->formatI18nTime() : __( 'N/A', 'bookly' ),
                        'appointment_time' => $appointment_start_client_dp ? $appointment_start_client_dp->formatI18nTime() : __( 'N/A', 'bookly' ),
                        'category_info' => $category ? $category->getTranslatedInfo() : '',
                        'category_name' => $service ? $service->getTranslatedCategoryName() : '',
                        'deposit_value' => BooklyLib\Utils\Price::format( $cart_info->getDepositPay() ),
                        'number_of_persons' => $cart_item->getNumberOfPersons(),
                        'service_info' => $service ? $service->getTranslatedInfo() : '',
                        'service_name' => $service ? $service->getTranslatedTitle() : __( 'Service was not found', 'bookly' ),
                        'service_price' => $service ? BooklyLib\Utils\Price::format( $cart_item->getServicePrice() ) : '',
                        'staff' => $staff,
                        'staff_info' => $staff ? $staff->getTranslatedInfo() : '',
                        'staff_name' => $staff ? $staff->getTranslatedName() : '',
                    );
                    $data = Proxy\Shared::prepareCartItemInfoText(
                        array(
                            'appointments' => array( array() ),
                            'online_meeting_url' => array(),
                            'online_meeting_password' => array(),
                            'online_meeting_join_url' => array(),
                            'staff' => $staff
                        ),
                        $cart_item,
                        $userData
                    );
                    $codes = Proxy\Shared::prepareInfoTextCodes( $codes, $data );
                    $info[] = BooklyLib\Utils\Codes::replace(
                        $service && $service->getWCProductId() > 0
                            ? $service->getTranslatedWCCartInfo()
                            : BooklyLib\Utils\Common::getTranslatedOption( 'bookly_l10n_wc_cart_info_value' )
                        , $codes, false );
                }
            }

            $other_data[] = array(
                'name' => count( $cart_items ) == 1 && $service && $service->getWCProductId() > 0
                    ? $service->getTranslatedWCCartInfoName()
                    : BooklyLib\Utils\Common::getTranslatedOption( 'bookly_l10n_wc_cart_info_name' ),
                'value' => implode( PHP_EOL . PHP_EOL, $info ),
            );
        }

        return $other_data;
    }

    /**
     * Print appointment details inside order items in the backend.
     *
     * @param int $item_id
     */
    public static function orderItemMeta( $item_id )
    {
        $data = wc_get_order_item_meta( $item_id, 'bookly' );
        if ( $data ) {
            $other_data = self::getItemData( array(), array( 'bookly' => $data ) );
            echo '<br/>' . $other_data[0]['name'] . '<br/>' . nl2br( $other_data[0]['value'] );
        }
    }

    /**
     * Get cart item price.
     *
     * @param $product_price
     * @param $wc_item
     * @param $cart_item_key
     * @return string
     */
    public static function getCartItemPrice( $product_price, $wc_item, $cart_item_key )
    {
        if ( isset ( $wc_item['bookly'] ) ) {
            $userData = new BooklyLib\UserBookingData( null );
            $userData->fillData( $wc_item['bookly'] );
            $userData->cart->setItemsData( $wc_item['bookly']['items'] );
            $cart_info = $userData->cart->getInfo();
            if ( 'excl' === get_option( 'woocommerce_tax_display_cart' ) && BooklyLib\Config::taxesActive() ) {
                $product_price = wc_price( $cart_info->getPayNow() - $cart_info->getPayTax() );
            } else {
                $product_price = wc_price( $cart_info->getPayNow() );
            }
        }

        return $product_price;
    }

    /**
     * Check if service can be provided, check if staff or service not deleted
     *
     * @param BooklyLib\UserBookingData $userData
     * @return bool
     */
    protected static function checkIfServiceIsProvided( BooklyLib\UserBookingData $userData )
    {
        foreach ( $userData->cart->getItems() as $cart_item ) {
            if ( $cart_item->getService() === false || $cart_item->getStaff() === false ) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param BooklyLib\UserBookingData $userData
     * @return bool|string|void
     * @throws \Exception
     */
    public static function addToCart( $userData )
    {
        if ( ! get_option( 'bookly_wc_enabled' ) ) {
            exit;
        }

        $session = WC()->session;
        /** @var \WC_Session_Handler $session */
        if ( $session instanceof \WC_Session_Handler && $session->get_session_cookie() === false ) {
            $session->set_customer_session_cookie( true );
        }
        if ( count( $userData->cart->getItems() ) === 0 ) {
            return true;
        } elseif ( $userData->cart->getFailedKey() === null ) {
            $cart_item  = self::_getIntersectedItem( $userData->cart->getItems() );
            if ( $cart_item === null ) {
                if ( get_option( 'bookly_cst_first_last_name' ) ) {
                    $first_name = $userData->getFirstName();
                    $last_name  = $userData->getLastName();
                } else {
                    $full_name  = $userData->getFullName();
                    $first_name = strtok( $full_name, ' ' );
                    $last_name  = strtok( '' );
                }
                $iso = $userData->getAddressIso();
                $bookly = $userData->getData();
                $bookly['version']     = self::VERSION;
                $bookly['items']       = $userData->cart->getItemsData();
                $bookly['wc_checkout'] = array(
                    'billing_first_name' => $first_name,
                    'billing_last_name'  => $last_name,
                    'billing_email'      => $userData->getEmail(),
                    'billing_phone'      => $userData->getPhone(),
                    // Billing country on WC checkout is select (select2)
                    'billing_country'    => isset( $iso['country'] ) ? $iso['country'] : null,
                    'billing_state'      => isset( $iso['state'] )   ? $iso['state'] : null,
                    'billing_city'       => $userData->getCity() ?: null,
                    'billing_address_1'  => $userData->getStreet() ? BooklyLib\Proxy\Pro::getFullAddressByCustomerData( array( 'street' => $userData->getStreet(), 'street_number' => $userData->getStreetNumber() ) ) : null,
                    'billing_address_2'  => $userData->getAdditionalAddress() ?: null,
                    'billing_postcode'   => $userData->getPostcode() ?: null,
                );
                if ( BooklyLib\Config::tasksActive() ) {
                    foreach ( $userData->cart->getItems() as $cart_item ) {
                        $slots = $cart_item->getSlots();
                        if ( $slots[0][2] === null ) {
                            // If identical appointments with no date/time are added to WC cart, WC will increase quantity for such items.
                            // To allow client add more than one task in cart, generate random line.
                            $bookly['wc_checkout']['bookly_random'] = md5( uniqid( time(), true ) );
                            break;
                        }
                    }
                }
                $product_id = get_option( 'bookly_wc_product' );
                $item_data = current( $bookly['items'] );
                $service_id = $item_data['service_id'];
                foreach ( $bookly['items'] as $item ) {
                    if ( $service_id != $item['service_id'] ) {
                        $service_id = null;
                        break;
                    }
                }
                if ( $service_id ) {
                    $product_id = BooklyLib\Entities\Service::query()
                        ->where( 'id', $bookly['items'][0]['service_id'] )->fetchVar( 'wc_product_id' ) ?: $product_id;
                }

                // Qnt 1 product in $userData exists value with number_of_persons
                WC()->cart->add_to_cart( $product_id, 1, '', array(), compact( 'bookly' ) );

                return true;
            } else {
                return Errors::CART_ITEM_NOT_AVAILABLE;
            }
        } else {
            return Errors::CART_ITEM_NOT_AVAILABLE;
        }
    }

    /**
     * Migration deprecated cart items data.
     *
     * @param string $wc_key
     * @param array  $wc_item
     * @return bool
     */
    protected static function _migration( $wc_key, &$wc_item )
    {
        if ( ! isset( $wc_item['bookly']['version'] ) ) {
            // The current implementation only remove cart items with deprecated format.
            WC()->cart->set_quantity( $wc_key, 0, false );
            WC()->cart->calculate_totals();

            return false;
        } else {
            // Version event data structure.
            $version = $wc_item['bookly']['version'];
            if ( $version == self::VERSION ) {
                return true;
            }

            if ( $version == '1.0' ) {
                // add new billing data
                $wc_item['bookly']['wc_checkout'] = array(
                    'billing_first_name' => $wc_item['bookly']['first_name'],
                    'billing_last_name'  => $wc_item['bookly']['last_name'],
                    'billing_email'      => $wc_item['bookly']['email'],
                    'billing_phone'      => $wc_item['bookly']['phone'],
                    'billing_country'    => null,
                    'billing_address_1'  => null,
                    'billing_address_2'  => null,
                    'billing_city'       => null,
                    'billing_state'      => null,
                    'billing_postcode'   => null,
                );
            }

            $wc_item['bookly']['version'] = self::VERSION;

            // Update client cart session.
            WC()->cart->set_session();
        }

        return true;
    }

    /**
     * Find conflicted CartItem with items in WC Cart.
     *
     * Resolved:
     *  number of persons > staff.capacity
     *  Services for some Staff intersected
     *
     * @param BooklyLib\CartItem[] $new_items
     * @return BooklyLib\CartItem
     */
    protected static function _getIntersectedItem( array $new_items )
    {
        /** @var BooklyLib\CartItem[] $wc_items */
        $wc_items  = array();
        $cart_item = new BooklyLib\CartItem();
        foreach ( WC()->cart->get_cart() as $wc_key => $wc_item ) {
            if ( array_key_exists( 'bookly', $wc_item ) ) {
                if ( self::_migration( $wc_key, $wc_item ) === false ) {
                    // Removed item from cart.
                    continue;
                }
                foreach ( $wc_item['bookly']['items'] as $item_data ) {
                    $entity = clone $cart_item;
                    $entity->setData( $item_data );
                    if ( $wc_item['quantity'] > 1 ) {
                        $nop = $item_data['number_of_persons'] *= $wc_item['quantity'];
                        $entity->setNumberOfPersons( $nop );
                    }
                    $wc_items[] = $entity;
                }
            }
        }
        $staff_service = array();
        foreach ( $new_items as $candidate_cart_item ) {
            $candidate_slots = $candidate_cart_item->getSlots();
            if ( $candidate_slots[0][2] === null ) {
                // Appointment with no date/time can't overlap with other appointments
                continue;
            }
            $candidate_staff_id = $candidate_cart_item->getStaff()->getId();
            $candidate_service_id = $candidate_cart_item->getService()->getId();
            foreach ( $wc_items as $wc_cart_item ) {
                $wc_cart_slots = $wc_cart_item->getSlots();
                // $wc_cart_service can be null when service exists in WC cart but removed from Bookly
                $wc_cart_service = $wc_cart_item->getService();
                if ( $wc_cart_service && $wc_cart_item->getStaff() && $candidate_cart_item->getService() ) {
                    if ( $candidate_staff_id == $wc_cart_item->getStaff()->getId() ) {
                        // Equal Staff
                        $candidate_start = date_create( $candidate_slots[0][2] );
                        $candidate_end   = date_create( $candidate_slots[0][2] )->modify( ( $candidate_cart_item->getService()->getDuration() + $candidate_cart_item->getExtrasDuration() ) . ' sec' );
                        $wc_cart_start   = date_create( $wc_cart_slots[0][2] );
                        $wc_cart_end     = date_create( $wc_cart_slots[0][2] )->modify( ( $wc_cart_service->getDuration() + $wc_cart_item->getExtrasDuration() ) . ' sec' );
                        if ( ( $wc_cart_end > $candidate_start ) && ( $candidate_end > $wc_cart_start ) ) {
                            // Services intersected.
                            if ( $candidate_start == $wc_cart_start ) {
                                // Equal Staff/Service/Start
                                if ( ! isset( $staff_service[ $candidate_staff_id ][ $candidate_service_id ] ) ) {
                                    $staff_service[ $candidate_staff_id ][ $candidate_service_id ] = self::_getMaxCapacity( $candidate_staff_id, $candidate_service_id );
                                }
                                $allow_capacity = $staff_service[ $candidate_staff_id ][ $candidate_service_id ];
                                $nop = $candidate_cart_item->getNumberOfPersons() + $wc_cart_item->getNumberOfPersons();
                                if ( $nop > $allow_capacity ) {
                                    // Equal Staff/Service/Start and number_of_persons > capacity
                                    return $candidate_cart_item;
                                }
                            } else {
                                // Intersect Services for some Staff
                                return $candidate_cart_item;
                            }
                        }
                    }
                }
            }
        }

        return null;
    }

    /**
     * Get max capacity.
     *
     * @param int $staff_id
     * @param int $service_id
     * @return int
     */
    private static function _getMaxCapacity( $staff_id, $service_id )
    {
        return BooklyLib\Config::groupBookingActive()
            ? BooklyLib\Entities\StaffService::query()
                ->where( 'staff_id', $staff_id )
                ->where( 'service_id', $service_id )
                ->fetchVar( 'capacity_max' )
            : 1;
    }
}