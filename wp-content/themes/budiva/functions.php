<?php

define( "THEME_URI", get_stylesheet_directory_uri() );
define( "THEME_DIR", get_stylesheet_directory() );
include_once( THEME_DIR . "/top_menu_walker.php" );
include_once( THEME_DIR . "/header_menu_walker.php" );
include_once( THEME_DIR . "/top_menu_walker_mobile.php" );


define( 'EMAIL_CONFIRMED_META_KEY', 'budiva_email_confirmed' );
define( 'USER_REG_METHOD_META_KEY', 'budiva_user_reg_method' );

add_filter( 'xmlrpc_enabled', '__return_false' );

// Include SMOF Plugin for theme settings
include_once( THEME_DIR . "/admin/index.php" );

// Include menu walker to head menu

spl_autoload_register( function ( $classname ) {
    $dir = THEME_DIR . "/inc/" . strtolower( preg_replace( array( '/([a-z])([A-Z])/', '/\\\/' ), array( '$1_$2', "/" ), $classname ) ) . ".class.php";
    if( file_exists( $dir ) )
        include_once( $dir );
} );

Locales::set_locales();

Shortcodes::init();


// Add theme supports
if( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'menus' );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'title-tag' );
}


add_filter( 'wp_mail', array( "Mail", "add_top_and_bottom" ), 99, 3 );
//add_filter( 'wpcf7_support_html5_fallback', '__return_true' );

add_filter( 'menu_image_default_sizes', function ( $sizes ) {
    return array();
} );

// Add menus
add_action( 'after_setup_theme', array( "Budiva", "after_setup_theme" ) );
add_action( 'wp_enqueue_scripts', array( "Budiva", "enqueue_scripts" ) );

add_action( 'wp_get_attachment_image_attributes', array( "Images", "change_image_alt" ), 99, 3 );
add_action( 'the_content', array( "Images", "the_content_change_image_alt" ), 99 );


add_filter( 'wp_mail_from_name', function () {
    return get_bloginfo( 'name' );
}, 99 );

add_filter( 'excerpt_length', function () {
    if( is_front_page() )
        return 22;
    return 35;
}, 99 );

new Media();

function get_more_link( $link, $content = 'Read more' ) {
    return sprintf( "<a href='%s' class='read-more-link'>%s</a>", $link, $content );
}

// Delete NOODP from meta Robots
add_filter( 'wpseo_robots', function ( $robotsstr ) {
    return str_replace( array( ',noodp', 'noodp,', 'noodp' ), '', $robotsstr );
} );

if( !is_user_logged_in() ) {
    // Login AJAX
    add_action( 'wp_ajax_budiva_login_user', array( "Ajax", "login_user" ) );
    add_action( 'wp_ajax_nopriv_budiva_login_user', array( "Ajax", "login_user" ) );

    // Register AJAX
    add_action( 'wp_ajax_budiva_register_user', array( "Ajax", "register_user" ) );
    add_action( 'wp_ajax_nopriv_budiva_register_user', array( "Ajax", "register_user" ) );

    // Send lost password to email
    add_action( 'wp_ajax_lost_pwd', array( "Ajax", "lost_password" ) );
    add_action( 'wp_ajax_nopriv_lost_pwd', array( "Ajax", "lost_password" ) );
}

// AJAX tabs
add_action( 'wp_ajax_get_tab', array( "Ajax", "get_tab" ) );
add_action( 'wp_ajax_nopriv_get_tab', array( "Ajax", "get_tab" ) );


add_filter( 'authenticate', array( "Budiva", "auth_email_is_confirmed" ), 10, 2 );

add_action( 'woocommerce_edit_account_form', array( 'ExtraFields', 'edit_account_form' ) );
add_action( 'woocommerce_save_account_details', array( 'ExtraFields', 'save_account_form' ) );

$url = 'http://' . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];
$current_post_id = url_to_postid( $url );
// Verify email
if( $current_post_id == 379  )
    add_action( 'template_redirect', array( "Budiva", "page_email_confirm" ) );


