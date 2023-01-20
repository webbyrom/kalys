<?php
namespace BooklyPro\Lib\Notifications\NewGiftCard;

use Bookly\Lib\Entities\Customer;
use Bookly\Lib\Entities\Staff;
use Bookly\Lib\Notifications\Base;
use BooklyPro\Lib\Entities\GiftCard;
use BooklyPro\Lib\Notifications\Assets\NewGiftCard;

/**
 * Class Sender
 * @package BooklyPro\Lib\Notifications\NewGiftCard
 */
abstract class Sender extends Base\Sender
{
    /**
     * Send notification abount new gift card.
     *
     * @param GiftCard $gift_card
     */
    public static function send( GiftCard $gift_card )
    {
        $codes = new NewGiftCard\Client\Codes( $gift_card );
        $notifications = static::getNotifications( 'new_gift_card' );
        $customer = Customer::find( $gift_card->getCustomerId() );
        if ( $customer ) {
            foreach ( $notifications['client'] as $notification ) {
                static::sendToClient( $customer, $notification, $codes );
            }
        }

        if ( $notifications['staff'] ) {
            $staff_list = Staff::query( 's' )
                ->leftJoin( 'GiftCardStaff', 'gcs', 'gcs.staff_id = s.id', 'BooklyPro\Lib\Entities' )
                ->where( 'gcs.gift_card_id', $gift_card->getId() )
                ->find();
            foreach ( $notifications['staff'] as $notification ) {
                foreach ( $staff_list as $staff ) {
                    static::sendToStaff( $staff, $notification, $codes );
                }
                static::sendToAdmins( $notification, $codes );
                static::sendToCustom( $notification, $codes );
            }
        }

    }
}