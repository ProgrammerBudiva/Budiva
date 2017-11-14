<?php

class Tabs
{
    public static function get_preview_dir() {
        return wp_upload_dir()['basedir'] . "/files_previews/";
    }

    public static function get_preview_url() {
        return wp_upload_dir()['baseurl'] . "/files_previews/";
    }

    public function __construct() {

    }

    public function get_tab( $tab, $type, $id, $custom_id = false ) {
        $name = "get_tab_{$tab}";

        return $this->$name( $type, $id, $custom_id );
    }

    public function get_tab_custom( $type, $id, $custom_id ) {
        $custom = \MetaBoxes\Tabs::get_custom_tab( $custom_id );

        return $this->_include( 'custom', array(
            'content' => $custom['content']
        ) );
    }

    public function get_tab_video( $type, $id ) {
        $videos = \MetaBoxes\Tabs::get_post_video( $id, $type );

        foreach( $videos as $key => $video ) {
            $k = parse_url( $video['link'] );
            parse_str( $k['query'], $k );
            $videos[$key]['key'] = $k['v'];
            $videos[$key]['iframe_src'] = "https://www.youtube.com/embed/" . $k['v'];
            $videos[$key]['iframe'] = '<iframe width="560" height="315" src="' . $videos[$key]['iframe_src'] . '" frameborder="0" allowfullscreen></iframe>';
            $videos[$key]['preview_link'] = 'https://i.ytimg.com/vi/' . $k['v'] . '/maxresdefault.jpg';
        }

        return $this->_include( 'video', array(
            'videos' => $videos
        ) );
    }

    public function get_tab_charasteristics( $type, $id ) {
        $charasteristics = \MetaBoxes\Tabs::get_post_charasteristics( $id, $type );

        return $this->_include( 'charasteristics', array(
            'charasteristics' => $charasteristics
        ) );
    }

    public function get_tab_sertificates( $type, $id ) {
        $sertificates = \MetaBoxes\Tabs::get_post_sertificates( $id, $type );

        foreach( $sertificates as $key => $sertificate ) {
            \MetaBoxes\Tabs::init_preview( $sertificate['file_id'], 'sertificates' );

            $sertificates[$key]['preview'] = $this->get_preview_url() . "sertificates/" . $sertificate['file_id'] . ".png";
            $type = explode( "/", get_post_mime_type( $sertificate['file_id'] ) )[0];

            $sertificates[$key]['link']['href'] = wp_get_attachment_url( $sertificate['file_id'] );
            $sertificates[$key]['link']['title'] = $sertificate['name'];
            $additional = '';
            if( in_array( $type, array( "image", "video" ) ) )
                $additional .= " data-rel='prettyPhoto'";
            elseif( $type )
                $additional .= " target='_blank'";

            $sertificates[$key]['link'] = sprintf( '<a href="%s" title="%s" %s>__INS__</a>', $sertificates[$key]['link']['href'], $sertificates[$key]['link']['title'], $additional );
        }

        return $this->_include( 'sertificates', array(
            'sertificates' => $sertificates
        ) );
    }

    public function get_tab_instructions( $type, $id ) {
        $instructions = \MetaBoxes\Tabs::get_post_instructions( $id, $type );

        foreach( $instructions as $key => $instruction ) {
            \MetaBoxes\Tabs::init_preview( $instruction['file_id'], 'instructions' );

            $instructions[$key]['preview'] = $this->get_preview_url() . "instructions/" . $instruction['file_id'] . ".png";
            $type = explode( "/", get_post_mime_type( $instruction['file_id'] ) )[0];

            $instructions[$key]['link']['href'] = wp_get_attachment_url( $instruction['file_id'] );
            $instructions[$key]['link']['title'] = $instruction['name'];
            $additional = '';
            if( in_array( $type, array( "image", "video" ) ) )
                $additional .= " data-rel='prettyPhoto'";
            elseif( $type )
                $additional .= " target='_blank'";

            $instructions[$key]['link'] = sprintf( '<a href="%s" title="%s" %s>__INS__</a>', $instructions[$key]['link']['href'], $instructions[$key]['link']['title'], $additional );
        }

        return $this->_include( 'instructions', array(
            'instructions' => $instructions
        ) );
    }

    public function get_tab_price( $type, $id ) {
        $prices = \MetaBoxes\Tabs::get_post_prices( $id, $type, true );
        $url = wp_get_attachment_url( $prices['download_id'] );

        return $this->_include( 'price', array(
            'prices' => $prices,
            'url' => $url
        ) );
    }

    public function _include( $template, $data = array() ) {
        if( !empty( $data ) && is_array( $data ) )
            extract( $data );
        ob_start();
        include( locate_template( "parts/tabs/{$template}.php" ) );
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
}