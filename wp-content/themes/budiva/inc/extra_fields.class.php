<?php

class ExtraFields
{
    public static function edit_account_form() {
        $user_id = get_current_user_id();
        $user_telephone = get_user_meta( $user_id, 'user_telephone', true );
        $user_get_news = get_user_meta( $user_id, 'user_get_news', true );
        $user_get_news_add_suggestions = get_user_meta( $user_id, 'user_get_news_add_suggestions', true );
        $user_get_articles = get_user_meta( $user_id, 'user_get_articles', true );
        include( locate_template( "parts/woocommerce_extra_fields.php" ) );
    }

    public static function save_account_form( $user_id ) {
        update_user_meta( $user_id, 'user_telephone', htmlentities( $_POST['user_telephone'] ) );
        update_user_meta( $user_id, 'user_get_news', self::get_field_for_update( 'user_get_news' ) );
        update_user_meta( $user_id, 'user_get_news_add_suggestions', self::get_field_for_update( 'user_get_news_add_suggestions' ) );
        update_user_meta( $user_id, 'user_get_articles', self::get_field_for_update( 'user_get_articles' ) );
    }

    public static function get_field_for_update( $name ) {
        return ( !empty( $_POST[$name] ) && $_POST[$name] == 'on' ) ? 1 : 0;
    }
}