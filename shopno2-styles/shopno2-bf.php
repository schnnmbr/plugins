<?php
/*
Plugin Name: Shopno2 Full Widgets Before Footer
Plugin URI: http://shopno2.com
Description: Full Widgets Before Footer
Use Boxes to add and display your boxes to your site.
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/
//WIDGETS

// 1
	register_sidebar( array(
		'name' => __( 'BF1', 'shopno2' ),
		'id' => 'bf1',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="%1$s"><div id="fbf1" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_before_footer', 'shopno2_sidebar_bf1' );

function shopno2_sidebar_bf1() {
if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'bf1' ) ) {}}}

// 2
	register_sidebar( array(
		'name' => __( 'BF2', 'shopno2' ),
		'id' => 'bf2',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_before_footer', 'shopno2_sidebar_bf2' );//location of sidebar 2

function shopno2_sidebar_bf2() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'bf2' ) ) {} }}

//3 
	register_sidebar( array(
		'name' => __( 'BF3', 'shopno2' ),
		'id' => 'fbf3',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_before_footer', 'shopno2_sidebar_3fbf3' );//location of sidebar 2

function shopno2_sidebar_bf3() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'bf3' ) ) {} }}

//Loads StyleSheet for Above Widgets
/* 
You cannot enqueue multiple scripts within different plugins. 
Easier cleaner workaround is by listing styles in th shopno2 styles plugin.
Code below is for instructional purposes only.
*/
/*function shopno2_widget_style_3fwah() {
        /** Enqueue Style Sheets */
        // Only enqueue if available
  /*      if ( is_readable( plugin_dir_path( __FILE__ ) . 'shopno2-3fwah-style.css' ) )
        					{
            wp_enqueue_style( 'shopno2-3fwah-style', plugin_dir_url( __FILE__ ) . 'shopno2-3fwah-style.css', array(), '0.1', 'screen' );
        }
}
add_action( 'wp_enqueue_scripts', 'shopno2_widget_style_3fwah', true );
