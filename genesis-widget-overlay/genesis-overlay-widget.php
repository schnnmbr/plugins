<?php
/*
 Plugin Name: Genesis Widget overlay
 Plugin URI: http://wpstud.io
 Description: This plugin allows you to create a full screen overlay widget-area
 Version: 1.0
 Author: Frank Schrijvers
 Author URI: http://www.frankschrijvers.nl
 Text Domain: : genesis-overlay-widget
License: GPLv2

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

defined( 'WPINC' ) or die;

register_activation_hook( __FILE__, 'wpstudio_activation_check' );
/**
 * This function runs on plugin activation. It checks to make sure the required
 * minimum Genesis version is installed. If not, it deactivates itself.
 */
function wpstudio_activation_check() {
	$latest = '2.0';
	$theme_info = wp_get_theme( 'genesis' );

	if ( ! function_exists('genesis_pre') ) {
		deactivate_plugins( plugin_basename( __FILE__ ) ); // Deactivate plugin
		wp_die( sprintf( __( 'Sorry, you can\'t activate %1$sGenesis Overlay Widget unless you have installed the %3$sGenesis Framework%4$s. Go back to the %5$sPlugins Page%4$s.', 'genesis-overlay-widget' ), '<em>', '</em>', '<a href="http://www.studiopress.com/themes/genesis" target="_blank">', '</a>', '<a href="javascript:history.back()">' ) );
	}

	if ( version_compare( $theme_info['Version'], $latest, '<' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) ); // Deactivate plugin
		wp_die( sprintf( __( 'Sorry, you can\'t activate %1$sGenesis Overlay Widget unless you have installed the %3$sGenesis %4$s%5$s. Go back to the %6$sPlugins Page%5$s.', 'genesis-overlay-widget' ), '<em>', '</em>', '<a href="http://www.studiopress.com/themes/genesis" target="_blank">', $latest, '</a>', '<a href="javascript:history.back()">' ) );
	}
}

add_action('admin_init', 'wpstudio_deactivate_check');
/**
 * This function runs on admin_init and checks to make sure Genesis is active, if not, it 
 * deactivates the plugin. This is useful for when users switch to a non-Genesis themes.
 */
function wpstudio_deactivate_check() {
    if ( ! function_exists('genesis_pre') ) {
		deactivate_plugins( plugin_basename( __FILE__ ) ); // Deactivate plugin
    }
} 

//* Enqueue scripts
add_action( 'wp_enqueue_scripts', 'wpstudio_load_scripts' );
function wpstudio_load_scripts() {
	wp_enqueue_script( 'modernizr', plugin_dir_url( __FILE__ ) . '/assets/js/modernizr.custom.js' );
	wp_enqueue_script( 'classie', plugin_dir_url( __FILE__ ) . '/assets/js/classie.min.js', '', '', true );
	wp_enqueue_script( 'global', plugin_dir_url( __FILE__ ) .'/assets/js/global.min.js' , array( 'jquery' ), '1.0.0', true );
}

// Enqueue stylesheet
//add_action( 'wp_enqueue_scripts', 'wpstudio_load_stylesheet' );
//function wpstudio_load_stylesheet() {
//	wp_enqueue_style( 'wpstudio-style', plugin_dir_url( __FILE__ ) . '/assets/css/style2.css' );
//}

add_action( 'genesis_admin_init', 'wpstudio_init');
function wpstudio_init() {
require( dirname( __FILE__ )  . '/inc/gow-admin.php');
include( dirname( __FILE__ ) . '/inc/gow-frontend.php');
new WPSTUDIO_Settings();
}


add_action( 'wp_enqueue_scripts', 'scripts_and_styles' );
function scripts_and_styles(){	
	if ( genesis_get_option( 'gow_css', 'gow-settings') == 1 ) {
		wp_enqueue_style( 'wpstudio-style', plugin_dir_url( __FILE__ ) . '/assets/css/wpstudio-style.css' );
	}
	if ( genesis_get_option( 'gow_effect', 'gow-settings') === 'overlay-corner' ) {
		wp_enqueue_style( 'effect-corner', plugin_dir_url( __FILE__ ) . '/assets/css/overlay-corner.css' );
		wp_enqueue_script( 'demo1', plugin_dir_url( __FILE__ ) . '/assets/js/demo1.min.js', '', '', true );
	}	
	if ( genesis_get_option( 'gow_effect', 'gow-settings') === 'overlay-slidedown' ) {
		wp_enqueue_style( 'effect-slidedown', plugin_dir_url( __FILE__ ) . '/assets/css/overlay-slidedown.css' );
		wp_enqueue_script( 'demo1', plugin_dir_url( __FILE__ ) . '/assets/js/demo1.min.js', '', '', true );
	}	
	if ( genesis_get_option( 'gow_effect', 'gow-settings') === 'overlay-scale' ) {
		wp_enqueue_style( 'effect-scale', plugin_dir_url( __FILE__ ) . '/assets/css/overlay-scale.css' );
		wp_enqueue_script( 'demo1', plugin_dir_url( __FILE__ ) . '/assets/js/demo1.min.js', '', '', true );
	}
	if ( genesis_get_option( 'gow_effect', 'gow-settings') === 'overlay-door' ) {
		wp_enqueue_style( 'effect-door', plugin_dir_url( __FILE__ ) . '/assets/css/overlay-door.css' );
		wp_enqueue_script( 'demo1', plugin_dir_url( __FILE__ ) . '/assets/js/demo1.min.js', '', '', true );
	}
	if ( genesis_get_option( 'gow_effect', 'gow-settings') === 'overlay-contentpush' ) {
		wp_enqueue_style( 'effect-contentpush', plugin_dir_url( __FILE__ ) . '/assets/css/overlay-contentpush.css' );
		wp_enqueue_script( 'demo1', plugin_dir_url( __FILE__ ) . '/assets/js/demo1.min.js', '', '', true );
	}
	if ( genesis_get_option( 'gow_effect', 'gow-settings') === 'overlay-contentscale' ) {
		wp_enqueue_style( 'effect-contentscale', plugin_dir_url( __FILE__ ) . '/assets/css/overlay-contentscale.css' );
		wp_enqueue_script( 'demo1', plugin_dir_url( __FILE__ ) . '/assets/js/demo7.js', '', '', true );
	}
	if ( genesis_get_option( 'gow_effect', 'gow-settings') === 'overlay-simplegenie' ) {
		wp_enqueue_style( 'effect-genie', plugin_dir_url( __FILE__ ) . '/assets/css/overlay-simplegenie.css' );
		wp_enqueue_script( 'demo1', plugin_dir_url( __FILE__ ) . '/assets/js/demo1.min.js', '', '', true );
	}
}