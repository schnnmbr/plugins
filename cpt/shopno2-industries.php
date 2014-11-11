<?php 

/*
Plugin Name:12-s2Industries
Plugin URI: http://shopno2.com
Description: Industries Custom Post Type For Use Through Out The Site
Use Industries to add and display industries to your site.
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/

// Register Custom Post Type
function shopno2_industry() {

	$labels = array(
		'name'                => _x( 'Industries', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Industry', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Industry', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Industry:', 'text_domain' ),
		'all_items'           => __( 'All Industries', 'text_domain' ),
		'view_item'           => __( 'View Industries', 'text_domain' ),
		'add_new_item'        => __( 'Add New Industry', 'text_domain' ),
		'add_new'             => __( 'New Industry', 'text_domain' ),
		'edit_item'           => __( 'Edit Industry', 'text_domain' ),
		'update_item'         => __( 'Update Industry', 'text_domain' ),
		'search_items'        => __( 'Search Industry', 'text_domain' ),
		'not_found'           => __( 'No Industries found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No Industries found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'Industry', 'text_domain' ),
		'description'         => __( 'Industry information pages', 'text_domain' ),
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
	);
	register_post_type( 'industry', $args );

}

// Hook into the 'init' action
add_action( 'init', 'shopno2_industry', 0 );

function shono2_category_archive_industry( $query ) {
	// we don't want this running on the admin side
	if ( is_admin() )
		return;
	// include our stream type on tag pages
	if ( is_tag() && $query->is_main_query() ) {
		$query->query_vars['post_type'] = array( 'post', 'Industry' );
		return;
	}
    // include our stream type on category pages
    if ( is_category() && $query->is_main_query() ) {
		$query->query_vars['post_type'] = array( 'post', 'Industry' );
		return;
	}
    // include our stream type on home page
	if ( is_home() && $query->is_main_query() ) {
		$query->query_vars['post_type'] = array( 'post' );
		return;
	}
}

add_action ( 'pre_get_posts', 'shono2_category_archive_industry' );