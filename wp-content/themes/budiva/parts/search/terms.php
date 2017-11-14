<div class="tiles">
    <?php foreach( $this->queries[$type]->terms as $term ) : ?>
        <div class="tile square" itemscope itemtype="http://schema.org/Product">
            <div class="tile-wrapper first-type">
                <?= wp_get_attachment_image( get_term_meta( $term->term_id, 'thumbnail_id', true ), array( 550, 550 ) ); ?>
                <div class="bg">
                    <div class="center">
                        <p><?= $term->name; ?></p>
                    </div>
                </div>
                <a href="<?= get_term_link( $term->term_id, 'product_cat' ); ?>">
                    <div class="h3" itemprop="name"><?= $term->name; ?></div>

                    <p itemprop="description"><?php the_field( 'short_desc', $term->taxonomy . '_' . $term->term_id ); ?></p>

                    <div class="btn">Подробнее</div>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>