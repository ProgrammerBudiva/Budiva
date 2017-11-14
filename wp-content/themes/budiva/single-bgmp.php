<?php get_header();
?>

<?php while(have_posts()) : the_post(); ?>
    <?= do_shortcode( '[bgmp-map width="1000" placemark="' . $post->ID . '" zoom="10" type="terrain"]' ); ?>
<?php endwhile; ?>

<?php get_footer(); ?>