<?php

class Media
{
    public function __construct() {
        add_filter( 'attachment_fields_to_edit', array( $this, 'add_fields_edit_media' ), 10, 2 );
        add_action( 'edit_attachment', array( $this, 'save_fields' ) );
    }

    public function add_fields_edit_media( $fields, $post ) {
        $fields["media-popup-name"] = array(
            "label" => __( 'Media popup name', 'budiva' ),
            "input" => "html",
            "html" => '<input type="text" name="media_popup_name" value="' . esc_attr( get_post_meta( $post->ID, 'media_popup_name', true ) ) . '" class="widefat" />'
        );

        return $fields;
    }

    public function save_fields( $attachment_id ) {
        $value = ( !empty( $_POST['media_popup_name'] ) ) ? $_POST['media_popup_name'] : '';
        update_post_meta( $attachment_id, 'media_popup_name', $value );
    }
}