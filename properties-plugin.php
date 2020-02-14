<?php

/**
 * Plugin Name:       Properties Plugin (name TBD)
 * Plugin URI:        http://www.website-tbd.com/
 * Description:       Plugin to add a custom home search functionality to your wordpress site
 * Version:           0.0.1
 * Author:            Brett Pollett & Zach Akbar
 * Author URI:        https://www.website-tbd.com
 * License:			  		GPL3
 * License URI:  	  	https://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain:       properties-plugin
 * Domain Path:       /languages
 *
 */

if (!defined('WPINC')) {
	die;
}

// Ensure the plugin only gets loaded once
if (!class_exists('PropertiesPlugin')):

	class PropertiesPlugin {

		// Static class
		/**
		 * @var PropertiesPlugin
		 */
		protected static $instance;

		/**
		 * @return PropertiesPlugin
		 */
		public static function instance() {
			if (is_null(static::$instance)) {
				static::$instance = new static();
			}
			return static::$instance;
		}

		public $plugin_file = __FILE__;

		public function __construct() {
			
			$this->define( 'PROP_PLUGIN_ABSPATH', dirname( __FILE__ ) . '/' );
			$this->define( 'PROP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

			$this->includes();
			$this->init_hooks();

			// Announce that properties plugin has been initiated
			do_action('propertiesplugin/init');
		}

		/**
		 * Define constant if not already set.
		 *
		 * @param string      $name  Constant name.
		 * @param string|bool $value Constant value.
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		private function includes() {
		
			// Load modules and classes
			require_once('includes/prop-core-functions.php');
			
			// Check remote hosting for plugin file for updates available
			require 'plugin-update-checker.php';
			$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
				'https://darkhousedevelopment.com/wp-plugins/properties-plugin.json',
				__FILE__, //Full path to the main plugin file or functions.php.
				'properties-plugin'
			);
			
			// Register front end classes
			require_once('includes/class-prop-register-cpt.php');
			
			PropRegisterCPT::instance();
			

			// Register admin interfaces if we're on an admin page
			if (is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
				//require_once('includes/class-clr-admin-woocommerce.php');
				
				//CLRAdminWooCommerce::instance();
			}
		
		}

		private function init_hooks() {
		
			add_action( 'wp_enqueue_scripts', [ $this, 'prop_enqueue_scripts' ] );
		
		}
	
		public function prop_enqueue_scripts(){
			
			// enqueue any admin or front end scripts and stylesheets here
			if( is_post_type_archive( array( "builders", "homes" ) ) || is_singular( array( "builders", "homes" ) ) ):
				wp_enqueue_style( 'properties', PROP_PLUGIN_URL . 'assets/css/properties-plugin.css', null, '1.0.0' );
				wp_enqueue_style( 'properties-print', PROP_PLUGIN_URL . 'assets/css/print-properties.css', null, '1.0.0', 'print' );
				wp_enqueue_script( 'properties-scripts', PROP_PLUGIN_URL . 'assets/js/prop-scripts.js', array( 'jquery' ), '1.0.0', true );
			endif;
			
		}

		static public function prop_plugin_activate() {

			// insert any functions required to run on plugin activation here

		}

		static public function prop_plugin_deactivate() {

			// insert any functions required to run on plugin deactivation here

		}
	}

	// call activation function on plugin activation
	register_activation_hook( __FILE__, 'PropertiesPlugin::prop_plugin_activate' );

	// call deactivation function on plugin deactivation
	register_deactivation_hook( __FILE__, 'PropertiesPlugin::prop_plugin_deactivate' );
	
endif; // End class_exists

$PRPL = PropertiesPlugin::instance();