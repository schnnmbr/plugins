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
		'singular_name'       => _x( 'Helpfile', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Helpfile', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Helpfile:', 'text_domain' ),
		'all_items'           => __( 'All HelpFiles', 'text_domain' ),
		'view_item'           => __( 'View Helpfile', 'text_domain' ),
		'add_new_item'        => __( 'Add New Helpfile', 'text_domain' ),
		'add_new'             => __( 'New Helpfile', 'text_domain' ),
		'edit_item'           => __( 'Edit Helpfile', 'text_domain' ),
		'update_item'         => __( 'Update Helpfile', 'text_domain' ),
		'search_items'        => __( 'Search helpfiles', 'text_domain' ),
		'not_found'           => __( 'No helpfile found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No helpfiles found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'helpfile', 'text_domain' ),
		'description'         => __( 'Helpfile information pages', 'text_domain' ),
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
		'supports' => array( 'title', 'editor', 'genesis-seo', 'thumbnail','genesis-cpt-archives-settings' ),
	);
	register_post_type( 'helpfile', $args );

}

// Hook into the 'init' action
add_action( 'init', 'shopno2_helpfile', 0 );