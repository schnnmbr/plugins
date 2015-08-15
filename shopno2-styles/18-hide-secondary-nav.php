<?php
/*
Plugin Name: 18 - Hide Secondary Navigation except on front page
Plugin URI: http://shopno2.com
Description: Hides Primary NAV; Ensure that move "4 - Move Primary Navigation" is not active!!!
Author: shopno2.com
Author URI: shopno2.com
Version: 0.1
*/




/** Genesis - Remove secondary nav */
function shopno2_hide_secondary_nav() {
if(is_page()){
remove_action( 'genesis_after_header', 'genesis_do_nav' ) ;
} 
 
else {echo ""; }
}
add_action ('genesis_header','shopno2_hide_secondary_nav');