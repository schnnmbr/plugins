<?php
/*
Plugin Name: Shopno2 Unique Features
Plugin URI: http://shopno2.com
Description: Hides Admin bar for non admins, Auto set Featured Images, Autocrops Thumbnails. 
Adds them support for custom background and headers/post.
Author: sachin nambiar
Author URI: shopno2.com
Version: 0.1
*/
/* Disallow direct access to the plugin file */
 
if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
	die('Sorry, but you cannot access this page directly.');
}
 
/** START ADDING CODE BELOW THIS LINE **/

//This snippet automatically sets the featured image by fetching the first image of the post.
//*Note – if you choose a featured image, that will be displayed instead.
function autoset_featured() {
          global $post;
          $already_has_thumb = has_post_thumbnail($post->ID);
              if (!$already_has_thumb)  {
              $attached_image = get_children( "post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1" );
                          if ($attached_image) {
                                foreach ($attached_image as $attachment_id => $attachment) {
                                set_post_thumbnail($post->ID, $attachment_id);
                                }
                           }
                        }
      }
add_action('the_post', 'autoset_featured');
add_action('save_post', 'autoset_featured');
add_action('draft_to_publish', 'autoset_featured');
add_action('new_to_publish', 'autoset_featured');
add_action('pending_to_publish', 'autoset_featured');
add_action('future_to_publish', 'autoset_featured');

//Autocrop thumbnails fo they do not stretch and look ugly!
// Standard Size Thumbnail
if(false === get_option("thumbnail_crop")) {
add_option("thumbnail_crop", "1"); }
else {
update_option("thumbnail_crop", "1");
}

// Medium Size Thumbnail
if(false === get_option("medium_crop")) {
add_option("medium_crop", "1"); }
else {
update_option("medium_crop", "1");
}

// Large Size Thumbnail
if(false === get_option("large_crop")) {
add_option("large_crop", "1"); }
else {
update_option("large_crop", "1");
}
//Add Super and Subscript buttons to TinyMCE
function my_mce_buttons_2($buttons) { 
  /**
   * Add in a core button that's disabled by default
   */
  $buttons[] = 'sup';
  $buttons[] = 'sub';

  return $buttons;
}
add_filter('mce_buttons_2', 'my_mce_buttons_2');

//Uncomment Below Line To Hide Admin Bar For Logged In Users
/*add_filter ('show_admin_bar', 'shopno2_custom_admin_bar_setting');
function shopno2_custom_admin_bar_setting() {
  if (is_admin())
    return TRUE;
  else
    return FALSE;
}*/



