<?php if( !empty( $videos ) ) : ?>
    <div class="row">
        <?php foreach( $videos as $video ) : ?>
            <div class="col-sm-6">
                <a href="<?= $video['link']; ?>" data-rel="prettyPhoto" title="<?= $video['name']; ?>">
                    <img src="<?= $video['preview_link']; ?>" alt="<?= $video['name']; ?>">
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


