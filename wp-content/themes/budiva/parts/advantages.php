<?php global $smof_data; ?>

<section class="advantages not-print">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="h4">Сотрудничать с нами удобно и выгодно:</div>
            </div>
        </div>

        <?php if( ( $adv_count = count( $smof_data["advantages_block"] ) ) > 0 ) : ?>
            <?php
            $place = array();
            if( $adv_count == 1 )
                $place[1] = "col-md-offset-9-24";
            elseif( $adv_count == 2 )
                $place[1] = "col-md-offset-3";
            elseif( ( $adv_count % 4 ) == 3 )
                $place[$adv_count - 2] = "col-md-offset-3-24";
            elseif( ( $adv_count % 4 ) == 2 ) {
                $place[$adv_count - 2] = "col-md-offset-3-24";
                $place[$adv_count - 5] = "col-md-offset-3-24";
            }
            elseif( ( $adv_count % 4 ) == 1 ) {
                $place[$adv_count - 1] = "col-md-offset-3";
                $place[$adv_count - 4] = "col-md-offset-3-24";
            }
            if( ( $adv_count % 2 ) == 1 )
                if( empty( $place[$adv_count - 1] ) )
                    $place[$adv_count - 1] = " col-sm-offset-3";
                else
                    $place[$adv_count - 1] .= " col-sm-offset-3";

            $counter = 0;
            ?>
            <div class="row">
                <?php foreach( $smof_data["advantages_block"] as $block ) : $counter++ ?>
                    <div class="<?= ( !empty( $place[$counter] ) ) ? $place[$counter] : ''; ?> col-md-3 col-sm-6 col-xs-12">
                        <div class="single-advantage">
                            <div class="thumb">
                                <img src="<?= $block["url"]; ?>" alt="<?= $block["title"]; ?>" title="<?= $block["title"]; ?>"/>
                            </div>
                            <div class="content">
                                <?= $block["title"]; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
