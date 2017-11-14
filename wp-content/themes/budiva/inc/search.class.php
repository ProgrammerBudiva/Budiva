<?php

class Search
{
    public static $per_page = 6;
    private $types = array( 'products', 'manufacturers', 'posts', 'categories' );
    private $search = '';
    private $is_type = false;

    private $queries = array(
        'products' => false,
        'manufacturers' => false,
        'posts' => false,
        'categories' => false
    );
    private $count = array(
        'products' => 0,
        'manufacturers' => 0,
        'posts' => 0,
        'categories' => 0
    );

    public function __construct( $search ) {
        $this->search = $search;
        if( !empty( $this->search ) ) {
            if( !empty( $_GET['type'] ) && in_array( $_GET['type'], $this->types ) ) {
                $function_name = "load_" . trim( $_GET['type'] );
                $this->$function_name( $this->get_current_offset() );
                $this->is_type = true;
            }
            else {
                $this->load_products();
                $this->load_manufacturers();
                $this->load_posts();
                $this->load_categories();
            }
        }
    }

    public function get_template( $template, $type, $name ) {
        if( $this->count[$type] > 0 ) {
            include( locate_template( "parts/search/header.php" ) );
            include( locate_template( "parts/search/{$template}.php" ) );

            if( $this->is_type ) {
                $max_num_pages = intval( ceil( $this->count[$type] / $this::$per_page ) );
                if( $max_num_pages > 1 ) {
                    echo '<div class="list-page"><ul>';
                    echo paginate_links( array(
                        'base' => str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
                        'total' => $max_num_pages,
                        'current' => $this->get_current_page(),
                        'mid_size' => 3,
                        'end_size' => 1,
                        'prev_text' => '&laquo;',
                        'next_text' => '&raquo;',
                        'type' => 'list',
                    ) );
                    echo '</ul></div>';
                }
            }
        }
    }

    public function have_query() {
        return ( !empty( $this->search ) );
    }

    public function have_results() {
        if(
            $this->count['products'] > 0 ||
            $this->count['manufacturers'] > 0 ||
            $this->count['posts'] > 0 ||
            $this->count['categories'] > 0
        )
            return true;
        return false;
    }

    private function get_current_offset() {
        return intval( ( $this->get_current_page() - 1 ) * $this::$per_page );
    }

    private function get_current_page() {
        return max( intval( get_query_var( 'paged' ) ), 1 );
    }

    private static function full_link( $type ) {
        echo home_url( '?s=' . urlencode( $_GET['s'] ) ) . "&type=" . urlencode( $type );
    }

    private static function partial_link() {
        echo home_url( '?s=' . urlencode( $_GET['s'] ) );
    }

    private function load_products( $offset = 0 ) {
        global $wp_query;
        $this->queries['products'] = $wp_query;
        $this->count['products'] = $this->queries['products']->found_posts;
    }

    private function load_manufacturers( $offset = 0 ) {
        $this->queries['manufacturers'] = new WP_Query( array(
            's' => $this->search,
            'post_status' => 'publish',
            'post_type' => 'manufacturer',
            'posts_per_page' => $this::$per_page,
            'offset' => $offset
        ) );
        $this->count['manufacturers'] = $this->queries['manufacturers']->found_posts;
    }

    private function load_posts( $offset = 0 ) {
        $this->queries['posts'] = new WP_Query( array(
            's' => $this->search,
            'post_status' => 'publish',
            'post_type' => array( 'post', 'news' ),
            'posts_per_page' => $this::$per_page,
            'offset' => $offset
        ) );
        $this->count['posts'] = $this->queries['posts']->found_posts;
    }

    private function load_categories( $offset = 0 ) {
        $this->queries['categories'] = new WP_Term_Query( array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
            'search' => $this->search,
            'number' => $this::$per_page,
            'offset' => $offset
        ) );
        $this->count['categories'] = get_terms( array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
            'search' => $this->search,
            'fields' => 'count'
        ) );
    }
}