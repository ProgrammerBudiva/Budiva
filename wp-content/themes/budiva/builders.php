<?php
/*
	Template Name: Builders
*/

get_header();

get_template_part( 'parts/underhead' ); ?>

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
                    <?php else : ?>
                        <?php foreach( $city['list'] as $item ) : ?>
                            <div itemscope itemtype="http://schema.org/Product" class="vacancy-item">
                                <div class="vacancy-header" data-toggle="collapse" data-target="#builder-<?= $city['a']->term_id; ?>-<?= $item->ID; ?>" style="background:#efefef;cursor:pointer;padding:5px;">
                                    <p itemprop="name" style="margin:0;">
                                        <b  class="toggle look-vacancy-builders collapsed"><?= $item->post_title; ?></b>
<!--                                        <script>
                                            $(document).ready(function (){
                                                $('#builder-<?= $city['a']->term_id; ?>-<?= $item->ID; ?>').on('hide.bs.collapse', function () {
                                                    $('.vacancy-item').removeClass('vacancy-item-active');
                                                    $('.vacancy-header').removeClass('vacancy-header-active');
                                                });

                                                $('#builder-<?= $city['a']->term_id; ?>-<?= $item->ID; ?>').on('show.bs.collapse', function () {
                                                    $('.vacancy-item').addClass('vacancy-item-active');
                                                    $('.vacancy-header').addClass('vacancy-header-active');
                                                });
                                            });
                                        </script>-->
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



                                    <?php
                                    $img_ids = json_decode( get_post_meta( $item->ID, "gallery_images", true ) );
                                    if( !empty( $img_ids ) && is_array( $img_ids ) ) : ?>

                                       <!-- <div class="category-slider">
                                            <div class="builders-slider-start">
                                                <?php /*foreach( $img_ids as $img_id ) : ?>
                                                    <div class="slide">
                                                        <a href="<?= wp_get_attachment_image_src( $img_id, 'full' )[0]; ?>" title="<?= get_post_meta( $img_id, 'media_popup_name', true ); ?>" class="zoom" data-rel="prettyPhoto[product-gallery]">
                                                            <?= wp_get_attachment_image( $img_id, 'size-270x270' ); ?>
                                                        </a>
                                                    </div>
                                                <?php endforeach; */?>
                                            </div>
                                        </div>-->
                                    <div class="works" itemprop="description">
                                            <?= wpautop( $item->post_content ); ?>
                                    </div>
                                    <div class="works">
                                            <div class="h3">Примеры работ</div>

<!--                                            <div class="builder-works clearfix">-->
                                                <div class="category-slider clearfix" style=" height:250px;   width: 97%;">
                                                    <div class="builders-slider">
                                                <?php foreach( $img_ids as $img_id ) : ?>

<!--                                                    <div class="work-item">-->
                                                        <div class="slide">
                                                        <a href="<?= wp_get_attachment_image_src( $img_id, 'full' )[0]; ?>" title="<?= get_post_meta( $img_id, 'media_popup_name', true ); ?>" class="zoom" data-rel="prettyPhoto[builder-<?= $city['a']->term_id; ?>-<?= $item->ID; ?>]">
                                                            <?= wp_get_attachment_image( $img_id, 'size-270x270' ); ?>
                                                        </a>
                                                        </div>
<!--                                                    </div>-->

                                                <?php endforeach; ?>
                                                    </div>
                                                </div>
<!--                                            </div>-->
                                        </div>

                                    <?php endif; ?>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <?php /* foreach( get_builders() as $city ) : ?>
                <div class="vacancy">
                    <div class="h3 primary-header"><?= $city['name']; ?>:</div>
                    <?php if( count( $city['list'] ) == 0 ) : ?>
                        Нет рекомендуемых подрядчиков
                    <?php else : ?>
                        <div class="panel-group" id="accordion-<?= $city['a']->term_id; ?>">
                            <?php foreach( $city['list'] as $item ) : ?>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <a data-toggle="collapse" data-parent="#accordion-<?= $city['a']->term_id; ?>" href="#collapse-<?= $city['a']->term_id; ?>-<?= $item->ID; ?>">
                                            <?= $item->post_title; ?>
                                        </a>
                                    </div>
                                    <div id="collapse-<?= $city['a']->term_id; ?>-<?= $item->ID; ?>" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <?= get_the_post_thumbnail( $item->ID, 'full' ); ?>
                                                </div>
                                                <div class="col-md-9" itemprop="description">
                                                    <?= wpautop( $item->post_content ); ?>
                                                </div>
                                            </div>

                                            <div class="works">
                                                <div class="h3">Виды выполняемых работ</div>
                                                <?php if( $works = get_the_terms( $item->ID, 'works' ) ) : ?>

                                                    <div class="builder-works clearfix">

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
                                                            <td><?= $email; ?></td>
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

                                            <?php
                                            $img_ids = json_decode( get_post_meta( $item->ID, "gallery_images", true ) );
                                            if( !empty( $img_ids ) && is_array( $img_ids ) ) : ?>

                                                <div class="works">
                                                    <div class="h3">Примеры работ</div>

                                                    <div class="builder-works clearfix">

                                                        <?php foreach( $img_ids as $img_id ) : ?>

                                                            <div class="work-item">
                                                                <a href="<?= wp_get_attachment_image_src( $img_id, 'full' )[0]; ?>" title="<?= get_post_meta( $img_id, 'media_popup_name', true ); ?>" class="zoom" data-rel="prettyPhoto[builder-<?= $city['a']->term_id; ?>-<?= $item->ID; ?>]">
                                                                    <?= wp_get_attachment_image( $img_id, 'size-140x140' ); ?>
                                                                </a>
                                                            </div>

                                                        <?php endforeach; ?>

                                                    </div>
                                                </div>

                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; */ ?>
        </div>
    </div>

    <div class="modal fade" role="dialog" id="resumeForm">
        <div class="modal-dialog modal-form-bid">
            <div class="modal-container type-form ">
                <button type="button" class="fancybox-close" data-dismiss="modal" aria-hidden="true"></button>
                <?php get_template_part( 'parts/resume-form' ); ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>


