<?php

$args = array(
    'type'         => 'post',
    'child_of'     => 0,
    'parent'       => '',
    'orderby'      => 'name',
    'order'        => 'ASC',
    'hide_empty'   => 0,
    'hierarchical' => true,
    'exclude'      => '',
    'include'      => '',
    'number'       => 0,
    'taxonomy'     => 'product_cat',
    'pad_counts'   => false,
    // полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms
);?>
<h2 class="hndle ui-sortable-handle">Отображать статью в категориях/товарах</h2>
<div class="articles-products">
<form id="categories">

<?php
$categories = get_categories( $args );
global $wpdb;
$check = $wpdb->get_results('Select * FROM wp_articles_to_categories WHERE  article_id="'.$post_ID.'"');
$checked = [];
$products = $wpdb->get_results('SELECT wp.ID, wp.post_title, wpm.meta_value FROM wp_posts wp LEFT JOIN wp_postmeta wpm ON wpm.post_id = wp.ID WHERE wp.post_type = \'product\' AND wp.post_status = \'publish\' AND wpm.meta_key = \'_yoast_wpseo_primary_product_cat\';');
$products_arr= [];
foreach ($products as $product){
    $products_arr[$product->meta_value] = [
            'id' => $product->ID,
            'title' => $product->post_title,
            'meta_value' => $product->meta_value
    ];
}

foreach($check as $value){
    $checked[] = $value->category_id;
}

foreach ($categories as $category){
    if($category->parent == 0){

    ?>
    <div>
    <input  type="checkbox"
        <?php
        if(array_search($category->term_id, $checked) !== false){?>
            checked
        <?php    }
        ?>
            name="test" id="<?php echo $category->term_id?>" data-attr="category">
    <label for="<?php echo $category->term_id?>"><?php echo $category->name?></label>
    </div>

<?php
        $child_cats = get_categories(array(
            'taxonomy' => 'product_cat',
            'child_of' => $category->term_id,
            'hide_empty' => 0
        ));

        foreach ($child_cats as $child_cat){?>
            <div class="child-cat" style="margin-left: 20px;">
                <input  type="checkbox" name="test"
                        <?php
                            if(array_search($child_cat->term_id, $checked) !== false){?>
                             checked
                        <?php    }
                        ?>
                        id="<?php echo $child_cat->term_id?>" data-attr="category">
                <label for="<?php echo $child_cat->term_id?>"><?php echo $child_cat->name?></label>
            </div>
       <?php
            foreach ($products as $product){
                if ($product->meta_value == $child_cat->term_id){ ?>
                    <div class="child-cat" style="margin-left: 40px;">
                        <input  type="checkbox" name="test"
                            <?php
                            if(array_search($product->ID, $checked) !== false){?>
                                checked
                            <?php    }
                            ?>
                                id="<?php echo $product->ID?>" data-attr="product">
                        <label for="<?php echo $product->ID?>"><?php echo $product->post_title?></label>
                    </div>
              <?php  }
            }
        }
}}?>
</form>
    <input name="save" style="margin-top: 10px;" type="submit" class="button button-primary button-large" id="cat_art" value="Сохранить категории">
</div>
<?php

include( ABSPATH . 'wp-admin/admin-footer.php' );
?>
<script>
    jQuery('#cat_art').click(function(){
        var selected = [];
        jQuery('#categories input:checked').each(function() {
            selected.push([jQuery(this).attr('id'), jQuery(this).attr('data-attr')]);
        });
        console.log(selected);
        var data = {
            action: 'save_article_category',
            array: selected,
            article: jQuery('#post_ID').val()
        };

        jQuery.post( '/wp-admin/admin-ajax.php', data, function(response){
            var json_response = jQuery.parseJSON(response.substring(0, response.length-1));
            var cat_art =jQuery('#cat_art');
            cat_art.val(json_response.data);
            cat_art.attr('disabled','disabled');
        });

    });
</script>