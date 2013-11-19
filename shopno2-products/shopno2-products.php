<?php 

/*
Plugin Name: Shopno2 Products
Plugin URI: http://shopno2.com
Description: Shopno2 Products
Use Products to add and display products to your site.
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/

// Register Custom Post Type
function shopno2_product() {

	$labels = array(
		'name'                => _x( 'Products', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Product', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Product', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Product:', 'text_domain' ),
		'all_items'           => __( 'All Products', 'text_domain' ),
		'view_item'           => __( 'View Products', 'text_domain' ),
		'add_new_item'        => __( 'Add New Product', 'text_domain' ),
		'add_new'             => __( 'New Product', 'text_domain' ),
		'edit_item'           => __( 'Edit Product', 'text_domain' ),
		'update_item'         => __( 'Update Product', 'text_domain' ),
		'search_items'        => __( 'Search Product', 'text_domain' ),
		'not_found'           => __( 'No Products found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No Products found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'Product', 'text_domain' ),
		'description'         => __( 'Product information pages', 'text_domain' ),
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
		'menu_icon'           => WP_PLUGIN_URL . '/shopno2-products/shopno2-products.png',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'supports' => array( 'title', 'editor', 'genesis-seo', 'thumbnail','genesis-cpt-archives-settings' ),
	);
	register_post_type( 'product', $args );

}

// Hook into the 'init' action
add_action( 'init', 'shopno2_product', 0 );

//Activate Grid For This Post Type
function be_grid_loop_on_product( $grid, $query ) {
	if( is_post_type_archive( 'product' ) )
		$grid = true;

	return $grid;
}
add_filter( 'genesis_grid_loop_section', 'be_grid_loop_on_product', 10, 2 );
