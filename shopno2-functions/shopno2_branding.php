<?php
/*
Plugin Name: Shopno2 Branding
Plugin URI: http://shopno2.com
Description: A simple plugin that rebrands the login & admin screens including footer message
Author: sachin nambiar
Author URI: shopno2.com
Version: 0.3
*/
 
/* Disallow direct access to the plugin file */
 
if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
	die('Sorry, but you cannot access this page directly.');
}
 
/** START ADDING CODE BELOW THIS LINE **/
//shopno2 Admin Screen Branding
function shopno2_custom_logo() {
  echo '<style type="text/css">
    #header-logo { background-image: url('.content_url('').'/themes/1/s2logo-72.png) !important; }
    </style>';
}

add_action('admin_head', 'shopno2_custom_logo');

/*shopno2 Login Screen*/



function shopno2_custom_login_logo() {
    echo '<link rel="stylesheet" type="text/css" href="/var/www/wp-content/plugins/shopno2-functions/customlogin.css" />';
}

add_action('login_head', 'shopno2_custom_login_logo');

//Custom Footer Text
function shopno2_remove_footer_admin () {
  echo '<i>Thank you for being our Customer! :) </i>';
}
add_filter('admin_footer_text', 'shopno2_remove_footer_admin');

//Replace Howdy with a more corporate sounding "Hello"
function shopno2_replace_howdy( $wp_admin_bar ) {
    $my_account=$wp_admin_bar->get_node('my-account');
    $newtitle = str_replace( 'Howdy,', 'Hello', $my_account->title );            
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $newtitle,
    ) );
}
add_filter( 'admin_bar_menu', 'shopno2_replace_howdy',25 );