if( is_404() ) {
    add_action( 'wp_ajax_gen_bad_link', 'gen_bad_link' );
    add_action( 'wp_ajax_nopriv_gen_bad_link', 'gen_bad_link' );
}


// Add widgets
add_action( 'widgets_init', array( "Widgets", "register_sidebars" ) );

// Add image sizes
if( function_exists( 'add_image_size' ) )
    Budiva::add_image_sizes();

// Getting right date in post
function budiva_posts_right_date( $post ) {
    $post->post_date = implode( '.', array_reverse( explode( '-', trim( explode( ' ', $post->post_date )[0] ) ) ) );
    return $post;
}

// Get category list for home block
function budiva_woo_cat_list() {
    return get_categories( array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'parent' => "0"
    ) );
}

add_filter( 'body_class', array( "Budiva", 'body_class' ) );

// Get sub-category list for home block
function budiva_woo_subcat_list( $parent, $count = 3 ) {
    $categories = get_categories( array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'parent' => intval( $parent ),
        'number' => $count
    ) );
    if( count( $categories ) > 0 ) {
        foreach( $categories as $key => $category ) {
            $priority = get_field( 'priority', 'product_cat_' . $category->term_id );
            $categories[$key] = array(
                'category' => $category,
                'priority' => $priority
            );
        }

        usort( $categories, function ( $a, $b ) {
            return ( intval( $b["priority"] ) - intval( $a["priority"] ) );
        } );

        foreach( $categories as $key => $category )
            $categories[$key] = $category['category'];

        return $categories;
    }

    $posts = get_posts( array(
        'post_type' => 'product',
        'numberposts' => 3,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $parent
            )
        )
    ) );

    foreach( $posts as $subkey => $post ) {
        $priority = intval( get_post_meta( $post->ID, 'priority', true ) );
        if( !$priority )
            $priority = 1;
        $posts[$subkey] = array(
            'post' => $post,
            'priority' => $priority
        );
    }

    usort( $posts, function ( $a, $b ) {
        return ( intval( $b["priority"] ) - intval( $a["priority"] ) );
    } );

    foreach( $posts as $subkey => $post )
        $posts[$subkey] = $post['post'];

    return $posts;
}

// Pagination
function budiva_wp_corenavi( $max = false ) {
    global $wp_query;
    $pages = '';
    if( !$max )
        $max = $wp_query->max_num_pages;
    if( !$current = get_query_var( 'paged' ) )
        $current = 1;
    $a['base'] = str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) );
    $a['total'] = $max;
    $a['current'] = $current;

    $total = 1; //1 - выводить текст "Страница N из N", 0 - не выводить
    $a['mid_size'] = 3; //сколько ссылок показывать слева и справа от текущей
    $a['end_size'] = 1; //сколько ссылок показывать в начале и в конце
    $a['prev_text'] = '&laquo;'; //текст ссылки "Предыдущая страница"
    $a['next_text'] = '&raquo;'; //текст ссылки "Следующая страница"
    $a['type'] = 'list';

    if( $max > 1 )
        echo '<div class="list-page"><ul>';
    //if ($total == 1 && $max > 1) $pages = '<span class="pages">Страница ' . $current . ' из ' . $max . '</span>'."\r\n";
    echo $pages . paginate_links( $a );
    if( $max > 1 )
        echo '</ul></div>';
}

// Get news for the news archive
function get_news_list() {
    return get_posts( array(
        'post_type' => 'news',
        'numberposts' => 0
    ) );
}


add_filter( 'gettext', 'upload_wp_text_convert', 20, 3 );
function upload_wp_text_convert( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'Товары' :
            $translated_text = __( 'Каталог товаров', 'woocommerce' );
            break;
    }
    return $translated_text;
}

function cities_sort( $a, $b ) {
    return ( intval( get_field( 'priority', 'city_' . $a->term_id ) ) > intval( get_field( 'priority', 'city_' . $b->term_id ) ) ) ? -1 : 1;
}

