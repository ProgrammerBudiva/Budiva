<?php

$Search = new Search( $_GET['s'] );

get_header();

get_template_part( 'parts/underhead' ); ?>

    <div class="container container-small subcategory-container">
        <?php if( !$Search->have_query() ) : ?>
            <?php get_template_part( 'parts/search/empty' ); ?>
        <?php elseif( $Search->have_results() ) : ?>
            <?php $Search->get_template( 'posts', 'products', 'Товары' ); ?>
            <?php $Search->get_template( 'terms', 'categories', 'Категории' ); ?>
            <?php $Search->get_template( 'manufacturers', 'manufacturers', 'Производители' ); ?>
            <?php $Search->get_template( 'posts', 'posts', 'Новости и статьи' ); ?>
        <?php else : ?>
            <?php get_template_part( 'parts/search/nothing' ); ?>
        <?php endif; ?>
    </div>

<?php get_template_part( 'parts/popular' ); ?>

    <div class="container container-form">
        <div class="modal-container type-form">
            <?php get_template_part( 'parts/bid' ); ?>
        </div>
    </div>

<?php get_footer(); ?>