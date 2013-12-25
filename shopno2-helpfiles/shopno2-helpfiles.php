<?php
/*
Plugin Name: Shopno2 HelpFiles
Plugin URI: http://shopno2.com
Description: Create Custom HelpFiles or Documentation For your users
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/

// Register Custom Post Type
function shopno2_helpfile() {

	$labels = array(
		'name'                => _x( 'HelpFiles', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'HelpFile', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'HelpFiles', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent HelpFile:', 'text_domain' ),
		'all_items'           => __( 'All HelpFiles', 'text_domain' ),
		'view_item'           => __( 'View HelpFiles', 'text_domain' ),
		'add_new_item'        => __( 'Add New HelpFile', 'text_domain' ),
		'add_new'             => __( 'New HelpFile', 'text_domain' ),
		'edit_item'           => __( 'Edit HelpFile', 'text_domain' ),
		'update_item'         => __( 'Update HelpFile', 'text_domain' ),
		'search_items'        => __( 'Search HelpFiles', 'text_domain' ),
		'not_found'           => __( 'No HelpFiles found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No HelpFiles found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'HelpFiles', 'text_domain' ),
		'description'         => __( 'HelpFiles information pages', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields', ),
		'taxonomies'          => array( 'category'),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => WP_PLUGIN_URL . '/shopno2-helpfiles/shopno2-helpfiles.png',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'supports' => array( 'title', 'editor', 'genesis-seo', 'thumbnail','genesis-cpt-archives-settings','excerpt' ),
	);
	register_post_type( 'helpfiles', $args );

}

// Hook into the 'init' action
add_action( 'init', 'shopno2_helpfile', 0 );

//Activate Grid For This Post Type
function be_grid_loop_on_helpfile( $grid, $query ) {
	if( is_post_type_archive( 'helpfiles' ) )
		$grid = true;

	return $grid;
}
add_filter( 'genesis_grid_loop_section', 'be_grid_loop_on_helpfile', 10, 2 );

