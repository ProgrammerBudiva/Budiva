<?php

class Terms
{
    private static $front_page_subcategories = null;
    private static $front_page_subcategories_list = null;

    public static function get_front_subcategories( $category_id ) {
        if( !self::$front_page_subcategories ) {
            self::$front_page_subcategories = get_option( 'front_page_subcategories' );

            $ids = array();
            foreach( self::$front_page_subcategories as $subcategory )
                foreach( $subcategory as $id )
                    $ids[] = $id;

            $terms = get_terms( array(
                'include' => $ids,
                'orderby' => 'include',
                'hide_empty' => false
            ) );

            foreach( $terms as $term )
                self::$front_page_subcategories_list[$term->term_id] = $term;
        }

        $result = array();
        foreach( self::$front_page_subcategories[$category_id] as $id )
            $result[] = self::$front_page_subcategories_list[$id];

        return $result;
    }
}