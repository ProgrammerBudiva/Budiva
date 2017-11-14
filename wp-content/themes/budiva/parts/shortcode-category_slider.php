<div class="category-slider">
    <div class="category-slider-start">
        <?php foreach( $img_ids as $img_id ) : ?>
            <div class="slide">
                <a href="<?= wp_get_attachment_image_src( $img_id, 'full' )[0]; ?>" title="<?= get_post_meta( $img_id, 'media_popup_name', true ); ?>" class="zoom" data-rel="prettyPhoto[product-gallery]">
                    <?= wp_get_attachment_image( $img_id, 'size-270x270' ); ?>
                </a>
            </div><?php endforeach; ?></div>
</div>

<?php

function get_image_sizes() {
    global $_wp_additional_image_sizes;

    $sizes = array();

    foreach( get_intermediate_image_sizes() as $_size ) {
        if( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
            $sizes[$_size]['width'] = get_option( "{$_size}_size_w" );
            $sizes[$_size]['height'] = get_option( "{$_size}_size_h" );
            $sizes[$_size]['crop'] = (bool) get_option( "{$_size}_crop" );
        }
        elseif( isset( $_wp_additional_image_sizes[$_size] ) ) {
            $sizes[$_size] = array(
                'width' => $_wp_additional_image_sizes[$_size]['width'],
                'height' => $_wp_additional_image_sizes[$_size]['height'],
                'crop' => $_wp_additional_image_sizes[$_size]['crop'],
            );
        }
    }

    return $sizes;
}