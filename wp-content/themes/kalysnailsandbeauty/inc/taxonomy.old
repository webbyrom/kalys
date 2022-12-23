<?php
function kalys_init() {

    register_taxonomy('soin des mains' ,'post',[
        'labels'=>  [
            'name'  =>  'Soin des mains',
            'singular_name' =>  'Soin des mains',
            'plural_name'   =>  'Soins des mains',
            'search_items'  =>  'Recherche soins des mains',
            'all_items'     =>  'Soins des mains',
            'edit_item'     =>  'Editer soin des mains',
            'update_item'   =>  'Mettre à jour soins des mains',
            'add_new_item'  =>  'Ajouter un nouveau soin des mains',
            'new_item_name' =>  'Ajouter un nouveau soin des mains',
            'menu_name'     =>  'Soin des mains'
        ],
        'show_in_rest'  =>  true,
        'hierarchical'  =>  true,
        'show_admin_column' =>  true,
        ]);
        
    register_taxonomy('soin du corps', 'post', [
        'labels'=>  [
            'name'  => 'Soin du corps',
            'singular_name' =>  'Soin du corps',
            'plural_name'   =>  'Soins du corps',
            'search_items'  =>  'Recherche soin du corps',
            'all_items'     =>  'Soins du corps',
            'edit_item'     =>  'Editer soin du corps',
            'update_item'   =>  'Mettre à jour soin du corps',
            'add_new_item'  =>  'Ajouter un nouveau soin du corps',
            'new_item_name' =>  'Ajouter un nouveau soin du corps',
            'menu_name'     =>  'Soin du corps'
        ],
        'show_in_rest'  =>  true,
        'hierarchical'  =>  true,
        'show_admin_column' =>  true,
        ]);
}
add_action('init', 'kalys_init');