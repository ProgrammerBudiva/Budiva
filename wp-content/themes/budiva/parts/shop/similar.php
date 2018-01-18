<?php if( !empty( $similar_products ) && $similar_products->have_posts() ) : ?>
    <div class="similar-products">
        <div class="primary-header">
            <span>С этим товаром покупают:</span>
        </div>

        <div class="tiles">
            <?php while( $similar_products->have_posts() ) : $similar_products->the_post(); ?>
                <div class="tile square" itemscope itemtype="http://schema.org/Product">
                    <div class="tile-wrapper first-type">
                        <?php the_post_thumbnail( array( 570, 570 ) ); ?>
                        <div class="bg">
                            <div class="center">
                                <p itemprop="name"><?php the_title(); ?></p>
                            </div>
                        </div>
                        <a href="<?php the_permalink(); ?>">
                            <div class="h3""><?php the_title(); ?></div>

                            <p itemprop="description"><?= get_the_excerpt(); ?></p>

                            <div class="btn">Подробнее</div>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>