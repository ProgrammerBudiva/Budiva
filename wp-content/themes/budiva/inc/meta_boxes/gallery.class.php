<?php

namespace MetaBoxes;

class Gallery
{
    public static $post_types = array( 'builders' );

    public static function add() {
        add_meta_box( 'gallery', 'Галерея', array( "MetaBoxes\Gallery", 'display' ), self::$post_types, 'normal' );
    }

    public static function display( $post ) {
        self::_display( $post->ID, 'post' );
    }

    public static function _display( $id, $type, $new = false ) {
        $default_img = \Images::get_underhead_default_img();
        $img = array();

        if( $type == 'post' )
            $img_id = get_post_meta( $id, "gallery_images", true );
        elseif( $type == 'term' )
            $img_id = get_term_meta( $id, "gallery_images", true );

        $img_ids = ( !empty( $img_id ) ) ? json_decode( $img_id ) : false;

        if( !$new && !empty( $img_ids ) && $img_ids && is_array( $img_ids ) ) {
            foreach( $img_ids as $i )
                $img[] = array(
                    "id" => $i,
                    "src" => wp_get_attachment_image_src( $i, array( 115, 90 ) )[0]
                );
        }
        else
            $img_id = '[]';

        if( $type == 'post' )
            return include( locate_template( 'parts/admin/meta-box-gallery-post.php' ) );
        elseif( $type == 'term' )
            return include( locate_template( 'parts/admin/meta-box-gallery-term.php' ) );
    }

    public static function save( $post_id ) {
        return self::_save( $post_id, 'post' );
    }

    public static function _save( $id, $post_type ) {
        if( !isset( $_POST['gallery_images'] ) )
            return false;

        if( $post_type == 'post' )
            update_post_meta( $id, "gallery_images", $_POST['gallery_images'] );
        elseif( $post_type == 'term' )
            update_term_meta( $id, "gallery_images", $_POST['gallery_images'] );

        return $id;

    }
}