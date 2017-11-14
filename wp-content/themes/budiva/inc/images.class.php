<?php

class Images
{
    private static $patterns = array(
        'фото $NAME$',
        'фотография $NAME$',
        'изображение $NAME$',
        '$NAME$ фото',
        '$NAME$ фотография',
        '$NAME$ изображение',
    );

    public static function get_default_img() {
        return THEME_URI . "/img/no-photo.jpg";
    }

    public static function get_underhead_default_img() {
        return THEME_URI . "/img/underhead-default.jpg";
    }

    public static function get_underhead_img() {
        global $post, $smof_data, $term;
        $img = Images::get_underhead_default_img();
        if( is_page() ) {
            $img_id = self::get_page_underhead_img( $post->ID );
            $img = ( $img_id ) ? wp_get_attachment_image_src( $img_id, 'full' )[0] : Images::get_underhead_default_img();
        }
        elseif( is_product() ) {
            $img_id = self::get_page_underhead_img( $post->ID );
            if( !$img_id ) {
                $term = wp_get_object_terms( $post->ID, 'product_cat' )[0];
                $img_id = self::get_category_underhead_img( $term->term_id );
                $img = ( $img_id ) ? wp_get_attachment_image_src( $img_id, 'full' )[0] : Images::get_underhead_default_img();
            }
            else
                $img = wp_get_attachment_image_src( $img_id, 'full' )[0];
        }
        elseif( is_singular( 'manufacturer' ) ) {
            $img_id = self::get_page_underhead_img( 1110 );
            $img = ( $img_id ) ? wp_get_attachment_image_src( $img_id, 'full' )[0] : Images::get_underhead_default_img();
        }
        elseif( is_single() ) {
            $img_id = self::get_page_underhead_img( $post->ID );
            $img = ( $img_id ) ? wp_get_attachment_image_src( $img_id, 'full' )[0] : $smof_data['und_single'];
            //$img = $smof_data['und_single'];
        }
        elseif( is_blog() ) {
            $img = $smof_data['und_blog'];
        }
        elseif( is_search() ) {
            $img = $smof_data['und_search'];
        }
        elseif( is_shop() ) {
            $img = $smof_data['und_catalog'];
        }
        elseif( is_product_category() ) {
            $img_id = self::get_category_underhead_img( get_queried_object()->term_id );
            $img = ( $img_id ) ? wp_get_attachment_image_src( $img_id, 'full' )[0] : Images::get_underhead_default_img();
        }

        return str_replace( "http://", "https://", $img );
    }

    public static function the_content_change_image_alt( $content, $title = false ) {
        if( !is_singular( array( 'product', 'news', 'post' ) ) && !is_tax( 'product_cat' ) && !is_page( 10 ) )
            return $content;

        $pattern = "/alt=(\"|')(\"|')/";
        while( preg_match( $pattern, $content ) )
            $content = preg_replace( $pattern, 'alt="' . self::get_changed_alt( $title ) . '"', $content );
        return $content;
    }

    public static function change_image_alt( $attr, $attachment, $size ) {
        if( !empty( $attr['alt_title'] ) && empty( $attr['alt'] ) )
            $attr['alt'] = self::get_changed_alt( $attr['alt_title'] );

        if( $attr['alt'] == 'alt_to_change' )
            $attr['alt'] = self::get_changed_alt();

        if( !empty( $attr['alt_title'] ) )
            unset( $attr['alt_title'] );

        return $attr;
    }

    private static function get_changed_alt( $title = false ) {
        if( !$title )
            $title = get_the_title();

        $pattern = each( self::$patterns )['value'];
        if( !$pattern ) {
            reset( self::$patterns );
            $pattern = each( self::$patterns )['value'];
        }

        return str_replace( '$NAME$', $title, $pattern );
    }

    private static function get_category_underhead_img( $id ) {
        $img_id = get_term_meta( $id, "underhead", true );
        if( !$img_id ) {
            $term = get_term( $id );
            if( $term->parent )
                return self::get_category_underhead_img( $term->parent );
        }
        return $img_id;
    }

    private static function get_page_underhead_img( $id ) {
        $img_id = get_post_meta( $id, "underhead", true );
        if( !$img_id ) {
            $post = get_post( $id );
            if( $post->post_parent )
                return self::get_page_underhead_img( $post->post_parent );
        }
        return $img_id;
    }
}