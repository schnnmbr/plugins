<?php
/*
Plugin Name: Shopno2 Move Primary Navigation
Plugin URI: http://shopno2.com
Description:  Menu Above Header
Use Boxes to add and display your boxes to your site.
Author: shopno2
Author URI: shopno2.com
Version:0.1


/* Reposition the primary navigation menu*/
function shopno2_move_pnav() {
	remove_action( 'genesis_after_header', 'genesis_do_nav' );	
	
}

add_action ('genesis_before_header','shopno2_move_pnav');
add_action( 'genesis_before_header', 'genesis_do_nav' );

