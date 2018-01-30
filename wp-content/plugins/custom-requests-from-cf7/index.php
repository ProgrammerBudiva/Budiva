<?php
global $wpdb;
wp_enqueue_style( 'dataTables', 'https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css', false, '1.1', 'all' );
wp_enqueue_script( 'dataTables', 'https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js', array ( 'jquery' ), 1.1, true);
wp_enqueue_script( 'dataTablesInit', '/wp-content/plugins/custom-requests-from-cf7/dataTablesInit.js', array ( 'dataTables' ), 1.1, true);
$results = $wpdb->get_results('Select * FROM custom_requests');
//echo "<pre>"; print_r($results); echo "</pre>";
?>
<div class="row" style="width: 90%; margin: auto; padding-top: 10px;">
    <table id="requests-table" class="display">
        <thead>
            <tr>
                <th>Дата</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>Форма</th>
                <th>Страница</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($results as $result){?>
            <tr>
                <td><?php echo !empty($result->created_at)? $result->created_at: '-';?></td>
                <td><?php echo !empty($result->email)? $result->email: '-';?></td>
                <td><?php echo !empty($result->phone)? $result->phone: '-';?></td>
                <td><?php echo !empty($result->form_name)? $result->form_name: '-';?></td>
                <td><?php echo !empty($result->url_page)? $result->url_page: '-';?></td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>