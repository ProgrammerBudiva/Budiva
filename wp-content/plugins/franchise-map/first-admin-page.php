<?php
if( !defined( 'ABSPATH' ) )
    exit;
?>

<div class="wrap">
    <h1>GO-GO-GO</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <?php wp_nonce_field( 'franchise-upload-csv', 'nnc' ); ?>

        <p class="submit">
            <input type="submit" id="submit" class="button button-primary" value="GO-GO-GO">
        </p>
    </form>
</div>