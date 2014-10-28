<?php
/*
Plugin Name: Shopno2 Widgets
Plugin URI: http://shopno2.com
Description: The right set of widgets to make your site awesome!
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/
//WIDGETS
// Before Footer For Widgetized Page
	register_sidebar( array(
		'name' => __( 'Before Footer', 'shopno2' ),
		'id' => 'bf',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_before_footer', 'shopno2_sidebar_bf' );


function shopno2_sidebar_bf() {

	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'bf' ) ) 

// After entry on Single Page
	register_sidebar( array(
		'name' => __( 'After Post', 'shopno2' ),
		'id' => 'ap',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_after_entry', 'shopno2_sidebar_ap' );

function shopno2_sidebar_ap() {
if (is_singular()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'ap' ) ) {}}}

