<?php $shrtcd = trim( do_shortcode( '[woof]' ) ); ?>
<?php if( !empty( $shrtcd ) ) : ?>
    <div class="container container-small container-filter">
        <div class="filter-bg">
            <a href="#" class="toogle-filter visible-filter visible-xs visible-sm">Скрыть фильтр</a>

            <div class="wrapper">
                <?= $shrtcd; ?>

                <?php
                if( is_active_sidebar( 'filter-widget' ) ) {
                    //	dynamic_sidebar( 'filter-widget' );
                } ?>
            </div>
        </div>
    </div>
<?php endif; ?>
