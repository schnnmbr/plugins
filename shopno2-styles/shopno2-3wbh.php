<?php
/*
Plugin Name: Shopno2 3 Widgets - Before Header
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
		'name' => __( '3wbh1', 'shopno2' ),
		'id' => '3wbh1',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="wbh1" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_before_header', 'shopno2_sidebar_3wbh1' );

function shopno2_sidebar_3wbh1() {
if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3wbh1' ) ) {}}}

// 2
	register_sidebar( array(
		'name' => __( '3wbh2', 'shopno2' ),
		'id' => '3wbh2',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="wbh2" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_before_header', 'shopno2_sidebar_3wbh2' );//location of sidebar 2

function shopno2_sidebar_3wbh2() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3wbh2' ) ) {} }}

// 3
	register_sidebar( array(
		'name' => __( '3wbh3', 'shopno2' ),
		'id' => '3wbh3',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="wbh3" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_before_header', 'shopno2_sidebar_3wbh3' );//location of sidebar 2

function shopno2_sidebar_3wbh3() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3wbh3' ) ) {} }}

//Loads StyleSheet for Above Widgets
/* 
You cannot enqueue multiple scripts within different plugins. 
Easier cleaner workaround is by listing styles in th shopno2 styles plugin.
Code below is for instructional purposes only.
*/
/*function shopno2_widget_style_3wbh() {
        /** Enqueue Style Sheets */
        // Only enqueue if available
  /*      if ( is_readable( plugin_dir_path( __FILE__ ) . 'shopno2-3wbh-style.css' ) )
        					{
            wp_enqueue_style( 'shopno2-3wbh-style', plugin_dir_url( __FILE__ ) . 'shopno2-3wbh-style.css', array(), '0.1', 'screen' );
        }
}
add_action( 'wp_enqueue_scripts', 'shopno2_widget_style_3wbh', true );
