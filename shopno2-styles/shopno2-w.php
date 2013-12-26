<?php
/*
Plugin Name: Shopno2 Widgetized Page
Plugin URI: http://shopno2.com
Description: Used when you need content Before Footer
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/
//WIDGETS
// Before Header For Widgetized Page
	register_sidebar( array(
		'name' => __( 'BHT', 'shopno2' ),
		'id' => 'bht',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_before_header', 'shopno2_sidebar_bht' );


function shopno2_sidebar_bht() {
if (is_page_template('shopno2_widgetized_page.php')){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'bht' ) ) 

{}}}

// After Header For Widgetized Page
	register_sidebar( array(
		'name' => __( 'AH1T', 'shopno2' ),
		'id' => 'ah1t',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );


add_action('genesis_after_header','shopno2_wraps_ah1t_before');
add_action('genesis_after_header', 'shopno2_sidebar_ah1t' );
add_action('genesis_after_header','shopno2_wraps_ah1t_after');	

function shopno2_sidebar_ah1t() {
if (is_page_template('shopno2_widgetized_page.php')){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'ah1t' ) ) {}}}

//Wraps On Sidebars
function shopno2_wraps_ah1t_before(){
echo '<div id="ah1t">';
}

function shopno2_wraps_ah1t_after(){
echo '</div>';
}

// After Header For Widgetized Page
	register_sidebar( array(
		'name' => __( 'AH2T', 'shopno2' ),
		'id' => 'ah2t',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action('genesis_after_header','shopno2_wraps_ah2t_before');	
add_action( 'genesis_after_header', 'shopno2_sidebar_ah2t');//location of sidebar 2
add_action('genesis_after_header','shopno2_wraps_ah2t_after');
function shopno2_sidebar_ah2t() {
	if (is_page_template('shopno2_widgetized_page.php')){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'ah2t' ) ) {} }}

//Wraps On Sidebars
function shopno2_wraps_ah2t_before(){
echo '<div id="ah2t">';
}

function shopno2_wraps_ah2t_after(){
echo '</div>';
}

// Before Footer For Widgetized Page
	register_sidebar( array(
		'name' => __( 'BFT', 'shopno2' ),
		'id' => 'bft',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
//add_action('genesis_before_footer','shopno2_wraps_bf1t_before');
add_action( 'genesis_before_footer', 'shopno2_sidebar_bft' );
//add_action('genesis_before_footer','shopno2_wraps_bf1t_after');

function shopno2_sidebar_bft() {
if (is_page_template('shopno2_widgetized_page.php')){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'bft' ) ) {}}}
