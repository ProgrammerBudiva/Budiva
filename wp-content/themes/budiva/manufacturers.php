<?php
/*
	Template Name: Manufacturers
*/

get_header();

get_template_part( 'parts/underhead' );

if( !$page = get_query_var( 'paged' ) )
    $page = 1;
$args = array(
    'posts_per_page' => -1,
    'post_type' => 'manufacturer',
    'orderby' => 'meta_value_num',
    'meta_key' => 'priority',
    //'offset' => ( get_option( 'posts_per_page' ) * ( $page - 1 ) )
);
$query = new WP_Query( $args );
?>

    <div class="content-wrap">
        <div class="container">

            <?php if( have_posts() ) : ?>
                <?php while( have_posts() ) : the_post(); ?>
                    <div class="container-bg">
                        <div class="news-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>

            <?php while( $query->have_posts() ) : $query->the_post(); ?>

                <div class="container-bg">

                    <div class="news-content">
                        <div class="row">

                            <div class="col-md-3 col-sm-6">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'size-270x?' ); ?>
                                </a>
                            </div>

                            <div class="col-md-9 col-sm-12">
                                <a href="<?php the_permalink(); ?>">
                                    <div class="h2 news-name"><?php the_title(); ?></div>
                                </a>

                                <?php the_excerpt(); ?>
                            </div>

                        </div>
                    </div>
                </div>

            <?php endwhile; ?>

            <?php /* if( function_exists( 'budiva_wp_corenavi' ) )
                budiva_wp_corenavi( $query->max_num_pages ); */  ?>
            <div class="clear"></div>
        </div>
    </div>

<?php get_footer(); ?>