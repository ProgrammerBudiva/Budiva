<?php

class HeaderMenuWalker extends Walker_Nav_Menu
{
    public function end_el( &$output, $object, $depth = 0, $args = array() ) {
        $class = $object->classes[0];
        $output .= "<div class='header-menu-informer $class'><div><div class='h3'>";
        //$output .= print_r($object, true);
        $output .= $object->title;
        $output .= "</div><p>";
        $output .= $object->description;
        $output .= "</p></div></div>";
    }
}