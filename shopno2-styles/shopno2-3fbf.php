<?php
/*
Plugin Name: Shopno2 3 Full Widgets Before Footer
Plugin URI: http://shopno2.com
Description: Responsive Widgets For Your Site
Use Boxes to add and display your boxes to your site.
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/
//WIDGETS

// 1
	register_sidebar( array(
		'name' => __( 'Full Width BF1', 'shopno2' ),
		'id' => '3fbf1',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="fbf1" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_before_footer', 'shopno2_sidebar_3fbf1' );

function shopno2_sidebar_3fbf1() {
if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3fbf1' ) ) {}}}

// 2
	register_sidebar( array(
		'name' => __( 'Full Width BF2', 'shopno2' ),
		'id' => '3fbf2',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="fbf2" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_before_footer', 'shopno2_sidebar_3fbf2' );//location of sidebar 2

function shopno2_sidebar_3fbf2() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3fbf2' ) ) {} }}

// 3
	register_sidebar( array(
		'name' => __( 'Full Width BF3', 'shopno2' ),
		'id' => '3fbf3',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="fbf3" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_before_footer', 'shopno2_sidebar_3fbf3' );//location of sidebar 2

function shopno2_sidebar_3fbf3() {
//	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3fbf3' ) ) {} }//}

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
