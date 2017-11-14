<?php

namespace MetaBoxes;

class Tabs
{
    public static $post_types = array( 'product', 'manufacturer' );

    public static function add() {
        add_meta_box( 'tabs', 'Вкладки', array( "MetaBoxes\Tabs", 'display' ), self::$post_types, 'normal' );
    }

    public static function display( $post ) {
        self::_display( $post->ID, 'post' );
    }

    public static function _display( $id, $type ) {
        $prices = self::get_post_prices( $id, $type );
        if( !$prices ) {
            $download_icon = '';
            $download_title = '';
            $prices = array(
                'download_id' => '',
                'view_id' => '',
            );
            // $view_icon = '';
            // $view_title = '';
        }
        else {
            $download_icon = wp_mime_type_icon( $prices['download_id'] );
            $download_title = get_the_title( $prices['download_id'] );
            // $view_icon = wp_mime_type_icon( $prices['view_id'] );
            // $view_title = get_the_title( $prices['view_id'] );
        }

        $charasteristics = self::get_post_charasteristics( $id, $type );

        $videos = self::get_post_video( $id, $type );

        $instructions = self::get_post_instructions( $id, $type );
        foreach( $instructions as $key => $instruction ) {
            $instructions[$key]['icon'] = wp_mime_type_icon( $instruction['file_id'] );
            $instructions[$key]['file_name'] = get_the_title( $instruction['file_id'] );
            $instructions[$key]['icon'] = wp_get_attachment_image_src( $instruction['file_id'], 'full' )[0];
        }

        $sertificates = self::get_post_sertificates( $id, $type );
        foreach( $sertificates as $key => $sertificate )
            $sertificates[$key]['icon'] = wp_get_attachment_image_src( $sertificate['file_id'], 'full' )[0];

        $customs = self::get_post_custom( $id, $type );

        if( $type == 'post' )
            include( locate_template( "parts/admin/meta-box-tabs-product.php" ) );
        if( $type == 'term' )
            include( locate_template( "parts/admin/meta-box-tabs-term.php" ) );
    }

    public static function save( $post_id, $post, $update ) {
        if( !in_array( get_post_type( $post_id ), self::$post_types ) )
            return;
        self::_save( $post_id, 'post' );
    }

