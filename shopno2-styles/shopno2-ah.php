<?php
/*
Plugin Name: Shopno2 After Header FrontPage Widgets
Plugin URI: http://shopno2.com
Description: Used when you need content After Header.
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/
//WIDGETS

// 1
	register_sidebar( array(
		'name' => __( 'AH1', 'shopno2' ),
		'id' => 'ah1',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );


add_action('genesis_after_header','shopno2_wraps_ah1_before');
add_action('genesis_after_header', 'shopno2_sidebar_ah1' );
add_action('genesis_after_header','shopno2_wraps_ah1_after');	

function shopno2_sidebar_ah1() {
if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'ah1' ) ) {}}}

//Wraps On Sidebars
function shopno2_wraps_ah1_before(){
echo '<div id="ah1">';
}

function shopno2_wraps_ah1_after(){
echo '</div>';
}

// 2
	register_sidebar( array(
		'name' => __( 'AH2', 'shopno2' ),
		'id' => 'ah2',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action('genesis_after_header','shopno2_wraps_ah2_before');	
add_action( 'genesis_after_header', 'shopno2_sidebar_ah2');//location of sidebar 2
add_action('genesis_after_header','shopno2_wraps_ah2_after');
function shopno2_sidebar_ah2() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'ah2' ) ) {} }}

//Wraps On Sidebars
function shopno2_wraps_ah2_before(){
echo '<div id="ah2">';
}

function shopno2_wraps_ah2_after(){
echo '</div>';
}

/*/3
	register_sidebar( array(
		'name' => __( 'AH3', 'shopno2' ),
		'id' => 'ah3',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_after_header', 'shopno2_sidebar_ah3', 25 );//location of sidebar 2

function shopno2_sidebar_ah3() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'ah3' ) ) {} }}

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
