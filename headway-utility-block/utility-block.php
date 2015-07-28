<?php
/*
Plugin Name: Utility Block
Plugin URI: http://www.headwaylabs.com
Description: Create blocks using shortcodes of many common page elements and then position and style them.
Author: Headway Labs
Version: 1.3.6
Author URI: http://www.headwaylabs.com
License: GNU GPL v2
*/

define('UTILITY_BLOCK_VERSION', '1.3.6');

/* Add any features included in our library */
include_once 'library/metaboxes/metaboxes.php';

/**
 * Everything runs at the after_setup_theme action to insure that 
 * all of Headway's classes and functions are loaded.
 **/
function utility_block_register() {

	/* Make sure that Headway is activated, otherwise don't register the block because errors will be thrown. */
	if ( !class_exists('Headway') )
		return;
	
	require_once 'block.php';
	require_once 'block-options.php';
	require_once 'design-editor-settings.php';

	/**
	 * @param Class name in block.php.  
	 * @param Path to the folder that contains the block icons.
	 **/
	return headway_register_block('HeadwayUtilityBlock', plugins_url(false, __FILE__));

}
add_action('after_setup_theme', 'utility_block_register');

function utility_block_extend_updater() {
	
	if ( !class_exists('HeadwayUpdaterAPI') )
			return;
			
	$updater = new HeadwayUpdaterAPI(array(
		'slug' => 'utility-block',
		'name' => 'Utility Block',
		'path' => plugin_basename(__FILE__),
		'type' => 'block',
		'current_version' => UTILITY_BLOCK_VERSION
	));

}
add_action('init', 'utility_block_extend_updater');

/** 
 * adds a css file to headway's admin so we can adjust the interface
 * not all blocks will need this, only if you need to make adjustments
**/
function utility_admin_css() {
	$file = dirname(__FILE__) . '/utility-block.php';
	$url = plugin_dir_url($file);
	$styles = array(
		'utility-admin-css' => $url . 'admin/css/admin.css',
	);
	
	wp_enqueue_multiple_styles($styles);
}
add_action('headway_visual_editor_styles', 'utility_admin_css');

/** 
 * adds a js file to headway's admin so we can add functions we then
 * use in the options callback's. If you using callbacks then you will
 * want to have this file included so you can add reusable functions there
**/
function utility_admin_scripts() {
	HeadwayCompiler::register_file(array(
		'name' => 'utility-block-js',
		'format' => 'js',
		'fragments' => array(
			dirname(__FILE__).'/admin/js/block.js'
		)
	));
}

add_action('headway_visual_editor_scripts', 'utility_admin_scripts', 12);