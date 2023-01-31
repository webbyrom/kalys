<?php
defined('ABSPATH') or die(''); // pour sécuriser la connexion
/****
 * definition de ce que le thème supporte, le titre, les menus, le html5, les thumbnails dans les articles
 * et les images
 */
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('menus');
    add_theme_support('html5', [
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption',
        'style',
        'script'
    ]);
    add_theme_support('post-thumbnails');
    add_theme_support('post-formats', array(
        'aside',
        'gallery',
        'link',
        'quote',
        'audio',
        'image'
    ));
    
    add_theme_support('custom-header');
    add_theme_support('automatic-fedd-links');
    add_theme_support('wp-block-styles');
    add_theme_support('custom-logo', array(
        'heigth'    =>  100,
        'width'     =>  400,
        'flex-height'   => true,
        'flex-width'    => true,
        'header-text'   => array('site-title', 'site-description'),
    ));
});
/****
 * autorisation pour le dl du format svg
 */

add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});
/****
 * title
 */
function kalys_title($title)
{
    return $title .= get_bloginfo('name', 'description');
}
function kalys_title_separator( $sep)
{
    return '|';
}
add_filter('document_title_separator', 'kalys_title_separator', 10, 1);