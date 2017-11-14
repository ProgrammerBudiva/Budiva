<?php

if( !defined( 'ABSPATH' ) ) {
    exit;
}

get_header( 'shop' );

if( is_shop() )
    get_template_part( 'parts/shop/shop' );
elseif( is_product_category() ) {
    if( get_queried_object()->parent )
        get_template_part( 'parts/shop/subcategory' );
    else
        get_template_part( 'parts/shop/category' );
}

get_footer( 'shop' );

?>
