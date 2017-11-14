<?php

class Tinymce
{
    public static function add_custom_buttons() {
        if( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
            return;
        }

        if( 'true' == get_user_option( 'rich_editing' ) ) {
            add_filter( 'mce_external_plugins', array( 'Tinymce', 'add_plugin' ) );
            add_filter( 'mce_buttons', array( 'Tinymce', 'register_button' ) );
        }
    }

    public static function add_style() {
        add_editor_style( 'css/tinymce.css' );
    }

    public function add_plugin( $plugin_array ) {
        $plugin_array['my_mce_button'] = THEME_URI . '/js/tinymce.js';
        return $plugin_array;
    }

    public static function register_button( $buttons ) {
        array_push( $buttons, 'my_mce_button' );
        return $buttons;
    }
}