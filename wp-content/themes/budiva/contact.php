<?php
/*
	Template Name: Contacts
*/

get_header();

?>
    <div class="content-wrap">
        <div class="container">
            <div class="breadcrumbs breadcrumbs-black">
                <?php if( function_exists( 'bcn_display' ) )
                    bcn_display(); ?>
            </div>
            <div class="clear"></div>
        </div>

        <div class="container">
            <div class="otstup_breadcrumbs"></div>

            <?php /* Simple Content */ ?>

            <content>
                <?php the_content(); ?>
            </content>

            <div class="clear"></div>

            <div class="maps-container">
                <?php
                $query_args = array(
                    "posts_per_page" => -1,
                    'post_type' => 'bgmp',
                    'orderby' => 'meta_value_num',
                    'meta_key' => 'priority'
                );
                $the_query = new WP_Query( $query_args );
                $map_markers = array();
                $maps = 0;
                ?>
                <table>
                    <tr>
                        <td><span data-target="0" class="active">Все филиалы</span></td>
                        <?php while( $the_query->have_posts() ) {
                            $maps++;
                            $the_query->the_post();
                            $meta = get_post_meta( $post->ID, '', true );
                            $marker = array(
                                'lat' => $meta['bgmp_latitude'][0],
                                'lng' => $meta['bgmp_longitude'][0],
                                'title' => $post->post_title,
                                'fillial_id' => $maps
                            );
                            $map_markers[0][] = $marker;
                            $map_markers[$maps][] = $marker;
                            ?>
                            <td><span data-target="<?= $maps; ?>"><?= $meta['bgmp_city'][0]; ?></span></td>
                        <?php }
                        $maps = 0;
                        wp_reset_query(); ?>
                    </tr>
                </table>

                <div id="google_map" data-map="0" style="height: 600px;"></div>

                <?php while( $the_query->have_posts() ) {
                    $maps++;
                    $the_query->the_post();
                    $meta = get_post_meta( $post->ID, '', true );
                    ?>

                    <table class="map-print map-print-<?= $maps; ?>">
                        <tr>
                            <th>Адрес</th>
                            <th>Телефон</th>
                            <th>E-mail</th>
                            <th>График работы</th>
                        </tr>
                        <tr>
                            <td><?= $meta['bgmp_address'][0]; ?></td>
                            <td><?= $meta['bgmp_phone'][0]; ?></td>
                            <td><?= $meta['bgmp_email'][0]; ?></td>
                            <td><?= nl2br( $meta['bgmp_description'][0] ); ?></td>
                        </tr>
                    </table>

                <?php }
                $maps = 0;
                wp_reset_query(); ?>

                <img src="" alt="" id="google_map_print" class="only-print">

                <div class="google-map-after">
                    <table class="map-0 active">
                        <tr>
                            <td>
                                <p>0(800)300-506 (бесплатный звонок)</p>

                                <p><a href="mailto:info@budiva.ua">info@budiva.ua</a></p>

                                <p>график работы: пн.-пт. с 09:00-18:00 </p>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>

                    <?php while( $the_query->have_posts() ) {
                        $maps++;
                        $the_query->the_post();
                        $meta = get_post_meta( $post->ID, '', true );
                        ?>

                        <table class="map-<?= $maps; ?>">
                            <tr>
                                <td>
                                    <div class="h2"><?= $post->post_title; ?></div>

                                    <table>
                                        <tr>
                                            <th>Адрес</th>
                                            <td><?= $meta['bgmp_address'][0]; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Телефон</th>
                                            <td><?= $meta['bgmp_phone'][0]; ?></td>
                                        </tr>
                                        <tr>
                                            <th>E-mail</th>
                                            <td>
                                                <a href="mailto:<?= $meta['bgmp_email'][0]; ?>"><?= $meta['bgmp_email'][0]; ?></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>График работы</th>
                                            <td><?= nl2br( $meta['bgmp_description'][0] ); ?></td>
                                        </tr>
                                    </table>

                                </td>
                                <td>
                                    <a href="#" class="print-map" data-target="map-<?= $maps; ?>">Версия для печати</a>
                                </td>
                                <td>
                                    <img src="/wp-content/themes/budiva/qr/qr.php?id=1&y=<?= $maps; ?>"/>
                                </td>
                            </tr>
                        </table>

                    <?php }
                    wp_reset_query(); ?>
                </div>
            </div>


            <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD40OPh0-uq1PXrYjUzkQvZAAmmqB-5jUc&callback=initMap&region=UA">
            </script>

            <div class="lines only-print">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>

            <script>
                var map_markers = JSON.parse('<?= json_encode($map_markers); ?>');

                function initMap(num=0) {
                    var lat, lng, zoom, i;

                    markers = map_markers[num];

                    $("#google_map").data('map', num);

                    if(markers.length == 1) {
                        lat = parseFloat(markers[0]['lat']);
                        lng = parseFloat(markers[0]['lng']);
                        zoom = 17;
                    }
                    else {
                        var min_lat = parseFloat(markers[0]['lat']);
                        var min_lng = parseFloat(markers[0]['lng']);
                        var max_lat = parseFloat(markers[0]['lat']);
                        var max_lng = parseFloat(markers[0]['lng']);
                        zoom = 6;
                        for(i = 1; i < markers.length; i++) {
                            lat = parseFloat(markers[i]['lat']);
                            lng = parseFloat(markers[i]['lng']);
                            if(lat > max_lat)
                                max_lat = lat;
                            if(lat < min_lat)
                                min_lat = lat;
                            if(lng > max_lng)
                                max_lng = lng;
                            if(lng < min_lng)
                                min_lng = lng;
                        }
                        lat = (min_lat + max_lat) / 2;
                        lng = (min_lng + max_lng) / 2;
                    }

                    var map = new google.maps.Map(document.getElementById('google_map'), {
                        zoom: zoom,
                        center: {lat: lat, lng: lng}
                    });

                    var map_label = new google.maps.MarkerImage(
                        '<?= THEME_URI; ?>/img/map-label.png',
                        new google.maps.Size(128, 83),
                        new google.maps.Point(0, 0),
                        new google.maps.Point(64, 83)
                    );

                    var marker = [];
                    for(i in markers) {
                        var m = markers[i];
                        marker[i] = new google.maps.Marker({
                            position: {
                                lat: parseFloat(m.lat),
                                lng: parseFloat(m.lng)
                            },
                            map: map,
                            title: m.title,
                            icon: map_label,
                            fillial_id: m.fillial_id
                        });

                        if(num == 0) {
                            marker[i].addListener('click', (function(marker) {
                                return function() {
                                    initMap(marker.fillial_id);
                                    change_view(marker.fillial_id);
                                }
                            })(marker[i]));
                        }
                    }
                }

                function change_view(id) {
                    $('.maps-container td span').removeClass('active');
                    $('.maps-container > table span[data-target="' + id + '"]').addClass('active');

                    $('.maps-container .google-map-after > table').removeClass('active');
                    var _class = "map-" + id;
                    $('.maps-container .google-map-after > table.' + _class).addClass('active');
                }

                jQuery(document).ready(function($) {
                    $('.maps-container td span').on('click', function() {
                        if(!$(this).hasClass('active')) {
                            var id = $(this).data('target');
                            initMap(id);
                            change_view(id);
                        }
                    });
                });
            </script>
        </div>

        <div class="container container-form">
            <div class="modal-container type-form">
                <?php get_template_part( 'parts/bid' ); ?>
            </div>
        </div>


    </div>

<?php get_footer(); ?>