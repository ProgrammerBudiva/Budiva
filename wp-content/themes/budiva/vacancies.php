<?php
/*
	Template Name: Vacancies
*/

get_header();

get_template_part( 'parts/underhead' ); ?>

    <div class="wrap vacancies-wrap">
        <div class="container">
            <div class="vacancies-content">
                <?php while( have_posts() ) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; ?>
            </div>

            <?php foreach( get_vacancies() as $vacancy ) : ?>
                <div class="vacancy">
                    <div class="h3 primary-header"><?= $vacancy['name']; ?>:</div>
                    <?php if( count( $vacancy['list'] ) == 0 ) : ?>
                        Нет открытых вакансий
                    <?php else : ?>
                        <?php foreach( $vacancy['list'] as $item ) : ?>
                            <div itemscope itemtype="http://schema.org/Product" class="vacancy-item">
                                <div class="vacancy-header">
                                    <p itemprop="name">
                                        <b data-toggle="collapse" data-target="#vacancy-<?= $vacancy['a']->term_id; ?>-<?= $item->ID; ?>" class="toggle look-vacancy collapsed"><?= $item->post_title; ?></b>
                                    </p>
                                </div>

                                <div class="vacancy-content collapse" id="vacancy-<?= $vacancy['a']->term_id; ?>-<?= $item->ID; ?>">
                                    <p itemprop="description"><?= $item->post_content; ?></p>

                                    <p>Адрес филиала смотрите на странице
                                        <a href="<?= get_home_url(); ?>/kontakty/" target="_blank">Контакты</a></p>

                                    <div class="send-resume">
                                        <a class="btn-blue" href="#" data-toggle="modal" data-target="#resumeForm" data-vacancy="<?= $item->post_title; ?> (<?= $vacancy['name']; ?>)">
                                            Отправить резюме
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
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