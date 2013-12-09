<?php
/*
Plugin Name: Shopno2 Functions.php
Plugin URI: http://shopno2.com
Description: A simple plugin that contains all Custom Functions
Author: sachin nambiar
Author URI: shopno2.com
Version: 0.3
*/
 
/* Disallow direct access to the plugin file */
 
if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
	die('Sorry, but you cannot access this page directly.');
}
 
/** START ADDING CODE BELOW THIS LINE **/

// CUSTOM ADMIN MENU LINK FOR ALL SETTINGS
//   function all_settings_link() {
//    add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
//   }
//   add_action('admin_menu', 'all_settings_link');
   
/**
 * Generic function to show a message to the user using WP's
 * standard CSS classes to make use of the already-defined
 * message colour scheme.
 *
 * @param $message The message you want to tell the user.
 * @param $errormsg If true, the message is an error, so use
 * the red message style. If false, the message is a status
  * message, so use the yellow information message style.
 */
/*function showMessage($message, $errormsg = false)
{
    if ($errormsg) {
        echo '<div id="message" class="error">';
    }
    else {
        echo '<div id="message" class="updated fade">';
    }
 
    echo "<p><strong>$message</strong></p></div>";
}
*/
/**
 * Just show our message (with possible checking if we only want
 * to show message to certain users.
 */
/*function showAdminMessages()
{
    // Shows as an error message. You could add a link to the right page if you wanted.
    showMessage("You need to upgrade your database as soon as possible...", true);

    // Only show to admins
    if (user_can('manage_options') {
       showMessage("Hello admins!");
    }
}

/** 
  * Call showAdminMessages() when showing other admin 
  * messages. The message only gets shown in the admin
  * area, but not on the frontend of your WordPress site. 
  */
/*add_action('admin_notices', 'showAdminMessages'); 
*/

 // remove wp version param from any enqueued scripts
/*function shopno2_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
//remove css jss from head
add_filter( 'style_loader_src', 'shopno2_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'shopno2_remove_wp_ver_css_js', 9999 );
*/
// remove junk from head
//remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
//remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
//remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

function shopno2_remove_extra_meta_boxes() {
//remove_meta_box( 'postcustom' , 'post' , 'normal' ); // custom fields for posts
//remove_meta_box( 'postcustom' , 'page' , 'normal' ); // custom fields for pages
//remove_meta_box( 'postexcerpt' , 'post' , 'normal' ); // post excerpts
//remove_meta_box( 'postexcerpt' , 'page' , 'normal' ); // page excerpts
remove_meta_box( 'commentsdiv' , 'post' , 'normal' ); // recent comments for posts
remove_meta_box( 'commentsdiv' , 'page' , 'normal' ); // recent comments for pages
remove_meta_box( 'tagsdiv-post_tag' , 'post' , 'side' ); // post tags
remove_meta_box( 'tagsdiv-post_tag' , 'page' , 'side' ); // page tags
remove_meta_box( 'trackbacksdiv' , 'post' , 'normal' ); // post trackbacks
remove_meta_box( 'trackbacksdiv' , 'page' , 'normal' ); // page trackbacks
remove_meta_box( 'commentstatusdiv' , 'post' , 'normal' ); // allow comments for posts
remove_meta_box( 'commentstatusdiv' , 'page' , 'normal' ); // allow comments for pages
remove_meta_box('slugdiv','post','normal'); // post slug
remove_meta_box('slugdiv','page','normal'); // page slug
//remove_meta_box('pageparentdiv','page','side'); // Page Parent Attributes. Necessary to use page attributes.
}
add_action( 'admin_menu' , 'shopno2_remove_extra_meta_boxes' );


//Change Wordpress Admin footer
/*function shopno2_change_footer() {
  return '<a href="mailto:sachin@shopno2.com">email support</a>';
}
add_filter( 'update_footer', 'shopno2_change_footer', 9999 );
*/
