<?php
/*
Plugin Name: 7 - Location Of Featured Image In Single Posts & Pages
Plugin URI: http://shopno2.com
Description: Customise your link color
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/

add_action( 'genesis_after_header', 's2_show_featured_image_single_page', 9 );
add_action( 'genesis_entry_header', 's2_show_featured_image_single_posts', 9 );
/**
 * Display Featured Image floated to the right in single Posts.
 */
function s2_show_featured_image_single_page() {
	if ( !is_page('') ) {
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

function s2_show_featured_image_single_posts() {
	if ( !is_single('') ) {
		return;
	}
 
	$image_args = array(
		'size' => '',
		'attr' => array(
			'class' => 'alignnone',
		),
	);
 
	genesis_image( $image_args );
}