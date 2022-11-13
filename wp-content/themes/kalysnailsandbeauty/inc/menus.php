<?php
add_action('after_setup_theme', function (){
    register_nav_menu('header', __('Menu principal', 'kalys'));
});