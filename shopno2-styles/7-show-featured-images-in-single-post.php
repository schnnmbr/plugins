<?php
/*
Plugin Name: 7 - Show Featured Image In Single Posts
Plugin URI: http://shopno2.com
Description: Customise your link color
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/

add_action( 'genesis_before_content_sidebar_wrap', 's2_show_featured_image_single_posts', 9 );
/**
 * Display Featured Image floated to the right in single Posts.
 */
function s2_show_featured_image_single_posts() {
	if ( ! is_singular('') ) {
		return;
	}
 
	$image_args = array(
		'size' => '',
		'attr' => array(
			'class' => 'aligncenter',
		),
	);
 
	genesis_image( $image_args );
}