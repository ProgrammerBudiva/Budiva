<?php

class Widgets
{
    public static function register_sidebars() {
        register_sidebar( array(
            'name' => __( 'Footer widget 1' ),
            'id' => 'footer-widget-area-1',
            'description' => __( 'Footer widget 1' ),
            'before_title' => '<div class="h2 widgettitle">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
        ) );

        register_sidebar( array(
            'name' => __( 'Footer widget 2' ),
            'id' => 'footer-widget-area-2',
            'description' => __( 'Footer widget 2' ),
            'before_title' => '<div class="h2 widgettitle">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
        ) );

        register_sidebar( array(
            'name' => __( 'Footer widget 3' ),
            'id' => 'footer-widget-area-3',
            'description' => __( 'Footer widget 3' ),
            'before_title' => '<div class="h2 widgettitle">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
        ) );

        register_sidebar( array(
            'name' => __( 'Footer widget 4' ),
            'id' => 'footer-widget-area-4',
            'description' => __( 'Footer widget 4' ),
            'before_title' => '<div class="h2 widgettitle">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
        ) );

        register_sidebar( array(
            'name' => __( 'Mobile Menu' ),
            'id' => 'mobile-menu',
            'description' => __( 'Mobile Menu' ),
            'before_title' => '<div class="h2 widgettitle">',
            'after_title' => '</div>',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
        ) );

        register_sidebar( array(
            'name' => __( 'Filter' ),
            'id' => 'filter-widget',
            //'description' => __( 'Footer widget 4' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
        ) );
    }
}