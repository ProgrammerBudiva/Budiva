<?php

namespace MetaBoxes;

class Posts
{
    public static function add_boxes() {
        Underhead::add();
        ViewHome::add();
        Tabs::add();
        Gallery::add();
    }

    public static function save_boxes( $postID, $post, $update ) {
        Underhead::save( $postID );
        ViewHome::save( $postID );
        Tabs::save( $postID, $post, $update );
        Gallery::save( $postID );
    }
}