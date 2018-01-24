<?php
/*
	Template Name: Builders
*/
// compare terms
function cmp_custom($a, $b)
{
    return strcmp($a->post_title, $b->post_title); // in reverse order to get DESC
}

get_header();

get_template_part( 'parts/underhead' ); ?>

<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" />
    <div class="wrap vacancies-wrap">
        <div class="container">
            <div class="    vacancies-content">
                <?php while( have_posts() ) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; ?>
            </div>

            <?php foreach( get_builders() as $city ) : ?>
                <div class="vacancy">
                    <div class="h3 primary-header"><?= $city['name']; ?>:</div>
                    <?php if( count( $city['list'] ) == 0 ) : ?>
                        Нет рекомендуемых подрядчиков
                    <?php else :
                            // sort terms using comparison function
                            usort($city['list'], 'cmp_custom');
                        ?>
                        <?php foreach( $city['list'] as $item ) : ?>
                            <div itemscope itemtype="http://schema.org/Product" class="vacancy-item">
                                <div class="vacancy-header" data-toggle="collapse" data-target="#builder-<?= $city['a']->term_id; ?>-<?= $item->ID; ?>" style="background:#efefef;cursor:pointer;padding:5px;">
                                    <p itemprop="name" style="margin:0;">
                                        <b  class="toggle look-vacancy-builders collapsed"><?= $item->post_title; ?></b>

                                    </p>
                                </div>

                                <div class="vacancy-content collapse" id="builder-<?= $city['a']->term_id; ?>-<?= $item->ID; ?>">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <?= get_the_post_thumbnail( $item->ID, 'full' ); ?>
                                        </div>
                                        <div class="col-md-6" style="padding-top: 6px;">
                                            <?php
                                            $address = get_post_meta( $item->ID, 'address', true );
                                            $phone = get_post_meta( $item->ID, 'phone', true );
                                            $email = get_post_meta( $item->ID, 'email', true );
                                            $work_time = get_post_meta( $item->ID, 'work_time', true );
                                            ?>
                                            <?php if( $address || $phone || $email || $work_time ) : ?>
                                                <table>
                                                    <?php if( $address ) : ?>
                                                        <tr>
                                                            <td>Адрес</td>
                                                            <td><?= $address; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if( $phone ) : ?>
                                                        <tr>
                                                            <td>Телефон</td>
                                                            <td><?= $phone; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if( $email ) : ?>
                                                        <tr>
                                                            <td>E-mail</td>
                                                            <td><a href="mailto:<?= $email; ?>"><?= $email; ?></a></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if( $work_time ) : ?>
                                                        <tr>
                                                            <td>График работы</td>
                                                            <td><?= $work_time; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </table>
                                            <?php endif; ?>
                                        </div>

                                    </div>

                                    <div class="works">
                                        <div class="h3">Виды выполняемых работ</div>
                                        <?php if( $works = get_the_terms( $item->ID, 'works' ) ) : ?>


                                            <div class="builder-works builder-works-types clearfix">

                                                <?php foreach( $works as $work ) : ?>

                                                    <div class="work-item">
                                                        <?= wp_get_attachment_image( get_field( 'work_image', 'works_' . $work->term_id ), 'size-140x140', false, array(
                                                            'alt' => $work->name,
                                                            'title' => $work->name
                                                        ) ); ?>
                                                    </div>

                                                <?php endforeach; ?>

                                            </div>

                                        <?php endif; ?>
                                    </div>

                                    <div class="works" itemprop="description">
                                        <?= wpautop( $item->post_content ); ?>
                                    </div>

                                    <?php
                                    $img_ids = json_decode( get_post_meta( $item->ID, "gallery_images", true ) );
                                    if( !empty( $img_ids ) && is_array( $img_ids ) ) : ?>

                                    <div class="works">
                                            <div class="h3">Примеры работ</div>
                                            <div class="category1-slider clearfix" style="   width: 97%;">

                                            <?php foreach( $img_ids as $img_id ) : ?>
                                                    <div class="slide">
                                                    <a href="<?= wp_get_attachment_image_src( $img_id, 'full' )[0]; ?>" title="<?= get_post_meta( $img_id, 'media_popup_name', true ); ?>" class="zoom" data-rel="prettyPhoto[builder-<?= $city['a']->term_id; ?>-<?= $item->ID; ?>]">
                                                        <?= wp_get_attachment_image( $img_id, 'size-270x270' ); ?>
                                                    </a>
                                                    </div>
                                            <?php endforeach; ?>

                                            </div>
                                    </div>

                                    <?php endif; ?>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<script>
    $(document).ready(function(){
//setTimeout(function(){

    $('.category1-slider').slick({
        infinite: false,
        slidesToShow: 4,
        slidesToScroll: 1,
//        arrows: true,
//        centerMode: true,
//        centerPadding: '60px',
//        adaptiveHeight: true,
        nextArrow: '<a class="custom-next"></a>',
        prevArrow: '<a class="custom-prev"></a>',
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true
//                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 320,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
    });


    $('.vacancy-content').on('shown.bs.collapse', function () {
        $('.category1-slider').slick('setPosition');
    })

</script>
<style>
    .custom-prev:before,
    .slick-next:before {
        color: black;
    }
    .slick-list {
        /*display: flex !important;*/

        width: 80%;
        margin: auto;
    }
    .custom-prev { padding: 0;
        background: transparent url(https://budiva.ua/wp-content/themes/budiva/img/arrow.png) no-repeat center !important;
        transform: rotate(270deg);
        height:20px;
        display: block!important;
        width: 75px;
        position: absolute;
        top: 50%;
        left: 0;
    }
    .custom-next { padding: 0;
        background: transparent url(https://budiva.ua/wp-content/themes/budiva/img/arrow.png) no-repeat center !important;
        transform: rotate(90deg);
        height:20px;
        position: absolute;
        width: 75px;
        display: block!important;
        top: 50%;
        right: 0;
    }
</style>
    <div class="modal fade" role="dialog" id="resumeForm">
        <div class="modal-dialog modal-form-bid">
            <div class="modal-container type-form ">
                <button type="button" class="fancybox-close" data-dismiss="modal" aria-hidden="true"></button>
                <?php get_template_part( 'parts/resume-form' ); ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>