// Get the vacancies for the vacancies page
function get_vacancies() {
    $cities = get_categories( array(
        'taxonomy' => 'city',
        'hide_empty' => false
    ) );
    usort( $cities, 'cities_sort' );
    $data = array();
    foreach( $cities as $city ) {
        $data[] = array(
            'name' => $city->name,
            'a' => $city,
            'list' => get_posts( array(
                'post_type' => 'vacancies',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'city',
                        'field' => 'id',
                        'terms' => $city->term_taxonomy_id
                    )
                )
            ) )
        );
    }

    return $data;
}

function get_builders() {
    $cities = get_categories( array(
        'taxonomy' => 'city',
        'hide_empty' => false
    ) );
    usort( $cities, 'cities_sort' );
    $data = array();
    foreach( $cities as $city ) {
        $data[] = array(
            'name' => $city->name,
            'a' => $city,
            'list' => get_posts( array(
                'post_type' => 'builders',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'city',
                        'field' => 'id',
                        'terms' => $city->term_taxonomy_id
                    )
                )
            ) )
        );
    }

    return $data;
}

// Init actions
add_action( 'init', array( "PostTypes", "register_post_types" ) );

add_filter( 'sanitize_file_name', function ( $filename ) {
    return mb_strtolower( $filename );
}, 99 );

// Login form
add_filter( 'login_form_bottom', 'add_social', true );
function add_social( $register = false ) {
    $return = '';
    if( !$register )
        $return .= budiva_add_recover_link();
    if( !is_user_logged_in() && mo_openid_is_customer_registered() ) {
        $mo_login_widget = new mo_openid_login_wid();
        ob_start();
        $mo_login_widget->openidloginForm();
        $html = ob_get_contents();
        ob_end_clean();
        $return .= $html;
    }
    return $return;
}

// Register form
function budiva_register_form() {
    if( !is_user_logged_in() ) {
        ob_start();
        ( new LoginWithAjaxWidget() )->widget( array(), array() );
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}

// Get category thumbnail
function budiva_get_category_image( $id, $size = 'thumbnail' ) {
    $meta = get_woocommerce_term_meta( $id, 'thumbnail_id', true );
    return budiva_get_image_by_id( $meta, $size );
}

// Get the post thumbnail
function budiva_get_post_image( $id, $size = 'thumbnail', $icon = false, $attr = '' ) {
    $thumb = get_post_thumbnail_id( $id );
    return budiva_get_image_by_id( $thumb, $size, $icon, $attr );
}

// Get thumbnail by ID and size
function budiva_get_image_by_id( $id, $size = 'thumbnail', $icon = false, $attr = '' ) {
    if( !$id || !$code = wp_get_attachment_image( $id, $size, $icon, $attr ) )
        return "<img src='" . Images::get_default_img() . "' alt='no-image' title='no-image' />";
    else
        return $code;
}

// Get category products
function budiva_get_category_products( $id ) {
    $tax_query = budiva_get_category_request();
    $tax_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'id',
        'terms' => $id
    );
    $args = array(
        'post_type' => 'product',
        'numberposts' => -1,
        'tax_query' => $tax_query
    );

    $posts = get_posts( $args );

    foreach( $posts as $subkey => $post ) {
        $priority = intval( get_post_meta( $post->ID, 'priority', true ) );
        if( !$priority )
            $priority = 1;
        $posts[$subkey] = array(
            'post' => $post,
            'priority' => $priority
        );
    }

    usort( $posts, function ( $a, $b ) {
        return ( intval( $b["priority"] ) - intval( $a["priority"] ) );
    } );

    foreach( $posts as $subkey => $post )
        $posts[$subkey] = $post['post'];
    return $posts;
}

function budiva_get_subcategories_terms( $id ) {
    $subcategories = get_terms( array(
        'taxonomy' => 'product_cat',
        'parent' => $id,
        'hide_empty' => false,
        'orderby' => 'count',
        'order' => 'DESC'
    ) );
    $res = array();
    foreach( $subcategories as $subcategory )
        $res[] = $subcategory->term_id;
    return $res;
}

