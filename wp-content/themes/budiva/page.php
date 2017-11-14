<?php
get_header();

the_post();

get_template_part( 'parts/underhead' );
?>

	<div class="content-wrap">
		<div class="container">
        
			<?php the_content(); ?>

			<div class="clear"></div>
		</div>
	</div>

<?php get_footer(); ?>