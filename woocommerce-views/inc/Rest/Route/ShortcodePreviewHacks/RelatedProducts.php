<?php // phpcs:ignore

namespace WooViews\Rest\Route\ShortcodePreviewHacks;

use ToolsetCommonEs\Rest\Route\ShortcodePreviewHacks\AHack;

/**
 * Hacks for shortcode [wpv-woo-related_products]
 *
 * Needs:
 * - Default value
 */
class RelatedProducts extends AHack {
	/**
	 * WP Post
	 *
	 * @var WP_Post
	 */
	private $post;
	/**
	 * WP Query
	 *
	 * @var WP_Query
	 */
	private $wp_query;
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
		$this->hack_wp_query();
		$this->hack_woocommerce();
		$this->hack_woodmart_theme();
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
	 * Simulates that WP is loading a product page
	 */
	private function hack_wp_query() {
		global $wp_query;

		$this->wp_query = $wp_query;

		$wp_query->is_singular = true;
		$wp_query->queried_object = get_post( $this->product_id );
	}

	/**
	 * Compatibility with WoodMart Theme
	 */
	private function hack_woodmart_theme() {
		if ( function_exists( 'woodmart_product_label' ) ) {
			global $product, $woodmart_options;
			$woodmart_options = [
				'related_product_view' => 'grid',
				'products_columns' => 3,
				'products_columns_mobile' => 3,
			];
			add_filter( 'woocommerce_sale_flash', 'woodmart_product_label', 10 );
		}
	}

	/**
	 * It hacks action woocommerce_simple_add_to_cart
	 */
	private function hack_woocommerce() {
		global $product;
		$this->product = $product;
		$product_factory = new \WC_Product_Factory();
		$product = $product_factory->get_product( $this->product_id );
		add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

		add_filter(
			'woocommerce_related_products',
			[ $this, 'related_products' ],
			10,
			1
		);
	}

	/**
	 * Gets related products default
	 *
	 * @param array $related Related products.
	 * @return array
	 */
	public function related_products( $related ) {
		if ( empty( $related ) ) {
			return [ $this->product_id ];
		}
		return $related;
	}

	/**
	 * Restore previous state
	 */
	public function restore() {
		global $post, $product;
		$post = $this->post; // phpcs:ignore
		$product = $this->product;
		remove_action( 'woocommerce_related_products', [ $this, 'related_products' ] );
	}
}
