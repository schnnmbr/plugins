<?php
/*
Plugin Name: 2 - remove post info
Plugin URI: http://shopno2.com
Description: The right set of widgets to make your site awesome!
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/

//Remove Post Info
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
if ( !is_page() ) {
	$post_info = '';
	return $post_info;
}}
