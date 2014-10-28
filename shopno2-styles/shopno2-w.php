<?php
/*
Plugin Name: Shopno2 Widgetized Page
Plugin URI: http://shopno2.com
Description: The right set of widgets to make your site awesome!
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/
//WIDGETS


// After Header For Widgetized Page
	register_sidebar( array(
		'name' => __( 'After Header', 'shopno2' ),
		'id' => 'ah',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );


add_action('genesis_after_header', 'shopno2_sidebar_ah' );


function shopno2_sidebar_ah() {
if (is_page_template('shopno2_widgetized_page.php')){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'ah' ) ) {}}}

// Before Content For Widgetized Page
	register_sidebar( array(
		'name' => __( 'Before Content SW', 'shopno2' ),
		'id' => 'bcsw',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );


add_action('genesis_before_content_sidebar_wrap', 'shopno2_sidebar_bcsw' );


function shopno2_sidebar_bcsw() {
if (is_page_template('shopno2_widgetized_page.php')){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'bcsw' ) ) {}}}

// After Content For Widgetized Page
	register_sidebar( array(
		'name' => __( 'After Content SW', 'shopno2' ),
		'id' => 'acsw',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_after_content_sidebar_wrap', 'shopno2_sidebar_acsw' );

function shopno2_sidebar_acsw() {
if (is_page_template('shopno2_widgetized_page.php')){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'acsw' ) ) 

{}}}



