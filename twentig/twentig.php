<?php
/**
 * Plugin Name: Twentig
 * Plugin URI: https://twentig.com
 * Description: A toolkit for Twenty Twenty-One & Twenty Twenty that helps you build a beautiful website. Easily.
 * Author: Twentig
 * Author URI: https://twentig.com
 * Version: 1.3
 * Text Domain: twentig
 * License: GPLv3 or later
 *
 * @package twentig
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup plugin constants.
 */
define( 'TWENTIG_VERSION', '1.3' );
define( 'TWENTIG_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'TWENTIG_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'TWENTIG_ASSETS_URI', TWENTIG_URI . 'dist' );
define( 'TWENTIG_PLUGIN_BASE', plugin_basename( __FILE__ ) );

/**
 * Load the Twentig plugin.
 */
require_once TWENTIG_PATH . 'inc/init.php';
