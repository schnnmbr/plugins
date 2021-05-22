<?php // phpcs:ignore

namespace WooViews\Rest\Route\ShortcodePreviewHacks;

use ToolsetCommonEs\Rest\Route\ShortcodePreviewHacks\AHack;

/**
 * Hacks for shortcode [wpv-woo-display-tabs]
 *
 * Needs:
 * - Default value
 */
class Tabs extends AHack {
	/**
	 * WP query
	 *
	 * @var WP_Query
	 */
	private $wp_query;
	/**
	 * Product
	 *
	 * @var WP_Post
	 */
	private $product;
	/**
	 * Product ID
	 *
	 * @var int
	 */
	private $product_id;
	/**
	 * Post
	 *
	 * @var WP_Post
	 */
	private $post;

	/**
	 * Constructor
	 *
	 * @param int $product_id Product ID.
	 */
	public function __construct( $product_id ) {
		$this->product_id = $product_id;
	}

	/**
	 * Do shortcode rendering hacks
	 */
	public function do_hack() {
		$this->hack_wp_query();
		$this->hack_woocommerce();
	}

	/**
	 * Simulates that WP is loading a product page
	 */
	private function hack_wp_query() {
		global $wp_query, $post;

		$this->post = $post;
		$this->wp_query = $wp_query;

		$wp_query->is_singular = true;
		$product = get_post( $this->product_id );
		$wp_query->queried_object = $product;
		setup_postdata( $product );
	}

	/**
	 * It hacks action wpv-woo-display-tabs
	 */
	private function hack_woocommerce() {
		global $product;
		$this->product = $product;
		$product_factory = new \WC_Product_Factory();
		$product = $product_factory->get_product( $this->product_id );
		add_filter( 'woocommerce_product_tabs', 'woocommerce_default_product_tabs' );
		add_filter( 'woocommerce_product_tabs', 'woocommerce_sort_product_tabs', 99 );
		add_filter(
			'woocommerce_product_tabs',
			function( $data ) {
				if ( ! empty( $data ) ) {
					return $data;
				}
				return [
					'demo' => [
						'title' => __( 'Demo', 'wpv-views' ),
						'callback' => function() {
							echo wp_kses_post( __( 'Demo tab', 'wpv-views' ) );
						},
					],
				];
			},
			100000000,
			1
		);
	}

	/**
	 * Restore previous data
	 */
	public function restore() {
		global $wp_query, $product;
		$wp_query = $this->wp_query; // phpcs:ignore
		$product = $this->product;
		setup_postdata( $this->post );
	}
}
