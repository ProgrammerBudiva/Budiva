<?php

/*
Plugin Name: Franchise Map
Description: Franchise Map
Author: Krigus
Version: 1.0
Author URI: http://krigus.com/
*/

if( !defined( 'ABSPATH' ) )
    exit;

class Franchise_Map
{
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    public function admin_menu() {
        if( is_admin() ) {
            add_menu_page( 'Franchise Map', 'Franchise Map', 'manage_options', 'franchise-map-1', array( $this, 'first_admin_page' ), '', 82 );
        }
    }

    public function first_admin_page() {
        if( !empty( $_POST ) && wp_verify_nonce( $_POST['nnc'], 'franchise-upload-csv' ) )
            $this->regen();

        include( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . "first-admin-page.php" );
    }

    private function regen() {
        global $wpdb;

        $attachments = get_posts( array(
            'numberposts' => -1,
            //'offset' => 10,
            //'numberposts' => 11,
            //'include' => array( 2899 ),
            'post_type' => 'attachment',
            'post_status' => 'inherit'
        ) );

        echo "Всего: " . count( $attachments ) . "<br>";

        $counter = 0;

        foreach( $attachments as $attachment ) {
            $counter++;

            echo $counter . ".) " . $attachment->guid . "<br>";

            $guid_small = strtolower( $attachment->guid );

            $metadata = get_post_meta( $attachment->ID, '_wp_attachment_metadata', true );
            $dir = strtolower( get_post_meta( $attachment->ID, '_wp_attached_file', true ) );

            if( $guid_small != $attachment->guid ) {
                echo "Нарушен регистр<br>";

                rename( get_attached_file( $attachment->ID ), wp_get_upload_dir()['basedir'] . "/$dir" );
                echo "Переименовали файл<br>";

                $query = "UPDATE `wp_posts` SET `guid`='" . $guid_small . "' WHERE `ID`='" . intval( $attachment->ID ) . "'";
                $wpdb->query( $query );
                echo "Заменили wp_posts<br>";

                update_post_meta( $attachment->ID, "_wp_attached_file", $dir );
                echo "Заменили _wp_attached_file<br>";

                $metadata['file'] = $dir;
                echo "Заменили ['file']<br>";
            }

            $full_dir = wp_get_upload_dir()['basedir'] . "/" . substr( $dir, 0, ( strripos( $dir, "/" ) + 1 ) );

            if( !empty( $metadata['sizes'] ) ) {
                echo "Есть " . count( $metadata['sizes'] ) . " размеров<br>";
                $_counter = 0;
                foreach( $metadata['sizes'] as $key => $size ) {

                    if( is_array( $size ) ) {
                        $file = $size['file'];
                        if( file_exists( $full_dir . $file ) ) {

                            $name = mb_strtolower( $file );

                            if( $name != $file ) {
                                rename( $full_dir . $file, $full_dir . $name );
                                $metadata['sizes'][$key]['file'] = $name;
                                $_counter++;
                            }
                        }
                    }
                    else {
                        /* if( file_exists( $full_dir . $size ) ) {

                            $name = mb_strtolower( $size );

                            if( $name != $size ) {
                                rename( $full_dir . $size, $full_dir . $name );
                                $metadata['sizes'][$key] = $name;
                                $_counter++;
                            }
                        } */
                    }

                    /* var_dump( $size );

                    echo $name . "<br>";
                    echo $size . "<br>"; */

                    /* if( !file_exists( $full_dir . $size['file'] ) )
                        echo "Размер не найден!<br>";
                    else
                        unlink( $full_dir . $size['file'] ); */
                }
                echo "Заменено " . $_counter . " размеров<br>";
            }
            else
                echo "Размеров на найдено!<br>";

            update_post_meta( $attachment->ID, "_wp_attachment_metadata", $metadata );
        }
    }

    private function check_inner( $dir ) {
        return preg_match( '/uploads\/[\d]{4}\/[\d]{2}\/[\d]{2}\//', $dir );
    }
}

new Franchise_Map();