// Get data for shop page
function budiva_get_shop_page_data( $sort_categories = true, $sort_subcategories = true ) {
    $result = array();

    $categories = get_terms( array(
        'taxonomy' => 'product_cat',
        //'orderby' => 'include',
        'include' => array( '8', '35', '24', '47' )
    ) );

    foreach( $categories as $key => $category ) {
        $priority = $sort_categories ? get_field( 'priority', 'product_cat_' . $category->term_id ) : 1;
        $categories[$key] = array(
            'category' => $category,
            'priority' => $priority
        );
    }

    if( $sort_categories )
        usort( $categories, function ( $a, $b ) {
            return ( intval( $b["priority"] ) - intval( $a["priority"] ) );
        } );

    foreach( $categories as $c ) {
        $category = $c["category"];
        $subcategories = get_terms( array(
            'taxonomy' => 'product_cat',
            'parent' => $category->term_id,
            'hide_empty' => false,
            'orderby' => 'count',
            'order' => 'DESC'
        ) );

        foreach( $subcategories as $key => $subcategory ) {
            $priority = $sort_subcategories ? get_field( 'priority', 'product_cat_' . $subcategory->term_id ) : 1;
            $subcategories[$key] = array(
                'category' => $subcategory,
                'priority' => $priority
            );
        }

        if( $sort_subcategories )
            usort( $subcategories, function ( $a, $b ) {
                return ( intval( $b["priority"] ) - intval( $a["priority"] ) );
            } );

        $template = ( $subcategories ) ? "cats" : "prods";
        foreach( $subcategories as $key => $s ) {
            $subcategory = $s['category'];
            $posts = get_posts( array(
                'post_type' => 'product',
                'numberposts' => 3,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'id',
                        'terms' => $subcategory->term_id
                    )
                )
            ) );

            foreach( $posts as $subkey => $post ) {
                $priority = intval( get_post_meta( $post->ID, 'priority', true ) );
                if( !$priority )
                    $priority = 1;
                $posts[$subkey] = array(
                    'post' => $post,
                    'priority' => $priority
                );
            }

            usort( $posts, function ( $a, $b ) {
                return ( intval( $b["priority"] ) - intval( $a["priority"] ) );
            } );

            foreach( $posts as $subkey => $post )
                $posts[$subkey] = $post['post'];

            $subcategories[$key] = array(
                'data' => $subcategory,
                'posts' => $posts
            );
        }
        $products = ( $subcategories ) ? array() : get_posts( array(
            'post_type' => 'product',
            'numberposts' => 6,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $category->term_id
                )
            ),
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    "key" => "priority",
                    "compare" => "EXISTS"
                ),
                array(
                    "key" => "priority",
                    "compare" => "NOT EXISTS"
                )
            ),
            //"orderby" => "meta_value",
            //"meta_key" => "priority"
        ) );
        $result[] = array(
            'category' => $category,
            'subcategories' => $subcategories,
            'template' => $template,
            'products' => $products
        );

    }
    return $result;
}

// Get data for links on the shop page
function budiva_get_shop_links( $data ) {
    $links = array();
    if( count( $data['subcategories'] ) > 0 ) {
        foreach( $data['subcategories'] as $subcategory )
            $links[] = array(
                'link' => get_term_link( $subcategory['data']->term_id, 'product_cat' ),
                'anchor' => $subcategory['data']->name
            );
    }
    elseif( count( $data['products'] ) > 0 ) {
        foreach( $data['products'] as $product )
            $links[] = array(
                'link' => get_permalink( $product->ID ),
                'anchor' => $product->post_title
            );
    }
    return $links;
}

// Get page name
function budiva_get_page_name() {
    if( is_shop() )
        return "Каталог товаров";
    elseif( is_product_category() )
        return get_queried_object()->name;
    elseif( is_search() )
        return "Результаты поиска";
    elseif( is_blog() )
        return get_queried_object()->post_title;
    else
        return get_the_title();
}

