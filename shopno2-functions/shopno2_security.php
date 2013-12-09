<?php
/*
Plugin Name: Shopno2 Security
Plugin URI: http://shopno2.com
Description: A simple plugin that applies better shopno2 security
Author: sachin nambiar
Author URI: shopno2.com
Version: 0.3
*/
/* Disallow direct access to the plugin file */
 
if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
	die('Sorry, but you cannot access this page directly.');
}
 
/** START ADDING CODE BELOW THIS LINE **/
//Remove the theme editor menu which is anyway never allowed to use.
function shopno2_remove_editor_menu() {
  remove_action('admin_menu', '_add_themes_utility_last', 101);
}

add_action('_admin_menu', 'shopno2_remove_editor_menu', 1);

// Obscure login screen error messages
function shopno2_login_obscure(){ return 'Wrong Username/Password Combination';}
add_filter( 'login_errors', 'shopno2_login_obscure' );