<?php

namespace MetaBoxes\Tax;

class Gallery extends \MetaBoxes\Gallery
{
    public static function add() {
        add_action( "product_cat_add_form_fields", array( "MetaBoxes\Tax\Gallery", "display_create" ) );
        add_action( "product_cat_edit_form_fields", array( "MetaBoxes\Tax\Gallery", "display_edit" ) );
    }

    public static function display_create() {
        self::display_term( 0, true );
    }

    public static function display_edit( $term ) {
        self::display_term( $term->term_id );
    }

    public static function display_term( $term_id, $new = false ) {
        self::_display( $term_id, 'term', $new );
    }

    public static function save_hook() {
        add_action( "create_product_cat", array( "MetaBoxes\Tax\Gallery", "save" ) );
        add_action( "edited_product_cat", array( "MetaBoxes\Tax\Gallery", "save" ) );
    }

    public static function save( $term_id ) {
        return self::_save( $term_id, 'term' );
    }
}