<?php

namespace MetaBoxes\Tax;

class Tax
{
    public static function add_boxes() {
        Underhead::add();
        Gallery::add();
        Tabs::add();
    }

    public static function save_boxes() {
        Underhead::save_hook();
        Gallery::save_hook();
        Tabs::save_hook();
    }
}