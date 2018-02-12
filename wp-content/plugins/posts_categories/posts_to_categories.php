<?php

$check = $wpdb->get_results('SELECT * FROM posts_to_categories WHERE post_id="' . $post->ID . '"');
$checked = [];
foreach($check as $value){
    $checked[] = $value->category_id;
}
$categories = $wpdb->get_results('SELECT * FROM post_category');
?>

<div class="custom-container" id="cat_posts_form">
    <h2 data-toggle="collapse" data-target="#categories-posts" class="hndle ">Отображать статью в тэговых</h2>
    <form id="cat_posts_form">
    <?php

    foreach ($categories as $category){
    ?>
        <div>
            <input  type="checkbox"
                <?php
                if(array_search($category->id, $checked) !== false){?>
                    checked
                <?php    }
                ?>
                    name="category" id="<?php echo $category->id?>">
            <label for="<?php echo $category->id?>"><?php echo $category->name?></label>
        </div>
    <?php
    }?>
    </form>
<input name="save" style="margin-top: 10px;" type="submit" class="button button-primary button-large" id="cat_post" value="Сохранить тэговые">
</div>
<script>
    jQuery('#cat_post').click(function(e) {
        e.preventDefault();
        var selected = [];
        jQuery('#cat_posts_form input:checked').each(function () {
            selected.push(jQuery(this).attr('id'));
        });
        console.log(selected);
        var data = {
            action: 'save_posts_categories',
            array: selected,
            article: jQuery('#post_ID').val()
        };
        jQuery.post( '/wp-admin/admin-ajax.php', data, function(response){
            var json_response = jQuery.parseJSON(response.substring(0, response.length-1));
            var cat_post =jQuery('#cat_post');
            cat_post.val(json_response.data);
            cat_post.attr('disabled','disabled');
        });
    });
</script>