<?php get_header(); ?>

    <div class="index-slider">
        <ul class="bxslider">
            <?php foreach( $smof_data["slider_home"] as $slide ) : ?>
                <li>
                    <div itemscope itemtype="http://schema.org/ImageObject">
                        <img itemprop="contentUrl" src="<?= str_replace( "http://", "https://", $slide['url'] ); ?>"/>
                    </div>
                    <div class="slider-box">
                        <div class="container clearfix">
                            <div itemscope itemtype="http://schema.org/Product" class="row slider-info-box">
                                <?php for( $i = 1; $i < 5; $i++ ) : ?>
                                    <div class="col-md-3 item">
                                        <div class="inner">
                                            <p itemprop="description"><?= $smof_data["home_slider_block_{$i}_desc"]; ?></p>

                                            <div class="centerfix">
                                                <div itemprop="name" class="bot-text"><?= $smof_data["home_slider_block_{$i}_name"]; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php /* <a href="#" class="scrollplz scroll-to-content">
            <span class="txt">Узнать</span>

            <div class="arrwscrl"></div>
            <span class="txt">больше</span>
        </a> */ ?>
    </div>

    <div class="content-block" id="content-block">
        <div class="container">

            <div class="tiles have-cross">
                <?php
                $args = array(
                    'taxonomy' => 'product_cat',
                    'hide_empty' => false,
                    'parent' => "0"
                );
                $term_query = new WP_Term_Query( $args );
                ?>

                <?php foreach( $term_query->terms as $category ) : ?>
                    <div class="tile square" itemscope itemtype="http://schema.org/Product">
                        <div class="tile-wrapper first-type">
                            <?= wp_get_attachment_image( get_term_meta( $category->term_id, 'thumbnail_id', true ), 'size-550x297', 0, array(
                                'alt_title' => $category->name
                            ) ); ?>
                            <div class="bg">
                                <div class="center">
                                    <p><?= $category->name; ?></p>
                                </div>
                            </div>
                            <a href="<?= get_term_link( $category->term_id, 'product_cat' ); ?>">
                                <div class="h3" itemprop="name"><?= $category->name; ?></div>

                                <p itemprop="description"><?php the_field( 'short_desc', $category->taxonomy . '_' . $category->term_id ); ?></p>

                                <div class="btn">Подробнее</div>
                            </a>
                        </div>

                        <?php foreach( Terms::get_front_subcategories( $category->term_id ) as $subcategory ) : ?>
                            <div class="tile-wrapper second-type">
                                <?= wp_get_attachment_image( get_term_meta( $subcategory->term_id, 'thumbnail_id', true ), 'size-170x170', 0, array(
                                    'alt_title' => $subcategory->name
                                ) ); ?>
                                <a class="bg" href="<?= get_term_link( $subcategory->term_id, 'product_cat' ); ?>">
                                    <div class="center">
                                        <p><?= $subcategory->name; ?></p>
                                    </div>

                                    <div class="btn">Подробнее</div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="trust hidden-sm hidden-xs hidden-md" style="background:url('<?= wp_get_attachment_url( get_post_meta( $post->ID, 'tryst_us_background', true ), 'full' ); ?>') no-repeat center;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="h2 primary-header">
                        Нам доверяют
                    </div>
                </div>
            </div>
            <div class="row">
                <?php

                $args = array(
                    'posts_per_page' => 3,
                    'post_type' => 'trust'
                );
                $query = new WP_Query( $args );
                ?>
                <?php while( $query->have_posts() ) : $query->the_post(); ?>
                    <div class="col-md-4">
                        <div class="trusted-single">
                            <?php the_post_thumbnail( 'size-360x270' ); ?>
                            <a href="#" data-toggle="modal" data-target="#trusted-popup-<?= the_ID(); ?>" class="header-wrapper">
                                <span><?php the_title(); ?></span>
                            </a>
                        </div>
                    </div>

                    <div class="modal fade" role="dialog" id="trusted-popup-<?= the_ID(); ?>">
                        <div class="modal-dialog modal-bad-link modal-ship">
                            <div class="modal-container type-form">
                                <button type="button" class="fancybox-close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3 class="trust-modal-header"><?= get_post_meta( $post->ID, 'popup_header', true ); ?></h3>

                                <div class="trust-modal-content"><?= wpautop( get_post_meta( $post->ID, 'popup_content', true ) ); ?></div>
                                <?php if( get_post_meta( $post->ID, 'link_isset', true ) ) : ?>
                                    <a class="btn-blue btn-trust" href="<?= get_post_meta( $post->ID, 'link', true ); ?>">Подробнее</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <div class="slider-benefits">
        <div class="container">

            <div class="slider-benefits-box">
                <ul class="bxslider2">
                    <?php foreach( $smof_data["slider_advantages"] as $slide ) : ?>
                        <li>
                            <img src="<?= str_replace( "http://", "https://", $slide['url'] ); ?>"/>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div id="bx-pager">
                    <?php foreach( $smof_data["slider_advantages"] as $key => $slide ) : ?>
                        <a data-slide-index="<?= ( $key - 1 ); ?>" href="#">
                            <div class="bz-pager-title"><?= $slide['title']; ?></div>

                            <p class="bz-pager-title"><?= $slide['description']; ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="manafacture">
        <div class="container">
            <a class="index-news-title-url" href="<?= get_home_url(); ?>/o-nas/proizvoditeli/">
                <div class="page-title"><?= $smof_data["home_seo_head"]; ?></div>
            </a>

            <p class="manafacture-info clearfix"><?= $smof_data["home_seo_text"]; ?></p>

            <div class="slider1" style="height: 0; ">
                <?php

                $args = array(
                    'posts_per_page' => -1,
                    'post_type' => 'manufacturer',
                    'meta_key' => 'out_home',
                    'meta_value' => '1',
                    'order' => 'ASC'
                );
                $query = new WP_Query( $args );

                while( $query->have_posts() ) : $query->the_post(); ?>
                    <div class="slide">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'size-170x?' ); ?>
                        </a>
                    </div>
                <?php endwhile;
                wp_reset_postdata(); ?>
            </div>
        </div>
    </div>

    <div itemtype="http://schema.org/NewsArticle" itemprop="author" class="index-news">
        <div class="container">
            <a class="index-news-title-url" href="<?= get_home_url(); ?>/stati/">
                <div class="page-title">новости и статьи</div>
            </a>

            <div class="row">
                <?php $args = array(
                    'post_type' => array( 'post', 'news' ),
                    'numberposts' => -1,
                    'meta_key' => 'view_home',
                    'meta_value' => 1
                );
                $query = new WP_Query( $args ); ?>
                <?php while( $query->have_posts() ) : $query->the_post(); ?>
                    <div itemprop="articleBody" class="col-md-6 index-news-container">

                        <div class="index-thumbnails-box">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'size-200x200' ); ?>
                            </a>
                        </div>

                        <div class="index-content-box clearfix">
                            <p class="index-content-box-date"><?php the_date(); ?></p>

                            <a href="<?php the_permalink(); ?>">
                                <div class="index-content-box-title"><?php the_title(); ?></div>
                            </a>

                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="row home-content">
                <div class="col-md-12">
                    <?php while( have_posts() ) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; ?>
                </div>
            </div>

        </div>
    </div>

<?php get_footer(); ?>