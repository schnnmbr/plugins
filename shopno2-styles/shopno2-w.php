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
		'id' => 'aht',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="ah"><div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );


add_action('genesis_after_header', 'shopno2_sidebar_aht' );


function shopno2_sidebar_aht() {
if (is_page_template('shopno2_widgetized_page.php')){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'aht' ) ) {}}}

// Before Content For Widgetized Page
	register_sidebar( array(
		'name' => __( 'Before Content', 'shopno2' ),
		'id' => 'bc',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="bc"><div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );


add_action('genesis_before_content', 'shopno2_sidebar_bc' );


function shopno2_sidebar_bc() {
if (is_page_template('shopno2_widgetized_page.php')){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'bc' ) ) {}}}

// After Content For Widgetized Page
	register_sidebar( array(
		'name' => __( 'After Content', 'shopno2' ),
		'id' => 'ac',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="ac"><div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_after_content', 'shopno2_sidebar_ac' );


function shopno2_sidebar_ac() {
if (is_page_template('shopno2_widgetized_page.php')){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'ac' ) ) 

{}}}

// Before Footer For Widgetized Page
	register_sidebar( array(
		'name' => __( 'Before Footer', 'shopno2' ),
		'id' => 'bft',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="bf"><div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_before_footer', 'shopno2_sidebar_bft' );


function shopno2_sidebar_bft() {
if (is_page_template('shopno2_widgetized_page.php')){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'bft' ) ) {}}}
