<?php
/*
Plugin Name: Shopno2 3 Widgets - Before-Layout
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
		'name' => __( 'Before Layout 1/3-1', 'shopno2' ),
		'id' => 'bg1',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="bg1" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_before', 'shopno2_sidebar_bg1' );

function shopno2_sidebar_bg1() {
if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'bg1' ) ) {}}}

// 2
	register_sidebar( array(
		'name' => __( 'Before Layout 1/3-2', 'shopno2' ),
		'id' => 'bg2',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="bg2" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_before', 'shopno2_sidebar_bg2' );//location of sidebar 2

function shopno2_sidebar_bg2() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'bg2' ) ) {} }}

// 3
	register_sidebar( array(
		'name' => __( 'Before Layout 1/3-3', 'shopno2' ),
		'id' => 'bg3',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="bg3" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_before', 'shopno2_sidebar_bg3' );//location of sidebar 2

function shopno2_sidebar_bg3() {
//	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'bg3' ) ) {} }//}

