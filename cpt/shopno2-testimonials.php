<?php

/*
Plugin Name: 15 - Shopno2 Testimonials
Plugin URI: http://shopno2.com
Description: Testimonial Custom Post Type For Use Through Out The Site 
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/

// Register Custom Post Type
function shopno2_testimonial() {

	$labels = array(
		'name'                => _x( 'Testimonials', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Testimonial', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Testimonial:', 'text_domain' ),
		'all_items'           => __( 'All Testimonial', 'text_domain' ),
		'view_item'           => __( 'View Testimonial', 'text_domain' ),
		'add_new_item'        => __( 'Add New Testimonial', 'text_domain' ),
		'add_new'             => __( 'New Testimonial', 'text_domain' ),
		'edit_item'           => __( 'Edit Testimonial', 'text_domain' ),
		'update_item'         => __( 'Update Testimonial', 'text_domain' ),
		'search_items'        => __( 'Search testimonials', 'text_domain' ),
		'not_found'           => __( 'No Testimonials found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No Testimonials found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'Testimonial', 'text_domain' ),
		'description'         => __( 'Testimonial information pages', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', ),
		'taxonomies'          => array( 'category' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => WP_PLUGIN_URL . '/cpt/shopno2-testimonials.png',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'genesis-seo', 'thumbnail','genesis-cpt-archives-settings', 'genesis-layouts' ), );

	//'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt','custom-fields'),
	register_post_type( 'testimonial', $args );

}

// Hook into the 'init' action
add_action( 'init', 'shopno2_testimonial', 0 );
//Activate Grid For This Post Type
function be_grid_loop_on_testimonial( $grid, $query ) {
	if( is_post_type_archive( 'testimonial' ) )
		$grid = true;

	return $grid;
}
add_filter( 'genesis_grid_loop_section', 'be_grid_loop_on_testimonial', 10, 2 );
