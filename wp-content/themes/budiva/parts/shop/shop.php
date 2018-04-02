<?php

get_template_part( 'parts/underhead' );

get_template_part( 'parts/additional-menu' );

$data = budiva_get_shop_page_data( true, false );
$field = get_field('price_file', 35 );
?>

<div class="content-wrap">
    <div class="container page-shop">
        <div class="temp-price-section" style="width: fit-content;margin: auto;margin-top: 20px;">
            <a href="<?php echo $field !== false ? $field : ''?>" class="tab-price-btn view"  target="_blank">Просмотреть прайс</a>
            <a href="<?php echo $field !== false ? $field : ''?>" class="tab-price-btn download"  download="">Скачать прайс</a>
            <a href="#" class="tab-price-btn print hide_mobile" style="margin-bottom: 0">Распечатать</a>

            <script>
                $(document).ready(function() {
                    $(".temp-price-section").on('click', '.print', function() {
                        window.open("<?php echo $field !== false ? $field : ''?>").print();
                        return false;
                    });
                });

                (function () {
                    var isMobile = false; //initiate as false
// device detection
                    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
                        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;
                    if(isMobile === true){
                        $('.hide_mobile').hide();
                    }
                })();
            </script></div>
        <?php foreach( $data as $item ) : ?>
            <?php
            $taxonomy = $item['category']->taxonomy;
            $term_id = $item['category']->term_id;
            $garant = get_field( 'garant', $taxonomy . '_' . $term_id );
            if( $garant < 1 )
                $garant = 0;
            ?>

            <div class="single-category-full" itemscope itemtype="http://schema.org/Product">
                <div class="container-bg">
                    <div class="news-content">
                        <div class="news-image">
                            <a href="<?= get_term_link( $item['category']->term_id, 'product_cat' ); ?>">
                                <?= budiva_get_category_image( $item['category']->term_id, 'size-360x270' ); ?>
                            </a>

                            <?php if( $garant ) : ?>
                                <div class="varranty">
                                    <div class="text1">Гарантия</div>
                                    <div class="value"><?= $garant ?></div>
                                    <div class="text2">лет</div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="h2 category-name" itemprop="name">
                            <a href="<?= get_term_link( $item['category']->term_id, 'product_cat' ); ?>"><?= $item['category']->name; ?></a>
                        </div>

                        <div itemprop="description">
                            <?= wpautop( get_field( 'short_desc_category', $item['category']->taxonomy . '_' . $item['category']->term_id ) ); ?>
                        </div>


                        <div class="more">
                            <a class="btn-blue" href="<?= get_term_link( $item['category']->term_id, 'product_cat' ); ?>">Подробнее</a>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <?php include( locate_template( 'parts/shop/shop-item-' . $item['template'] . '.php' ) ); ?>

        <?php endforeach; ?>
    </div>
</div>
