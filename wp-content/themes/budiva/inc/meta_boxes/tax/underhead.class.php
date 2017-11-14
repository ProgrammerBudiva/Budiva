<?php

namespace MetaBoxes\Tax;

class Underhead
{
    public static function add() {
        add_action( "product_cat_add_form_fields", array( "MetaBoxes\Tax\Underhead", "display_create" ) );
        add_action( "product_cat_edit_form_fields", array( "MetaBoxes\Tax\Underhead", "display_edit" ) );
    }

    public static function display_create() {
        $default_img = \Images::get_underhead_default_img();
        $img_id = 0;
        $img = $default_img;
        return include( locate_template( 'parts/admin/meta-box-underhead-category.php' ) );
    }

    public static function display_edit( $term ) {
        $default_img = \Images::get_underhead_default_img();
        $img_id = get_term_meta( $term->term_id, "underhead", true );
        $img = ( $img_id ) ? wp_get_attachment_image_src( $img_id, array( 115, 90 ) )[0] : $default_img;
        return include( locate_template( 'parts/admin/meta-box-underhead-category.php' ) );
    }

    public static function save_hook() {
        add_action( "create_product_cat", array( "MetaBoxes\Tax\Underhead", "save" ) );
        add_action( "edited_product_cat", array( "MetaBoxes\Tax\Underhead", "save" ) );
    }

    public static function save( $term_id ) {
        if( !isset( $_POST['underhead'] ) )
            return;
        update_term_meta( $term_id, 'underhead', $_POST['underhead'] );
        return $term_id;
    }
}