// Check if page is blog
function is_blog() {
    return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag() ) && 'post' == get_post_type();
}

// get the popular products
function budiva_get_popular_products() {
    $attr = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => '-1',
        'meta_key' => '_featured',
        'meta_value' => 'yes'
    );
    return get_posts( $attr );
}

// Add metabox for the underhead image in pages
if( is_admin() ) {
    add_action( 'add_meta_boxes', array( "MetaBoxes\Posts", "add_boxes" ) );
    add_action( 'save_post', array( "MetaBoxes\Posts", "save_boxes" ), 90, 3 );

    MetaBoxes\Tax\Tax::add_boxes();
    MetaBoxes\Tax\Tax::save_boxes();

    add_action( 'admin_head', function () {
        wp_enqueue_style( "budiva_admin_css", THEME_URI . "/css/admin.css" );
    } );

    add_action( 'admin_head', array( 'Tinymce', 'add_custom_buttons' ) );
    add_action( 'current_screen', array( 'Tinymce', 'add_style' ) );

    new Admin\WpTable\ProductCat();
}

// Fix error with uploading PDF
/* if( class_exists( 'Tiny_Plugin' ) ) {
    $tiny = new Tiny_Plugin();
    global $wp_filter;
    var_dump( $wp_filter );
    exit( 0 );
    remove_filter( 'wp_generate_attachment_metadata',
        array( $tiny, 'compress_on_upload' ),
        10
    );
} */

function budiva_noindex_filter() {
    if( is_active_filter() )
        echo '<meta name="robots" content="noindex,nofollow"/>';
}

add_action( 'wp_head', 'budiva_noindex_filter' );

function is_active_filter() {
    $d = get_request_data();
    return ( isset( $d['filter'] ) && $d['filter'] == '1' ) ? true : false;
}

function get_request_data() {
    //return ( new WOOF() )->get_request_data();
}

function budiva_get_category_request( $term_id = false ) {
    $data = get_request_data();

    $res = array();
    $woo_taxonomies = NULL;
    $woo_taxonomies = get_object_taxonomies( 'product' );

    if( !empty( $data ) AND is_array( $data ) ) {
        foreach( $data as $tax_slug => $value ) {
            if( in_array( $tax_slug, $woo_taxonomies ) ) {
                $value = explode( ',', $value );
                $res[] = array(
                    'taxonomy' => $tax_slug,
                    'field' => 'slug',
                    'terms' => $value,
                );
            }
        }
    }

    if( $term_id ) {
        $tax_slug = 'product_cat';
        $slugs = array();
        $term = get_term( intval( $term_id ), $tax_slug );
        if( is_object( $term ) ) {
            $slugs[] = $term->slug;
        }

        if( !empty( $slugs ) ) {
            $res[] = array(
                'taxonomy' => $tax_slug,
                'field' => 'slug', //id
                'terms' => $slugs
            );
        }
    }


    if( !empty( $res ) ) {
        $res = array_merge( array( 'relation' => 'AND' ), $res );
    }

    return $res;
}

function budiva_remove_slug_product( $post_link, $post, $leavename ) {
    if( 'product' != $post->post_type || 'publish' != $post->post_status ) {
        return $post_link;
    }
    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
    return $post_link;
}

add_filter( 'post_type_link', 'budiva_remove_slug_product', 10, 3 );

function budiva_parse_request_product( $query ) {
    if( !$query->is_main_query() )
        return;

    if( 2 != count( $query->query ) || !isset( $query->query['page'] ) ) {
        return;
    }

    if( !empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'post', 'product', 'page' ) );
    }
}

add_action( 'pre_get_posts', 'budiva_parse_request_product' );

