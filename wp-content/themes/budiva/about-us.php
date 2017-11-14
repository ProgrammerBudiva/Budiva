<?php
/*
	Template Name: About Us
*/

get_header();

get_template_part( 'parts/underhead' ); ?>

    <div class="content-wrap about-us-wrap">
        <div class="container">
            <div class="row">
                <?php while( have_posts() ) : the_post(); ?>
                    <div itemscope itemtype="http://schema.org/Product">
                    <div class="about-thumb col-md-3 col-xs-3">
                        <a href="<?= wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>" class="zoom" rel="prettyPhoto">
                            <?= wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                        </a>
                    </div>
                    <div class="about-text col-md-9 col-xs-9" itemprop="description">
                      <?php the_content(); ?>
                    </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <div class="icon-fix">
            <div itemscope itemtype="http://schema.org/Organization" class="icons-wrapper">
                <div class="about-icon">
                    <a itemprop="url" style="border:none;display:inline" href="<?= get_home_url(); ?>/o-nas/vakansii/"><img src="<?= THEME_URI; ?>/img/vak.png" alt="Вакансии" /></a>
                    <a itemprop="url" href="<?= get_home_url(); ?>/o-nas/vakansii/">Вакансии компании</a>
                </div>
                <div class="about-icon">
                    <a itemprop="url" style="border:none;display:inline" href="<?= get_home_url(); ?>/o-nas/sotrudnichestvo/"><img src="<?= THEME_URI; ?>/img/head.png" alt="Сотрудничество" /></a>
                    <a itemprop="url" href="<?= get_home_url(); ?>/o-nas/sotrudnichestvo/">Сотрудничество</a>
                </div>
                <div class="about-icon">
                    <a itemprop="url" style="border:none;display:inline" href="<?= get_home_url(); ?>/o-nas/proizvoditeli/"><img src="<?= THEME_URI; ?>/img/manufacturer.gif" alt="Производители" /></a>
                    <a itemprop="url" href="<?= get_home_url(); ?>/o-nas/proizvoditeli/">Производители</a></div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>