    /**
     * Save post metadata when a post is saved.
     */
    public static function _save( $post_id, $post_type ) {
        if( empty( $_POST['tabs'] ) )
            return;

        $data = $_POST['tabs'];

        // var_dump($data);
        // exit(0);

        /**
         * Prices
         */
        if( !$prices = self::get_post_prices( $post_id, $post_type ) )
            self::create_post_prices( $post_id, (int) $data['price']['download'], 0, $post_type );
        else
            self::update_post_prices( $prices['id'], (int) $data['price']['download'], 0 );

        /**
         * Charasteristics
         */
        if( !$charasteristics = self::get_post_charasteristics( $post_id, $post_type ) )
            self::create_post_charasteristics( array(
                'type' => $post_type,
                'post_id' => $post_id,
                'content' => $data['characteristics']['content']
            ) );
        else
            self::update_post_charasteristics( array(
                'id' => $charasteristics['id'],
                'content' => $data['characteristics']['content']
            ) );

        /**
         * Video
         */
        $videos = self::get_post_video( $post_id, $post_type );
        $videos_delete = array();
        foreach( $videos as $video )
            $videos_delete[] = $video['id'];
        $videos_update = array();
        $videos_insert = array();
        foreach( $data['video']['name'] as $key => $name ) {
            if( !empty( $data['video']['id'][$key] ) && $data['video']['id'][$key] ) {
                $videos_update[] = array(
                    'id' => $data['video']['id'][$key],
                    'name' => $name,
                    'link' => $data['video']['link'][$key],
                    'priority' => $key
                );

                if( ( $search = array_search( $data['video']['id'][$key], $videos_delete ) ) !== FALSE )
                    unset( $videos_delete[$search] );
            }
            else {
                self::create_post_video( array(
                    'type' => $post_type,
                    'post_id' => $post_id,
                    'name' => $name,
                    'link' => $data['video']['link'][$key],
                    'priority' => $key
                ) );
            }
        }
        self::delete_post_videos( $videos_delete );
        foreach( $videos_update as $video )
            self::update_post_video( $video );

        /**
         * Instructions
         */
        $instructions = self::get_post_instructions( $post_id, $post_type );
        $instructions_delete = array();
        foreach( $instructions as $instruction )
            $instructions_delete[] = $instruction['id'];
        $instructions_update = array();
        $instructions_insert = array();
        foreach( $data['instructions']['name'] as $key => $name ) {
            if( !empty( $data['instructions']['id'][$key] ) && $data['instructions']['id'][$key] ) {
                $instructions_update[] = array(
                    'id' => $data['instructions']['id'][$key],
                    'name' => $name,
                    'file_id' => $data['instructions']['file_id'][$key],
                    'priority' => $key
                );

                if( ( $search = array_search( $data['instructions']['id'][$key], $instructions_delete ) ) !== FALSE )
                    unset( $instructions_delete[$search] );
            }
            else {
                self::create_post_instruction( array(
                    'type' => $post_type,
                    'post_id' => $post_id,
                    'name' => $name,
                    'file_id' => $data['instructions']['file_id'][$key],
                    'priority' => $key
                ) );
            }
        }
        self::delete_post_instructions( $instructions_delete );
        foreach( $instructions_update as $instruction )
            self::update_post_instruction( $instruction );

        /**
         * Sertificates
         */
        $sertificates = self::get_post_sertificates( $post_id, $post_type );
        $sertificates_delete = array();
        foreach( $sertificates as $sertificate )
            $sertificates_delete[] = $sertificate['id'];
        $sertificates_update = array();
        $sertificates_insert = array();
        foreach( $data['sertificates']['name'] as $key => $name ) {
            if( !empty( $data['sertificates']['id'][$key] ) && $data['sertificates']['id'][$key] ) {
                $sertificates_update[] = array(
                    'id' => $data['sertificates']['id'][$key],
                    'name' => $name,
                    'file_id' => $data['sertificates']['file_id'][$key],
                    'priority' => $key
                );

                if( ( $search = array_search( $data['sertificates']['id'][$key], $sertificates_delete ) ) !== FALSE )
                    unset( $sertificates_delete[$search] );
            }
            else {
                self::create_post_sertificate( array(
                    'type' => $post_type,
                    'post_id' => $post_id,
                    'name' => $name,
                    'file_id' => $data['sertificates']['file_id'][$key],
                    'priority' => $key
                ) );
            }
        }
        self::delete_post_sertificates( $sertificates_delete );
        foreach( $sertificates_update as $sertificate )
            self::update_post_sertificate( $sertificate );

        /**
         * Custom
         */
        $customs = self::get_post_custom( $post_id );
        $customs_delete = array();
        foreach( $customs as $custom )
            $customs_delete[] = $custom['id'];
        $customs_update = array();
        $customs_insert = array();
        foreach( $data['custom'] as $key => $custom ) {
            if( !empty( $custom['id'] ) && $custom['id'] ) {
                $customs_update[] = array(
                    'id' => $custom['id'],
                    'name' => $custom['name'],
                    'content' => $custom['content'],
                    'priority' => $key
                );

                if( ( $search = array_search( $custom['id'], $customs_delete ) ) !== FALSE )
                    unset( $customs_delete[$search] );
            }
            else {
                self::create_post_custom( array(
                    'type' => $post_type,
                    'post_id' => $post_id,
                    'name' => $custom['name'],
                    'content' => $custom['content'],
                    'priority' => $key
                ) );
            }
        }
        self::delete_post_customs( $customs_delete );
        foreach( $customs_update as $custom )
            self::update_post_custom( $custom );
    }

