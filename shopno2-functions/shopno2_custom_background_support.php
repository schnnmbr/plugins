<?php
/*
Plugin Name: Shopno2 Custom Background Support
Plugin URI: http://shopno2.com
Description: To be used when theme does not have Custom Background Support built in.
Author: sachin nambiar
Author URI: shopno2.com
Version: 0.3
*/

/* Disallow direct access to the plugin file */
 
if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
	die('Sorry, but you cannot access this page directly.');
}
 
/** START ADDING CODE BELOW THIS LINE **/
/*
Adding Theme Support For Custom Backgrounds for Posts
*/
add_theme_support( 'custom-background' );