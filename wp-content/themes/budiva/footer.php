<?php global $smof_data; ?>

<?php get_template_part( "parts/advantages" ); ?>

<div class="footer">
    <div class="container">
        <div class="row footer-menu-box">
            <div class="col-md-9 col-sm-12">
                <?php if( is_active_sidebar( 'footer-widget-area-1' ) )
                    dynamic_sidebar( 'footer-widget-area-1' ); ?>
            </div>

            <div class="col-md-3 col-sm-12">
                <?php if( is_active_sidebar( 'footer-widget-area-2' ) )
                    dynamic_sidebar( 'footer-widget-area-2' ); ?>
            </div>
        </div>

        <div class="row footer-line-box">
            <div class="col-md-3 col-sm-6 col-xs-6 footer-social-share">
				<span class="clearfix" itemscope itemtype="http://schema.org/Organization" id="soc_icons">
                    <a itemprop="sameAs" rel="nofollow" target="_blank" href="<?= $smof_data['fb_link']; ?>">
                        <img src="<?= THEME_URI ?>/img/footer/fb.png" alt="компания Будива в facebook"/>
                    </a>
                    <a itemprop="sameAs" rel="nofollow" target="_blank" href="<?= $smof_data['gp_link']; ?>">
                        <img src="<?= THEME_URI ?>/img/footer/you.png" alt="компания Budiva в youtube"/>
                    </a>
                    <a itemprop="sameAs" rel="nofollow" target="_blank" href="<?= $smof_data['vk_link']; ?>">
                        <img src="<?= THEME_URI ?>/img/footer/gp.png" alt="фирма Будива на google plus"/>
                    </a>
                </span>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-6 pull-right">
                <span class="write-to-us"><a href="#" data-toggle="modal" data-target="#bidForm">Напишите нам</a></span>
            </div>

            <div class="col-md-6 col-sm-12 subscribe-news">
                <div class="subscribe-box clearfix">
                    <?= do_shortcode( '[contact-form-7 id="343"]' ); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center copyright">
                © 2015 - 2017 budiva.ua
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.12/jquery.mask.js"></script>
<script>
    (function($) {
        $(".header-menu-box-two .one").hover(
            function() {
                $('.header-menu-informer.one').toggleClass("opacoty-one");
            }
        );

        $(".header-menu-box-two .two").hover(
            function() {
                $('.header-menu-informer.two').toggleClass("opacoty-one");
            }
        );

        $(".header-menu-box-two .three").hover(
            function() {
                $('.header-menu-informer.three').toggleClass("opacoty-one");
            }
        );

        $(".header-menu-box-two .four").hover(
            function() {
                $('.header-menu-informer.four').toggleClass("opacoty-one");
            }
        );
    })(jQuery);
</script>

<script>
    function order_alert_success(id, msg) {
        $('.wpcf7', id).hide(0).after('<div class="wpcf7-response-output wpcf7-mail-sent-ok">' + msg + '</div>');
        $(id).find('.modal-container').addClass('response-css');
    }

    $(function() {
        $("a.scroll-to-content").click(function(event) {
            event.preventDefault();
            $.scrollTo($("#content-block"), 400, {
                offset: -120
            });
        });

        $("a.backtotop").click(function(event) {
            event.preventDefault();
            $.scrollTo($("body"), 800);
        });

        $('.mobile-button-open-menu').click(function(event) {
            $('.wrapper-menu-mobile').slideToggle();
        });

        $('.change-pass').click(function(event) {
            event.preventDefault();
            if($(this).hasClass('active')) {
                $(this).removeClass('active');
                $('input[name="password_current"]').prop('disabled', true).val('');
                $('.wrp-password_1, .wrp-password_2').fadeOut('fast');
            } else {
                $(this).addClass('active');
                $('input[name="password_current"]').prop('disabled', false);
                $('.wrp-password_1, .wrp-password_2').fadeIn('fast');
            }
        });

        $('#btn-login').on('click', function(e) {
            e.preventDefault();
            $('#loginRegisterForm').modal('show');
        });

        <?php if (is_user_logged_in()) : ?>
        $('.menu-item-20 a').attr('href', '<?= home_url(); ?>/my-account/edit-account/');
        <?php else : ?>
        $('.menu-item-20 a').on('click', function(e) {
            e.preventDefault();
            $('#loginRegisterForm').modal('show');
        });
        <?php endif; ?>

        $(window).scroll(function() {
            if($(window).width() >= '1180') {
                if($(window).scrollTop() > 100) {
                    if(!$('#menu-header-menu').hasClass('hidden-menu')) {
                        $('body').css('margin-top', '103');
                        $('#menu-header-menu').addClass('hidden-menu');
                    }
                }
                else {
                    if($('#menu-header-menu').hasClass('hidden-menu')) {
                        $('body').css('margin-top', '143');
                        $('#menu-header-menu').removeClass('hidden-menu');
                    }
                }
            }
        });

        $('.order-product #subscribesubmit').click(function(event) {
            var val = $('.order-product #subscribe').val();
            if(val != '') {
                $('.box-order-product .your-product input').val(val);
                $('.box-order-product .your-product input').attr('value', val);
                $('.box-order-product').fadeIn('fast');
                $(document).mouseup(function(e) {
                    var container = $('.box-order-product');
                    if(container.has(e.target).length === 0 && e.target != document.getElementById('subscribesubmit')) {
                        container.fadeOut();
                        $('.order-product #subscribe').val('');
                    }
                });
            }
        });

        $('.header-menu-social-button a').attr('target', '_blank');

        if($(window).width() <= '768') {
            $('.page-numbers .next, .page-numbers .prev').parent().css('border', 'none');
        }

        if($(window).width() <= '768') {
            $('.additional-menu #menu-additional-menu > li > a').click(function(event) {
                event.preventDefault();
            });

            $(document).mouseup(function (e){ // событие клика по веб-документу
                var div = $(".additional-menu"); // тут указываем ID элемента
                if (!div.is(e.target) // если клик был не по нашему блоку
                    && div.has(e.target).length === 0) { // и не по его дочерним элементам
//                    div.hide(); // скрываем его
                    if($('.sub-menu').filter(function(){ return $(this).css('display') == 'block'; })){
                        $(this).css('display', 'none');
                        console.log('123');
                    }
                }
            });

        }

        $("input.phone, input#account_telephone, input#user_telephone").mask("+38(099)999-99-99");
    });

