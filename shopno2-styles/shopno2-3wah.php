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
		'name' => __( '3wah1', 'shopno2' ),
		'id' => '3wah1',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="wah1" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_after_header', 'shopno2_sidebar_3wah1' );

function shopno2_sidebar_3wah1() {
if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3wah1' ) ) {}}}

// 2
	register_sidebar( array(
		'name' => __( '3wah2', 'shopno2' ),
		'id' => '3wah2',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="wah2" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_after_header', 'shopno2_sidebar_3wah2' );//location of sidebar 2

function shopno2_sidebar_3wah2() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3wah2' ) ) {} }}

// 3
	register_sidebar( array(
		'name' => __( '3wah3', 'shopno2' ),
		'id' => '3wah3',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="wah3" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_after_header', 'shopno2_sidebar_3wah3' );//location of sidebar 2

function shopno2_sidebar_3wah3() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3wah3' ) ) {} }}

