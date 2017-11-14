<?php

/**
 * @var $subcats
 */

if( !is_active_filter() ) {
    $cat = get_queried_object();

    $subcats = budiva_woo_subcat_list( $cat->term_id, 0 );
    if( $subcats[0] instanceof WP_Post ) {
        get_template_part( 'parts/shop/subcategory' );
        return;
    }
}
else
    $cat = get_queried_object();

get_template_part( 'parts/underhead' );

get_template_part( 'parts/filter' );

?>

<?php if( !is_active_filter() ) : ?>

    <div class="content-wrap category-page">
        <div class="container container-small">

            <div class="tiles have-cross">
                <?php foreach( $subcats as $cat_key => $category ) : ?>
                    <div class="tile square" itemscope itemtype="http://schema.org/Product">
                        <div class="tile-wrapper first-type">
                            <?= wp_get_attachment_image(
                                get_term_meta( $category->term_id, 'thumbnail_id', true ),
                                array( 550, 550 ),
                                false,
                                array(
                                    'data-small' => wp_get_attachment_image_src( get_term_meta( $category->term_id, 'thumbnail_id', true ), 'size-550x297' )[0],
                                    'alt_title' => $category->name
                                ) ); ?>

                            <div class="bg">
                                <div class="center">
                                    <p><?= $category->name; ?></p>
                                </div>
                            </div>
                            <a href="<?= get_term_link( $category->term_id, 'product_cat' ); ?>">
                                <div class="h3" itemprop="name"><?= $category->name; ?></div>

                                <p itemprop="description"><?php the_field( 'short_desc', $category->taxonomy . '_' . $category->term_id ); ?></p>

                                <div class="btn">Подробнее</div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="container">
            <div class="container-bg">
                <div class="news-content">
                    <div itemprop="name" class="h2 primary-header"><?= $cat->name; ?></div>

                    <?php get_template_part( 'parts/tabs' ); ?>

                    <?php /* <div class="manafacture-info clearfix" itemprop="description">
                        <?= wpautop( str_replace( "http://", "https://", Images::the_content_change_image_alt( do_shortcode( $cat->description ), budiva_get_page_name() ) ) ); ?>
                    </div> */ ?>
                </div>
            </div>
        </div>
    </div>

<?php else :
    $products = budiva_get_category_products( budiva_get_subcategories_terms( $cat->term_id ) );

    include( locate_template( 'parts/shop/product-list.php' ) );
endif; ?>

<div class="container">
    <div class="modal-container type-form" id="form1086">
        <?php get_template_part( 'parts/bid' ); ?>
    </div>
</div>