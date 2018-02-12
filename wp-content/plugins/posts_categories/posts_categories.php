<?php
//require_once( '../../admin.php' );
//require_once( ABSPATH . 'wp-admin/admin-header.php' );
global $wpdb;
wp_enqueue_style( 'dataTables', 'https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css', false, '1.1', 'all' );
wp_enqueue_style( 'magnificPopup', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css', false, '1.1', 'all' );

wp_enqueue_script( 'dataTables', 'https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js', array ( 'jquery' ), 1.1, true);
wp_enqueue_script( 'dataTablesInit', '/wp-content/plugins/custom-requests-from-cf7/dataTablesInit.js', array ( 'dataTables' ), 1.1, true);
wp_enqueue_script( 'magnificPopup', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js', array ( 'jquery' ), 1.1, true);
$categories = $wpdb->get_results('SELECT * FROM post_category');
?>

<div class="row" style="width: 50%; margin: auto; padding-top: 10px;">
    <a id="test" class="button button-primary" style="margin:15px" href="#my-popup">Добавить категорию</a>
    <table id="requests-table" class="display">
        <thead>
        <tr>
            <th>Id</th>
            <th>Название</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($categories as $category){?>
            <tr>
                <td><?php echo !empty($category->id)? $category->id: '-';?></td>
                <td><?php echo !empty($category->name)? $category->name: '-';?></td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>




<div id="my-popup" class="mfp-hide white-popup">
    <label for="name">Укажите название</label>
    <input type="text" id="name" name="name">
    <div class="wc-update-now button-primary" id="add_category" style="margin-top: 10px;">Добавить</div>
</div>


<script>
    jQuery(document).ready(function() {
        jQuery('#test').magnificPopup({type:'inline'});

        jQuery('#add_category').click(function(){
            var data = {
                action: 'save_new_post_category',
                name: jQuery('#name').val()
            };
            jQuery.post( '/wp-admin/admin-ajax.php', data, function(response){
                var json_response = jQuery.parseJSON(response.substring(0, response.length-1));
                if(json_response.data === 'success'){
                    window.location.replace('/wp-admin/custom/posts_categories/posts_categories.php');
                }else{
                    console.log('alert');
                }
            });
        });


    });
</script>

<style>
    .white-popup {
        position: relative;
        background: #FFF;
        padding: 40px;
        width: auto;
        max-width: 200px;
        margin: 20px auto;
        text-align: center;
    }
</style>