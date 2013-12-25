<?php
/*
Plugin Name: Shopno2 Customers
Plugin URI: http://shopno2.com
Description: Customers Plugin. 
Add your cutomers  
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/

// Register Custom Post Type
function shopno2_customer() {

	$labels = array(
		'name'                => _x( 'Customers', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Customer', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Customer', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Customer:', 'text_domain' ),
		'all_items'           => __( 'All Customers', 'text_domain' ),
		'view_item'           => __( 'View Customer', 'text_domain' ),
		'add_new_item'        => __( 'Add New Customer', 'text_domain' ),
		'add_new'             => __( 'New Customer', 'text_domain' ),
		'edit_item'           => __( 'Edit Customer', 'text_domain' ),
		'update_item'         => __( 'Update Customer', 'text_domain' ),
		'search_items'        => __( 'Search customers', 'text_domain' ),
		'not_found'           => __( 'No Customer found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No Customers found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'customer', 'text_domain' ),
		'description'         => __( 'Customer information pages', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields', ),
		'taxonomies'          => array( 'category' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => WP_PLUGIN_URL . '/shopno2-customers/shopno2-customers.png',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'supports' => array( 'title', 'editor', 'genesis-seo', 'thumbnail','genesis-cpt-archives-settings' ),
	);
	register_post_type( 'customer', $args );

}

// Hook into the 'init' action
add_action( 'init', 'shopno2_customer', 0 );

//Activate Grid For This Post Type
function be_grid_loop_on_customer( $grid, $query ) {
	if( is_post_type_archive( 'customer' ) )
		$grid = true;

	return $grid;
}
add_filter( 'genesis_grid_loop_section', 'be_grid_loop_on_customer', 10, 2 );
