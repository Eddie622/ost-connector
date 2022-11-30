<?php

/**
 * 	Plugin Name:	    OST Connector
 * 	Description:	    Extends Scand OS Ticket Connector Functionality to include admin page and email submission
 * 	Version: 		    0.9.0
 * 	Author: 		    Heriberto Torres
 * 	Author URI: 	    https://heribertotorres.com
 * 	Text Domain: 	    OST
 *  License:            GPL v2 or later
 *  License URI:        https://www.gnu.org/licenses/gpl-2.0.html
 *  Update URI:         false
 *  GitHub Plugin URI:  Eddie622/ost-connector
 *  GitHub Plugin URI:  https://github.com/Eddie622/ost-connector
 */

// Prohibit direct script loading
defined('ABSPATH') || die('No direct script access allowed!');

final class OST_Connector
{
    /**
     * @var OST_Connector
     */
    protected static $instance = null;
    
    public $plugin_path;
    public $plugin_url;

    /**
     * Singleton instance
     *
     * @return  self
     */
	public static function instance() {
		if( null === self::$instance ) {
			self::$instance = new self();
        }
        return self::$instance;
	}

    /**
     * Constructor
     * 
     * @return  void
     */
    public function __construct() {
        $this->define_paths();
        $this->require_files();
        
        // Construct Menus
        add_action('init', [$this, 'add_menus']);
    }
    
    /**
     * Set paths
     * 
     * @return  void
     */
    
    private function define_paths() {
        $this->plugin_path = trailingslashit( plugin_dir_path( __FILE__ ) );
        $this->plugin_url  = trailingslashit( plugins_url( '/', __FILE__ ) );
        define( 'OST_CONNECTOR_DIR', $this->plugin_path );
        define( 'OST_CONNECTOR_URL', $this->plugin_url );
    }

    /**
     * Set required files
     * 
     * @return  void
     */
    
    private function require_files() {
        require_once(OST_CONNECTOR_DIR . 'api-controller.php');
        require_once(OST_CONNECTOR_DIR . 'include/admin.php');
        require_once(OST_CONNECTOR_DIR . 'include/settings.php');
    }
    
    /**
     * Add Admin Menu Pages
     * 
     * @return  void
     */
    function add_menus(){
        add_action( 'admin_menu', [OST_Admin(), 'OST_Helpdesk_Menu'] );
        !current_user_can('manage_options')?: add_action( 'admin_menu', [OST_Settings(), 'OST_add_settings_page'] );
    }
    
    /**
    * Enqueue Assets
    * 
    * @return void
    */
    public function load_admin_styles(){
        add_action( 'admin_enqueue_scripts', [$this, 'enqueue_admin_styles'] );
    }
    
    public function enqueue_admin_styles() {
        $version = filemtime(OST_CONNECTOR_DIR . '/assets/css/ost-main.css');
        wp_enqueue_style( 'ost-main', OST_CONNECTOR_URL . '/assets/css/ost-main.css', array(), $version, 'all');
    }
     
    public function load_plugin_scripts() {
        $version = filemtime(OST_CONNECTOR_DIR . '/assets/js/app.js');
        wp_enqueue_script( 'app', OST_CONNECTOR_URL . '/assets/js/app.js', array( 'jquery' ), $version, true );
    }
    
}


/**
 * Returns main instance of OST_Connector
 * 
 * @return  OST_Connector
 */
function OST_Connector() {
	return OST_Connector::instance();
}


OST_Connector();
