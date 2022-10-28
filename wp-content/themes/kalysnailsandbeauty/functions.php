<?php

function kalys_supports()
{
    add_theme_support('title-tag');
}
function kalys_register_assets()
{
    wp_register_style('css', get_template_directory_uri() . '/style.css');
    wp_register_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css');
    wp_register_style('Font-kalys', 'https://use.typekit.net/fli7ejo.css');
    wp_register_script('popper', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js', [], false, true);
    wp_register_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.js', ['popper', 'jquery'], false, true);
    wp_enqueue_style('css');
    wp_enqueue_style('bootstrap');
    wp_enqueue_style('Font-kalys');
    wp_enqueue_script('bootstrap');
}
function kalys_title($title)
{
    return $title .= get_bloginfo('name', 'description');
}
add_action('after_setup_theme', 'kalys_supports');
add_action('wp_enqueue_scripts', 'kalys_register_assets');
add_filter('wp_title', 'kalys_title');
