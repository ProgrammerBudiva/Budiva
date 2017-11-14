<?php

class PostTypes
{
    public static function register_post_types() {
        register_post_type( 'trust', array(
            'labels' => array(
                'name' => __( "Trusted" ),
                'singular_name' => __( "Trusted" ),
                'add_new' => __( "Add new" ),
                'add_new_item' => __( "Add trusted" ),
                'edit_item' => __( "Edit trusted" ),
                'new_item' => __( "New item" ),
                'view_item' => __( "View trusted item" ),
                'search_items' => __( "Search trusted" ),
                'not_found' => __( "Trusted not found" ),
                'not_found_in_trash' => __( "Trusted not found in trash" ),
                'parent_item_colon' => __( "" ),
                'menu_name' => __( "Trusted" ),
            ),
            'public' => true,
            'menu_position' => 6,
            'hierarchical' => false,
            'query_var' => true,
            'supports' => array( 'title', 'thumbnail' ),
            'show_in_nav_menus' => false
        ) );

        register_post_type( 'news', array(
            'labels' => array(
                'name' => __( "News" ),
                'singular_name' => __( "News" ),
                'add_new' => __( "Add new" ),
                'add_new_item' => __( "Add news" ),
                'edit_item' => __( "Edit news" ),
                'new_item' => __( "New item" ),
                'view_item' => __( "View news" ),
                'search_items' => __( "Search news" ),
                'not_found' => __( "News not found" ),
                'not_found_in_trash' => __( "News not found in trash" ),
                'parent_item_colon' => __( "" ),
                'menu_name' => __( "News" ),
            ),
            'public' => true,
            'menu_position' => 6,
            'hierarchical' => false,
            'query_var' => true,
            'has_archive' => true,
            'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'post-formats', "excerpt" ),
        ) );

        register_post_type( 'vacancies', array(
            'labels' => array(
                'name' => __( "Vacancies" ),
                'singular_name' => __( "Vacancy" ),
                'add_new' => __( "Add new" ),
                'add_new_item' => __( "Add new vacancy" ),
                'edit_item' => __( "Edit vacancy" ),
                'new_item' => __( "New vacancy" ),
                'view_item' => __( "View vacancy" ),
                'search_items' => __( "Search vacancies" ),
                'not_found' => __( "Vacancies not found" ),
                'not_found_in_trash' => __( "Vacancies not found in trash" ),
                'parent_item_colon' => __( "" ),
                'menu_name' => __( "Vacancies" ),
            ),
            'public' => true,
            'menu_position' => 7,
            'hierarchical' => false,
            'query_var' => true,
            'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'post-formats' ),
        ) );

        register_post_type( 'manufacturer', array(
            'labels' => array(
                'name' => __( "Manufacturers" ),
                'singular_name' => __( "Manufacturer" ),
                'add_new' => __( "Add new" ),
                'add_new_item' => __( "Add new manufacturer" ),
                'edit_item' => __( "Edit manufacturer" ),
                'new_item' => __( "New manufacturer" ),
                'view_item' => __( "View manufacturer" ),
                'search_items' => __( "Search manufacturers" ),
                'not_found' => __( "Manufacturers not found" ),
                'not_found_in_trash' => __( "Manufacturers not found in trash" ),
                'parent_item_colon' => __( "" ),
                'menu_name' => __( "Manufacturers" ),
            ),
            'public' => true,
            'publicly_queryable' => true,
            'menu_position' => 8,
            'hierarchical' => false,
            'query_var' => true,
            'supports' => array( 'title', 'editor', 'thumbnail' ),
        ) );

        register_post_type( 'builders', array(
            'labels' => array(
                'name' => __( "Builders" ),
                'singular_name' => __( "Builder" ),
                'add_new' => __( "Add new" ),
                'add_new_item' => __( "Add new builder" ),
                'edit_item' => __( "Edit builder" ),
                'new_item' => __( "New builder" ),
                'view_item' => __( "View builder" ),
                'search_items' => __( "Search builders" ),
                'not_found' => __( "Builders not found" ),
                'not_found_in_trash' => __( "Builders not found in trash" ),
                'parent_item_colon' => __( "" ),
                'menu_name' => __( "Builders" ),
            ),
            'public' => true,
            'publicly_queryable' => true,
            'menu_position' => 8,
            'hierarchical' => false,
            'query_var' => true,
            'supports' => array( 'title', 'editor', 'thumbnail' ),
        ) );

        self::register_taxonomies();
    }

    private static function register_taxonomies() {
        register_taxonomy( 'city', array( 'vacancies', 'builders' ), array(
            'label' => 'Cities',
            'labels' => array(
                'name' => __( "Cities" ),
                'singular_name' => __( "City" ),
                'search_items' => __( "Search Cities" ),
                'all_items' => __( "All Cities" ),
                'parent_item' => __( "Parent City" ),
                'parent_item_colon' => __( "Parent City:" ),
                'edit_item' => __( "Edit City" ),
                'update_item' => __( "Update City" ),
                'add_new_item' => __( "Add New City" ),
                'new_item_name' => __( "New City Name" ),
                'menu_name' => __( "Cities" )
            ),
            'public' => true,
            'publicly_queryable' => null,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'show_tagcloud' => true,
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => true,
            'capabilities' => array(),
            'meta_box_cb' => null,
            'show_admin_column' => false,
            '_builtin' => false,
            'show_in_quick_edit' => null,
        ) );

        register_taxonomy( 'works', array( 'builders' ), array(
            'label' => 'Works',
            'labels' => array(
                'name' => __( "Works" ),
                'singular_name' => __( "Work" ),
                'search_items' => __( "Search Works" ),
                'all_items' => __( "All Works" ),
                'parent_item' => __( "Parent Work" ),
                'parent_item_colon' => __( "Parent Work:" ),
                'edit_item' => __( "Edit Work" ),
                'update_item' => __( "Update Work" ),
                'add_new_item' => __( "Add New Work" ),
                'new_item_name' => __( "New Work Name" ),
                'menu_name' => __( "Works" )
            ),
            'public' => true,
            'publicly_queryable' => null,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'show_tagcloud' => true,
            'hierarchical' => false,
            'update_count_callback' => '',
            'rewrite' => true,
            'capabilities' => array(),
            'meta_box_cb' => null,
            'show_admin_column' => false,
            '_builtin' => false,
            'show_in_quick_edit' => null,
        ) );
    }
}