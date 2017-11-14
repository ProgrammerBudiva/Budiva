<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woothemes.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     1.6.4
 */

if( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header( 'shop' );

get_template_part( 'parts/underhead' );

while( have_posts() ) : the_post();
    $post = budiva_posts_right_date( $post );
    $fields = get_post_custom( $post->ID );
    $term = wp_get_post_terms( $post->ID, 'product_cat' )[0];
    $product_chars = budiva_get_product_chars( $post->ID );
    $product = wc_get_product( $post->ID );
    $attachment_ids = $product->get_gallery_attachment_ids();
    $similar_products = Budiva::get_similar_products( $post->ID, $term->slug );
    $woocommerce_shop_page_id = get_option( 'woocommerce_shop_page_id' );
    ?>

    <div class="content-wrap single-product">
        <div class="container">
            <div class="container-bg">

                <div class="product-header clearfix">
                    <?php if( $attachment_ids ) : ?>
                        <div class="news-image has-bx clearfix">
                            <div class="thumbnails" style="height: 0; overflow: hidden;">
                                <?php if( count( $attachment_ids ) == 2 ) : ?>
                                    <?php
                                    //printf( '<div class="slide"><a href="%s" title="%s" class="zoom" data-rel="prettyPhoto[product-gallery]">%s</a></div>', $image_link, $title, $image );
                                    ?>
                                <?php endif; ?>

                                <?php foreach( $attachment_ids as $attachment_id ) :

                                    $image_link = strtolower(wp_get_attachment_url( $attachment_id ));

                                    if( !$image_link )
                                        continue;

                                    $image_title = esc_attr( get_the_title( $attachment_id ) );

                                    $image = wp_get_attachment_image( $attachment_id, 'size-270x270', 0, $attr = array(
                                        'title' => $image_title,
                                        'alt_title' => $post->post_title
                                    ) );

                                    $title = get_post_meta( $attachment_id, 'media_popup_name', true );
                                    // $title = $image_title;

                                    printf( '<div class="slide"><a href="%s" title="%s" class="zoom" data-rel="prettyPhoto[product-gallery]">%s</a></div>', $image_link, $title, $image );
                                endforeach; ?>
                            </div>
                            <?php
                            $thumb = get_post_thumbnail_id( $id );

                            $title = get_post_meta( get_post_thumbnail_id(), 'media_popup_name', true );

                            printf(
                                '<a href="%s" title="%s" class="zoom" data-rel="prettyPhoto[product-gallery]">%s</a>',
                                strtolower(wp_get_attachment_url( $thumb )),
                                $title,
                                strtolower(budiva_get_image_by_id( $thumb, 'size-270x270', false, array(
                                    'alt_title' => $post->post_title,
                                )) )
                            );
                            ?>
                        </div>
                    <?php else : ?>
                        <div class="news-image">
                            <a href="<?= wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>" class="zoom" data-rel="prettyPhoto[product-gallery]">
                                <?= budiva_get_post_image( $post->ID, 'size-270x270', false, array(
                                    'alt_title' => $post->post_title
                                ) ); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="product-title">
                        <div class="h2 primary-header only-pc"><span><?= $post->post_title; ?></span></div>

                        <a href="#" class="btn btn-blue" data-toggle="modal" data-target="#orderForm">
                            Заказать для моего объекта
                        </a>

                        <div class="one-click">
                            Купить в 1 клик
                            <div class="inner">
                                <?= do_shortcode( '[contact-form-7 id="2200"]' ); ?>
                            </div>
                        </div>
                    </div>

                    <div class="product-shipping">
                        <?php
                        $shipping_data = get_post_meta( $post->ID, 'shipping_data', true );
                        if( empty( $shipping_data ) || !$shipping_data )
                            $shipping_data = get_post_meta( $woocommerce_shop_page_id, 'all_shipping', true );

                        $payment_data = get_post_meta( $post->ID, 'payment_data', true );
                        if( empty( $payment_data ) || !$payment_data )
                            $payment_data = get_post_meta( $woocommerce_shop_page_id, 'all_payment', true );

                        $stock_image = get_post_meta( $post->ID, 'stock_image', true );
                        ?>

                        <?php if( !empty( $shipping_data ) && $shipping_data ) : ?>
                            <div class="cont">
                                <div class="header shipping-header">Доставка</div>

                                <ul>
                                    <li><?= implode( '</li><li>', explode( "\r\n", $shipping_data ) ); ?></li>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if( !empty( $payment_data ) && $payment_data ) : ?>
                            <div class="cont">
                                <div class="header payment-header">Оплата</div>

                                <ul>
                                    <li><?= implode( '</li><li>', explode( "\r\n", $payment_data ) ); ?></li>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if( !empty( $stock_image ) && $stock_image ) : ?>
                            <?= wp_get_attachment_image( $stock_image, 'full' ); ?>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="news-content clearfix">

                    <?php // include( locate_template( 'parts/shop/prices.php' ) ); ?>
                    <?php // include( locate_template( 'parts/shop/chars.php' ) ); ?>

                    <?php get_template_part( 'parts/tabs' ); ?>

                    <?php include( locate_template( 'parts/shop/similar.php' ) ); ?>

                </div>
            </div>
        </div>

        <div class="container container-form">
            <div class="modal-container type-form" id="form1086">
                <?php get_template_part( 'parts/bid' ); ?>
            </div>
        </div>
    </div>


    <?php

endwhile; ?>

<div class="modal fade" role="dialog" id="orderForm">
    <div class="modal-dialog modal-form-bid">
        <button type="button" class="fancybox-close" data-dismiss="modal" aria-hidden="true"></button>
        <div class="modal-container type-form">
            <?php echo do_shortcode( '[contact-form-7 id="228" title="Заказ"]' ); ?>
        </div>
    </div>
</div>

<?php

get_footer( 'shop' );

?>
