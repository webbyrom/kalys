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
function kalys_title_separator($title)
{
    return '|';
}
function kalys_menu_class($classes)
{
    $classes[] = 'nav-item';
    return $classes;
}
function kalys_menu_link_class($attrs)
{
    $attrs['class'] = 'nav-link';
    return $attrs;
}
/*********************
 * fonction pagination avec activation de la classe active, remplacement de la classe current par active
 */
function kalys_pagination()
{
    $pages = paginate_links(['type' => 'array']);
    if ($pages === null) {
        return;
    }
    echo '<nav aria-label="Pagination" class="my-4>';
    echo '<ul class="pagination">';
    foreach ($pages as $page) {
        $active = strpos($page, 'current') !== false;
        $class = 'page-item';
        if ($active) {
            $class .= ' active';
        }
        echo '<li class="' . $class . '">';
        echo str_replace('page-numbers', 'page-link', $page);
        echo '</li>';
    }
    echo '</ul>';
    echo '</nav>';
}
/***********************************************************
 * taxonomy des articles
 */
function kalys_init()
{
    register_taxonomy('soin', 'post', [
        'labels' => [
            'name' => 'Soin',
            'singular_name' => 'Soin',
            'plural_name'   => 'Soins',
            'search_items'  => 'Rechercher tous les soins',
            'all_items'     => 'Tous les Soins',
            'edit_item'     => 'Editer le soin',
            'update_item'   => 'Mettre à jour le soin',
            'add_new_item'  => 'Ajouter un nouveau soin',
            'new_item_name' => 'Ajouter un nouveau soin',
            'menu_name'     => 'Soins',
        ],
        'show_in_rest'   => true,
        'hierarchical'   => true,
        'show_admin_column'  => true,
    ]);
    register_post_type('kalys_epilation', [
        'labels' => [
            'name'  => 'Epilation',
            'singular_name' =>  'Epilation',
            'plural_name'   =>  'Epilations',
            'search_items'  =>  'Rechercher les épilations',
            'all_item'  =>  'Toutes les épilations',
            'edit_item' =>  'Editer l\'épilation',
            'update_item'   =>  'Mettre à jour l\'épilation',
            'add_new_item'  =>  'Ajouter une nouvelle épilation',
            'new_item_name' =>  'Ajouter une nouvelle épilation',
            'menu_name' =>  'Epilation',
        ],
        'show_in_rest'  => true,
        'public'    =>  true,
        'menu_position' => 2,
        'menu_icon' =>  'dashicons-businesswoman',
        'supports'  =>  [
            'title',
            'editor',
            'thumbnail',
            'comments',
            'author',
            'post-formats',
        ],
        'show_in_rest'  =>  true,
        'has_archive'   =>  true,
    ]);
    register_post_type('kalys_manucure', [
        'labels' => [
            'name'  => 'Manucure',
            'singular_name' =>  'Manucure',
            'plural_name'   =>  'Manucures',
            'search_items'  =>  'Rechercher les manucures',
            'all_item'  =>  'Toutes les manucures',
            'edit_item' =>  'Editer les manucures',
            'update_item'   =>  'Mettre à jour les manucures',
            'add_new_item'  =>  'Ajouter une nouvelle manucures',
            'new_item_name' =>  'Ajouter une nouvelle manucures',
            'menu_name' =>  'Manucure',
        ],
        'show_in_rest'  => true,
        'public'    =>  true,
        'menu_position' => 3,
        'menu_icon' =>  'dashicons-admin-customizer',
        'supports'  =>  [
            'title',
            'editor',
            'thumbnail',
            'comments',
            'author',
            'post-formats',
        ],
        'show_in_rest'  =>  true,
        'has_archive'   =>  true,
    ]);
}

add_action('init', 'kalys_init');
add_action('after_setup_theme', 'kalys_supports');
add_action('wp_enqueue_scripts', 'kalys_register_assets');
add_filter('wp_title', 'kalys_title');
add_filter('document_title_separator', 'kalys_title_separator');
add_filter('nav_menu_css_class', 'kalys_menu_class');
add_filter('nav_menu_link_attributes', 'kalys_menu_link_class');

require_once('metaboxes/sponso.php');
require_once('options/kalys.php');
SponsoMetaBox::register();
KalysMenuPage::register();


add_filter('manage_kalys_epilation_posts_columns', function ($columns) {
    return [
        'cb'    => $columns['cb'],
        'thumbnail' => 'Miniature',
        'title'     => $columns['title'],
        'date'      => $columns['date']
    ];
});
/*****
 * création d'un colonne dans l'admin wordpress( la colonne miniature)
 */
add_filter('manage_kalys_epilation_posts_custom_column', function ($column, $postId) {
    if ($column === 'thumbnail') {
        the_post_thumbnail('thumbnail', $postId);
    }
}, 10, 2);
add_filter('manage_kalys_manucure_posts_columns', function ($columns) {
    return [
        'cb'    => $columns['cb'],
        'thumbnail' => 'Miniature',
        'title'     => $columns['title'],
        'date'      => $columns['date']
    ];
});
add_filter('manage_kalys_manucure_posts_custom_column', function ($column, $postId) {
    if ($column === 'thumbnail') {
        the_post_thumbnail('thumbnail', $postId);
    }
}, 10, 2);

/****
 * utilisation du fichier admin.css pour cette nouvelle colonne et partie
 */
add_action('admin_enqueue_scripts', function () {
    wp_enqueue_style('admin_kalys', get_template_directory_uri() . '/assets/css/admin-css/admin.css');
});


add_filter('manage_post_posts_columns', function ($columns) {
    $newColumns = [];
    foreach ($columns as $k => $v) {
        if ($k === 'date') {
            $newColumns['kalys_sponso'] = 'Article sponsorisé ?';
        }
        $newColumns[$k] = $v;
    }
    return $newColumns;
});

add_filter('manage_post_posts_custom_column', function ($column, $postId) {
    if ($column === 'kalys_sponso') {
        if (!empty(get_post_meta($postId, SponsoMetaBox::META_KEY, true))) {
            $class = 'yes';
        } else {
            $class = 'no';
        }
        echo '<div class="bullet bullet-' . $class . '"></div>';
    }
}, 10, 2);


/***
 *  @param WP_Query $query
 */
function kalys_pre_get_posts($query)
{
    if (is_admin() || !is_home() || !$query->is_main_query()) {
        return;
    }
    if (get_query_var('kalys_sponso') === '1') {
        $meta_query = $query->get('meta_query', []);
        $meta_query[] = [
            'key'   => SponsoMetaBox::META_KEY,
            'compare'   => 'EXISTS',
        ];
        $query->set('meta_query', $meta_query);
    }
}
function kalys_query_vars($params)
{
    $params[] = 'kalys_sponso';
    return $params;
}
add_action('pre_get_posts', 'kalys_pre_get_posts');
add_filter('query_vars',  'kalys_query_vars');
