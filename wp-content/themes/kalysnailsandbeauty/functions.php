<?php

function kalys_supports () {
    add_theme_support('title-tag');
}
function kalys_register_assets () {
    wp_register_style('sass', get_stylesheet_uri(), 'assests/sass/style.scss');
    wp_enqueue_style('sass');
}
add_action('after_setup_theme', 'kalys_supports');
add_action('wp_enqueue_scripts', 'kalys_register_assets');