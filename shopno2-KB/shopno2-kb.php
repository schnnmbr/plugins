<?php 

/*
Plugin Name: Shopno2 KnowledgeBase
Plugin URI: http://shopno2.com
Description: KnowledgeBase
Build your own knowledgebase for your customers 
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/

// Register Custom Post Type
function shopno2_kb() {

	$labels = array(
		'name'                => _x( 'KBs', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'KB', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'KB', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent KB:', 'text_domain' ),
		'all_items'           => __( 'All KBs', 'text_domain' ),
		'view_item'           => __( 'View KBs', 'text_domain' ),
		'add_new_item'        => __( 'Add New KB', 'text_domain' ),
		'add_new'             => __( 'New KB', 'text_domain' ),
		'edit_item'           => __( 'Edit KB', 'text_domain' ),
		'update_item'         => __( 'Update KB', 'text_domain' ),
		'search_items'        => __( 'Search KB', 'text_domain' ),
		'not_found'           => __( 'No KBs found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No KBs found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'KB', 'text_domain' ),
		'description'         => __( 'KB information pages', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields', ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => WP_PLUGIN_URL . '/shopno2-kb/shopno2-kb.png',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'kb', $args );

}

// Hook into the 'init' action
add_action( 'init', 'shopno2_kb', 0 );