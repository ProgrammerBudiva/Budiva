<?php

$products = get_post_meta( get_the_ID(), 'manufacturer_products', true );

if( !empty( $products ) )
    $products_query = new WP_Query( array(
        'post_type' => 'product',
        'post__in' => $products,
        'posts_per_page' => -1
    ) );
else
    $products_query = false;

get_header();

get_template_part( 'parts/underhead' ); ?>

    <div class="content-wrap">
        <div class="container">

            <div class="container-bg">
                <?php while( have_posts() ) : the_post();
                    $post = budiva_posts_right_date( $post ); ?>

                    <?php if( !get_post_meta( $post->ID, 'has_preview_inner', true ) ) : ?>
                        <div class="news-image">
                            <?= wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), 'size-270x?', false, array(
                                'class' => '',
                                'alt' => 'alt_to_change'
                            ) ); ?>
                        </div>
                    <?php endif; ?>

                    <div itemtype="http://schema.org/Event" class="news-content clearfix">
                        <?php if( get_post_type( $post ) == 'news' ) : ?>
                            <span class="date"><time itemprop="startDate"><?= the_date( 'd-m-Y' ) ?></time></span>
                        <?php endif; ?>

                        <?php if( $h = get_post_meta( $post->ID, 'additional_header', true ) ) : ?>
                            <div class="h2 primary-header">
                                <span itemprop="name"><?= $h; ?></span>
                            </div>
                        <?php endif; ?>

                        <p itemprop="description"><?php the_content(); ?></p>

                        <?php get_template_part( 'parts/tabs' ); ?>

                        <?php if( !empty( $products_query ) && $products_query->have_posts() ) : ?>
                            <div class="manufacturer-products subcategory-container">
                                <div class="tiles">
                                    <?php while( $products_query->have_posts() ) : $products_query->the_post(); ?>
                                        <div class="tile square" itemscope itemtype="http://schema.org/Product">
                                            <div class="tile-wrapper first-type">
                                                <?php the_post_thumbnail( array( 570, 570 ) ); ?>
                                                <div class="bg">
                                                    <div class="center">
                                                        <p itemprop="name"><?php the_title(); ?></p>
                                                    </div>
                                                </div>
                                                <a href="<?php the_permalink(); ?>">
                                                    <h3 itemprop="name"><?php the_title(); ?></h3>

                                                    <p itemprop="description"><?= get_the_excerpt(); ?></p>

                                                    <div class="btn">Подробнее</div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endwhile; ?>
                <div class="clear"></div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>