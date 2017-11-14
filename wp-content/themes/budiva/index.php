<?php
/*
	Template Name: Blog
*/

get_header();


get_template_part( 'parts/underhead' ); ?>

    <div class="news-block container">
        <?php if( have_posts() ) : ?>
            <div class="row">
                <?php while( have_posts() ) :
                    the_post();
                    $post = budiva_posts_right_date( $post );
                    get_template_part( 'parts/blog-content' );
                endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="clear"></div>

<?php if( function_exists( 'budiva_wp_corenavi' ) )
    budiva_wp_corenavi(); ?>
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