</script>

<?php if( !is_user_logged_in() ) : ?>
    <div class="modal fade" role="dialog" id="loginRegisterForm">
        <div class="modal-dialog modal-sm type-form login-register-form">
            <button type="button" class="fancybox-close" data-dismiss="modal" aria-hidden="true"></button>
            <div class="tabs">
                <a href="#" data-form="popup-login-form" class="tab tab-active">Вход</a>
                <a href="#" data-form="popup-register-form" class="tab">Регистрация</a>
            </div>

            <form name="popup-login-form" id="popup-login-form" method="post" style="display: block;">
                <?php wp_nonce_field( 'budiva_login', 'budiva_login_nonce', false, true ); ?>

                <p class="login-username">
                    <label for="user_login">E-mail</label>
                    <input type="text" name="log" id="user_login" class="input" value="" size="20">
                </p>

                <p class="login-password">
                    <label for="user_pass">Пароль</label>
                    <input type="password" name="pwd" id="user_pass" class="input" value="" size="20">
                </p>

                <p class="login-remember">
                    <label><input name="rememberme" type="checkbox" id="rememberme" value="forever"> Запомнить
                        меня</label></p>

                <p class="login-submit">
                    <input type="submit" name="login-submit" id="login-submit" class="button-primary" value="Войти">
                </p>

                <a href="#" id="recover-link" class="std-link">Забыли пароль?</a>

                <div class="error-login" style="color:red; display:none; margin-bottom:10px;"></div>

                <div class="block-recovery-pwd">
                    <?php wp_nonce_field( 'budiva_lost_pwd', 'budiva_lost_pwd_nonce', false, true ); ?>

                    <p class="login-lostpwd_email">
                        <label for="lostpwd_email">Введите E-mail</label>
                        <input type="text" name="lostpwd_email" id="lostpwd_email" class="input" value="" size="20">
                    </p>

                    <p class="login-submit">
                        <input type="submit" id="lostpwd-submit" class="button-primary" value="Восстановить">
                    </p>

                    <div class="error" style="color:red; display:none; margin-bottom:10px;"></div>
                </div>

                <div class="clear"></div>
                <?php echo do_shortcode('[TheChamp-Login]') ?>
            </form>

            <form name="form" id="popup-register-form" method="post">
                <div class="ftxt">
                    <label for="com_username">ФИО<span class="required">*</span></label>
                    <input id="com_username" name="com_username" type="text" class="input" required="required" value=""/>
                </div>
                <div class="ftxt">
                    <label for="com_email">E-mail<span class="required">*</span> </label>
                    <input id="com_email" name="com_email" type="email" class="input" required="required" value=""/>
                </div>
                <div class="ftxt">
                    <label for="account_telephone">Телефон</label>
                    <input id="account_telephone" name="account_telephone" type="text" class="input phone" value=""/>
                </div>
                <div class="ftxt">
                    <label for="receive_delivery">
                        <input id="receive_delivery" name="receive_delivery" type="checkbox" class="" value="on" checked="checked"/>
                        Получать рассылку
                    </label>
                </div>

                <div class="g-recaptcha" data-sitekey="6LcP_xoUAAAAAPypJwKRR3fMWUZE-Rhq1NTdX7FU"></div>

                <?php wp_nonce_field( 'budiva_new_user', 'budiva_new_user_nonce', true, true ); ?>

                <div class="error" style="color:red; display:none; margin-bottom:10px;"></div>

                <div class="fbtn">
                    <input type="submit" name="com_submit" id="register-submit" class="button" value="Продолжить">

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php if( is_404() ) : ?>
    <div class="modal fade" role="dialog" id="badLink">
        <div class="modal-dialog modal-bad-link">
            <div class="modal-container type-form">
                <button type="button" class="fancybox-close" data-dismiss="modal" aria-hidden="true"></button>
                Спасибо!
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="modal fade" role="dialog" id="bidForm">
    <div class="modal-dialog modal-form-bid">
        <div class="modal-container type-form" id="form1086">
            <button type="button" class="fancybox-close" data-dismiss="modal" aria-hidden="true"></button>
            <?php get_template_part( 'parts/bid' ); ?>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="bidFormSmall">
    <div class="modal-dialog modal-form-bid-small">
        <div class="modal-container type-form ">
            <button type="button" class="fancybox-close" data-dismiss="modal" aria-hidden="true"></button>
            <?php get_template_part( 'parts/bid-small' ); ?>
        </div>
    </div>
