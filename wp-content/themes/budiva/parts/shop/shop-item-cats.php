<div class="row subcategories">
    <?php foreach( $item['subcategories'] as $subcategory ) : ?>
        <div class="col-md-6 subcategory only-pc">
            <a class="index-news-title-url" href="<?= get_term_link( $subcategory['data']->term_id, 'product_cat' ); ?>">
                <div class="h2 page-title"><?= $subcategory['data']->name; ?></div>
            </a>

            <div class="tiles tile">
                <?php foreach( $subcategory['posts'] as $post ) : ?>
                    <div class="tile-wrapper second-type">
                        <?= get_the_post_thumbnail( $post->ID, 'size-270x270' ); ?>
                        <a class="bg" href="<?= get_permalink( $post->ID ); ?>">
                            <div class="center">
                                <p><?= $post->post_title; ?></p>
                            </div>

                            <div class="btn">Подробнее</div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="clear"></div>
</div>