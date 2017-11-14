<?php do_action( self::PREFIX . 'meta-address-before' ); ?>

<p><?php _e( 'Enter the address of the placemark. You can type in anything that you would type into a Google Maps search field, from a full address to an intersection, landmark, city or just a zip code.', 'basic-google-maps-placemarks' ); ?></p>

<style>
	#bgmp-placemark-coordinates select { width: 25em; }
	#bgmp-placemark-coordinates textarea { width: 25em; height: 100px; }
</style>

<table id="bgmp-placemark-coordinates">	<?php // @todo should use self::PREFIX, but too late b/c users already styling w/ this ?>
	<tbody>
		<tr>
			<th><label for="<?php echo self::PREFIX; ?>city"><?php _e( 'City:', 'basic-google-maps-placemarks' ); ?></label></th>
			<td>
				<select name="<?php echo self::PREFIX; ?>city" id="<?php echo self::PREFIX; ?>city">
					<?php foreach( get_terms( "city", array( "hide_empty" => false ) ) as $_city ) : ?>
						<option value="<?= $_city->name; ?>" <?php if( $_city->name == $city ) echo "selected"; ?> ><?= $_city->name; ?></option>
					<?php endforeach; ?>
				</select>

				<em><a href="<?= get_home_url(); ?>/wp-admin/edit-tags.php?taxonomy=city&post_type=vacancies"><?php printf( __( 'Add new city', 'basic-google-maps-placemarks' ), esc_html( $latitude ), esc_html( $longitude ) ); ?></a></em>
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo self::PREFIX; ?>address"><?php _e( 'Address:', 'basic-google-maps-placemarks' ); ?></label></th>
			<td>
				<input id="<?php echo self::PREFIX; ?>address" name="<?php echo self::PREFIX; ?>address" type="text" class="regular-text" value="<?php echo esc_attr( $address ); ?>" />

				<?php if( $showGeocodeResults ) : ?>
					<em><?php printf( __( '(Geocoded to: %f, %f)', 'basic-google-maps-placemarks' ), esc_html( $latitude ), esc_html( $longitude ) ); ?></em>

				<?php elseif( $showGeocodeError ) : ?>
					<em><?php _e( "(Error geocoding address. Please make sure it's correct and try again.)", 'basic-google-maps-placemarks' ); ?></em>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo self::PREFIX; ?>phone"><?php _e( 'Phone:', 'basic-google-maps-placemarks' ); ?></label></th>
			<td>
				<input id="<?php echo self::PREFIX; ?>phone" name="<?php echo self::PREFIX; ?>phone" type="text" class="regular-text" value="<?php echo esc_attr( $phone ); ?>" />
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo self::PREFIX; ?>email"><?php _e( 'E-mail:', 'basic-google-maps-placemarks' ); ?></label></th>
			<td>
				<input id="<?php echo self::PREFIX; ?>email" name="<?php echo self::PREFIX; ?>email" type="text" class="regular-text" value="<?php echo esc_attr( $email ); ?>" />
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo self::PREFIX; ?>description"><?php _e( 'Description:', 'basic-google-maps-placemarks' ); ?></label></th>
			<td>
				<textarea id="<?php echo self::PREFIX; ?>description" name="<?php echo self::PREFIX; ?>description" class="regular-text"><?php echo esc_attr( $description ); ?></textarea>
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo self::PREFIX; ?>latitude"><?php _e( 'Latitude:', 'basic-google-maps-placemarks' ); ?></label></th>
			<td>
				<input id="<?php echo self::PREFIX; ?>latitude" name="<?php echo self::PREFIX; ?>latitude" type="text" class="regular-text" value="<?php echo esc_attr( $latitude ); ?>" />
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo self::PREFIX; ?>longitude"><?php _e( 'Longitude:', 'basic-google-maps-placemarks' ); ?></label></th>
			<td>
				<input id="<?php echo self::PREFIX; ?>longitude" name="<?php echo self::PREFIX; ?>longitude" type="text" class="regular-text" value="<?php echo esc_attr( $longitude ); ?>" />
			</td>
		</tr>
	</tbody>
</table>

<?php do_action( self::PREFIX . 'meta-address-after' ); ?>
