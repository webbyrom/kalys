<?php
add_action('customize_register', function (WP_Customize_Manager $manager){
/****
 * Ajout de le section Theme apparence dans le menu personnalisation
 * le double _ devant ('Theme apparence')sert pour la traduction
 *
 */
    $manager->add_section('kalys_apparence', [
        'title' => __('Theme apparence')
    ]);
/***
 * sanitize_callback évite que l'utilisateur rentre n'importe quoi
 */
    $manager->add_setting('logo', [
        'sanitize_callback' => 'esc_url_raw'
    ]);

/****
 * créer le petit formulaire au niveau de la personnalisation
 */
    $manager->add_control(new WP_Customize_Image_Control($manager, 'logo', [
        'label' => __('Logo', 'kalys'),
        'section'   => 'kalys_apparence'
    ]));
});