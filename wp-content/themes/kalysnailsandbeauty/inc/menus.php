<?php

/***
 * déclaration du et autorisation du menu de navigation principal (header)
 */
/*
add_action('after_setup_theme', function (){
    register_nav_menus([
        'header'=> esc_html__('Menu principal', 'kalys'),
        'footer'=> esc_html__('Menu footer', 'kalys')
    ]);
});


/****
 * Menu principale(ne pas oublier de le remplacer dans le header )
 */
if (!function_exists('kalys_register_menu')) {
    function kalys_register_menu()
    {
        register_nav_menus([
            'primary'   =>  esc_html('Menu Principal', 'kalys'),
            'footer'    =>  esc_html('Menu Footer')
        ]);
    }
    add_action('init', 'kalys_register_menu');
}
if (! function_exists('kalys_primary_nav')) {
    function kalys_primary_nav() {
        wp_nav_menu([
            'theme_location'    => 'primary',
            'sort_column'   =>  'menu_order',
            'container'     =>  false,
            'menu_class'    =>  'kalys_primary_nav nav_menu',
            'menu_id'       =>  'kalys_primary_nav nav_menu',
            'echo'          => true,
			'show_home'		=> true,
            'before'        => '',
            'after'         => '',
            'link_before'   =>  '<span>',
            'link_after'    => '</span>',
            'item_wrap'     =>  '<ul id="%1$s class="%2$s">%3$s</ul>',
            'item_spacing'  =>  'preserve',
            'depth'         => 0,
            'walker'        => '',

        ]);
    }
}
/******
 * add active link custom class
 */
add_filter('nav_menu_css_class', 'kalys_add_active_class', 10, 2);

function kalys_add_active_class($classes, $item){

    if ( $item->menu_item_parent == 0 &&
    in_array('current-menu-item', $classes) ||
    in_array('current-menu-ancestor', $classes) ||
    in_array('current-menu-parent', $classes) ||
    in_array('current_page_parent', $classes) ||
    in_array('current_page_ancestor', $classes)) {
        $classes[] = 'kalys_m_active';
    }
    return $classes;
}


/***a modifier*******************************************************************kalys_get_post_views */



/* création de la navigation au niveau du footer via un widget
 *
 */
require_once('widgets/social.php');

add_action('widgets_init', function () {
    register_widget(Kalys_Social_Widget::class);
    register_sidebar([
        'id'    => 'footer-nav',
        'name'  => __('Footer_nav', 'kalys'),
        'before_title' => '<div class="footer-title">',
        'after_title'    => '</div>',
        'before_widget' => '<div class="footer_col">',
        'after_widget'   => '</div>'
    ]);
    register_sidebar([
        'id'    => 'blog',
        'name'  => __('Blog sidebar', 'kalys'),
        'before_title' => '<div class="sidebar_title">',
        'after_title'    => '</div>',
        'before_widget' => '<div class="sidebar_widget">',
        'after_widget'   => '</div>'
    ]);
});
