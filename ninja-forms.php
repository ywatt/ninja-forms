<?php if ( ! defined( 'ABSPATH' ) ) exit;

/*
Plugin Name: Ninja Forms
Plugin URI: http://ninjaforms.com/
Description: Ninja Forms is a webform builder with unparalleled ease of use and features.
Version: 2.9.27
Author: The WP Ninjas
Author URI: http://ninjaforms.com
Text Domain: ninja-forms
Domain Path: /lang/

Copyright 2015 WP Ninjas.
*/

define( 'LOAD_DEPRECATED', FALSE );

if( defined( 'LOAD_DEPRECATED') AND LOAD_DEPRECATED ) {
    include 'deprecated/ninja-forms.php';
    return;
}

final class Ninja_Forms
{
    private static $instance;

    public static function instance()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof Ninja_Forms)) {
            self::$instance = new Ninja_Forms;
            spl_autoload_register(array(self::$instance, 'autoloader'));
        }

        return self::$instance;
    }

    public function autoloader($class_name)
    {
        if (false !== strpos($class_name, 'NF_')) {
            $class_name = str_replace('NF_', '', $class_name);
            $classes_dir = realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR;
            $class_file = str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';
            if (file_exists($classes_dir . $class_file)) {
                require_once $classes_dir . $class_file;
            }
        }
    }

} // End Class Ninja_Forms

function Ninja_Forms()
{
    return Ninja_Forms::instance();
}

Ninja_Forms();
