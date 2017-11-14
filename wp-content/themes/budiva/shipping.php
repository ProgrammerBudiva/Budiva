<?php
/*
	Template Name: Shipping
*/

get_header();

$post_id = get_the_ID();

get_template_part( 'parts/underhead' ); ?>

    <div class="content-wrap container-shipping">
        <div class="container only-pc">
            <div class="row">
                <div class="col-md-3 back-num back-num-1">
                    <div class="h3"><?= get_post_meta( $post_id, '1_1_h', true ); ?></div>

                    <p><?= get_post_meta( $post_id, '1_1_t', true ); ?></p>
                </div>
                <div class="col-md-3 back-num back-num-2">
                    <div class="h3"><?= get_post_meta( $post_id, '1_2_h', true ); ?></div>

                    <p><?= get_post_meta( $post_id, '1_2_t', true ); ?></p>
                </div>
                <div class="col-md-3 back-num back-num-3">
                    <div class="h3"><?= get_post_meta( $post_id, '1_3_h', true ); ?></div>

                    <p><?= get_post_meta( $post_id, '1_3_t', true ); ?></p>
                </div>
                <div class="col-md-3 back-num back-num-4">
                    <div class="h3"><?= get_post_meta( $post_id, '1_4_h', true ); ?></div>

                    <p><?= get_post_meta( $post_id, '1_4_t', true ); ?></p>
                </div>
            </div>
        </div>
        <div class="container container-small">
            <div class="col-md-12 shipping-head">
                <div class="h2"><?= get_post_meta( $post_id, '2_h', true ); ?></div>

                <p><?= get_post_meta( $post_id, '2_t', true ); ?></p>
            </div>
            <div class="col-md-4 adv">
                <div class="for-img-cont">
                    <img src="<?= THEME_URI; ?>/img/shipping/ship-1.png" alt="бесплатная доставка"/>
                </div>

                <p><?= get_post_meta( $post_id, '2_1_t', true ); ?></p>
            </div>
            <div class="col-md-4 adv">
                <div class="for-img-cont">
                    <img src="<?= THEME_URI; ?>/img/shipping/ship-2.png" alt="доставка в любую точку украины"/>
                </div>

                <p><?= get_post_meta( $post_id, '2_2_t', true ); ?></p>
            </div>
            <div class="col-md-4 adv">
                <div class="for-img-cont">
                    <img src="<?= THEME_URI; ?>/img/shipping/ship-3.png" alt="возможен самовывоз"/>
                </div>

                <p><?= get_post_meta( $post_id, '2_3_t', true ); ?></p>
            </div>
            <div class="col-md-12 shipping-head">
                <div class="h2"><?= get_post_meta( $post_id, '3_h', true ); ?></div>

                <p><?= get_post_meta( $post_id, '3_t', true ); ?></p>
            </div>
            <div class="col-md-4 adv">
                <div class="for-img-cont">
                    <img src="<?= THEME_URI; ?>/img/shipping/pay-1.png" alt="Наличный"/>
                </div>

                <p><?= get_post_meta( $post_id, '3_1_t', true ); ?></p>
            </div>
            <div class="col-md-4 adv">
                <div class="for-img-cont">
                    <img src="<?= THEME_URI; ?>/img/shipping/pay-2.png" alt="оплата на банковскую карточку"/>
                </div>

                <p><?= get_post_meta( $post_id, '3_2_t', true ); ?></p>
            </div>
            <div class="col-md-4 adv">
                <div class="for-img-cont">
                    <img src="<?= THEME_URI; ?>/img/shipping/pay-3.png" alt="безналичный расчет"/>
                </div>

                <p><?= get_post_meta( $post_id, '3_3_t', true ); ?></p>
            </div>
            <div class="clear"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 shipping-foot">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>