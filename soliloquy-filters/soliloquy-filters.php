<?php
/*
Plugin Name: Soliloquy Filters Addon
Plugin URI: http://soliloquywp.com/
Description: Enables image filtering support for the Soliloquy for WordPress plugin.
Author: Thomas Griffin
Author URI: http://thomasgriffinmedia.com/
Version: 1.0.6
License: GNU General Public License v2.0 or later
License URI: http://www.opensource.org/licenses/gpl-license.php
*/

/*
	Copyright 2012  Thomas Griffin  (email : thomas@thomasgriffinmedia.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/** Load all of the necessary class files for the plugin */
spl_autoload_register( 'Tgmsp_Filters::autoload' );

/**
 * Init class for the Filters Addon for Soliloquy.
 *
 * @since 1.0.0
 *
 * @package Tgmsp-Filters
 * @author Thomas Griffin <thomas@thomasgriffinmedia.com>
 */
class Tgmsp_Filters {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Holds a copy of the main plugin filepath.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	private static $file = __FILE__;

	/**
	 * Current version of the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = '1.0.6';

	/**
	 * Constructor. Hooks all interactions into correct areas to start
	 * the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		self::$instance = $this;

		/** Run a hook before the slider is loaded and pass the object */
		do_action_ref_array( 'tgmsp_filters_init', array( $this ) );

		register_activation_hook( __FILE__, array( $this, 'activation' ) );

		/** Load the plugin in the init hook (set high priority to make sure it loads after Soliloquy is fully loaded) */
		add_action( 'init', array( $this, 'init' ), 20 );

	}

	/**
	 * Activation hook. Checks to make sure that the main Soliloquy for
	 * WordPress plugin is active before proceeding.
	 *
	 * @since 1.0.0
	 */
	public function activation() {

		/** If the Tgmsp class doesn't exist, deactivate ourself and die */
		if ( ! class_exists( 'Tgmsp' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( __( 'The Soliloquy for WordPress plugin must be active before you can activate this plugin.', 'soliloquy-filters' ) );
		}

	}

	/**
	 * Loads the plugin updater and all the actions and
	 * filters for the class.
	 *
	 * @since 1.0.0
	 *
	 * @global array $soliloquy_license Soliloquy license data
	 */
	public function init() {

		/** Load the plugin textdomain for internationalizing strings */
		load_plugin_textdomain( 'soliloquy-filters', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		// Only load certain items in the admin.
		if ( is_admin() ) :
    		/** Instantiate all the necessary components of the plugin */
    		$tgmsp_filters_admin	 = new Tgmsp_Filters_Admin();
    		$tgmsp_filters_ajax		 = new Tgmsp_Filters_Ajax();
    		$tgmsp_filters_media	 = new Tgmsp_Filters_Media();
    		$tgmsp_filters_strings	 = new Tgmsp_Filters_Strings();

    		/** If the Preview Addon is available, load the Preview class */
    		if ( class_exists( 'Tgmsp_Preview', false ) ) // Don't check the autoload stack for this instantiation
    			$tgmsp_filters_preview = new Tgmsp_Filters_Preview();

    		/** Setup the license checker */
    		global $soliloquy_license;

    		/** Only process update if a key has been entered and updates are on */
    		if ( isset( $soliloquy_license['license'] ) ) {
    			$args = array(
    				'remote_url' 	=> 'http://soliloquywp.com/',
    				'version' 		=> $this->version,
    				'plugin_name'   => 'Soliloquy Filters Addon',
    				'plugin_slug' 	=> 'soliloquy-filters',
    				'plugin_path' 	=> plugin_basename( __FILE__ ),
    				'plugin_url' 	=> WP_PLUGIN_URL . '/soliloquy-filters',
    				'time' 			=> 43200,
    				'key' 			=> $soliloquy_license['license']
    			);

    			/** Instantiate the automatic plugin updater class */
    			$tgmsp_filters_updater = new Tgmsp_Updater( $args );
    		}
        endif;

        // Load global components.
        $tgmsp_filters_shortcode = new Tgmsp_Filters_Shortcode();

	}

	/**
	 * PSR-0 compliant autoloader to load classes as needed.
	 *
	 * @since 1.0.0
	 *
	 * @param string $classname The name of the class
	 * @return null Return early if the class name does not start with the correct prefix
	 */
	public static function autoload( $classname ) {

		if ( 'Tgmsp_Filters' !== mb_substr( $classname, 0, 13 ) )
			return;

		$filename = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . str_replace( '_', DIRECTORY_SEPARATOR, $classname ) . '.php';
		if ( file_exists( $filename ) )
			require $filename;

	}

	/**
	 * Helper method to determine if Soliloquy is inactive or not.
	 *
	 * @since 1.0.0
	 *
	 * @global string $pagenow The current page slug
	 * @return bool True if Soliloquy is not active, false otherwise
	 */
	public static function soliloquy_is_not_active() {

		global $pagenow;

		return ! ( class_exists( 'Tgmsp' ) ) && ! ( isset( $_GET['action'] ) && 'do-plugin-upgrade' == $_GET['action'] || 'plugin-editor.php' == $pagenow && isset( $_REQUEST['file'] ) && preg_match( '|^soliloquy|', $_REQUEST['file'] ) || 'update-core.php' == $pagenow );

	}

	/**
	 * Factory method for creating a new image filter object instance. The image param must
	 * be a valid directory path to the image.
	 *
	 * @since 1.0.0
	 *
	 * @param int $id The image attachment ID
	 * @param string $image The real path to the image being filtered
	 * @param string $filter The type of filter to be applied to the image
	 * @param array $size The width and height dimensions for the image, crop mode and thumb slug
	 * @return object A new image filter object
	 */
	public static function factory( $id, $image, $filter, array $size ) {

		$tgmsp_filters_output = new Tgmsp_Filters_Output( $id, $image, $filter, $size );

		/** Output a notice if there is an error generating the filter */
		if ( is_wp_error( $tgmsp_filters_output ) )
			add_settings_error( 'tgmsp', 'tgmsp-filter-error', $tgmsp_filters_output->get_error_message(), 'error' );

	}

	/**
	 * Getter method for retrieving the object instance.
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {

		return self::$instance;

	}

	/**
	 * Getter method for retrieving the main plugin filepath.
	 *
	 * @since 1.0.0
	 */
	public static function get_file() {

		return self::$file;

	}

}

/** Instantiate the init class */
$tgmsp_filters = new Tgmsp_Filters();