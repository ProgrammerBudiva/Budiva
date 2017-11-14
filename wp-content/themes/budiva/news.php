<?php
/*
	Template Name: News
*/

get_header();

get_template_part( 'parts/underhead' );

get_template_part( 'parts/news-stock' ); ?>

    <div class="news-block container">

        <?php
        if( !$page = get_query_var( 'paged' ) )
            $page = 1;
        $args = array(
            'post_type' => 'news',
            'numberposts' => 0,
            'offset' => ( get_option( 'posts_per_page' ) * ( $page - 1 ) )
        );
        $news = new WP_Query( $args );
        if( $news->have_posts() ) : ?>
            <div class="row">
                <?php while( $news->have_posts() ) : $news->the_post();
                    $post = budiva_posts_right_date( $post );
                    $display_date = true;
                    get_template_part( 'parts/blog-content' );
                endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="clear"></div>
<?php if( function_exists( 'budiva_wp_corenavi' ) )
    budiva_wp_corenavi( $news->max_num_pages ); ?>
    <div class="clear"></div>

    <div class="container_sub">
        <?php
        $var[] = apply_filters( 'the_content', get_post_meta( $post->ID, 'subscribe_form', true ) );
        if( !empty( $var ) ) {
            echo apply_filters( 'the_content', get_post_meta( 10, 'subscribe_form', true ) );
        }
        ?>
    </div>

<?php get_footer(); ?>