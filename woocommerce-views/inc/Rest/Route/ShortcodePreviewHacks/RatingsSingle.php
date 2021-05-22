<?php // phpcs:ignore

namespace WooViews\Rest\Route\ShortcodePreviewHacks;

use ToolsetCommonEs\Rest\Route\ShortcodePreviewHacks\AHack;

/**
 * Hacks for shortcode [wpv-woo-single-products-rating]
 *
 * Needs:
 * - Default value
 */
class RatingsSingle extends AHack {
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
	 * Rating value
	 *
	 * @var int
	 */
	private $rating;

	/**
	 * Constructor
	 *
	 * @param int $product_id Product ID.
	 * @param boolean $is_toolset_template Is using Toolset templates.
	 */
	public function __construct( $product_id, $is_toolset_template ) {
		$this->product_id = $product_id;
		$this->is_toolset_template = $is_toolset_template;
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
		global $wp_query;

		$this->wp_query = $wp_query;

		$wp_query->is_singular = true;
		$wp_query->queried_object = get_post( $this->product_id );
	}

	/**
	 * It hacks action rating shortcodes
	 */
	private function hack_woocommerce() {
		global $product;
		$this->product = $product;
		$product_factory = new \WC_Product_Factory();
		$product = $product_factory->get_product( $this->product_id );
		if ( $product ) {
			$this->rating = $product->get_rating_count();
			add_action( 'woocommerce_after_template_part', [ $this, 'default_rating' ] );
		}
	}

	/**
	 * Echoes default rating
	 *
	 * @param string $template Template name.
	 */
	public function default_rating( $template ) {
		if ( 'single-product/rating.php' === $template && $this->rating <= 0 ) {
			echo '<div class="woocommerce-product-rating' . ( $this->is_toolset_template ? ' wooviews-rating' : '' ). '"><div class="star-rating wc_views_star_rating"><span style="width:80%"><strong class="rating">4</strong> ' .
				// translators: rating 1 out of 5.
				esc_html__( 'out of', 'woocommerce-views' ) .
				' 5</span></div><a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<span class="count">1</span> ' .
				esc_html__( 'customer review', 'woocommerce-views' ) .
				')</a></div>';
		}
	}

	/**
	 * Restore previous data
	 */
	public function restore() {
		global $wp_query, $product;
		$wp_query = $this->wp_query; // phpcs:ignore
		$product = $this->product;
		remove_action( 'woocommerce_after_template_part', [ $this, 'default_rating' ] );
	}
}
