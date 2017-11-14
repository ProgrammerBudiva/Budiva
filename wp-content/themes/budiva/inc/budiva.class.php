<?php

class Budiva
{
    public static function add_image_sizes() {
        add_image_size( 'size-550x550', 550, 550, true );
        add_image_size( 'size-550x297', 550, 297, true );
        add_image_size( 'size-360x270', 360, 270, true );
        add_image_size( 'size-270x270', 270, 270, true );
        add_image_size( 'size-270x?', 270, 270, false );
        add_image_size( 'size-200x200', 200, 200, true );
        add_image_size( 'size-170x170', 170, 170, true );
        add_image_size( 'size-170x?', 170, 170, false );
        add_image_size( 'size-140x140', 140, 140, true );
        add_image_size( 'size-100x100', 100, 100, true );
    }

    public static function after_setup_theme() {
        remove_action( 'wp_head', 'rel_canonical' );

        register_nav_menu( 'top_menu_place', 'Top Menu' );
        register_nav_menu( 'header_menu_place', 'Header Menu' );

        remove_image_size( 'shop_thumbnail' );
        remove_image_size( 'shop_catalog' );
        remove_image_size( 'shop_single' );

        remove_image_size( 'menu-24x24' );
        remove_image_size( 'menu-36x36' );
        remove_image_size( 'menu-48x48' );

        remove_image_size( 'thumb' );
        remove_image_size( 'thumbnail' );
        remove_image_size( 'medium' );
        remove_image_size( 'large' );
        remove_image_size( 'post-thumbnail' );
    }

    public static function enqueue_scripts() {
        global $smof_data;
        $uri = get_stylesheet_directory_uri();

        if( !is_admin() ) {
            wp_dequeue_style( 'mo_openid_admin_settings_style' );
            wp_dequeue_style( 'mo_openid_admin_settings_phone_style' );
            wp_dequeue_style( 'mo-wp-bootstrap-social' );
            wp_dequeue_style( 'mo-wp-bootstrap-main' );
            wp_dequeue_style( 'mo-wp-font-awesome' );
        }

        wp_enqueue_style( 'open-sans-google-css', 'https://fonts.googleapis.com/css?family=Open+Sans' );
        wp_enqueue_style( 'bootstrap', $uri . "/css/bootstrap.css" );
        wp_enqueue_style( 'awesome', $uri . "/css/font-awesome.min.css" );
        wp_enqueue_style( 'lightbox', $uri . "/css/lightbox.css" );
        wp_enqueue_style( 'jquery-bxslider', $uri . "/css/jquery.bxslider.css" );
        wp_enqueue_style( 'print', $uri . "/css/print.css", array( 'bootstrap', 'main-style' ), false, 'print' );
        wp_enqueue_style( 'main-style', $uri . "/style.css" );

        wp_enqueue_script( 'jquery', $uri . '/js/jquery.min.js', array(), "1.11.0", true );

        wp_enqueue_script( 'jquery-maskedinput', $uri . '/js/jquery.maskedinput.min.js', array( "jquery" ), false, true );
        wp_enqueue_script( 'lightbox', $uri . '/js/lightbox.js', array( "jquery" ), false, true );
        wp_enqueue_script( 'jquery-bxslider', $uri . '/js/jquery.bxslider.js', array( "jquery" ), false, true );
        wp_enqueue_script( 'video-show-script', $uri . '/js/video-show-script.js', array( "jquery" ), false, true );
        wp_enqueue_script( 'budiva', $uri . '/js/budiva.js', array( "jquery" ), false, true );

        if( !is_user_logged_in() ) {
            wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js' );
            wp_enqueue_script( 'reg-ajax', $uri . '/js/reg.js', array( "jquery" ), false, true );
        }


        wp_enqueue_script( 'core-feedback-modal', $uri . '/js/core-feedback-modal.js', array( "jquery" ), false, true );
        wp_enqueue_script( 'bootstrap', $uri . '/js/bootstrap.min.js', array( "jquery" ), false, true );
        wp_enqueue_script( 'scrollTo', $uri . '/js/jquery.scrollTo.min.js', array( "jquery" ), false, true );

        wp_localize_script( 'reg-ajax', 'reg_vars', array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
            )
        );

