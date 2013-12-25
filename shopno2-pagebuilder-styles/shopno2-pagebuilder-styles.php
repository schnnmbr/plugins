<?php
/*
Plugin Name: Shopno2 Pagebuilder Styles
Plugin URI: http://shopno2.com
Description: Styles for siteorigin pagebuilder panels. 
Put your css into pagebuilder.css to customise your panels. 
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/
 
/* Disallow direct access to the plugin file */
 
if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
	die('Sorry, but you cannot access this page directly.');
}

/*CHECK IF PAGEBUILDER IS ACTIVE*/
 

/*PANEL STYLE DEFINITIONS*/
function shopno2_panels_row_styles($styles) {
    $styles['grid-4'] = __('grid-4', '1');
    $styles['grid-3'] = __('grid-3', '1');
    $styles['grid-2'] = __('grid-2', '1');
    $styles['highlight'] = __('highlight', '1');
    return $styles;

}
add_filter('siteorigin_panels_row_styles', 'shopno2_panels_row_styles');

function shopno2_scripts() {
wp_register_style( 'prefix-style', plugins_url('pagebuilder.css', __FILE__) );
wp_enqueue_style( 'prefix-style' ); 
}

add_action('wp_enqueue_scripts','shopno2_scripts');

  