<div class="tiles manufacturers">
    <?php while( $this->queries[$type]->have_posts() ) : $this->queries[$type]->the_post(); ?>
        <div class="tile square" itemscope itemtype="http://schema.org/Product">
            <div class="tile-wrapper first-type">
                <?php the_post_thumbnail( array( 570, 570 ) ); ?>
                <div class="bg"></div>
                <a href="<?php the_permalink(); ?>">
                    <div class="h3" itemprop="name"><?php the_title(); ?></div>

                    <div class="btn">Подробнее</div>
                </a>
            </div>
        </div>
    <?php endwhile; ?>
</div>