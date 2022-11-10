<?php
// https://codex.wordpress.org/Plugin_API/Action_Reference/customize_register
    add_action('customize_register', function (WP_Customize_Manager $manager){
        $manager->add_section('kalys_apparence', [
            'title' => 'Personnalisation de l\'apparence',
        ]);
        $manager->add_setting('header_background', [
            'default' => '#FFF0F',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'

        ]);
/****
 * ajout du contrôle de la couleur dans le menu personnaliser et personnalisation de l'apparence, couleur du header
 */
        $manager->add_control(new WP_Customize_Color_Control($manager, 'header_background', [
            'section'   =>  'kalys_apparence',
            'setting'   =>  'header_background',
            'label' =>  'Couleur du Header'
        ]));
    });

    add_action('customize_preview_init', function () {
        wp_enqueue_script('kalys_apparence', get_template_directory_uri() . '/assets/js/kalys.js/apparence.js', ['jquery', 'customize-preview'], '', true);
    });
?>

