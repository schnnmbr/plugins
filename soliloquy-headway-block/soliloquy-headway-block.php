<?php
/*
Plugin Name: Soliloquy Headway Block
Plugin URI: http://soliloquywp.com/
Description: Adds Headway block support for the Soliloquy for WordPress plugin.
Author: Thomas Griffin
Author URI: http://thomasgriffinmedia.com/
Version: 1.1.0
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
spl_autoload_register( 'Tgmsp_Headway::autoload' );

/**
 * Init class for the Headway block for Soliloquy.
 *
 * @since 1.0.0
 *
 * @package Tgmsp-Headway
 * @author Thomas Griffin <thomas@thomasgriffinmedia.com>
 */
class Tgmsp_Headway {
	
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
	public $version = '1.1.0';
	
	/**
	 * Constructor. Hooks all interactions into correct areas to start
	 * the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
			
		self::$instance = $this;
			
		/** Run a hook before the slider is loaded and pass the object */
		do_action_ref_array( 'tgmsp_headway_init', array( $this ) );
			
		register_activation_hook( __FILE__, array( $this, 'activation' ) );

		/** For this particular plugin, we need to hook into the after_setup_theme hook in order to register the block correctly */
		add_action( 'after_setup_theme', array( $this, 'init' ), 20 );
		
	}
		
	/**
	 * Activation hook. Checks to make sure that the main Soliloquy for
	 * WordPress plugin is active before proceeding. Also checks to make
	 * sure that Headway is active as well.
	 *
	 * @since 1.0.0
	 */
	public function activation() {
		
		/** If the Tgmsp class doesn't exist, deactivate ourself and die */
		if ( ! class_exists( 'Tgmsp' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( __( 'The Soliloquy for WordPress plugin must be active before you can enable this block.', 'soliloquy-headway' ) );
		}
		
		/** If the Headway class doesn't exist, deactivate ourself and die */
		if ( ! class_exists( 'Headway' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( __( 'The Headway WordPress Theme must be active before you can enable this block.', 'soliloquy-headway' ) );
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
		load_plugin_textdomain( 'soliloquy-headway', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		
		/** Instantiate all the necessary components of the plugin */
		$tgmsp_headway_block	= new Tgmsp_Headway_Block();
		$tgmsp_headway_options	= new Tgmsp_Headway_Options( null );
		$tgmsp_headway_strings	= new Tgmsp_Headway_Strings();
		
		/** Now that the plugin is good to go, let's register the block with Headway */
		headway_register_block( 'Tgmsp_Headway_Block', plugins_url( '', __FILE__ ) );
		
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
	
		if ( 'Tgmsp_Headway' !== mb_substr( $classname, 0, 13 ) )
			return;
			
		$filename = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . str_replace( '_', DIRECTORY_SEPARATOR, $classname ) . '.php';
		if ( file_exists( $filename ) )
			require $filename;
	
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
$tgmsp_headway = new Tgmsp_Headway();