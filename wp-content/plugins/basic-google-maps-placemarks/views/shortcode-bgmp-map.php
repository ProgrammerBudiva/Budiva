<script type="text/javascript">
	bgmpDataAll[<?= $map_id; ?>] = {
		options: <?php echo json_encode( $this->getMapOptions( $attributes ) ); ?>,
		markers: <?php echo json_encode( $this->getMapPlacemarks( $attributes ) ); ?>,
		height: '<?= $attributes['height']; ?>'
	};
</script>
	
<div id="<?php echo self::PREFIX; ?>map-canvas-<?= $map_id; ?>">
	<p><?php _e( 'Loading map...', 'basic-google-maps-placemarks' ); ?></p>
	<p><img src="<?php echo plugins_url( 'images/loading.gif', dirname( __FILE__ ) ); ?>" alt="<?php _e( 'Loading', 'basic-google-maps-placemarks' ); ?>" /></p>
</div>