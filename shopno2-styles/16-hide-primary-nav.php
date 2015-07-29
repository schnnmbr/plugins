<?php
/*
Plugin Name: 16 - Hide Primary Navigation except on front page
Plugin URI: http://shopno2.com
Description: Hides Primary NAV; Ensure that move "4 - Move Primary Navigation" is not active!!!
Author: shopno2.com
Author URI: shopno2.com
Version: 0.1
*/

/** Remove Header */


/** Genesis - Remove primary nav */
function shopno2_hide_primary_nav() {
if(!is_front_page()){
remove_action( 'genesis_after_header', 'genesis_do_nav' ) ;
} 
 
else {echo ""; }
}
add_action ('genesis_header','shopno2_hide_primary_nav');