    /**
     *
     * Characteristics
     *
     */
    private static function create_post_charasteristics( $data ) {
        global $wpdb;
        $wpdb->insert(
            'wp_tabs_characteristics',
            $data,
            array(
                '%s',
                '%d',
                '%s'
            )
        );
    }

    public static function get_post_charasteristics( $post_id, $post_type = 'post' ) {
        global $wpdb;
        return $wpdb->get_row( "SELECT * FROM `wp_tabs_characteristics` WHERE `type`='{$post_type}' AND `post_id` = {$post_id}", ARRAY_A );
    }

    private static function update_post_charasteristics( $data ) {
        global $wpdb;
        $id = $data['id'];
        unset( $data['id'] );
        $data['content'] = stripslashes( $data['content'] );
        $wpdb->update(
            'wp_tabs_characteristics',
            $data,
            array(
                'id' => $id
            ),
            array(
                '%s'
            ),
            array( '%d' )
        );
    }

    /**
     *
     * Custom
     *
     */
    private static function create_post_custom( $data ) {
        global $wpdb;
        $wpdb->insert(
            'wp_tabs_custom',
            $data,
            array(
                '%s',
                '%d',
                '%s',
                '%s',
                '%d'
            )
        );
    }

    public static function get_post_custom( $post_id, $post_type = 'post' ) {
        global $wpdb;
        return $wpdb->get_results( "SELECT * FROM `wp_tabs_custom` WHERE `type`='{$post_type}' AND `post_id` = {$post_id} ORDER BY `priority` ASC", ARRAY_A );
    }

    public static function get_custom_tab( $tab_id ) {
        global $wpdb;
        return $wpdb->get_row( "SELECT * FROM `wp_tabs_custom` WHERE `id`='{$tab_id}'", ARRAY_A );
    }

    private static function update_post_custom( $data ) {
        global $wpdb;
        $id = $data['id'];
        unset( $data['id'] );
        $data['content'] = stripslashes( $data['content'] );
        $wpdb->update(
            'wp_tabs_custom',
            $data,
            array(
                'id' => $id
            ),
            array(
                '%s',
                '%s',
                '%d'
            ),
            array( '%d' )
        );
    }

    private static function delete_post_customs( $data ) {
        global $wpdb;
        foreach( $data as $id )
            $wpdb->delete(
                'wp_tabs_custom',
                array(
                    'id' => $id
                )
            );
    }

    /**
     *
     * Preview file
     *
     */

    public static function init_preview( $file_id, $type = 'instructions' ) {
        if( self::isset_preview( $file_id, $type ) )
            return;

        self::create_preview( $file_id, $type );
    }

    // 124 * 175
    // 155 * 219

