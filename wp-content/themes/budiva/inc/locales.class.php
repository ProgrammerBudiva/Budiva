<?php

class Locales
{
    public static function set_locales() {
        $locales = array(
            "ru_RU.UTF8",
            "Russian_Russia.65001",
            "Russian_Russia.UTF8",
            "ru_RU.UTF-8",
        );

        $setFlag = false;

        foreach( $locales as $localeName ) {
            if( $setFlag === false ) {
                // Выполняем установку локали
                setlocale( LC_ALL, $localeName );
            }

            // Провреряем, установлена ли локаль
            if( $setFlag === false &&
                //(mb_strtolower("qwertyёЁАБГДЯQWERTYZ") === "qwertyёёабгдяqwertyz")
                //||
                preg_match( "/^[а-яЁё]+$/ui", strftime( "%a" ) )
            ) {
                // Локаль установлена корректно
                $setFlag = true;
                break;
            }
        }

        setlocale( LC_NUMERIC, "C" );
    }
}