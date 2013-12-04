<?php
/*
Plugin Name: Shopno2 FrontPage Widgets
Plugin URI: http://shopno2.com
Description: Front Page Widgets For Your Site
Use Boxes to add and display your boxes to your site.
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/
//WIDGETS

// Horizontal Widgets Before Layout
	register_sidebar( array(
		'name' => __( 'Before Layout 1/3', 'shopno2' ),
		'id' => 'wbg1',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="wbg1" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_before', 'shopno2_sidebar_wbg1' );

function shopno2_sidebar_wbg1() {
if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'wbg1' ) ) {}}}

// Horizontal Widgets Before Header
	register_sidebar( array(
		'name' => __( 'Before Header 1/3', 'shopno2' ),
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

// Horizontal Widgets After Header 1/3rd
	register_sidebar( array(
		'name' => __( 'After Header 1/3', 'shopno2' ),
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

// FullWidth After Header
	register_sidebar( array(
		'name' => __( 'FullWidth After Header', 'shopno2' ),
		'id' => '3fwah1',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="fwah1" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_after_header', 'shopno2_sidebar_3fwah1' );

function shopno2_sidebar_3fwah1() {
if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3fwah1' ) ) {}}}

// Before Sidewrap 1/3rd
	register_sidebar( array(
		'name' => __( 'Before Sidewrap 1/3', 'shopno2' ),
		'id' => '3bsw1',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="bsw1" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_before_content_sidebar_wrap', 'shopno2_sidebar_3bsw1' );

function shopno2_sidebar_3bsw1() {
if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3bsw1' ) ) {}}}

// FullWidth Before SideWrap
	register_sidebar( array(
		'name' => __( 'FullWidth Before SideWrap', 'shopno2' ),
		'id' => '3fbsw1',
		'description' => __( 'Add widgets here to appear in your sidebar.', 'shopno2' ),
		'before_widget' => '<div id="fbsw1" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

add_action( 'genesis_before_content_sidebar_wrap', 'shopno2_sidebar_3fbsw1' );

function shopno2_sidebar_3fbsw1() {
if (is_front_page()){
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( '3fbsw1' ) ) {}}}		