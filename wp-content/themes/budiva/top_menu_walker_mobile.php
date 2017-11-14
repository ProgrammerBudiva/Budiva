<?php

class TopMenuWalkerMobile extends Walker_Nav_Menu
{
    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if( $element->classes[0] != "entrance" || !is_user_logged_in() ) {
            if( $element->classes[0] != "header-menu-social-button" )
                parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
        }
        elseif( $element->classes[0] == "entrance" && !is_user_logged_in() ) {
            $element->title = "Вход/Регистрация";
            parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
        }
        elseif( $element->classes[0] == "entrance" ) {
            global $current_user;
            wp_get_current_user();
            $element->title = $current_user->user_login;
            parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
        }
    }
}