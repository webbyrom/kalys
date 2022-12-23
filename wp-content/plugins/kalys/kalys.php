<?php
/*********
 * Plugin Name: Kalys soin des mains et soin du corps
 * Description: Gestion des posts type
 * Author: Romain Fourel | Web-byrom
 * Version: 1.0.0
 * 
 */
add_action('init', function () {

    register_post_type('soin-mains', [
        'label' =>__('Soin des mains'),
        'menu_icon' =>  'dashicons-smiley',
        'labels'    =>  [
            'name'  =>__('Soin des mains', 'kalys'),
            'singular_name' =>__('Soin des mains', 'kalys'),
            'edit_item' =>__('Edit soin des mains', 'kalys'),
            'new_item'  =>__('New soin des mains', 'kalys'),
            'view_item' =>__('View soin des mains', 'kalys'),
            'view_items' =>__('View Soins des mains', 'kalys'),
            'search_items' =>__('Search soins des mains', 'kalys'),
            'not_found' =>__('Pas de soins de mains trouvés', 'kalys'),
            'not_found_in_trash' =>__('pas de soins des mains trouvé à la poubelle', 'kalys'),
            'all_items' =>__('Tous les soins des mains', 'kalys'),
            'archives'  =>__('Archives soins des mains', 'kalys'),
            'attributes'    =>__('Attributs soin des mains', 'kalys'),
            'insert_into_item'  =>__('Insertion dans soin des mains', 'kalys'),
            'uploaded_to_this_item' =>__('Charger dans Soins des mains', 'kalys'),
            'filter_items_list' =>__('Filtrer la liste des soins des mains', 'kalys'),
            'items_list_navigation' =>__('Navigation dans la liste de soin des mains', 'kalys'),
            'items_list'    =>__('Liste des soins des mains', 'kalys'),
            'item_published'    =>__('Soin des mains publié', 'kalys'),
            'item_published_privately'  =>__('Soin des mains publié en privé', 'kalys'),
            'item_reverted_to_draft'    =>__('Soin des mains redevenu brouillon', 'kalys'),
            'item_scheduled'    =>__('Soin des mains prevu', 'kalys'),
            'item_updated'  =>__('Soin des mains mis à jour', 'kalys'),
        ],
        'public'  => true,
        'hierarchical'  => true,
        'menu_position' => 3,
        'exclude_from_search' =>  false,
        'taxonomies'  => ['manucure'],
        'supports'  =>  ['title', 'editor', 'comments', 'author', 'excerpt', 'thumbnail'],
        'show_in_rest'  => true,
        'has_archive'   => true,
    ]);
    
    register_taxonomy('manucure', 'soin-mains', [
        'labels'    =>  [
            'name'  =>__('Manucures', 'kalys'),
            'singular_name' =>__('manucure', 'kalys'),
            'search_items'  =>__('Recherche de manucures', 'kalys'),
            'popular_items' =>__('manucures Populaires', 'kalys'),
            'name_field_description'    =>__('manucure', 'kalys'),
            'all_items' =>__('Toutes les manucures', 'kalys'),
            'parent_item'   =>__('manucure Parente', 'kalys'),
            'parent_item_colon' =>__('manucure Parente', 'kalys'),
            'edit_item' =>__('Modifier la manucure', 'kalys'),
            'view_item' =>__('voir la manucure', 'kalys'),
            'update_item'   =>__('Mettre à jour la manucure', 'kalys'),
            'add_new_item'  =>__('Ajouter une nouvelle manucure', 'kalys'),
            'new_item_name' =>__('Nouveau nom de manucure', 'kalys'),
            'separate_items_with_commas' =>__('Séparer les manucures avec des virgules', 'kalys'),
            'add_or_remove_items'  =>__('Ajouter ou supprimer des manucures', 'kalys'),
            'choose_from_most_used' =>__('Choisir parmi les plus utilisés', 'kalys'),
            'not_found' =>__('Rien trouvé', 'kalys'),
            'no_terms'  =>__('Pas de conditions', 'kalys'),
            'items_list_navigation' =>__('Navigation dans la liste des manucures', 'kalys'),
            'items_list'  =>__('liste des Articles', 'kalys'),
            'most_used' =>_x('Le plus utlisé', 'kalys'),
            'back_to_items' =>__('&larr', 'Retour à l\'article', 'kalys'),
        ],
        'show_in_rest' => true,
        'hierarchical'=> true,
        'show_in_menu'  => true,
        'public'    => true,
    ]);
    register_post_type('soin-corps', [
        'label' => __('Soin du corps'),
        'menu_icon' =>  'dashicons-businesswoman',
        'labels'    =>  [
            'name'  =>__('Soin du corps', 'kalys'),
            'singular_name' =>__('Soin du corps', 'kalys'),
            'edit_item' =>__('Edit soin du corps', 'kalys'),
            'new_item'  =>__('New soin du corps', 'kalys'),
            'view_item' =>__('View soin du corps', 'kalys'),
            'view_items' =>__('View Soins du corps', 'kalys'),
            'search_items' =>__('Search soins du corps', 'kalys'),
            'not_found' =>__('Pas de soins de corps trouvés', 'kalys'),
            'not_found_in_trash' =>__('pas de soins du corps trouvé à la poubelle', 'kalys'),
            'all_items' =>__('Tous les soins du corps', 'kalys'),
            'archives'  =>__('Archives soins du corps', 'kalys'),
            'attributes'    =>__('Attributs soin du corps', 'kalys'),
            'insert_into_item'  =>__('Insertion dans soin du corps', 'kalys'),
            'uploaded_to_this_item' =>__('Charger dans Soins du corps', 'kalys'),
            'filter_items_list' =>__('Filtrer la liste des soins du corps', 'kalys'),
            'items_list_navigation' =>__('Navigation dans la liste de soin du corps', 'kalys'),
            'items_list'    =>__('Liste des soins du corps', 'kalys'),
            'item_published'    =>__('Soin du corps publié', 'kalys'),
            'item_published_privately'  =>__('Soin du corps publié en privé', 'kalys'),
            'item_reverted_to_draft'    =>__('Soin du corps redevenu brouillon', 'kalys'),
            'item_scheduled'    =>__('Soin du corps prevu', 'kalys'),
            'item_updated'  => __('Soin du corps mis à jour', 'kalys'),
    
        ],
        'public'    =>  true,
        'hierarchical'  =>  true,
        'menu_position' => 4,
        'exclude_from_search'   =>  false,
        'taxonomies'    => ['épilation'],
        'supports'  =>  ['title', 'editor', 'comments', 'author', 'excerpt', 'thumbnail'],
        'show_in_rest'  => true,
        'has_archive'   =>true,
    ]);
    register_taxonomy('épilation', 'soin-corps', [
        'labels'    =>  [
            'name'  =>__('Epilation', 'kalys'),
            'singular_name' =>__('épilation', 'kalys'),
            'search_items'  =>__('Recherche de épilations', 'kalys'),
            'popular_items' =>__('épilations Populaires', 'kalys'),
            'all_items' =>__('Toutes les épilations', 'kalys'),
            'parent_item'   =>__('épilation Parente', 'kalys'),
            'parent_item_colon' =>__('épilation Parente', 'kalys'),
            'edit_item' =>__('Modifier l\'épilation', 'kalys'),
            'view_item' =>__('voir l\'épilation', 'kalys'),
            'update_item'   =>__('Mettre à jour l\' épilation', 'kalys'),
            'add_new_item'  =>__('Ajouter une nouvelle épilation', 'kalys'),
            'new_item_name' =>__('Nouveau nom d\'épilation', 'kalys'),
            'separate_items_with_commas' =>__('Séparer les épilations avec des virgules', 'kalys'),
            'add_or_remove_items'   =>__('Ajouter ou supprimer des épilations', 'kalys'),
            'choose_from_most_used' =>__('Choisir parmi les plus utilisés', 'kalys'),
            'not_found' =>__('Rien trouvé', 'kalys'),
            'no_terms'  =>__('Pas de conditions', 'kalys'),
            'items_list_navigation' =>__('Navigation dans la liste des épilations', 'kalys'),
            'items_list'    =>__('liste des épilations', 'kalys'),
            'most_used' =>_x('Le plus utlisé', 'kalys'),
            'back_to_items' =>__('&larr', 'Retour à l\'article', 'kalys'),
        ],
        'show_in_rest'   => true,
        'hierarchical'   => true,
        'show_admin_column'  => true,
    ]);
   
});



register_activation_hook(__FILE__ , 'flush_rewrite_rules');
register_deactivation_hook(__FILE__ , 'flush_rewrite_rules');
