<?php

/**
 * SkyEng test - Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package SkyEng Test
 */

/**
 * Define Constants
 **/

define( 'THEME_DIR', dirname( __FILE__ )                              );
define( 'THEME_DEP', dirname( __FILE__ ) . '/dependency/'             );
define( 'THEME_API', dirname( __FILE__ ) . '/api/'                    );
define( 'THEME_OPT', dirname( __FILE__ ) . '/options/'                );

require_once( THEME_DEP . 'vendor/autoload.php' );
require_once( THEME_API . 'google_api.php' );
require_once( THEME_OPT . 'forms_option.php' );

Class THEME_REGISTER
{
    public static function styles() {
        wp_enqueue_style( 'theme_styles', get_template_directory_uri() . '/style.css' );
    }

    public static function scripts() {
        wp_enqueue_script( 'theme_validation_script', get_template_directory_uri() . '/js/validation.js' );
        wp_enqueue_script( 'theme_ajax_script', get_template_directory_uri() . '/js/ajax.js' );
        wp_enqueue_script( 'theme_actions_script', get_template_directory_uri() . '/js/actions.js' );
    }

}
add_action( 'wp_enqueue_scripts', ['THEME_REGISTER', 'scripts' ] );
add_action( 'wp_enqueue_scripts', ['THEME_REGISTER', 'styles' ] );