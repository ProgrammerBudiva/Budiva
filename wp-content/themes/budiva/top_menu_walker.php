<?php

class TopMenuWalker extends Walker_Nav_Menu
{
    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if( $element->classes[0] != "entrance" || !is_user_logged_in() ) {
            //$element->title = ucfirst( strtolower( $element->title ) );
            parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
        }
        elseif( $element->classes[0] == "entrance" ) {
            $current_user = wp_get_current_user();
            $element->title = ( strlen( $current_user->display_name ) < 9 ) ? $current_user->display_name : "Личный<br>кабинет";
            parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
        }
    }
}