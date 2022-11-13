<?php
defined('ABSPATH') or die(''); // pour sécuriser la connexion
/****
 * definition de ce que le thème supporte, le titre, les menus, le html5, les thumbnails dans les articles
 * et les images
 */
add_action('after_setup_theme', function (){
    add_theme_support('title-tag');
    add_theme_support('menus');
    add_theme_support('html5');
    add_theme_support('post-thumbnails');
    add_theme_support('post-formats', array ('aside', 'gallery'));
});
/****
 * autorisation pour le dl du format svg
 */

add_filter('upload_mimes', function ($mimes){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});

