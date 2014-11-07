<?php
/*
Plugin Name: 7 - Show Featured Image In Single Posts
Plugin URI: http://shopno2.com
Description: Customise your link color
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/

add_action( 'genesis_after_header', 's2_show_featured_image_single_posts', 9 );
/**
 * Display Featured Image floated to the right in single Posts.
 */
function s2_show_featured_image_single_posts() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
 
	$image_args = array(
		'size' => 'large',
		'attr' => array(
			'class' => 'none',
		),
	);
 
	genesis_image( $image_args );
}