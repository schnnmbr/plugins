<?php
/*
Plugin Name: Shopno2 3 Widgets - Before Content Sidebar Wrap
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
		'name' => __( 'Before Sidewrap 1/3-1', 'shopno2' ),
		'id' => '3bsw1',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="bsw1" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_before_content_sidebar_wrap', 'shopno2_sidebar_3bsw1' );

function shopno2_sidebar_3bsw1() {
//if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3bsw1' ) ) {}}//}

// 2
	register_sidebar( array(
		'name' => __( 'Before Sidewrap 1/3-2', 'shopno2' ),
		'id' => '3bsw2',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="bsw2" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_before_content_sidebar_wrap', 'shopno2_sidebar_3bsw2' );//location of sidebar 2

function shopno2_sidebar_3bsw2() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3bsw2' ) ) {} }}

// 3
	register_sidebar( array(
		'name' => __( 'Before Sidewrap 1/3-3', 'shopno2' ),
		'id' => '3bsw3',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="bsw3" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_before_content_sidebar_wrap', 'shopno2_sidebar_3bsw3' );//location of sidebar 2

function shopno2_sidebar_3bsw3() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3bsw3' ) ) {} }}

