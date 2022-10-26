<?php

function kalys_supports()
{
    add_theme_support('title-tag');
}
function kalys_register_assets()
{
    wp_register_style('css', get_template_directory_uri() . '/style.css');
    wp_register_style('bootstrap', get_template_directory_uri() . './assets/css/bootstrap.css');
    wp_register_script('bootstrap', get_template_directory_uri() . '/assets/js');
    wp_enqueue_style('css');
    wp_enqueue_style('bootstrap');
}
add_action('after_setup_theme', 'kalys_supports');
add_action('wp_enqueue_scripts', 'kalys_register_assets');
