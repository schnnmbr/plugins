<?php
/*
Plugin Name: 11 - Hide Header except on front page
Plugin URI: http://shopno2.com
Description: Hides Header
Author: shopno2.com
Author URI: shopno2.com
Version: 0.1
*/

/** Remove Header */


/** Genesis - Remove header and header markup */
function shopno2_hide_header() {
//if(!is_front_page()) {
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
} 
 
//else {echo ""; }
//}
add_action ('genesis_before_header','shopno2_hide_header');