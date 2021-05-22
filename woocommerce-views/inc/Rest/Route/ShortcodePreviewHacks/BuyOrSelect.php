<?php // phpcs:ignore

namespace WooViews\Rest\Route\ShortcodePreviewHacks;

use ToolsetCommonEs\Rest\Route\ShortcodePreviewHacks\AHack;

/**
 * Hacks for shortcode [wpv-woo-buy-or-select]
 *
 * Needs:
 * - Sets `$post`
 */
class BuyOrSelect extends AHack {
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
	}

	/**
	 * It hacks action woocommerce_simple_add_to_cart
	 */
	private function hack_woocommerce() {
		global $post;
		$this->post = $post;
		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
		$post = get_post( $this->product_id );
	}

	/**
	 * Restore previous status
	 */
	public function restore() {
		global $product;
		$post = $this->post;
	}
}
