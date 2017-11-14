<?php

get_header();

get_template_part( 'parts/underhead' ); ?>

    <div class="content-wrap">
        <div class="container">

            <div class="container-bg">
                <?php while( have_posts() ) : the_post();
                    $post = budiva_posts_right_date( $post ); ?>

                    <?php if( !get_post_meta( $post->ID, 'has_preview_inner', true ) ) : ?>
                        <div class="news-image 123">
                            <?= wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), 'size-270x270', false, array(
                                'class' => '',
                                'alt' => 'alt_to_change'
                            ) ); ?>
                        </div>
                    <?php endif; ?>

                    <div itemtype="http://schema.org/Event" class="news-content">
                        <?php if( get_post_type( $post ) == 'news' ) : ?>
                            <span class="date"><time itemprop="startDate"><?= the_date( 'd-m-Y' ) ?></time></span>
                        <?php endif; ?>

                        <?php if( $h = get_post_meta( $post->ID, 'additional_header', true ) ) : ?>
                            <div class="h2 primary-header">
                                <span itemprop="name"><?= $h; ?></span>
                            </div>
                        <?php endif; ?>

                        <p><span itemprop="description"><?php the_content(); ?></span></p>
                    </div>
                <?php endwhile; ?>
                <div class="clear"></div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>