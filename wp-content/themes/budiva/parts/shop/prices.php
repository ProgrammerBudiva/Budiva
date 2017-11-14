<?php if( $fields['_regular_price'][0] ) : ?>
    <?php if( $product->get_regular_price() != $product->get_display_price() ) : ?>
        <div class="price only-pc">
            Цена от
            <span class="old"><?= $product->get_regular_price(); ?></span>
            <span><?= $product->get_display_price(); ?></span>
            гривен
        </div>
    <?php else : ?>
        <div class="price only-pc">
            Цена от <span><?= $product->get_display_price(); ?></span> гривен
        </div>
    <?php endif; ?>
<?php endif; ?>