<?php // phpcs:ignore

namespace WooViews\Rest\Route\ShortcodePreviewHacks;

use ToolsetCommonEs\Rest\Route\ShortcodePreviewHacks\AHack;

/**
 * Hacks for shortcode [wpv-woo-list_attributes]
 *
 * Needs:
 * - Default value
 */
class ListAttributes extends AHack {
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
			'woocommerce_display_product_attributes',
			function( $attributes, $product ) {
				if ( empty( $attributes ) ) {
					$attributes['demo_attribute'] = [
						'label' => __( 'Demo attribute', 'woocommerce-views' ),
						'value' => __( 'Some value', 'woocommerce-views' ),
					];
				}
				return $attributes;
			},
			10,
			2
		);
	}

	/**
	 * Restore previous state
	 */
	public function restore() {
		global $post, $product;
		$post = $this->post; // phpcs:ignore
		$product = $this->product;
	}
}
