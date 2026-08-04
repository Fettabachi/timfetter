<?php

// Portfolio Items Post Type
add_action('init', 'tf_work_items_register_post_type');

function tf_work_items_register_post_type()
{
    register_post_type('portfolio-items', array(
        'labels' => array(
            'name'               => 'Work',
            'singular_name'      => 'Work Item',
            'menu_name'          => 'Work',
            'name_admin_bar'     => 'Work Item',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Work Item',
            'new_item'           => 'New Work Item',
            'edit_item'          => 'Edit Work Item',
            'view_item'          => 'View Work Item',
            'all_items'          => 'All Work',
            'search_items'       => 'Search Work',
            'not_found'          => 'No work found.',
            'not_found_in_trash' => 'No work found in Trash.',
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'has_archive'        => 'work',
        'rewrite'            => array(
            'slug'       => 'work',
            'with_front' => false,
        ),
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'page-attributes',
        ),
    ));
}

// Property Post Type
function fu_register_property_cpt()
{
    $labels = array(
        'name'               => 'Properties',
        'singular_name'      => 'Property',
        'menu_name'          => 'Properties',
        'name_admin_bar'     => 'Property',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Property',
        'new_item'           => 'New Property',
        'edit_item'          => 'Edit Property',
        'view_item'          => 'View Property',
        'all_items'          => 'All Properties',
        'search_items'       => 'Search Properties',
        'not_found'          => 'No properties found.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'has_archive'        => true,
        'menu_icon'          => 'dashicons-admin-home',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'       => true,
        'rewrite'            => array('slug' => 'properties'),
    );

    register_post_type('fu_property', $args);
}
add_action('init', 'fu_register_property_cpt');

/**
 * Register Component Lab CPT & Taxonomy
 */
function fu_register_lab_cpt()
{
    $labels = array(
        'name'               => 'Component Lab',
        'singular_name'      => 'Component',
        'menu_name'          => 'Component Lab',
        'add_new_item'       => 'Add New Component',
        'all_items'          => 'All Components',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'has_archive'        => true,
        'menu_icon'          => 'dashicons-rest-api',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'       => true,
        'rewrite'            => array('slug' => 'lab'),
    );

    register_post_type('fu_lab', $args);

    register_taxonomy('lab_category', 'fu_lab', array(
        'label'        => 'Categories',
        'rewrite'      => array('slug' => 'lab-category'),
        'hierarchical' => true,
        'show_in_rest' => true,
    ));
}
add_action('init', 'fu_register_lab_cpt');

/**
 * Resource CPT + taxonomy
 */
function fu_register_resource_content()
{
    $labels = [
        'name'               => 'Resources',
        'singular_name'      => 'Resource',
        'menu_name'          => 'Resources',
        'name_admin_bar'     => 'Resource',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Resource',
        'new_item'           => 'New Resource',
        'edit_item'          => 'Edit Resource',
        'view_item'          => 'View Resource',
        'all_items'          => 'All Resources',
        'search_items'       => 'Search Resources',
        'not_found'          => 'No resources found.',
        'not_found_in_trash' => 'No resources found in Trash.',
    ];

    register_post_type(
        'resource',
        [
            'labels'             => $labels,
            'public'             => true,
            'show_in_rest'       => true,
            'has_archive'        => true,
            'rewrite'            => ['slug' => 'resources'],
            'menu_icon'          => 'dashicons-media-document',
            'supports'           => ['title', 'editor', 'excerpt', 'thumbnail'],
            'menu_position'      => 20,
            'publicly_queryable' => true,
            'show_in_nav_menus'  => true,
        ]
    );

    $taxonomy_labels = [
        'name'              => 'Resource Categories',
        'singular_name'     => 'Resource Category',
        'search_items'      => 'Search Resource Categories',
        'all_items'         => 'All Resource Categories',
        'edit_item'         => 'Edit Resource Category',
        'update_item'       => 'Update Resource Category',
        'add_new_item'      => 'Add New Resource Category',
        'new_item_name'     => 'New Resource Category Name',
        'menu_name'         => 'Resource Categories',
    ];

    register_taxonomy(
        'resource_category',
        ['resource'],
        [
            'labels'            => $taxonomy_labels,
            'public'            => true,
            'hierarchical'      => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'rewrite'           => ['slug' => 'resource-category'],
        ]
    );
}
add_action('init', 'fu_register_resource_content');

/**
 * Remove blog posts from the native WordPress XML sitemap.
 */
function tf_filter_sitemap_post_types($post_types)
{
    unset($post_types['post']);

    return $post_types;
}
add_filter('wp_sitemaps_post_types', 'tf_filter_sitemap_post_types');


/**
 * Remove taxonomy archives from the native WordPress XML sitemap.
 */
function tf_filter_sitemap_taxonomies($taxonomies)
{
    return array();
}
add_filter('wp_sitemaps_taxonomies', 'tf_filter_sitemap_taxonomies');
