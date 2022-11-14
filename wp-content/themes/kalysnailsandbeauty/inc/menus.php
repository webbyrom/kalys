<?php

/***
 * déclaration du et autorisation du menu de navigation principal (header)
 */
add_action('after_setup_theme', function (){
    register_nav_menu('header', __('Menu principal', 'kalys'));
});


/***
 * création de la navigation au niveau du footer via un widget
 *
 */
add_action('widgets_init', function (){
    register_sidebar([
        'id'    => 'footer-nav',
        'name'  => __('Footer_nav', 'kalys'),
        'before_title' => '<div class="footer-title">',
        'after_title' => '</div>',
        'before_widget' => '<div class="footer_col">',
        'afer_widget'   => '</div'
    ]);
});