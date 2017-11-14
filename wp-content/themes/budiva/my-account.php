<?php
/*
    Template Name: My account
*/

if( !defined( 'ABSPATH' ) ) {
    exit;
}

/*if( !is_user_logged_in() )
    header( "Location: " . get_home_url() . "/404.php" );*/
get_header();

get_template_part( 'parts/underhead' );
?>

    <div class="container edit-account-container">
        <?php /* <div class="notice">
            Поздравляем, регистрация успешно пройдена, аккаунт активирован и Вы можете настроить рассылки и изменить
            пароль.
            <p>
                <?php wc_print_notices(); ?>
            </p>
        </div> */ ?>

        <h2 class="header">Мои данные</h2>

        <div class="woocommerce-MyAccount-content">
            <?php do_action( 'woocommerce_account_content' ); ?>
        </div>
    </div>

<?php get_footer(); ?>