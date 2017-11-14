<div class="container container-small subcategory-container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-title">популярные товары</h2>
        </div>
    </div>

    <?php if( $products = budiva_get_popular_products() ) : ?>
        <div class="tiles">

            <?php foreach( budiva_get_popular_products() as $product ) : ?>
                <div class="tile square" itemscope itemtype="http://schema.org/Product">
                    <div class="tile-wrapper first-type">
                        <?= get_the_post_thumbnail( $product->ID, array( 570, 570 ) ); ?>
                        <div class="bg">
                            <div class="center">
                                <p itemprop="name"><?= $product->post_title; ?></p>
                            </div>
                        </div>
                        <a href="<?= get_permalink( $product->ID ); ?>">
                            <div class="h3" itemprop="name"><?= $product->post_title; ?></div>

                            <p itemprop="description"><?= $product->post_excerpt; ?></p>

                            <div class="btn">Подробнее</div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    <?php endif; ?>
</div>