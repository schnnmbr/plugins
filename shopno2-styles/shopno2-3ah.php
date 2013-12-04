<?php
/*
Plugin Name: Shopno2 3 Widgets - After Header
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
		'name' => __( 'After Header 1/3-1', 'shopno2' ),
		'id' => '3ah1',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="ah1" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_after_header', 'shopno2_sidebar_3ah1' );

function shopno2_sidebar_3ah1() {
if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3ah1' ) ) {}}}

// 2
	register_sidebar( array(
		'name' => __( 'After Header 1/3-2', 'shopno2' ),
		'id' => '3ah2',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="ah2" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_after_header', 'shopno2_sidebar_3ah2' );//location of sidebar 2

function shopno2_sidebar_3ah2() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3ah2' ) ) {} }}

// 3
	register_sidebar( array(
		'name' => __( 'After Header 1/3-3', 'shopno2' ),
		'id' => '3ah3',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="ah3" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_after_header', 'shopno2_sidebar_3ah3' );//location of sidebar 2

function shopno2_sidebar_3ah3() {
//	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3ah3' ) ) {} }//}

