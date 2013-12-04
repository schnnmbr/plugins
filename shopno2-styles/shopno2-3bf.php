<?php
/*
Plugin Name: Shopno2 3 Widgets - Before Footer
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
		'name' => __( 'Before Footer 1/3-1', 'shopno2' ),
		'id' => '3bf1',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="bf1" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_before_footer', 'shopno2_sidebar_3bf1' );

function shopno2_sidebar_3bf1() {
if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3bf1' ) ) {}}}

// 2
	register_sidebar( array(
		'name' => __( 'Before Footer 1/3-2', 'shopno2' ),
		'id' => '3bf2',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="bf2" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_before_footer', 'shopno2_sidebar_3bf2' );//location of sidebar 2

function shopno2_sidebar_3bf2() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3bf2' ) ) {} }}

// 3
	register_sidebar( array(
		'name' => __( 'Before Footer 1/3-3', 'shopno2' ),
		'id' => '3bf3',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="bf3" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_before_footer', 'shopno2_sidebar_3bf3' );//location of sidebar 2

function shopno2_sidebar_3bf3() {
//	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3bf3' ) ) {} }//}