        $current_user = wp_get_current_user();
        wp_localize_script( 'budiva', 'reg_vars', array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'name' => $current_user->display_name,
                'phone' => get_user_meta( $current_user->ID, 'user_telephone', true ),
                'email' => $current_user->user_email,
                'theme_uri' => THEME_URI
            )
        );

        wp_localize_script( 'core-feedback-modal', 'sliders_speed', array(
                'slider_home_speed' => intval( $smof_data["slider_home_speed"] ),
                'slider_advantages_speed' => intval( $smof_data["slider_advantages_speed"] ),
                'slider_manufacturers_speed' => intval( $smof_data["slider_manufacturers_speed"] ),
            )
        );

        wp_enqueue_script( 'prettyPhoto' );
        wp_enqueue_script( 'prettyPhoto-init' );

        wp_enqueue_style( 'woocommerce_prettyPhoto_css' );
    }

    public static function auth_email_is_confirmed( $user, $username ) {
        $user_obj = get_user_by( ( is_email( $username ) ? 'email' : 'login' ), $username );

        if( is_a( $user_obj, 'WP_User' ) ) {
            $reg_method = get_user_meta( $user_obj->ID, USER_REG_METHOD_META_KEY, true );
            $email_confirmed = get_user_meta( $user_obj->ID, EMAIL_CONFIRMED_META_KEY, true );

            if( $reg_method == 'online' && $email_confirmed !== 'true' ) {
                remove_action( 'authenticate', 'wp_authenticate_username_password', 20 );
                return new WP_Error( 'email_not_confirmed', "Вы не подтвердили свой email." );
            }
        }

        return $user;
    }

    public static function body_class( $classes ) {
        if( !empty( trim( do_shortcode( '[woof]' ) ) ) )
            $classes[] = 'have-filter';

        if( is_tax( 'product_cat' ) ) {
            $category = get_queried_object();
            if( $category->parent == 0 )
                $classes[] = 'category-parent';
        }

        return $classes;
    }

    public static function page_email_confirm() {
        global $post;

        if( isset( $_GET['action'] ) && $_GET['action'] == 'email_confirm' ) {
            global $wp_hasher;

            $user = get_user_by( 'id', intval( $_GET['userid'] ) );

            if( is_a( $user, 'WP_User' ) ) {
                if( empty( $wp_hasher ) ) {
                    require_once ABSPATH . WPINC . '/class-phpass.php';
                    $wp_hasher = new PasswordHash( 8, true );
                }

                $hashed = get_user_meta( $user->ID, EMAIL_CONFIRMED_META_KEY, true );

                if( rawurldecode( $_GET['key'] ) == $hashed || $hashed === 'true' ) {
                    update_user_meta( $user->ID, EMAIL_CONFIRMED_META_KEY, 'true' );

                    $post->post_content = '
						<h2>Регистрация успешно завершена!</h2>
						<p>Теперь Вы можете <a href="#" id="btn-login">войти</a> на сайт.</p>';

                    $user = wp_signon( array(
                        'user_login' => $user->user_email,
                        'user_password' => base64_decode( $_GET["hash"] ),
                        'remember' => true
                    ), false );

                    if( !is_wp_error( $user ) )
                        header( "Location: " . get_permalink( 379 ) . "?action=register_success" );
                    //header( "Location: " . home_url() );
                }
                else {
                    $post->post_content = '
						<h2>Что-то пошло не так!</h2>
						<p>Попробуйте еще раз или обратитесь к администратору сайта.</p>';
                }
            }
            else {
                $post->post_content = '
						<h2>Что-то пошло не так!</h2>
						<p>Попробуйте еще раз или обратитесь к администратору сайта.</p>';
            }
        }
        elseif( isset( $_GET['action'] ) && $_GET['action'] == 'register_success' ) {
            $post->post_content = '
                <h2>Поздравляем!</h2>
                <p>Вы успешно активировали свою учетную запись!</p>
                <p>Теперь покупка строительных материалов будет выгодной и удобной!</p>';
        }
        else {
            wp_safe_redirect( '/' );
        }
    }

    public static function get_similar_products( $post_id, $term_slug ) {
        $similar_products = get_post_meta( $post_id, 'similar_products', true );
        if( !empty( $similar_products ) ) {
            $args = array(
                'post_type' => 'product',
                'post__in' => $similar_products,
                'posts_per_page' => 4
            );
        }
        else {
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 4,
                'orderby' => 'rand',
                'tax_query' => array(
                    'relation' => 'OR',
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => array( $term_slug )
                    )
                )
            );
        }
        return new WP_Query( $args );
    }
}