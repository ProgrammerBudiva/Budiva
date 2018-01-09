<?php
/*
	Template Name: Cooperation
*/

get_header();

get_template_part( 'parts/underhead' ); ?>
    <div itemscope itemtype="http://schema.org/ImageObject" class="wrap">
        <div class="container">
            <div class="col-md-5 hidden-sm hidden-xs coop-img ">
                <img itemprop="contentUrl" src="<?= THEME_URI; ?>/img/cooperation.png" alt="Кооперация"/>
            </div>
            <div class="col-md-7 coop-desc">
                <div itemprop="description" class="coop-item">
                    <?= get_post_meta( $post->ID, 'providers', true ); ?>
                    <a href="#" class="coop-button" data-toggle="modal" data-target="#coopForm">Стать поставщиком</a>
                </div>
                <div itemprop="description" class="coop-item">
                    <?= get_post_meta( $post->ID, 'clients', true ); ?>
                    <a href="#" class="coop-button" data-toggle="modal" data-target="#getPriceForm">Получить прайс</a>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <?php /* <div class="container">
            <div class="col-md-12 coop-head">
                <h2>сотрудничая с нами, вы получаете</h2>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 coop-item-adv">
                <div class="img">
                    <img itemprop="contentUrl" src="<?= THEME_URI; ?>/img/cooperation/item-1.png" alt="Высокое качество строительных материалов"/>
                </div>

                <p><span itemprop="description">Высокое качество <br>
                    строительных материалов</span></p>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 coop-item-adv">
                <div class="img">
                    <img itemprop="contentUrl" src="<?= THEME_URI; ?>/img/cooperation/item-2.png" alt="Индивидуальный подход"/>
                </div>

                <p><span itemprop="description">Индивидуальный <br>
                    подход</span></p>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 coop-item-adv">
                <div class="img">
                    <img itemprop="contentUrl" src="<?= THEME_URI; ?>/img/cooperation/item-3.png" alt="Выгодные цены и гибкую систему скидок"/>
                </div>

                <p><span itemprop="description">Выгодные цены <br>
                    и гибкую систему скидок</span></p>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 coop-item-adv">
                <div class="img">
                    <img itemprop="contentUrl" src="<?= THEME_URI; ?>/img/cooperation/item-4.png" alt="Возможность бесплатной доставки на объект"/>
                </div>

                <p><span itemprop="description">Возможность бесплатной <br>
                    доставки на объект</span></p>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 coop-item-adv">
                <div class="img">
                    <img itemprop="contentUrl" src="<?= THEME_URI; ?>/img/cooperation/item-5.png" alt="Техническую поддержку"/>
                </div>

                <p><span itemprop="description">Техническую поддержку <br>
                    (консультации <br>
                    специалистов, технические <br>
                    решения)</span></p>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 coop-item-adv">
                <div class="img">
                    <img itemprop="contentUrl" src="<?= THEME_URI; ?>/img/cooperation/item-6.png" alt="Перечень зарекомендовавших себя подрядчиков и партнеров"/>
                </div>

                <p> <span itemprop="description">Перечень <br>
                    зарекомендовавших <br>
                    себя подрядчиков <br>
                    и партнеров</span>
                </p>
            </div>
            <div class="clear"></div>
        </div> */ ?>
    </div>

<?php if( have_posts() ) : ?>
    <?php while( have_posts() ) : the_post(); ?>
        <div class="container content-container">
            <div class="col-md-7 coop-desc">
                <div itemprop="description" class="coop-item">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>

    <div class="modal fade" role="dialog" id="coopForm">
        <div class="modal-dialog modal-form-bid">
            <div class="modal-container type-form ">
                <button type="button" class="fancybox-close" data-dismiss="modal" aria-hidden="true"></button>
                <?= do_shortcode( '[contact-form-7 id="197" title="Стать поставщиком"]' ); ?>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" id="getPriceForm">
        <div class="modal-dialog modal-form-bid">
            <div class="modal-container type-form ">
                <button type="button" class="fancybox-close" data-dismiss="modal" aria-hidden="true"></button>
                <?= do_shortcode( '[contact-form-7 id="198" title="Получить прайс"]' ); ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>