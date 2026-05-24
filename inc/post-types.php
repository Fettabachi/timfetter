<?php

// Portfolio Items Post Type
add_action('init', 'tf_portfolio_items_register_post_type');

function tf_portfolio_items_register_post_type()
{
    register_post_type('portfolio-items', array(
        'labels' => array(
            'name' => 'Portfolio Items',
            'singular_name' => 'Portfolio Item',
            'add_new' => 'Add new portfolio item',
            'edit_item' => 'Edit portfolio item',
            'new_item' => 'New portfolio item',
            'view_item' => 'View portfolio item',
            'search_items' => 'Search portfolio items',
            'not_found' => 'No portfolio items found',
            'not_found_in_trash' => 'No portfolio items found in Trash'
        ),
        'public' => true,
        'has_archive' => 'work',
        'rewrite' => array(
            'slug' => 'work',
            'with_front' => false,
        ),
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        )
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
        'public'             => true,
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
        'public'             => true,
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
