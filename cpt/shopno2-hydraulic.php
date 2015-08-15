	<?php 

/*
Plugin Name: 17 - Hydraulic Cylinder
Plugin URI: http://shopno2.com
Description: Hydraulic  Cylinder CPT For Use Through Out The Site
Use Hydraulic to add and display hydraulic on your site.
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/

// Register Custom Post Type
function shopno2_hydraulic_cylinder() {

	$labels = array(
		'name'                => _x( 'Hydraulic Cylinder', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Hydraulic Cylinder', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Hydraulic Cylinder', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Hydraulic:', 'text_domain' ),
		'all_items'           => __( 'All Hydraulic Cylinder', 'text_domain' ),
		'view_item'           => __( 'View Hydraulic Cylinder', 'text_domain' ),
		'add_new_item'        => __( 'Add New Hydraulic Cylinder', 'text_domain' ),
		'add_new'             => __( 'New Hydraulic Cylinder', 'text_domain' ),
		'edit_item'           => __( 'Edit Hydraulic Cylinder', 'text_domain' ),
		'update_item'         => __( 'Update Hydraulic Cylinder', 'text_domain' ),
		'search_items'        => __( 'Search Hydraulic Cylinder', 'text_domain' ),
		'not_found'           => __( 'No Hydraulic Cylinder found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No Hydraulic Cylinder found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'Hydraulic Cylinder', 'text_domain' ),
		'description'         => __( 'Hydraulic Cylinder information pages', 'text_domain' ),
		'labels'              => $labels,
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
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'genesis-seo', 'thumbnail','genesis-cpt-archives-settings', 'genesis-layouts' ), );
		
	
	register_post_type( 'hydraulic-cylinder', $args );

}

// Hook into the 'init' action
add_action( 'init', 'shopno2_hydraulic_cylinder', 0 );

function shono2_category_archive_hydraulic_cylinder( $query ) {
	// we don't want this running on the admin side
	if ( is_admin() )
		return;
	// include our stream type on tag pages
	if ( is_tag() && $query->is_main_query() ) {
		$query->query_vars['post_type'] = array( 'post', 'Hydraulic Cylinder' );
		return;
	}
    // include our stream type on category pages
    if ( is_category() && $query->is_main_query() ) {
		$query->query_vars['post_type'] = array( 'post', 'Hydraulic Cylinder' );
		return;
	}
    // include our stream type on home page
	if ( is_home() && $query->is_main_query() ) {
		$query->query_vars['post_type'] = array( 'post' );
		return;
	}
}

add_action ( 'pre_get_posts', 'shono2_category_archive_hydraulic_cylinder' );