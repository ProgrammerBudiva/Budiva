<?php

get_header();

?>

    <div class="content-wrap">
        <div class="container container-small error-page">
            <div class="text">
                <h1>Ошибка</h1>

                <p class="e404">404</p>

                <p class="desc">Такой страницы не
                    существует<span class="hidden-xs">, но вы можете вернуься на <a href="<?= get_home_url(); ?>">главную</a>
                    или оставьте заявку ─ мы перезвоним Вам и ответим на все вопросы</p>
                <a class="btn-blue visible-xs" style="width:300px;margin: 10px auto 0" href="<?= get_home_url(); ?>">Назад
                    на главную</a></span>
                <a class="btn-blue" id="bad-link" style="width:300px;display: inline-block;margin: 5px 0 25px;" href="#">Сообщить
                    о битой ссылке</a></span>
                <?php wp_nonce_field( 'budiva_bad_link', 'budiva_bad_link_nonce', true, true ); ?>
            </div>
            <img src="<?php bloginfo( 'template_directory' ); ?>/img/builder.png" class="rabbit-404 visible-xs" alt="Заяц">
        </div>
        <div class="container container-small type-form bid-404">
            <?= do_shortcode( '[contact-form-7 id="125" title="Оставьте заяку и мы перезвоним Вам (404)"]' ); ?>
            <div class="clear"></div>
        </div>
    </div>

<?php

get_template_part( 'parts/popular' );

get_footer();

?>