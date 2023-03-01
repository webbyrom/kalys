<?php
defined('ABSPATH') or die('');
/*********
 * Plugin Name: Kalys Nails & Beauty
 * Description: Gestion des posts type
 * Author: Romain Fourel | https://web-byrom.com
 * Version: 1.0.0
 * 
 */

add_action('init', function () {

    register_post_type('soin-mains', [
        'label' => __('Soin des mains'),
        'menu_icon' =>  get_template_directory_uri(). "/assets/logo/logo_admin_kalys-02.png",
        'labels'    =>  [
            'name'  => __('Soin des mains', 'kalysNails'),
            'singular_name' => __('Soin des mains', 'kalysNails'),
            'edit_item' => __('Modifer soin des mains', 'kalysNails'),
            'new_item'  => __('Nouveau soin des mains', 'kalysNails'),
            'view_item' => __('Voir soin des mains', 'kalysNails'),
            'view_items' => __('Voir Soins des mains', 'kalysNails'),
            'search_items' => __('Recherche soins des mains', 'kalysNails'),
            'not_found' => __('Pas de soins de mains trouvés', 'kalysNails'),
            'not_found_in_trash' => __('pas de soins des mains trouvé à la poubelle', 'kalysNails'),
            'all_items' => __('Tous les soins des mains', 'kalysNails'),
            'archives'  => __('Archives soins des mains', 'kalysNails'),
            'attributes'    => __('Attributs soin des mains', 'kalysNails'),
            'insert_into_item'  => __('Insertion dans soin des mains', 'kalysNails'),
            'uploaded_to_this_item' => __('Charger dans Soins des mains', 'kalysNails'),
            'filter_items_list' => __('Filtrer la liste des soins des mains', 'kalysNails'),
            'items_list_navigation' => __('Navigation dans la liste de soin des mains', 'kalysNails'),
            'items_list'    => __('Liste des soins des mains', 'kalysNails'),
            'item_published'    => __('Soin des mains publié', 'kalysNails'),
            'item_published_privately'  => __('Soin des mains publié en privé', 'kalysNails'),
            'item_reverted_to_draft'    => __('Soin des mains redevenu brouillon', 'kalysNails'),
            'item_scheduled'    => __('Soin des mains prevu', 'kalysNails'),
            'item_updated'  => __('Soin des mains mis à jour', 'kalysNails'),
        ],
        'public'  => true,
        'hierarchical'  => true,
        'menu_position' => 3,
        'capability_type'=> 'post',
        'publicly_queryable' => true,
        'exclude_from_search' =>  false,
        'show_in_nav_menu'=> true,
        'show_in_admin_bar' => true,
        'query_var'          =>true,
        'rewrite'   => ['slug' => 'soin-mains'],
        'taxonomies'  => ['manucure'],
        'supports'  =>  ['title', 'editor','custom-fields','page-attributes', 'comments', 'author', 'excerpt', 'thumbnail'],
        'show_in_rest'  => true,
        'has_archive'   => true
    ]);

    register_taxonomy('manucure', 'soin-mains', [
        'labels'    =>  [
            'name'  => __('manucures', 'kalysNails'),
            'singular_name' => __('manucure', 'kalysNails'),
            'search_items'  => __('Recherche de manucures', 'kalysNails'),
            'popular_items' => __('manucures Populaires', 'kalysNails'),
            'name_field_description' => __('manucure', 'kalysNails'),
            'all_items' => __('Toutes les manucures', 'kalysNails'),
            'parent_item'   => __('manucure Parente', 'kalysNails'),
            'parent_item_colon' => __('manucure Parente', 'kalysNails'),
            'edit_item' => __('Modifier la manucure', 'kalysNails'),
            'view_item' => __('Voir la manucure', 'kalysNails'),
            'update_item'   => __('Mettre à jour la manucure', 'kalysNails'),
            'add_new_item'  => __('Ajouter une nouvelle manucure', 'kalysNails'),
            'new_item_name' => __('Nouveau nom de manucure', 'kalysNails'),
            'separate_items_with_commas' => __('Séparer les manucures avec des virgules', 'kalysNails'),
            'add_or_remove_items'  => __('Ajouter ou supprimer des manucures', 'kalysNails'),
            'choose_from_most_used' => __('Choisir parmi les plus utilisés', 'kalysNails'),
            'not_found' => __('Rien trouvé', 'kalysNails'),
            'no_terms'  => __('Pas de conditions', 'kalysNails'),
            'items_list_navigation' => __('Navigation dans la liste des manucures', 'kalysNails'),
            'items_list'  => __('liste des Articles', 'kalysNails'),
            'most_used' => _x('Le plus utlisé', 'kalysNails'),
            'back_to_items' => __('&larr', 'Retour à l\'article', 'kalysNails'),
        ],
        'show_in_rest' => true,
        'show_ui'   => true,
        'hierarchical' => true,
        'show_in_menu'  => true,
        'show_in_nav_menu'=> true,
        'show_in_admin_bar'=> true,
        'query_var' => true,
        'public'    => true,
        'exclude_from_search' =>  false,
        'show_admin_column'  => true,
        'show_in_quick_edit'  => true
    ]);
    register_post_type('soin-corps', [
        'label' => __('Soins du corps'),
        'menu_icon' =>  get_template_directory_uri(). "/assets/logo/kalys_admin-epilation.png",
        'labels'    =>  [
            'name'  => __('Soin du corps', 'kalysNails'),
            'singular_name' => __('Soin du corps', 'kalysNails'),
            'edit_item' => __('Modifier soin du corps', 'kalysNails'),
            'new_item'  => __('Nouveau soin du corps', 'kalysNails'),
            'view_item' => __('Voir soin du corps', 'kalysNails'),
            'view_items' => __('Voir Soins du corps', 'kalysNails'),
            'search_items' => __('Recherhcer soins du corps', 'kalysNails'),
            'not_found' => __('Pas de soins de corps trouvés', 'kalysNails'),
            'not_found_in_trash' => __('pas de soins du corps trouvé à la poubelle', 'kalysNails'),
            'all_items' => __('Tous les soins du corps', 'kalysNails'),
            'archives'  => __('Archives soins du corps', 'kalysNails'),
            'attributes'    => __('Attributs soin du corps', 'kalysNails'),
            'insert_into_item'  => __('Insertion dans soin du corps', 'kalysNails'),
            'uploaded_to_this_item' => __('Charger dans Soins du corps', 'kalysNails'),
            'filter_items_list' => __('Filtrer la liste des soins du corps', 'kalysNails'),
            'items_list_navigation' => __('Navigation dans la liste de soin du corps', 'kalysNails'),
            'items_list'    => __('Liste des soins du corps', 'kalysNails'),
            'item_published'    => __('Soin du corps publié', 'kalysNails'),
            'item_published_privately'  => __('Soin du corps publié en privé', 'kalysNails'),
            'item_reverted_to_draft'    => __('Soin du corps redevenu brouillon', 'kalysNails'),
            'item_scheduled'    => __('Soin du corps prevu', 'kalysNails'),
            'item_updated'  => __('Soin du corps mis à jour', 'kalysNails'),

        ],
        'public'  => true,
        'hierarchical'  => true,
        'menu_position' => 4,
        'exclude_from_search' =>  false,
        'rewrite'   => ['slug' => 'soin-corps'],
        'taxonomies'  => ['épilation'],
        'supports'  =>  ['title', 'editor', 'comments', 'author', 'excerpt', 'thumbnail'],
        'show_in_rest'  => true,
        'has_archive'   => true
    ]);
    register_taxonomy('épilation', 'soin-corps', [
        'labels'    =>  [
            'name'  => __('Epilation', 'kalysNails'),
            'singular_name' => __('épilation', 'kalysNails'),
            'search_items'  => __('Recherche de épilations', 'kalysNails'),
            'popular_items' => __('épilations Populaires', 'kalysNails'),
            'all_items' => __('Toutes les épilations', 'kalysNails'),
            'parent_item'   => __('épilation Parente', 'kalysNails'),
            'parent_item_colon' => __('épilation Parente', 'kalysNails'),
            'edit_item' => __('Modifier l\'épilation', 'kalysNails'),
            'view_item' => __('voir l\'épilation', 'kalysNails'),
            'update_item'   => __('Mettre à jour l\' épilation', 'kalysNails'),
            'add_new_item'  => __('Ajouter une nouvelle épilation', 'kalysNails'),
            'new_item_name' => __('Nouveau nom d\'épilation', 'kalysNails'),
            'separate_items_with_commas' => __('Séparer les épilations avec des virgules', 'kalysNails'),
            'add_or_remove_items'   => __('Ajouter ou supprimer des épilations', 'kalysNails'),
            'choose_from_most_used' => __('Choisir parmi les plus utilisés', 'kalysNails'),
            'not_found' => __('Rien trouvé', 'kalysNails'),
            'no_terms'  => __('Pas de conditions', 'kalysNails'),
            'items_list_navigation' => __('Navigation dans la liste des épilations', 'kalysNails'),
            'items_list'    => __('liste des épilations', 'kalysNails'),
            'most_used' => _x('Le plus utlisé', 'kalysNails'),
            'back_to_items' => __('&larr', 'Retour à l\'article', 'kalysNails'),
        ],
        'show_in_rest' => true,
        'show_ui'   => true,
        'hierarchical' => true,
        'show_in_menu'  => true,
        'public'    => true,
        'exclude_from_search' =>  false,
        'show_admin_column'  => true,
        'show_in_quick_edit'  => true
    ]);
});

register_activation_hook(__FILE__, 'flush_rewrite_rules');
register_deactivation_hook(__FILE__, 'flush_rewrite_rules');
