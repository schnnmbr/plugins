<?php
/*
Plugin Name: Shopno2 Full Widget Before SideWrap
Plugin URI: http://shopno2.com
Description: Full Widget Before SideWrap
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/
//WIDGETS

// 1
	register_sidebar( array(
		'name' => __( 'BS1', 'shopno2' ),
		'id' => 'bs1',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="bs1" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_before_content_sidebar_wrap', 'shopno2_sidebar_bs1' );

function shopno2_sidebar_bs1() {
if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'bs1' ) ) {}}}

// 2
	register_sidebar( array(
		'name' => __( 'BS2', 'shopno2' ),
		'id' => 'bs2',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="bs2" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_before_content_sidebar_wrap', 'shopno2_sidebar_bs2' );//location of sidebar 2

function shopno2_sidebar_bs2() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'bs2' ) ) {} }}

// 3
	register_sidebar( array(
		'name' => __( 'BS3', 'shopno2' ),
		'id' => 'bs3',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="bs3" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
add_action( 'genesis_before_content_sidebar_wrap', 'shopno2_sidebar_bs3' );//location of sidebar 2

function shopno2_sidebar_bs3() {
	if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'bs3' ) ) {} }}

