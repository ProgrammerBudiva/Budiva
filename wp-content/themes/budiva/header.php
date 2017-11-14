<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7">
<![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8">
<![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9">
<![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> class="no-js">
<!--<![endif]-->
<head>
    <?php /*
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-M7CD9N');</script>
<!-- End Google Tag Manager -->
 */ ?>

    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= get_stylesheet_directory_uri(); ?>/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
    <?php wp_head(); ?>
    <script type="text/javascript">$ = jQuery</script>
    <!-- Facebook Pixel Code -->
    <script>
        !function(f, b, e, v, n, t, s) {
            if(f.fbq)return;
            n = f.fbq = function() {
                n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if(!f._fbq)f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window,
            document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1764713323748589', {em: 'insert_email_variable,'});
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1764713323748589&ev=PageView&noscript=1"/>
    </noscript>
    <!-- DO NOT MODIFY -->
    <!-- End Facebook Pixel Code -->
</head>
<body <?php body_class(); ?>>


<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M7CD9N"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="header fixed-header">
    <div class="container">
        <div class="logo-box">
            <?php if( !is_front_page() ) : ?>
                <a class="logotype" href="<?= get_home_url(); ?>">
                    <img itemprop="contentUrl" src="<?= Smof::get( 'service_2_icon' ); ?>" alt="компания Будива (Budiva) - официальный дистрибьютор корпорации ТехноНИКОЛЬ" title="Logo">
                </a>
            <?php else : ?>
                <img itemprop="contentUrl" src="<?= Smof::get( 'service_2_icon' ); ?>" alt="компания Будива (Budiva) - официальный дистрибьютор корпорации ТехноНИКОЛЬ" title="Logo">
            <?php endif; ?>

        </div>
        <div class="menu-box-right">
            <?php wp_nav_menu( array(
                'theme_location' => 'top_menu_place',
                'container_class' => 'header-menu-box',
                'menu_class' => 'navbar-menu-list',
                'walker' => new TopMenuWalker
            ) ); ?>
            <div class="search-and-call-box-right">
                <?php get_search_form(); ?>
                <div itemscope itemtype="http://schema.org/Organization">
                    <a class="btn-phone" itemprop="url" href="#" data-toggle="modal" data-target="#bidFormSmall">
                        <i class="fa fa-phone" aria-hidden="true"></i>Обратный
                        звонок</a>

                    <div class="header-phones">

                        <div>
                            <div class="header-number" itemprop="telephone"><?= Smof::get( "header_main_phone" ); ?></div>

                            <div class="small">звонок бесплатный</div>

                            <?php if( !empty( Smof::get( "header_additional_phones" ) ) ) : ?>
                                <div class="numbers-add">
                                    <?php foreach( Smof::get( "header_additional_phones" ) as $phone ) : ?>
                                        <div itemprop="telephone" class="header-number clearfix">
                                            <div class="pull-left"><?= $phone["description"]; ?></div>
                                            <div class="pull-right"><?= $phone["title"]; ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
                <div class="clear"></div>

            </div>

            <?php wp_nav_menu( array(
                'theme_location' => 'header_menu_place',
                'container' => false,
                'menu_class' => 'header-menu-box-two',
                'walker' => new HeaderMenuWalker
            ) ); ?>

        </div>
        <div class="clear"></div>
    </div>
</div>

<div class="mobile-header">
    <div class="container mobile-search not-print clearfix">
        <?php get_search_form(); ?>
    </div>
    <div class="container">
        <div class="row">
            <div itemscope itemtype="http://schema.org/ImageObject" class="col-xs-6 col-sm-4 col-md-4 hidden-lg print-100 mobile-logo">
                <?php if( !is_front_page() ) : ?>
                    <a class="mobile-logotype" href="<?= get_home_url(); ?>">
                        <img itemprop="contentUrl" src="<?= Smof::get( 'service_2_icon' ); ?>" alt="компания Будива (Budiva) - официальный дистрибьютор корпорации ТехноНИКОЛЬ" title="Logo">
                    </a>
                <?php else : ?>
                    <img itemprop="contentUrl" src="<?= Smof::get( 'service_2_icon' ); ?>" alt="компания Будива (Budiva) - официальный дистрибьютор корпорации ТехноНИКОЛЬ" title="Logo">
                <?php endif; ?>

                <div class="link only-print">https://budiva.ua/</div>
            </div>
            <div class="hidden-xs col-sm-3 col-md-3 hidden-lg search-box-container not-print">
                <?php get_search_form(); ?>
            </div>
            <div class="hidden-xs col-sm-3 col-md-3 hidden-lg header-phones-container not-print">
                <div class="header-phones">

                    <div>
                        <div class="header-number" itemprop="telephone"><?= Smof::get( 'header_main_phone' ); ?></div>

                        <div class="small">звонок бесплатный</div>

                        <?php if( !empty( Smof::get( "header_additional_phones" ) ) ) : ?>
                            <div class="numbers-add">
                                <?php foreach( Smof::get( "header_additional_phones" ) as $phone ) : ?>
                                    <div itemprop="telephone" class="header-number clearfix">
                                        <div class="pull-left"><?= $phone["description"]; ?></div>
                                        <div class="pull-right"><?= $phone["title"]; ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
            <div class="col-xs-1 col-xs-1-8 hidden-sm hidden-md hidden-lg btn-container not-print">
                <a href="#" class="mobile-header-button-phone mobile-search-toggle">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </a>
            </div>
            <div class="col-xs-1 col-xs-1-8 col-sm-1 col-md-1 hidden-lg btn-container not-print">
                <a href="#" data-toggle="modal" data-target="#bidFormSmall" class="mobile-header-button-phone without-border">
                    <img src="<?= THEME_URI; ?>/img/call-1.png" alt="call-1" title="call-1"/>
                </a>
            </div>
            <div class="col-xs-1 col-xs-1-8 hidden-sm hidden-md hidden-lg btn-container not-print">
                <a href="tel:<?= preg_replace( "/[^0-9]/", '', Smof::get( 'header_main_phone' ) ); ?>" class="mobile-header-button-phone without-border">
                    <img src="<?= THEME_URI; ?>/img/call.png" alt="call-2" title="call-2"/>
                </a>
            </div>
            <div class="col-xs-1 col-xs-1-8 col-sm-1 col-md-1 hidden-lg burger-container not-print">
                <div class="mob-menu-right">
                    <div class="mobile-button-open-menu clearfix">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="wrapper-menu-mobile not-print">
                <?php if( is_active_sidebar( 'mobile-menu' ) )
                    dynamic_sidebar( 'mobile-menu' ); ?>
                <div id="nav_menu-2" class="widget widget_nav_menu">
                    <div class="h2 widgettitle">Меню</div>
                    <?php wp_nav_menu( array(
                        'theme_location' => 'top_menu_place',
                        'container_class' => 'header-menu-box',
                        'menu_class' => 'menu',
                        'depth' => 1,
                        'walker' => new TopMenuWalkerMobile
                    ) ); ?>
                </div>
            </div>
        </div>
    </div>
</div>