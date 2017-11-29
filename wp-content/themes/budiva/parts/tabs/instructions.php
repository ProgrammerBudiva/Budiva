<?php
$counter = 0;
$count = count( $instructions );
?>

<?php foreach( $instructions as $instruction ) : ?>
<!--    echo "<pre>"; print_r($instruction); echo "</pre>";-->
    <?php $counter++; ?>
    <?php $type = explode( "/", get_post_mime_type( $instruction['file_id'] ) )[0]; ?>

    <?php if( ( $counter % 3 ) == 1 ) : ?>
        <div class="row">
    <?php endif; ?>

    <div class="col-md-4 col-sm-6 single-instruction">
        <div class="row">
            <div class="col-md-5 col-sm-5 instruction-image">
                <?= str_replace( "__INS__", "<img src='{$instruction['preview']}' alt='{$instruction['name']}'>", $instruction['link'] ); ?>
            </div>
            <div class="col-md-7 col-sm-7 instruction-content"><?= str_replace( "__INS__", $instruction['name'], $instruction['link'] ); ?></div>
        </div>
    </div>

    <?php if( ( ( $counter % 3 ) == 0 ) || ( $counter == $count ) ) : ?>
        </div>
    <?php endif; ?>

<?php endforeach; ?>
