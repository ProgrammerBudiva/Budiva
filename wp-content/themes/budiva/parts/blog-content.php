<div itemscope itemtype="http://schema.org/NewsArticle" class="col-md-6 index-news-container news-item <?= ( get_field( 'action' ) ) ? 'type-action' : 'type-news'; ?> clearfix">

    <?php if( !get_post_meta( $post->ID, 'has_preview_outer', true ) ) : ?>
        <div class="index-thumbnails-box">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'size-200x200' ); ?>
            </a>

            <?php if( get_field( 'action' ) ) : ?>
                <div class="stock"></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="index-content-box clearfix" itemprop="articleBody">
        <p class="news-date"><?php the_date(); ?></p>

        <a href="<?php the_permalink(); ?>" itemprop="headline" class="h2 news-name">
            <?php the_title(); ?>
        </a>

        <p class="news-txt" itemprop="description">
            <?= wp_trim_words( $post->post_content, 18, ' ... ' . get_more_link( get_permalink( $post->ID ), 'подробнее' ) ); ?>
        </p>
    </div>
</div>