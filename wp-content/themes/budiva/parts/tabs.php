<div class="tabs clearfix">
    <?php
    if( is_singular() ) {
        $tabs_id = get_the_ID();
        $tabs_type = 'post';
    }
    else {
        $tabs_id = get_queried_object()->term_id;
        $tabs_type = 'term';
    }
    $prices = MetaBoxes\Tabs::get_post_prices( $tabs_id, $tabs_type, true );
    $charasteristics = MetaBoxes\Tabs::get_post_charasteristics( $tabs_id, $tabs_type );
    $videos = MetaBoxes\Tabs::get_post_video( $tabs_id, $tabs_type );
    $instructions = MetaBoxes\Tabs::get_post_instructions( $tabs_id, $tabs_type );
    $sertificates = MetaBoxes\Tabs::get_post_sertificates( $tabs_id, $tabs_type );
    $customs = MetaBoxes\Tabs::get_post_custom( $tabs_id, $tabs_type );

    $tabs = new Tabs();
    ?>

    <ul class="product-tabs clearfix">
        <?php if( !is_singular( 'manufacturer' ) ) : ?>
            <li data-target="#tab_description" class="active">Описание</li>
        <?php endif; ?>
        <?php if( !empty( $prices['download_id'] ) ) : ?>
            <li data-target="#tab_price"><b>Прайс-лист</b></li>
        <?php endif; ?>
        <?php if( !empty( $charasteristics['content'] ) ) : ?>
            <li data-target="#tab_charasteristics">Характеристики</li>
        <?php endif; ?>
        <?php if( !empty( $videos ) ) : ?>
            <li data-target="#tab_video">Видео</li>
        <?php endif; ?>

        <?php if( is_singular( 'manufacturer' ) ) : ?>
            <li data-target="#tab_instructions" class="active">Инструкции</li>
        <?php elseif( !empty( $instructions ) ) : ?>
            <li data-target="#tab_instructions">Инструкции</li>
        <?php endif; ?>

        <?php if( !empty( $sertificates ) ) : ?>
            <li data-target="#tab_sertificates">Сертификаты</li>
        <?php endif; ?>
        <?php if( !empty( $customs ) ) : ?>
            <?php foreach( $customs as $custom ) : ?>
                <li data-target="#tab_custom_<?= $custom['id']; ?>"><?= $custom['name']; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <div class="product-tab-content" data-product="<?= $tabs_id; ?>" data-type="<?= $tabs_type; ?>">
        <div class="tab-loader text-center hide">
            <img src="<?= THEME_URI; ?>/img/loader.gif" alt="loader">
        </div>
        <?php if( !is_singular( 'manufacturer' ) ) : ?>
            <div id="tab_description" class="product-tab active">
                <?php if( is_singular() ) : ?>
                    <?php the_content(); ?>
                <?php else : ?>
                    <div class="manafacture-info clearfix" itemprop="description">
                        <?= wpautop( str_replace( "http://", "https://", Images::the_content_change_image_alt( do_shortcode( get_queried_object()->description ), budiva_get_page_name() ) ) ); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if( !empty( $prices['download_id'] ) ) : ?>
            <div id="tab_price" data-type="price" class="product-tab"></div>
        <?php endif; ?>

        <?php if( !empty( $charasteristics['content'] ) ) : ?>
            <div id="tab_charasteristics" data-type="charasteristics" class="product-tab"></div>
        <?php endif; ?>
        <?php if( !empty( $videos ) ) : ?>
            <div id="tab_video" data-type="video" class="product-tab"></div>
        <?php endif; ?>

        <?php if( is_singular( 'manufacturer' ) ) : ?>
            <div id="tab_instructions" data-type="instructions" class="product-tab active">
                <?= $tabs->get_tab( "instructions", $tabs_type, $tabs_id, false ); ?>
            </div>
        <?php elseif( !empty( $instructions ) ) : ?>
            <div id="tab_instructions" data-type="instructions" class="product-tab"></div>
        <?php endif; ?>

        <?php if( !empty( $sertificates ) ) : ?>
            <div id="tab_sertificates" data-type="sertificates" class="product-tab"></div>
        <?php endif; ?>
        <?php if( !empty( $customs ) ) : ?>
            <?php foreach( $customs as $custom ) : ?>
                <div id="tab_custom_<?= $custom['id']; ?>" data-type="custom" data-id="<?= $custom['id']; ?>" class="product-tab"></div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>