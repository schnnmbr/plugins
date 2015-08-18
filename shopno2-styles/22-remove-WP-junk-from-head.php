<?php
/*
Plugin Name: 22 - Remove WP Junk from head
Plugin URI: http://shopno2.com
Description: Removes rsd, wp_generator, feedlinks, index_rel, wlwmanifest etc.
Author: sachin nambiar
Author URI: shopno2.com
Version: 0.5
*/
 
/* Disallow direct access to the plugin file */
 
if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
	die('Sorry, but you cannot access this page directly.');
}
 
/** START ADDING CODE BELOW THIS LINE **/

// remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
//remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);