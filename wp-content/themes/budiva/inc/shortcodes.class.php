<?php

class Shortcodes
{
    public static function init() {
        add_shortcode( "btn_buy", array( "Shortcodes", "btn_buy" ) );
        add_shortcode( "btn_write", array( "Shortcodes", "btn_write" ) );
        add_shortcode( "category_slider", array( "Shortcodes", "category_slider" ) );
    }

    public static function btn_buy( $atts = array() ) {
        $atts = shortcode_atts( array(
            "text" => "Заказать"
        ), $atts, "btn_buy" );
        return '<a href="#" class="btn-blue" data-toggle="modal" data-target="#orderForm">' . $atts["text"] . '</a>';
    }

    public static function btn_write( $atts = array() ) {
        $atts = shortcode_atts( array(
            "text" => "Заказать"
        ), $atts, "btn_buy" );
        return '<a href="#" class="btn-blue" data-toggle="modal" data-target="#bidForm">' . $atts["text"] . '</a>';
    }

    public static function category_slider( $attr ) {
        global $post;

        if( !is_tax() )
            return;

        $img_id = get_term_meta( get_queried_object()->term_id, "gallery_images", true );
        $img_ids = json_decode( $img_id );

        if( empty( $img_ids ) && !is_array( $img_ids ) )
            return;

        $images = array();
        foreach( $img_ids as $i )
            $images[] = wp_get_attachment_image_src( $i, array( 115, 90 ) )[0];

        ob_start();
        include( locate_template( "parts/shortcode-category_slider.php" ) );
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
}