<?php

class Smof
{
    private $smof_data;
    private static $instance = null;

    private function __construct() {
        global $smof_data;
        $this->smof_data = $smof_data;
    }

    public static function get_instance() {
        if( !self::$instance )
            self::$instance = new self();
        return self::$instance;
    }

    public static function get( $name, $replace_ssl = true ) {
        $data = self::get_instance()->smof_data;

        if( empty( $data[$name] ) )
            return false;

        if( !$replace_ssl )
            return $data[$name];

        return str_replace( "http://", "https://", $data[$name] );
    }
}