</div>

<?php wp_footer(); ?>

<!-- BEGIN JIVOSITE CODE {literal} -->
<!--<script type='text/javascript'>-->
<!--    (function() {-->
<!--        var widget_id = '7a7v75xS6m';-->
<!--        var d = document;-->
<!--        var w = window;-->
<!---->
<!--        function l() {-->
<!--            var s = document.createElement('script');-->
<!--            s.type = 'text/javascript';-->
<!--            s.async = true;-->
<!--            s.src = '//code.jivosite.com/script/widget/' + widget_id;-->
<!--            var ss = document.getElementsByTagName('script')[0];-->
<!--            ss.parentNode.insertBefore(s, ss);-->
<!--        }-->
<!---->
<!--        if(d.readyState == 'complete') {-->
<!--            l();-->
<!--        } else {-->
<!--            if(w.attachEvent) {-->
<!--                w.attachEvent('onload', l);-->
<!--            } else {-->
<!--                w.addEventListener('load', l, false);-->
<!--            }-->
<!--        }-->
<!--    })();</script>-->
<!-- {/literal} END JIVOSITE CODE -->

    <script type="text/javascript">
        (function(d, w, s) {
            var widgetHash = 'n1kk2paqv5ff7h04nkjb', gcw = d.createElement(s); gcw.type = 'text/javascript'; gcw.async = true;
            gcw.src = '//widgets.binotel.com/getcall/widgets/'+ widgetHash +'.js';
            var sn = d.getElementsByTagName(s)[0]; sn.parentNode.insertBefore(gcw, sn);
        })(document, window, 'script');
    </script>

    </body>
</html>

<?php
if( current_user_can( 'administrator' ) && defined('SAVEQUERIES') && SAVEQUERIES ) {
    global $wpdb;
    echo '<br /><br />########## SQL запросы ##########<br /><br />';
    echo '<span style="margin-left: 10px;"><b>';
    echo 'Количество SQL-запросов = ' . sizeof( $wpdb->queries );
    echo '</b></span><br />';
    $sqlstime = 0;
    foreach( $wpdb->queries as $qrarr ) {
        $sqlstime += $qrarr[1];
    }
    echo '<span style="margin-left: 10px;"><b>';
    echo 'Затрачено времени = ' . round( $sqlstime, 4 ) . ' секунд';
    echo '</b></span><br /><br />';
    foreach( $wpdb->queries as $qrarr ) {
        echo '<span style="color: blue;margin-left: 10px;">SQL-запрос = </span>' . $qrarr[0] . '<br />';
        echo '<span style="color: blue;margin-left: 10px;">Время выполнения = </span>' . round( $qrarr[1], 4 ) . ' секунд<br />';
        echo '<span style="color: blue;margin-left: 10px;">Файлы и функции: </span><br />';
        $filesfunc = split( ",", $qrarr[2] );
        foreach( $filesfunc as $funcs ) {
            echo '<span style="margin-left: 20px;">+ ' . $funcs . '</span><br />';
        }
        echo '<br />';
    }
    echo '<br />########## END: SQL запросы ##########<br /><br />';
} ?>