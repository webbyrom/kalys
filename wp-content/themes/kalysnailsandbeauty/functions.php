<?php

function kalys_supports()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    register_nav_menu('header', 'menu header');
    register_nav_menu('footer', 'menu footer');

    add_image_size('card-header-post', 350, 215, true);

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
function kalys_title_separator($title) {
    return '|';
}
function kalys_menu_class ($classes) {
    $classes[] = 'nav-item';
    return $classes;

}
function kalys_menu_link_class($attrs) {
    $attrs['class'] = 'nav-link';
    return $attrs;

}
function kalys_pagination() {
    $pages = paginate_links(['type' => 'array']);
    if ($pages === null) {
        return;
    }
    echo '<nav aria-label="Pagination" class="my-4>';
    echo '<ul class="pagination">';
    foreach($pages as $page){
        $active = strpos($page,'current') !== false;
        $class = 'page-item';
        if ($active) {
            $class .= ' active';
        }
        echo'<li class="' . $class . '">';
        echo str_replace('page-numbers', 'page-link', $page);
        echo '</li>';
    }
    echo '</ul>';
    echo '</nav>';
}
add_action('after_setup_theme', 'kalys_supports');
add_action('wp_enqueue_scripts', 'kalys_register_assets');
add_filter('wp_title', 'kalys_title');
add_filter('document_title_separator', 'kalys_title_separator');
add_filter('nav_menu_css_class', 'kalys_menu_class');
add_filter('nav_menu_link_attributes', 'kalys_menu_link_class');

require_once('metaboxes/sponso.php');
SponsoMetaBox::register();