<?php 

/*
Plugin Name:11-s2Customers
Plugin URI: http://shopno2.com
Description: Customers Custom Post Type For Use Through Out The Site
Use Customers to add and display customers to your site.
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
		'view_item'           => __( 'View Customers', 'text_domain' ),
		'add_new_item'        => __( 'Add New Customer', 'text_domain' ),
		'add_new'             => __( 'New Customer', 'text_domain' ),
		'edit_item'           => __( 'Edit Customer', 'text_domain' ),
		'update_item'         => __( 'Update Customer', 'text_domain' ),
		'search_items'        => __( 'Search Customer', 'text_domain' ),
		'not_found'           => __( 'No Customers found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No Customers found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'Customer', 'text_domain' ),
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
		'menu_icon'           => WP_PLUGIN_URL . '/cpt/cpt.png',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'supports' => array( 'title', 'editor', 'genesis-seo', 'thumbnail','genesis-cpt-archives-settings','excerpt', 'genesis-layouts' ),
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'headway-seo')
	);
	register_post_type( 'customer', $args );

}

// Hook into the 'init' action
add_action( 'init', 'shopno2_customer', 0 );

function shono2_category_archive_customer( $query ) {
	// we don't want this running on the admin side
	if ( is_admin() )
		return;
	// include our stream type on tag pages
	if ( is_tag() && $query->is_main_query() ) {
		$query->query_vars['post_type'] = array( 'post', 'Customer' );
		return;
	}
    // include our stream type on category pages
    if ( is_category() && $query->is_main_query() ) {
		$query->query_vars['post_type'] = array( 'post', 'Customer' );
		return;
	}
    // include our stream type on home page
	if ( is_home() && $query->is_main_query() ) {
		$query->query_vars['post_type'] = array( 'post' );
		return;
	}
}

add_action ( 'pre_get_posts', 'shono2_category_archive_customer' );