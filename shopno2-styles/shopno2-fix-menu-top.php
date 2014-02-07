<?php
/*
Plugin Name: Shopno2 Menu Fix On Top
Plugin URI: http://shopno2.com
Description: Fixes Primary Menu on Top of Page
Author: shopno2.com
Author URI: shopno2.com
Version: 0.1
*/
//* First Reposition the primary navigation menu
// Child theme setup function
function child_theme_setup() {
  // Remove the primary navigation from its current location
  remove_action( 'genesis_after_header', 'genesis_do_nav' );
  
  // Add the primary navigation to the top of the page
  add_action( 'genesis_before_header', 'genesis_do_nav' );
}
 
// Hook into genesis_setup
add_action( 'genesis_setup', 'child_theme_setup' );

function shopno2_fixed_menu() {
        /** Enqueue Style Sheets */
        // Only enqueue if available
        if ( is_readable( plugin_dir_path( __FILE__ ) . 'shopno2-fixed-menu.css' ) )
        					{
            wp_enqueue_style( 'shopno2-fixed-menu', plugin_dir_url( __FILE__ ) . 'shopno2-fixed-menu.css', array(), '0.1', 'screen' );
        }
}
add_action( 'wp_enqueue_scripts', 'shopno2_fixed_menu', 5 );
