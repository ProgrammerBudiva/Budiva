<?php

namespace MetaBoxes\Tax;

class Tabs extends \MetaBoxes\Tabs
{
    public static function add() {
        //add_action( "product_cat_add_form_fields", array( "MetaBoxes\Tax\Tabs", "display_create" ) );
        add_action( "product_cat_edit_form_fields", array( "MetaBoxes\Tax\Tabs", "display_edit" ), 99 );
    }
//
//    public static function display_edit( $term ) {
//        self::_display( $term->term_id, 'term' );
//    }
//
    public static function save_hook() {
        //add_action( "create_product_cat", array( "MetaBoxes\Tax\Underhead", "save" ) );
        add_action( "edited_product_cat", array( "MetaBoxes\Tax\Tabs", "save" ) );
    }
//
////    public static function save( $term_id ) {
////        self::_save( $term_id, 'term' );
////        return $term_id;
////    }
}