    private static function create_preview( $file_id, $type = 'instructions' ) {
        $new_image_path = \Tabs::get_preview_dir() . "{$type}/" . $file_id . ".png";

        $source_image_data = wp_get_attachment_image_src( $file_id, 'full' );
        if( $source_image_data ) {
            $source_image_src = $source_image_data[0];
            $source_image_path = ABSPATH . substr( $source_image_src, ( stripos( $source_image_src, "/", 8 ) + 1 ) );
        }
        else {
            $img = new \imagick();
            $img->setBackgroundColor( new \ImagickPixel( 'transparent' ) );
            $img->readImage( get_attached_file( $file_id ) . "[0]" );
            $img->setImageFormat( "png" );
            file_put_contents( $new_image_path, $img->getImageBlob() );
            $source_image_path = $new_image_path;
        }

        $new_width = ( $type == 'instructions' ) ? 124 : 155;
        $new_height = ( $type == 'instructions' ) ? 175 : 219;

        list( $old_full_width, $old_full_height ) = getimagesize( $source_image_path );
        $factor_width = $old_full_width / $new_width;
        $factor_height = $old_full_height / $new_height;
        $min_factor = min( $factor_height, $factor_width );
        $old_partial_width = $min_factor * $new_width;
        $old_partial_height = $min_factor * $new_height;

        $new_image = imagecreatetruecolor( $new_width, $new_height );
        $old_image_extension = pathinfo( $source_image_path )['extension'];

        $img = new \imagick();
        $img->readImage( $source_image_path );
        $img->resizeImage( $new_width, $new_height, \imagick::FILTER_LANCZOS, 1, false );
        file_put_contents( $new_image_path, $img->getImageBlob() );

        /* if( $old_image_extension == 'png' )
            $old_image = imagecreatefrompng( $source_image_path );
        elseif( $old_image_extension == 'jpg' )
            $old_image = imagecreatefromjpeg( $source_image_path );

        imagecopyresampled( $new_image, $old_image, 0, 0, 0, 0, $new_width, $new_height, $old_partial_width, $old_partial_height );

        imagejpeg( $new_image, $new_image_path ); */


        // header( 'Content-Type: image/jpeg' );

        // file_put_contents( \Tabs::get_preview_dir() . "{$type}/" . $file_id . ".png", $img->getImageBlob() );

        //echo $source_image_path;
        // exit( 0 );


        /* $width = ( $type == 'instructions' ) ? 124 : 155;
        $height = ( $type == 'instructions' ) ? 175 : 219;

        $img = new \imagick();
        $img->setBackgroundColor( new \ImagickPixel( 'transparent' ) );
        $mime_type = get_post_mime_type( $file_id );

        if( substr_count( $mime_type, "pdf" ) !== false )
            $img->setIteratorIndex( 0 );

        if( substr_count( $mime_type, "pdf" ) !== false )
            $img->readImage( get_attached_file( $file_id ) . "[0]" );
        else
            $img->readImage( get_attached_file( $file_id ) );

        if( substr_count( $mime_type, "pdf" ) !== false )
            $img->setIteratorIndex( 0 );

        $img->resizeImage( $width, $height, \imagick::FILTER_LANCZOS, 1 );
        $img->setImageFormat( "png" );
        //$img->setImageCompression( \imagick::COMPRESSION_JPEG );
        //$img->setImageCompressionQuality( 1000 );
        file_put_contents( \Tabs::get_preview_dir() . "{$type}/" . $file_id . ".png", $img->getImageBlob() ); */
    }

    private static function isset_preview( $file_id, $type = 'instructions' ) {
        $dir = \Tabs::get_preview_dir() . "{$type}/" . $file_id . ".png";
        return file_exists( $dir );
    }

    /**
     *
     * Sertificates
     *
     */
    private static function create_post_sertificate( $data ) {
        global $wpdb;
        $wpdb->insert(
            'wp_tabs_sertificates',
            $data,
            array(
                '%s',
                '%d',
                '%s',
                '%d',
                '%d'
            )
        );

        self::init_preview( $data['file_id'], 'sertificates' );
    }

    public static function get_post_sertificates( $post_id, $post_type = 'post' ) {
        global $wpdb;
        return $wpdb->get_results( "SELECT * FROM `wp_tabs_sertificates` WHERE `type`='{$post_type}' AND `post_id` = {$post_id} ORDER BY `priority` ASC", ARRAY_A );
    }

    private static function update_post_sertificate( $data ) {
        global $wpdb;
        $id = $data['id'];
        unset( $data['id'] );
        $wpdb->update(
            'wp_tabs_sertificates',
            $data,
            array(
                'id' => $id
            ),
            array(
                '%s',
                '%d',
                '%d'
            ),
            array( '%d' )
        );

        self::init_preview( $data['file_id'], 'sertificates' );
    }

    private static function delete_post_sertificates( $data ) {
        global $wpdb;
        foreach( $data as $id )
            $wpdb->delete(
                'wp_tabs_sertificates',
                array(
                    'id' => $id
                )
            );
    }

