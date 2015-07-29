<?php
/*
Plugin Name: Shopno2 Custom Header Support
Plugin URI: http://shopno2.com
Description: Description: To be used when theme does not have Custom Header Support built in.
Author: sachin nambiar
Author URI: shopno2.com
Version: 0.3
*/
/* Disallow direct access to the plugin file */
 
if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
	die('Sorry, but you cannot access this page directly.');
}
 
/** START ADDING CODE BELOW THIS LINE **/

//* Add support for custom header
add_theme_support( 'custom-header', array(
      // 'default-text-color'     => '000000',
     	'header-text'            => true,
        'height'                 => 200,
        'width'                  => 0,
	 // Support flexible height and width.
		'flex-height'            => true,
	 	'flex-width'             => true,
	
) );