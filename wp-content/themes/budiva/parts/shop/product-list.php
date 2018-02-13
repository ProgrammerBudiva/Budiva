<div class="content-wrap category-page">
    <div class="container container-small subcategory-container">
        <?php if( $products ) : ?>
            <div class="tiles">
                <?php foreach( $products as $product ) : ?>
                    <div class="tile square" itemscope itemtype="http://schema.org/Product">
                        <div class="tile-wrapper first-type">
                            <?= get_the_post_thumbnail(
                                $product->ID,
                                array( 570, 570 ),
                                array(
                                    'data-small' => wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'size-550x297' )[0],
                                    'alt_title' => $product->post_title
                                ) ); ?>

                            <div class="bg">
                                <div class="center">
                                    <p itemprop="name"><?= $product->post_title; ?></p>
                                </div>
                            </div>
                            <a href="<?= get_permalink( $product->ID ); ?>">
                                <div class="h3"><?= $product->post_title; ?></div>

                                <p itemprop="description"><?= $product->post_excerpt; ?></p>

                                <div class="btn">Подробнее</div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php elseif( is_active_filter() ) : ?>
            <p class="filter-no-results">Товаров не найдено</p>
        <?php endif; ?>
        <div class="clear"></div>
    </div>

    <div class="container">
        <div class="container-bg">
            <div class="news-content">
                <div itemprop="name" class="h2 primary-header"><?= $cat->name; ?></div>

                <?php get_template_part( 'parts/tabs' ); ?>

                <?php /* <div class="manafacture-info clearfix" itemprop="description">
                    <?= wpautop( str_replace( "http://", "https://", Images::the_content_change_image_alt( do_shortcode( $cat->description ), budiva_get_page_name() ) ) ); ?>
                </div> */ ?>
            </div>
                        <?php if($cat->term_id === 25){ ?>

                    <div class="container" style="">
                        <div class="container-bg container-iframe" style="height: 2265px;width: fit-content;">
                        </div>
                    </div>
                    <script>
                        $(window).load(function(){
                            $('.container-iframe').html('<iframe id="frame-shinglas"  sandbox="allow-same-origin allow-scripts allow-forms" src="https://shinglas.com.ua/raschyet-krovli/?embedded=Y" scrolling="no" style="border: 0;height: 2500px; width:1001px; transform: scale(0.9); transform-origin: 0 0;"></iframe>')
                        });
                    </script>

                        <?php }?>
        </div>
    </div>
</div>