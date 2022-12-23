<?php 
/*********
 * Plugin Name: Kalys soin des mains et soin du corps
 * Description: Gestion des posts type
 * Author: Romain Fourel /Web-byrom
 * Version: 1.0.0
 * Text Domain: Kalys
 */
add_action('init', function(){
register_post_type('soin des mains', [
    'label' =>  'Soin des Mains',
    'menu_icon' =>  'dashicons-smiley',
    'labels'    =>  [
        'name'  => __('Soin des mains', 'kalys'),
        'singular_name' =>  __('Soin des mains', 'kalys'),
        'edit_item' =>  __('Edit soin des mains', 'kalys'),
        'new_item'  =>  __('New soin des mains', 'kalys'),
        'view_item' =>  __('View soin des mains', 'kalys'),
        'view_items'    => __('View Soins des mains', 'kalys'),
        'search_items'  => __('Search soins des mains', 'kalys'),
        'not_found' => __('Pas de soins de mains trouvés', 'kalys'),
        'not_found_in_trash'    =>  __('pas de soins des mains trouvé à la poubelle', 'kalys'),
        'all_items' =>  __('Tous les soins des mains', 'kalys'),
        'archives'  =>  __('Archives soins des mains', 'kalys'),
        'attributes'    =>  __('Attributs soin des mains', 'kalys'),
        'insert_into_item'  => __('Insertion dans soin des mains','kalys'),
        'uploaded_to_this_item' =>  __('Charger dans Soins des mains', 'kalys'),
        'filter_items_list' =>  __('Filtrer la liste des soins des mains', 'kalys'),
        'items_list_navigation' =>  __('Navigation dans la liste de soin des mains', 'kalys'),
        'items_list'    =>  __('Liste des soins des mains', 'kalys'),
        'item_published'    =>  __('Soin des mains publié', 'kalys'),
        'item_published_privately'  =>  __('Soin des mains publié en privé', 'kalys'),
        'item_reverted_to_draft'    =>  __('Soin des mains redevenu brouillon', 'kalys'),
        'item_scheduled'    =>  __('Soin des mains prevu','kalys'),
        'item_updated'  =>  __('Soin des mains mis à jour', 'kalys'),



    ],
    'public'    =>  true,
    'hierarchical'  =>  true,
    'exclude_from_search'   =>  false,
    'taxonomies'    => ['soin_des_mains_type'],
    'supports'  =>  ['title', 'editor', 'comments', 'author', 'excerpt', 'thumbnail']
]);
register_taxonomy('soin_des_mains_type', 'soin des mains', [
    'labels'    =>  [
        'name'  =>  __('Catégories','kalys'),
        'singular_name' =>  __('Catégorie', 'kalys'),
        'search_items'  =>  __('Recherche de Catégories', 'kalys'),
        'popular_items' =>  __('Catégories Populaires', 'kalys'),
        'all_items' =>  __('Toutes les Catégories', 'kalys'),
        'parent_item'   =>  __('Catégorie Parente', 'kalys'),
        'parent_item_colon' =>  __('Catégorie Parente', 'kalys'),
        'edit_item' =>  __('Modifier la Catégorie', 'kalys'),
        'view_item' =>  __('voir la Catégorie', 'kalys'),
        'update_item'   =>  __('Mettre à jour la Catégorie', 'kalys'),
        'add_new_item'  =>  __('Ajouter une nouvelle Catégorie', 'kalys'),
        'new_item_name' =>  __('Nouveau nom de Catégorie', 'kalys'),
        'separate_items_with_commas'    => __('Séparer les Catégories avec des virgules', 'kalys'),
        'add_or_remove_items'   =>  __('Ajouter ou supprimer des Catégories', 'kalys'),
        'choose_from_most_used' =>  __('Choisir parmi les plus utilisés', 'kalys'),
        'not_found' =>   __('Rien trouvé', 'kalys'),
        'no_terms'  =>  __('Pas de conditions', 'kalys'),
        'items_list_navigation' =>  __('Navigation dans la liste des catégories', 'kalys'),
        'items_list'    =>  __('liste des Articles', 'kalys'),
        'most_used' =>  __('Le plus utlisé', 'kalys'),
        'back_to_items' =>  __('&larr', 'Retour à l\'article', 'kalys'),
    ]
    ]);

register_post_type('soin du corps', [
    'label' =>  'Soin du corps',
    'menu_icon' =>  'dashicons-businesswoman',
    'labels'    =>  [
        'name'  => __('Soin du corps', 'kalys'),
        'singular_name' =>  __('Soin du corps', 'kalys'),
        'edit_item' =>  __('Edit soin du corps', 'kalys'),
        'new_item'  =>  __('New soin du corps', 'kalys'),
        'view_item' =>  __('View soin du corps', 'kalys'),
        'view_items'    => __('View Soins du corps', 'kalys'),
        'search_items'  => __('Search soins du corps', 'kalys'),
        'not_found' => __('Pas de soins de corps trouvés', 'kalys'),
        'not_found_in_trash'    =>  __('pas de soins du corps trouvé à la poubelle', 'kalys'),
        'all_items' =>  __('Tous les soins du corps', 'kalys'),
        'archives'  =>  __('Archives soins du corps', 'kalys'),
        'attributes'    =>  __('Attributs soin du corps', 'kalys'),
        'insert_into_item'  => __('Insertion dans soin du corps','kalys'),
        'uploaded_to_this_item' =>  __('Charger dans Soins du corps', 'kalys'),
        'filter_items_list' =>  __('Filtrer la liste des soins du corps', 'kalys'),
        'items_list_navigation' =>  __('Navigation dans la liste de soin du corps', 'kalys'),
        'items_list'    =>  __('Liste des soins du corps', 'kalys'),
        'item_published'    =>  __('Soin du corps publié', 'kalys'),
        'item_published_privately'  =>  __('Soin du corps publié en privé', 'kalys'),
        'item_reverted_to_draft'    =>  __('Soin du corps redevenu brouillon', 'kalys'),
        'item_scheduled'    =>  __('Soin du corps prevu','kalys'),
        'item_updated'  =>  __('Soin du corps mis à jour', 'kalys'),



    ],
    'public'    =>  true,
    'hierarchical'  =>  true,
    'exclude_from_search'   =>  false,
    'taxonomies'    => ['soin_du_corps_type'],
    'supports'  =>  ['title', 'editor', 'comments', 'author', 'excerpt', 'thumbnail']
]);
register_taxonomy('soin_du_corps_type', 'soin du corps', [
    'labels'    =>  [
        'name'  =>  __('Catégories','kalys'),
        'singular_name' =>  __('Catégorie', 'kalys'),
        'search_items'  =>  __('Recherche de Catégories', 'kalys'),
        'popular_items' =>  __('Catégories Populaires', 'kalys'),
        'all_items' =>  __('Toutes les Catégories', 'kalys'),
        'parent_item'   =>  __('Catégorie Parente', 'kalys'),
        'parent_item_colon' =>  __('Catégorie Parente', 'kalys'),
        'edit_item' =>  __('Modifier la Catégorie', 'kalys'),
        'view_item' =>  __('voir la Catégorie', 'kalys'),
        'update_item'   =>  __('Mettre à jour la Catégorie', 'kalys'),
        'add_new_item'  =>  __('Ajouter une nouvelle Catégorie', 'kalys'),
        'new_item_name' =>  __('Nouveau nom de Catégorie', 'kalys'),
        'separate_items_with_commas'    => __('Séparer les Catégories avec des virgules', 'kalys'),
        'add_or_remove_items'   =>  __('Ajouter ou supprimer des Catégories', 'kalys'),
        'choose_from_most_used' =>  __('Choisir parmi les plus utilisés', 'kalys'),
        'not_found' =>   __('Rien trouvé', 'kalys'),
        'no_terms'  =>  __('Pas de conditions', 'kalys'),
        'items_list_navigation' =>  __('Navigation dans la liste des catégories', 'kalys'),
        'items_list'    =>  __('liste des Articles', 'kalys'),
        'most_used' =>  __('Le plus utlisé', 'kalys'),
        'back_to_items' =>  __('&larr', 'Retour à l\'article', 'kalys'),
    ]
    ]);
    
});

register_activation_hook(__FILE__, 'flush_rewrite_rules');
register_deactivation_hook(__FILE__, 'flush_rewrite_rules');