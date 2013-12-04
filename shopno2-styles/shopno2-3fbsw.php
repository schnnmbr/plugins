<?php
/*
Plugin Name: Shopno2 3 Full Widgets Before SideWrap
Plugin URI: http://shopno2.com
Description: Boxes For Your Site
Use Boxes to add and display your boxes to your site.
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/
//WIDGETS

// 1
	register_sidebar( array(
		'name' => __( 'Full Widget BS1', 'shopno2' ),
		'id' => '3fbsw1',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="fbsw1" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_before_content_sidebar_wrap', 'shopno2_sidebar_3fbsw1' );

function shopno2_sidebar_3fbsw1() {
//if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3fbsw1' ) ) {}}//}

// 2
	register_sidebar( array(
		'name' => __( 'Full Widget BS2', 'shopno2' ),
		'id' => '3fbsw2',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="fbsw2" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_before_content_sidebar_wrap', 'shopno2_sidebar_3fbsw2' );//location of sidebar 2

function shopno2_sidebar_3fbsw2() {
//	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3fbsw2' ) ) {} }//}

// 3
	register_sidebar( array(
		'name' => __( 'Full Widget BS3', 'shopno2' ),
		'id' => '3fbsw3',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="fbsw3" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_before_content_sidebar_wrap', 'shopno2_sidebar_3fbsw3' );//location of sidebar 2

function shopno2_sidebar_3fbsw3() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3fbsw3' ) ) {} }}

