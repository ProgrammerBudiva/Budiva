<div class="products-list only-pc">
    <?php
    $class = "col-md-2";
    foreach( $item['products'] as $post )
        include( locate_template( 'parts/shop/shop-item-post.php' ) );
    ?>
    <div class="clear"></div>
</div>