function budiva_get_product_chars( $id ) {
    $tax = get_object_taxonomies( 'product', 'objects' );
    unset( $tax['product_shipping_class'] );
    unset( $tax['product_type'] );
    unset( $tax['product_tag'] );
    unset( $tax['product_cat'] );
    unset( $tax['product_visibility'] );

    $res = array();
    foreach( $tax as $name => $value ) {
        $val = wp_get_post_terms( $id, $name );

        if( $val ) {
            $tmp = array(
                'name' => $value->label,
                'value' => array()
            );

            foreach( (array) $val as $v ) {
                $tmp['value'][] = $v->name;
            }

            $res[] = $tmp;
        }
    }

    return $res;
}

function pre( $data, $return = false ) {
    $data = "<pre>" . print_r( $data, true ) . "</pre>";
    if( $return )
        return $data;
    echo $data;
    return;
}

// Ставим 404 статус
add_action( 'pre_handle_404', 'remove_author_pages_page' );
function remove_author_pages_page( $false ) {
    global $wp_query;

    if( is_singular( 'vacancies' ) || is_singular( 'bgmp' ) || is_tax( 'city' ) ) {
        $wp_query->set_404();
        status_header( 404 );
        nocache_headers();

        return true;
    }

    return $false;
}

add_filter( 'excerpt_more', function ( $more ) {
    global $post;
    if( is_search() || is_singular( 'manufacturer' ) || is_singular( 'product' ) )
        return $more;
    return ' ... <a href="' . get_permalink( $post->ID ) . '" class="read-more-link">Подробнее</a>';
} );


add_action( 'pre_get_posts', 'budiva_search_items_count' );
function budiva_search_items_count( $query ) {
    if( $query->is_search && $query->is_main_query() ) {
        $query->set( 'posts_per_page', Search::$per_page );
        $query->set( 'post_type', 'product' );
    }
}

add_filter( 'manage_edit-product_cat_columns', 'add_views_column', 4 );
function add_views_column( $columns ) {
    unset( $columns["description"] );

    return $columns;
}

add_filter( 'wpseo_breadcrumb_links', function ( $crumbs ) {
    //unset( $crumbs[count( $crumbs )-1] );
    return $crumbs;
} );


add_filter( 'wpseo_breadcrumb_single_link', function ( $link_output ) {
    if( strpos( $link_output, 'breadcrumb_last' ) !== false ) {
        $link_output = '';
    }
    return $link_output;
} );


function request_url() {
    $result = ( isset( $_SERVER['HTTPS'] ) && ( $_SERVER['HTTPS'] == 'on' ) ) ? 'https://' : 'http://';
    $result .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    return $result;
}


//add_filter( 'wp_calculate_image_srcset', 'budiva_categories_rectange_images' );
function budiva_categories_rectange_images( $sources ) {
    if( !is_tax( 'product_cat' ) )
        return $sources;

    if( !empty( $sources['600'] ) ) {
        $sources['600']['url'] = str_replace( '600x600', '550x297', $sources['600']['url'] );
    }

    return $sources;
}

function is_ie() {
    return false;
    return ( isset( $_SERVER['HTTP_USER_AGENT'] ) && preg_match( "/(?i)msie|trident/", $_SERVER['HTTP_USER_AGENT'] ) );
}

function active( &$active, $class = true ) {
    if( $active )
        if( $class )
            echo ' class="active"';
        else
            echo ' active';

    $active = false;
}

/* Отключаем админ панель для всех, кроме администраторов. */
if (!current_user_can('administrator')):
    show_admin_bar(false);
endif;


add_action("wp_ajax_delete_product_price", "budiva_delete_price");

function budiva_delete_price(){

//    $prices = MetaBoxes\Tabs::get_post_prices( $_POST['post_id'], 'post', true );

    global $wpdb;
    $wpdb->update( 'wp_tabs_price',
        array('download_id' => 0),
        array('post_id' => $_POST['post_id'])
    );

//    $wpdb->update( 'wp_tabs_price',
//        array('download_id' => 0),
//        array('id' => $prices['id'])
//    );
}

