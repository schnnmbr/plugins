<?php
/*
  Plugin Name: Toolset WooCommerce Blocks
  Plugin URI: https://toolset.com/course/custom-woocommerce-site/?utm_source=plugin&utm_medium=gui&utm_campaign=woocommerceblocks
  Description: Lets you add e-commerce functionality to any site, running any theme.
  Author: OnTheGoSystems
  Author URI: http://www.onthegosystems.com
  Version: 2.9.4
  WC tested up to: 4.7.1
 */

/** {ENCRYPTION PATCH HERE} **/

/**
 * include plugin class
 */
if(defined('WOOCOMMERCE_VIEWS_PLUGIN_PATH')) return;

define('WOOCOMMERCE_VIEWS_PLUGIN_PATH', dirname(__FILE__));

if(defined('WOOCOMMERCE_VIEWS_PATH')) return;

define( 'WOOCOMMERCE_VIEWS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define('WOOCOMMERCE_VIEWS_PATH', dirname(__FILE__) . '/Class_WooCommerce_Views.php');

define('WC_VIEWS_VERSION', '2.9.4');

if (!defined('WPVDEMO_TOOLSET_DOMAIN')) {
	define('WPVDEMO_TOOLSET_DOMAIN', 'toolset.com');
}

define( 'WC_VIEWS_FILE', __FILE__ );

require_once( 'psr4-autoload.php' );

// Important to load here as it's required for the promoting notices on Views.
if ( ! class_exists( 'Class_WooCommerce_Views' ) ) {
	require_once( 'Class_WooCommerce_Views.php' );
}


/**
 * Init WooCommerce Views.
 */
$bootstrap = new \WooViews\Bootstrap();
$bootstrap->init();

/**
 * Init Blocks.
 */
$bootstrap_blocks = new \WooViews\BootstrapBlocks();
$bootstrap_blocks->init();
