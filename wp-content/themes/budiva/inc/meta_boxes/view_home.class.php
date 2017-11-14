<?php

namespace MetaBoxes;

class ViewHome
{
    public static function add() {
        add_meta_box( 'view_home', 'Отображение на главной', array( "MetaBoxes\ViewHome", "display" ), array( 'post', 'news' ), 'side' );
    }

    public static function display() {
        global $post;
        $view = get_post_meta( $post->ID, 'view_home', true );
        $checked = ( $view ) ? "checked='checked'" : "";
        include( locate_template( 'parts/admin/meta-box-view-home.php' ) );
    }

    public static function save( $postID ) {
        global $post;
        if( isset( $_POST['view_home_save'] ) ) {
            $value = ( isset( $_POST['view_home'] ) ) ? 1 : 0;
            update_post_meta( $post->ID, 'view_home', $value );
        }
    }
}