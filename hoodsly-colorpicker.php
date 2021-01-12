<?php
/**
 * Plugin Name: Hoodsly ColorPicker
 * Plugin URI:  https://keendevs.com
 * Description: This is a color picker plugin for woocommerce.
 * Version:     1.0.0
 * Author:      KeenDevs
 * Author URI:  https://keendevs.com
 * Text Domain: hoodsly-colorpicker
 * Domain Path: /languages/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( ! defined('ABSPATH') ){
    exit;
}

/**
 * The main Plugin Class
 */
final class Hoodsly_ColorPicker {

    /**
     * Plugin Version
     */
    const version = '1.0.0';

    /**
     * Class Constractor
     */
    private function __construct(){


        $this->defineConstance();


        add_action( "plugins_loaded", [ $this, 'includes' ] );

    }

   /**
    * Initilize a singleton instance
    *
    * @return /wooThankYou
    */
    public static function init(  ){

        static $instance = false;

        if( ! $instance ){

            $instance = new self();

        }

        return $instance;
    }

    /**
     * Plugin Constance
     *
     * @return /wooThankYou
     */
    public function defineConstance(){

        define('COLORPICKER_VERSION', self::version);
        define('COLORPICKER_FILE', __FILE__);
        define('COLORPICKER_PATH', __DIR__);
        define('COLORPICKER_URL', plugins_url('', COLORPICKER_FILE));
        define('COLORPICKER_ASSETS', COLORPICKER_URL."/assets");

    }


    /**
     * Plugins Loaded
     *
     * @return /wooThankYou
     */
    public function includes(){
        require COLORPICKER_PATH. '/includes/functions.php';
    }
    
}

/**
 * Initilize the main plugin
 *
 * @return /wooThankYou
 */
function Hoodsly_ColorPicker(){

    return Hoodsly_ColorPicker::init();

}

/**
 * kick-off the plugin
 */
Hoodsly_ColorPicker();

