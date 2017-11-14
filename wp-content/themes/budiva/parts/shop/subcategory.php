<?php

get_template_part( 'parts/underhead' );

get_template_part( 'parts/filter' );

$cat = get_queried_object();

$products = budiva_get_category_products( $cat->term_id );

include( locate_template( 'parts/shop/product-list.php' ) );

?>

<div class="container">
    <div class="modal-container type-form" id="form1086">
        <?php get_template_part( 'parts/bid' ); ?>
    </div>
</div>