<?php

get_template_part( 'parts/underhead' );

get_template_part( 'parts/additional-menu' );

$data = budiva_get_shop_page_data( true, false );

?>

<div class="content-wrap">
    <div class="container page-shop">
        <?php foreach( $data as $item ) : ?>
            <?php
            $taxonomy = $item['category']->taxonomy;
            $term_id = $item['category']->term_id;
            $garant = get_field( 'garant', $taxonomy . '_' . $term_id );
            if( $garant < 1 )
                $garant = 0;
            ?>

            <div class="single-category-full" itemscope itemtype="http://schema.org/Product">
                <div class="container-bg">
                    <div class="news-content">
                        <div class="news-image">
                            <a href="<?= get_term_link( $item['category']->term_id, 'product_cat' ); ?>">
                                <?= budiva_get_category_image( $item['category']->term_id, 'size-360x270' ); ?>
                            </a>

                            <?php if( $garant ) : ?>
                                <div class="varranty">
                                    <div class="text1">Гарантия</div>
                                    <div class="value"><?= $garant ?></div>
                                    <div class="text2">лет</div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="h2 category-name" itemprop="name">
                            <a href="<?= get_term_link( $item['category']->term_id, 'product_cat' ); ?>"><?= $item['category']->name; ?></a>
                        </div>

                        <div itemprop="description">
                            <?= wpautop( get_field( 'short_desc_category', $item['category']->taxonomy . '_' . $item['category']->term_id ) ); ?>
                        </div>


                        <div class="more">
                            <a class="btn-blue" href="<?= get_term_link( $item['category']->term_id, 'product_cat' ); ?>">Подробнее</a>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <?php include( locate_template( 'parts/shop/shop-item-' . $item['template'] . '.php' ) ); ?>

        <?php endforeach; ?>
    </div>
</div>
