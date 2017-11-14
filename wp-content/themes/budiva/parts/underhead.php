<?php
$class = "";
/*if( is_single() || is_product() )
    $class = "only-pc";*/
?>

<div class="underhead <?= $class; ?>" style="background:url('<?= Images::get_underhead_img(); ?>') no-repeat; background-size: cover; background-position:center;">
    <div class="container">
        <div class="breadcrumbs">
            <?php /*if( function_exists( 'bcn_display' ) )
                bcn_display();*/ ?>
            <?php
            if( function_exists( 'yoast_breadcrumb' ) ) {
                yoast_breadcrumb();
            }
            ?>
        </div>
        <h1><?= budiva_get_page_name(); ?></h1>
    </div>
</div>