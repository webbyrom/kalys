<?php
namespace Bookly\Backend\Components\Dialogs\Whatsapp;

use Bookly\Lib;

/**
 * Class Ajax
 * @package Bookly\Backend\Components\Dialogs\Whatsapp
 */
class Ajax extends Lib\Base\Ajax
{
    public static function getWhatsappTemplates()
    {
        wp_send_json( Lib\Cloud\API::getInstance()->whatsapp->getTemplates() );
    }
}