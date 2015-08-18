<?php
/*
Plugin Name: 21 - Remove CSS & JS versions from head
Plugin URI: http://iphco.in
Description: emove CSS & JS versions from head
Author: sachin nambiar
Author URI: iphco.in
Version: 0.5
*/
 
/* Disallow direct access to the plugin file */
 
if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
	die('Sorry, but you cannot access this page directly.');
}
 
/** START ADDING CODE BELOW THIS LINE **/
 // remove wp version param from any enqueued scripts
function shopno2_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
//remove css jss ver from head
add_filter( 'style_loader_src', 'shopno2_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'shopno2_remove_wp_ver_css_js', 9999 );
