<?php // phpcs:ignore

namespace WooViews\Rest\Route\ShortcodePreviewHacks;

use ToolsetCommonEs\Rest\Route\ShortcodePreviewHacks\AHack;

/**
 * Hacks for shortcode [wpv-woo-breadcrumb]
 *
 * Needs:
 * - Default value
 */
class Breadcrumb extends AHack {
	/**
	 * WP Post
	 *
	 * @var WP_Post
	 */
	private $post;
	/**
	 * Product
	 *
	 * @var object
	 */
	private $product;
	/**
	 * Product ID
	 *
	 * @var integer
	 */
	private $product_id;

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
		$this->hack_wp();
		$this->hack_woocommerce();
	}

	/**
	 * Simulates that WP is loading a product page
	 */
	private function hack_wp() {
		global $post;

		$this->post = $post;
		$post = get_post( $this->product_id ); // phpcs:ignore
	}

	/**
	 * It hacks action woocommerce_simple_add_to_cart
	 */
	private function hack_woocommerce() {
		global $product;
		$this->product = $product;
		$product_factory = new \WC_Product_Factory();
		$product = $product_factory->get_product( $this->product_id );
		add_filter(
			'woocommerce_get_breadcrumb',
			[ $this, 'get_breadcrumb' ],
			10,
			1
		);
	}

	/**
	 * Gets product's breadcrumb
	 *
	 * @param array $breadcrumbs Breadcrumb list.
	 * @return array
	 */
	public function get_breadcrumb( $breadcrumbs ) {
		$breadcrumbs[] = [ get_the_title( $this->product_id ), null ];
		return $breadcrumbs;
	}

	/**
	 * Show the product title in the product loop. By default this is an H2.
	 */
	public function woocommerce_template_loop_product_title() {
		echo get_the_title(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	/**
	 * Restore previous state
	 */
	public function restore() {
		global $post, $product;
		$post = $this->post; // phpcs:ignore
		$product = $this->product;
		remove_action( 'woocommerce_get_breadcrumb', [ $this, 'get_breadcrumb' ] );
	}
}
