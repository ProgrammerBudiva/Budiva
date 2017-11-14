<?php

namespace MetaBoxes;

class Underhead
{
    public static function add() {
        add_meta_box( 'underhead', 'Картинка под шапкой', array( "MetaBoxes\Underhead", "display" ), array( 'page', 'product', 'post', 'news' ), 'advanced', 'high' );
    }

    public static function display() {
        global $post;
        $default_img = \Images::get_underhead_default_img();
        $img_id = get_post_meta( $post->ID, "underhead", true );
        $img = ( $img_id ) ? wp_get_attachment_image_src( $img_id, array( 115, 90 ) )[0] : $default_img;
        include( locate_template( 'parts/admin/meta-box-underhead.php' ) );
    }

    public static function save( $postID ) {
        global $post;
        if( isset( $_POST['underhead'] ) ) {
            update_post_meta( $post->ID, 'underhead', $_POST['underhead'] );
        }
    }
}