<?php

if( ! defined( 'WC_VIEWS_TEMPLATE_SOURCE_TOOLSET_SLUG' ) ) {
	define( 'WC_VIEWS_TEMPLATE_SOURCE_TOOLSET_SLUG', 'toolset' );
}
if( ! defined( 'WC_VIEWS_TEMPLATE_SOURCE_WOOCOMMERCE_SLUG' ) ) {
	define( 'WC_VIEWS_TEMPLATE_SOURCE_WOOCOMMERCE_SLUG', 'woocommerce' );
}
if( ! defined( 'WC_VIEWS_BLOCKS_NAMESPACE' ) ) {
	define( 'WC_VIEWS_BLOCKS_NAMESPACE', 'woocommerce-views' );
}

if( ! defined( 'WC_VIEWS_BLOCKS_CONFIG_DIR' ) ) {
	define( 'WC_VIEWS_BLOCKS_CONFIG_DIR', __DIR__ . '/config' );
}

// Basic config.
$config = [
	'blocks' => [
		'namespace' => WC_VIEWS_BLOCKS_NAMESPACE,
	]
];

// Extend this array for any new block config file.
$block_config_files = [
	WC_VIEWS_BLOCKS_CONFIG_DIR . '/cart-message.php',
	WC_VIEWS_BLOCKS_CONFIG_DIR . '/breadcrumb.php',
	WC_VIEWS_BLOCKS_CONFIG_DIR . '/list-attributes.php',
	WC_VIEWS_BLOCKS_CONFIG_DIR . '/product-meta.php',
	WC_VIEWS_BLOCKS_CONFIG_DIR . '/product-image.php',
	WC_VIEWS_BLOCKS_CONFIG_DIR . '/related.php',
	WC_VIEWS_BLOCKS_CONFIG_DIR . '/tabs.php',
	WC_VIEWS_BLOCKS_CONFIG_DIR . '/ratings.php',
	WC_VIEWS_BLOCKS_CONFIG_DIR . '/reviews.php',
	WC_VIEWS_BLOCKS_CONFIG_DIR . '/product-price.php',
];

// Load all block config files of the above array.
foreach( $block_config_files as $block_config_file ) {
	if( file_exists( $block_config_file ) ) {
		$block_config = include( $block_config_file );
		if( is_array( $block_config ) && array_key_exists( 'slug', $block_config ) ) {
			$config['blocks'][ $block_config['slug'] ] = $block_config;
		}
	}
}

// Return complete config.
return $config;
