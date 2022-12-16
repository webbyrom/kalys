<?php
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('css', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('kalys_bootstrap_style', get_template_directory_uri() . '/assets/css/bootstrap.css');
    wp_enqueue_script('kalys_bootstrap_script', get_template_directory_uri() . '/assets/js/bootstrap.js', [], false, true);
    wp_enqueue_script('kalys_menu_sticky', get_template_directory_uri() .'/assets/js/kalys.js/sticky-menu.js', [], false, true);
});