add_action('wp_ajax_get_subscriber', 'save_subscriber');
function save_subscriber(){
    //Запись подписчика в бд
    global $wpdb;
    $check_email = $wpdb->get_results('Select id FROM subscribers WHERE email="'.$_POST["email"].'"');
    $subscriber_id = $check_email[0]->id;

    /**
     * Запись в бд, всех заявок
     */
    $date = date("Y-m-d H:i:s");
    $wpdb->insert(
        'custom_requests',
        array('email' => $_POST['email'], 'phone' => $_POST['phone'], 'form_name' => $_POST['name'], 'url_page' => $_POST['url'], 'created_at' => $date)
    );
    //Проверка, есть ли такой email уже в базе
    if(!isset($subscriber_id)) {
        $wpdb->insert(
            'subscribers',
            array('email' => $_POST['email'], 'type' => $_POST['type'])
        );

        $user = 'marketing@budiva.ua';
        $password = '546213';
        $create_contact_url = 'https://esputnik.com/api/v1/contact';

        $contact = new stdClass();
        $contact->channels = array(array('type'=>'email', 'value' => $_POST["email"]));
        $contact->groups = array(array('name' => $_POST['type']));
        send_request($create_contact_url, $contact, $user, $password);
    }
}
//Integration function with esputnik
function send_request($url, $json_value, $user, $password) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json_value));
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_USERPWD, $user.':'.$password);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
}


add_action('wp_ajax_save_article_category', 'save_article_category');

function save_article_category(){
    global $wpdb;

    $check = $wpdb->get_results('DELETE FROM wp_articles_to_categories WHERE article_id="'.$_POST["article"].'"');

    if(count($_POST['array']) > 1){

        foreach($_POST['array'] as $category) {

            $wpdb->insert(
                'wp_articles_to_categories',
                array('category_id' => $category[0], 'article_id' => $_POST['article'], 'type' => $category[1])
            );

        }
    }else{

        $wpdb->insert(
            'wp_articles_to_categories',
            array('category_id' => $_POST['array'][0][0], 'article_id' => $_POST['article'], 'type' => $_POST['array'][0][1])
        );
    }

    $response = '';

    if (empty($wpdb->last_error)){
        $response = 'Сохранено';
    }else{
        $response = 'Ошибка';
    }

    echo json_encode(array('data' => $response));
}

add_action( 'admin_menu', 'register_my_custom_menu_page' );
function register_my_custom_menu_page(){
    add_menu_page(
        'custom menu title', 'Заявки', 'manage_options', 'custom-requests-from-cf7/index.php', '', plugins_url( 'myplugin/images/icon.png' ), 6
    );
}

add_action('wp_ajax_save_new_post_category', 'save_new_post_category');

function save_new_post_category(){
    if (!empty($_POST['name'])) {
        global $wpdb;

        $wpdb->insert(
            'post_category',
            array('name' => $_POST['name'])
        );

        if ($wpdb->insert_id !== 0) {
            echo json_encode(array('data' => 'success'));
        } else {
            echo json_encode(array('data' => 'error'));
        }
    }else{
        echo json_encode(array('data' => 'error'));
    }
}

add_action('wp_ajax_save_posts_categories', 'save_posts_categories');

function save_posts_categories(){
    global $wpdb;
    $wpdb->get_results('DELETE FROM posts_to_categories WHERE post_id="'.$_POST["article"].'"');

    if(count($_POST['array']) > 1){

        foreach($_POST['array'] as $category) {

            $wpdb->insert(
                'posts_to_categories',
                array('category_id' => $category, 'post_id' => $_POST['article'])
            );
        }
    }else{

        $wpdb->insert(
            'posts_to_categories',
            array('category_id' => $_POST['array'], 'post_id' => $_POST['article'])
        );
    }

    if (empty($wpdb->last_error)){
        $response = 'Сохранено';
    }else{
        $response = $wpdb->last_error;
    }

    echo json_encode(array('data' => $response));
}

add_action('wp_ajax_nopriv_get_tag_posts', array('Ajax', 'get_tag_posts'));
