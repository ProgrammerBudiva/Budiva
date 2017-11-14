<?php

namespace Admin\WpTable;

class ProductCat
{
    public function __construct() {
        add_filter( 'manage_edit-product_cat_columns', array( $this, 'add_column' ) );
        add_filter( 'manage_product_cat_custom_column', array( $this, 'column_value' ), 10, 3 );
    }

    public function add_column( $columns ) {
        $new = array();
        foreach( $columns as $key => $value )
            if( $key != 'posts' )
                $new[$key] = $value;
            else {
                $new['order'] = "Приоритет";
                $new[$key] = $value;
            }
        return $new;
    }

    public function column_value( $columns, $column, $term_id ) {
        if( $column == 'order' )
            return get_field( 'priority', 'product_cat_' . $term_id );
    }
}