    /**
     *
     * Instructions
     *
     */
    private static function create_post_instruction( $data ) {
        global $wpdb;
        $wpdb->insert(
            'wp_tabs_instructions',
            $data,
            array(
                '%s',
                '%d',
                '%s',
                '%d',
                '%d'
            )
        );

        self::init_preview( $data['file_id'] );
    }

    public static function get_post_instructions( $post_id, $post_type = 'post' ) {
        global $wpdb;
        return $wpdb->get_results( "SELECT * FROM `wp_tabs_instructions` WHERE `type`='{$post_type}' AND `post_id` = {$post_id} ORDER BY `priority` ASC", ARRAY_A );
    }

    private static function update_post_instruction( $data ) {
        global $wpdb;
        $id = $data['id'];
        unset( $data['id'] );
        $wpdb->update(
            'wp_tabs_instructions',
            $data,
            array(
                'id' => $id
            ),
            array(
                '%s',
                '%d',
                '%d'
            ),
            array( '%d' )
        );

        self::init_preview( $data['file_id'] );
    }

    private static function delete_post_instructions( $data ) {
        global $wpdb;
        foreach( $data as $id )
            $wpdb->delete(
                'wp_tabs_instructions',
                array(
                    'id' => $id
                )
            );
    }

    /**
     *
     * Videos
     *
     */
    private static function create_post_video( $data ) {
        global $wpdb;
        $wpdb->insert(
            'wp_tabs_video',
            $data,
            array(
                '%s',
                '%d',
                '%s',
                '%s',
                '%d'
            )
        );
    }

    public static function get_post_video( $post_id, $post_type = 'post' ) {
        global $wpdb;
        return $wpdb->get_results( "SELECT * FROM `wp_tabs_video` WHERE `type`='{$post_type}' AND `post_id` = {$post_id} ORDER BY `priority` ASC", ARRAY_A );
    }

    private static function update_post_video( $data ) {
        global $wpdb;
        $id = $data['id'];
        unset( $data['id'] );
        $wpdb->update(
            'wp_tabs_video',
            $data,
            array(
                'id' => $id
            ),
            array(
                '%s',
                '%s',
                '%d'
            ),
            array( '%d' )
        );
    }

    private static function delete_post_videos( $data ) {
        global $wpdb;
        foreach( $data as $id )
            $wpdb->delete(
                'wp_tabs_video',
                array(
                    'id' => $id
                )
            );
    }

    /**
     *
     * Prices
     *
     */
    private static function create_post_prices( $post_id, $download_id, $view_id, $type = 'post' ) {
        global $wpdb;
        $wpdb->insert(
            'wp_tabs_price',
            array(
                'type' => $type,
                'post_id' => $post_id,
                'download_id' => $download_id,
                'view_id' => $view_id,
                'priority' => 0
            ),
            array(
                '%s',
                '%d',
                '%d',
                '%d',
                '%d'
            )
        );
    }

    public static function get_post_prices( $post_id, $post_type = 'post', $hierarchical = false ) {
        global $wpdb;

        $result = $wpdb->get_row( "SELECT * FROM `wp_tabs_price` WHERE `type`='{$post_type}' AND `post_id` = {$post_id}", ARRAY_A );
        if( ( !$result || !$result['download_id'] ) && $hierarchical ) {
            if( $post_type == 'post' ) {
                $term_list = wp_get_post_terms( $post_id, 'product_cat' );

                return self::get_post_prices( $term_list[0]->term_id, 'term', true );
            }
            else {
                $term = get_term( $post_id, 'product_cat' );

                return self::get_post_prices( $term->parent, 'term' );
            }
        }
        else
            return $result;
    }

    private static function update_post_prices( $prices_id, $download_id, $view_id ) {
        global $wpdb;
        $wpdb->update(
            'wp_tabs_price',
            array(
                'download_id' => $download_id,
                'view_id' => $view_id
            ),
            array(
                'id' => $prices_id
            ),
            array(
                '%d',
                '%d'
            ),
            array( '%d' )
        );
    }
}