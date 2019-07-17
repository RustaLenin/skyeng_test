<?php

Class SkyEng_FormOptions {

    public static function getOption( $name ) {
        return get_option( $name );
    }

    public static function updateOption( $name, $data = [] ) {
        $option = self::getOption( $name );
        if ( empty($option) ) {
            $option = [];
        }
        $new_data = array_merge( $option, $data );
        update_option( $name, $new_data );
    }

}