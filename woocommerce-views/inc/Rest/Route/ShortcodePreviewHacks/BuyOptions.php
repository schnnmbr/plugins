<?php // phpcs:ignore

namespace WooViews\Rest\Route\ShortcodePreviewHacks;

use ToolsetCommonEs\Rest\Route\ShortcodePreviewHacks\AHack;

/**
 * Hacks for shortcode [wpv-woo-buy-options]
 *
 * Needs:
 * - Sets `$post`
 */
class BuyOptions extends AHack {
	/**
	 * Product ID
	 *
	 * @var string
	 */
	private $product_id;
	/**
	 * Previous post
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
		$this->hack_woocommerce();
		$this->hack_wp_query();
	}

	/**
	 * It hacks action woocommerce_simple_add_to_cart
	 */
	private function hack_woocommerce() {
		global $post;
		$this->post = $post;
		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
		$post = get_post( $this->product_id );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		add_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
		add_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
		add_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
		add_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
		add_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
		add_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
	}

	/**
	 * Simulates that WP is loading a product page
	 */
	private function hack_wp_query() {
		global $wp_query;

		$this->wp_query = $wp_query;

		$wp_query->is_singular = true;
		$wp_query->queried_object = get_post( $this->product_id );
	}

	/**
	 * Restore previous status
	 */
	public function restore() {
		global $product;
		$post = $this->post;
	}
}
