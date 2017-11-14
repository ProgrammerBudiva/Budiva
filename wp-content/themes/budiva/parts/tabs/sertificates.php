<?php
$counter = 0;
$count = count( $sertificates );
?>

<?php foreach( $sertificates as $sertificate ) : ?>

    <?php $counter++; ?>
    <?php $type = explode( "/", get_post_mime_type( $sertificate['file_id'] ) )[0]; ?>

    <?php if( ( $counter % 3 ) == 1 ) : ?>
        <div class="row">
    <?php endif; ?>

    <div class="col-md-4 col-sm-6 single-sertificate">
        <div class="row">
            <div class="col-md-5 col-sm-5 sertificate-image">
                <?= str_replace( "__INS__", "<img src='{$sertificate['preview']}' alt='{$sertificate['name']}'>", $sertificate['link'] ); ?>
            </div>
            <div class="col-md-7 col-sm-7 sertificate-content"><?= str_replace( "__INS__", $sertificate['name'], $sertificate['link'] ); ?></div>
        </div>
    </div>

    <?php if( ( ( $counter % 3 ) == 0 ) || ( $counter == $count ) ) : ?>
        </div>
    <?php endif; ?>

<?php endforeach; ?>

<?php /* foreach( $sertificates as $sertificate ) : ?>

    <?php $counter++; ?>
    <?php $type = explode( "/", get_post_mime_type( $sertificate['file_id'] ) )[0]; ?>

    <?php if( ( $counter % 6 ) == 1 ) : ?>
        <div class="row">
    <?php endif; ?>

    <div class="col-md-2 col-sm-3 single-sertificate">
        <?= str_replace( "__INS__", "<img src='{$sertificate['preview']}' alt='{$sertificate['name']}'>", $sertificate['link'] ); ?>
    </div>

    <?php if( ( ( $counter % 6 ) == 0 ) || ( $counter == $count ) ) : ?>
        </div>
    <?php endif; ?>

<?php endforeach; */ ?>