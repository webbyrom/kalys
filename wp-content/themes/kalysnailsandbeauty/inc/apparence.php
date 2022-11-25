<?php
add_action('customize_register', function (WP_Customize_Manager $manager){
/****
 * Ajout de le section Theme apparence dans le menu personnalisation
 * le double _ devant ('Theme apparence')sert pour la traduction
 *
 */
    $manager->add_section('kalys_logo_apparence', [
        'title' => __('Gestion du  logo')
    ]);
/***
 * sanitize_callback évite que l'utilisateur rentre n'importe quoi
 */
    $manager->add_setting('logo', [
        'sanitize_callback' => 'esc_url_raw'
    ]);

/****
 * créer le petit formulaire au niveau de la personnalisation au niveau du logo
 */
    $manager->add_control(new WP_Customize_Image_Control($manager, 'logo',
    [
        'label' => __('Logo', 'kalys'),
        'section'   => 'kalys_logo_apparence' 
    ]));
});
/*****
 * Création de la personnalisation du header(color picker) du thème
 */
add_action('customize_register', function (WP_Customize_Manager $manager){

    $manager->add_section('kalys_apparence',[
        'title' =>  'Couleur header',
    ]);

    $manager->add_setting('header_background', [
        'default'   => '#FFF0F',
        'transport' =>  'postMessage',
        'sanitize_callback' =>  'sanitize_hex_color'
    ]);

    $manager->add_control(new WP_Customize_Color_Control($manager, 'header_background',
    [    'label' =>  __('Couleur du header', 'kalys'),
        'section' => 'kalys_apparence'
       
    ]));
});
add_action('customize_preview_init', function (){
    wp_enqueue_script('kalys_apparence', get_template_directory_uri() . './assets/js/kalys.js/apparence.js', ['jquery', 'customize-preview'], '', true);
});