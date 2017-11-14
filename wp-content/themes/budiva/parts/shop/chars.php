<?php if( count( $product_chars ) > 0 || $product->get_sku() || $product->has_weight() || $product->has_dimensions() ) : ?>
    <h4>Характеристики</h4>

    <?php if( $product->get_sku() ) : ?>
        <p><b>Артикул:</b> <?php echo $product->get_sku(); ?></p>
    <?php endif; ?>

    <?php if( $product->has_weight() ) : ?>
        <p>
            <b>Вес:</b> <?php echo wc_format_localized_decimal( $product->get_weight() ) . ' ' . __( get_option( 'woocommerce_weight_unit' ), 'woocommerce' ); ?>
        </p>
    <?php endif; ?>

    <?php if( $product->has_dimensions() ) : ?>
        <p><b>Габариты:</b> <?php echo $product->get_dimensions(); ?></p>
    <?php endif; ?>

    <?php foreach( $product_chars as $char ) : ?>
        <p><b><?= $char['name']; ?>:</b> <?= implode( ', ', $char['value'] ); ?></p>
    <?php endforeach; ?>
<?php endif; ?>