<?php

class Ajax
{
    public static function login_user() {
        if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'budiva_login' ) ) {
            self::wr_response( 'Ooops, something went wrong, please try again later.' );
        }

        if( empty( $_POST['log'] ) || empty( $_POST['pwd'] ) ) {
            self::wr_response( "Не все поля заполнены." );
        }

        $user = wp_signon();

        if( is_wp_error( $user ) ) {
            $signon_errors = array(
                'invalid_username' => 'Неправильный Email или Пароль.',
                'incorrect_password' => 'Неправильный Email или Пароль.',
                'empty_username' => 'Введите Email.',
                'empty_password' => 'Введите Пароль.',
            );
            $error_code = $user->get_error_code();

            if( isset( $signon_errors[$error_code] ) ) {
                self::wr_response( $signon_errors[$error_code] );
            }
            else {
                self::wr_response( $user->get_error_message() );
            }
        }

        self::wr_response( "", 1 );
    }

    public static function register_user() {
        if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'budiva_new_user' ) )
            self::wr_response( 'Ooops, something went wrong, please try again later.' );

//        if( !self::recaptcha_verify( $_POST['recaptcha'] ) ) {
//            self::wr_response( "Нажмите на капчу." );
//        }

        $username = sanitize_text_field( $_POST['user'] );
        $username = $email = sanitize_text_field( $_POST['mail'] );

        if( empty( $username ) || empty( $email ) )
            self::wr_response( "Не все поля заполнены" );

        if( !is_email( $email ) )
            self::wr_response( "Некорректный E-mail" );

        if( username_exists( $username ) )
            self::wr_response( "Такой пользователь уже зарегистрирован. <a href='#' id='recover-link'>Забыли пароль?</a>", 2 );

        if( email_exists( $email ) )
            self::wr_response( "Такой E-mail уже зарегистрирован", 2 );

        $password = wp_generate_password( 12, false );

        $user_id = wp_create_user( $username, $password, $email );

        // Return
        if( !is_wp_error( $user_id ) ) {
            global $wp_hasher;

            // Now insert the key, hashed, into the DB.
            if( empty( $wp_hasher ) ) {
                require_once ABSPATH . WPINC . '/class-phpass.php';
                $wp_hasher = new PasswordHash( 8, true );
            }
            $key = $wp_hasher->HashPassword( $password );

            update_user_meta( $user_id, EMAIL_CONFIRMED_META_KEY, $key );
            update_user_meta( $user_id, USER_REG_METHOD_META_KEY, 'online' );

            $current_user = get_user_by( 'id', $user_id );
            $current_user->first_name = sanitize_text_field( $_POST['user'] );
            wp_update_user( $current_user );

            $delivery = ExtraFields::get_field_for_update( 'delivery' );
            update_user_meta( $user_id, 'user_telephone', htmlentities( $_POST['phone'] ) );
            update_user_meta( $user_id, 'user_get_news', $delivery );
            update_user_meta( $user_id, 'user_get_news_add_suggestions', $delivery );
            update_user_meta( $user_id, 'user_get_articles', $delivery );

            $subject = "Регистрация на сайте";
            $headers = "Content-Type: text/html; charset=utf-8\r\n";
            $headers .= "From: site@budiva.ua\r\n";

            $text = "<p>Поздравляем! Вы успешно зарегистрированы на сайте <a style='color: #0077cc; text-decoration: none;' href='" . get_home_url() . "'>budiva.ua</a>.</p>";
            $text .= "<p>Вам необходимо перейти по ссылке ниже, чтобы завершить регистрацию.</p>";
            $text .= '<p>' . get_permalink( 379 ) . "?action=email_confirm&key=" . rawurlencode( $key ) . "&userid=" . $user_id . "&hash=" . base64_encode( $password ) . "</p>";
            $text .= "<p style='font-weight:bold; color:#177ca3;'>Ваши данные для авторизации на сайте:</p>
			<p><b>E-mail для входа:</b> {$username}<br />
			<b>Ваш пароль:</b> {$password}</p>";

            wp_mail( $email, $subject, $text, $headers );

            self::wr_response( "На Вашу почту выслано письмо для подтверждения регистрации.<br />Перейдите, пожалуйста, по указанной в письме ссылке для завершния регистрации.", 1 );
        }
        else
            self::wr_response( $user_id->get_error_message() );
    }

    public static function lost_password() {
        if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'budiva_lost_pwd' ) )
            die( 'Ooops, something went wrong, please try again later.' );

        $email = sanitize_text_field( $_POST['email'] );

        if( !email_exists( $email ) )
            self::wr_response( "Пользователя с таким E-mail не существует" );

        $user = get_user_by( 'email', $email );
        $password = wp_generate_password( 12, false );

        wp_set_password( $password, $user->ID );

        $headers = "Content-Type: text/html; charset=utf-8\r\n";
        $subject = "Изменение пароля";

        $text = "<p>Здравствуйте</p>";
        $text .= "<p>Вы воспользовались формой восстановления пароля на сайте <a style='color: #40c6f0; text-decoration: none;' href='" . get_home_url() . "'>budiva.ua</a>.</p><br>";
        $text .= "<p style='font-weight:bold; color:#177ca3;'>Ваши данные для авторизации на сайте:</p>
			<p><b>E-mail для входа:</b> {$email}<br />
			<b>Ваш пароль:</b> {$password}</p>";

        wp_mail( $email, $subject, $text, $headers );

        self::wr_response( "Новый пароль отправлен на почту", 1 );
    }

    public static function gen_bad_link() {
        if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'budiva_bad_link' ) )
            die( 'Ooops, something went wrong, please try again later.' );

        $link = sanitize_text_field( $_POST['link'] );

        $subject = "Сообщение о битой ссылке";
        $text = "На сайте найдена битая ссылка: {$link}";
        $headers = "Content-Type: text/html; charset=utf-8\r\n";
        wp_mail( get_option( 'admin_email' ), $subject, $text, $headers );

        self::wr_response( true );
    }

    public static function wr_response( $text, $code = 0 ) {
        $resp = array(
            'text' => $text,
            'code' => $code
        );
        die( json_encode( $resp ) );
    }

    public static function recaptcha_verify( $response_token ) {
        $is_human = false;

        if( empty( $response_token ) )
            return $is_human;

        $response = wp_safe_remote_post( 'https://www.google.com/recaptcha/api/siteverify', array(
                'body' => array(
                    'secret' => '6LcP_xoUAAAAANIIs3-r4GCJMqwskq7O6Jd82SNB',
                    'response' => $response_token,
                    'remoteip' => $_SERVER['REMOTE_ADDR']
                )
            )
        );

        if( 200 != wp_remote_retrieve_response_code( $response ) ) {
            return $is_human;
        }

        $response = wp_remote_retrieve_body( $response );
        $response = json_decode( $response, true );

        $is_human = isset( $response['success'] ) && true == $response['success'];

        return $is_human;
    }

    public static function get_tab() {
        $type = sanitize_text_field( $_POST['type'] );
        $custom_id = sanitize_text_field( $_POST['custom_id'] );
        $post_type = sanitize_text_field( $_POST['post_type'] );
        $product_id = intval( $_POST['product_id'] );

        $tabs = new Tabs();
        echo $tabs->get_tab( $type, $post_type, $product_id, $custom_id );
        exit();
    }
}