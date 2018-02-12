<?php
global $wpdb;
$tags = $wpdb->get_results('SELECT pc.id, pc.name FROM post_category pc RIGHT JOIN posts_to_categories ON pc.id = posts_to_categories.category_id;');
/*
	Template Name: Blog
*/

get_header();


get_template_part( 'parts/underhead' ); ?>
    <div class="news-block container">
        <div id="preloader"></div>
        <div class="tags-container">
            <div class="tag-item button-primary-custom" data-attr="all">Все статьи</div>
            <?php
                if (!empty($tags)){
                    foreach ($tags as $tag){ ?>

                        <div class="tag-item button-primary-custom" data-attr="<?php echo $tag->id;  ?>"><?php echo $tag->name?></div>

                    <?php }
                }
            ?>
        </div>
        <?php if( have_posts() ) : ?>
            <div class="row" id="posts-block">

                <?php while( have_posts() ) :
                    the_post();
                    $post = budiva_posts_right_date( $post );
                    get_template_part( 'parts/blog-content' );
                endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="clear"></div>

<?php if( function_exists( 'budiva_wp_corenavi' ) )
    budiva_wp_corenavi(); ?>
    <div class="clear"></div>

    <div class="container_sub">
        <?php
        $var[] = apply_filters( 'the_content', get_post_meta( $post->ID, 'subscribe_form', true ) );
        if( !empty( $var ) ) {
            echo apply_filters( 'the_content', get_post_meta( 10, 'subscribe_form', true ) );
        }
        ?>
    </div>
<?php get_footer(); ?>

<script>
    $(document).ready(function(){
        $(".tag-item").click(function(){
            $('#preloader').fadeIn();
            $.ajax({
                type: "POST",
                url: "/wp-admin/admin-ajax.php",
                data: { action: 'get_tag_posts' , tag_id: $(this).attr('data-attr') },
                success: function (html) {
                    $('#posts-block').html(html);
                    $('#preloader').fadeOut('slow');
                }
            });
        });
    });
</script>
