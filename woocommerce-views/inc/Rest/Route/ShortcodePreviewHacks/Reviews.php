<?php // phpcs:ignore

namespace WooViews\Rest\Route\ShortcodePreviewHacks;

use ToolsetCommonEs\Rest\Route\ShortcodePreviewHacks\AHack;

/**
 * Hacks for shortcode [wpv-woo-reviews]
 *
 * Needs:
 * - Default value
 */
class Reviews extends AHack {
	/**
	 * WP query
	 *
	 * @var WP_Query
	 */
	private $wp_query;
	/**
	 * Product
	 *
	 * @var WP_Comment
	 */
	private $comment;
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
	 * shortcode
	 *
	 * @var string
	 */
	private $shortcode;

	/**
	 * Constructor
	 *
	 * @param int $product_id Product ID.
	 */
	public function __construct( $product_id, $shortcode ) {
		$this->product_id = $product_id;
		$this->shortcode = $shortcode;
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
	 * It hacks action woocommerce_simple_add_to_cart
	 */
	private function hack_woocommerce() {
		global $product;
		$this->product = $product;
		$product_factory = new \WC_Product_Factory();
		$product = $product_factory->get_product( $this->product_id );
		$shortcode = $this->shortcode;
		add_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar', 10 );
		add_action( 'woocommerce_review_before_comment_meta', function() {
			echo '<div class="star-rating wc_views_star_rating" title="Rated 4 out of 5"><span style="width:80%"></div>';
		} );
		add_action( 'woocommerce_review_meta', 'woocommerce_review_display_meta', 10 );
		add_action( 'woocommerce_review_comment_text', 'woocommerce_review_display_comment_text', 10 );
		add_filter(
			'woocommerce_views_reviews_tabs',
			function() use ( $shortcode ) {
				return [
					'reviews' => [
						'title' => __( 'Reviews', 'wpv-views' ),
						'callback' => function() use ( $shortcode ) {
							global $comment;
							$this->comment = $comment;
							$current_user = wp_get_current_user();
							$comment_data = new \StdClass();
							$comment_data->comment_ID = '1';
							$comment_data->comment_post_ID = '1';
							$comment_data->comment_author = $current_user->user_login;
							$comment_data->comment_author_email = $current_user->user_email;
							$comment_data->comment_author_url = '';
							$comment_data->comment_author_IP = '127.0.0.1';
							$comment_data->comment_date = date_i18n( 'F j, Y' );
							$comment_data->comment_date_gmt = date_i18n( 'F j, Y' );
							$comment_data->comment_content = __( 'This is a demo review.', 'woocommerce-views' ) .
															 "\r\n\r\n" .
															 __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'woocommerce-views' );
							$fake_comment = new \WP_Comment( $comment_data );
							$comment = $fake_comment;

							echo strpos( $shortcode, "template-source='toolset'" ) !== false ?
								'<div class="wooviews-reviews">' :
								'</div>';

							echo '<div id="comments">';
							echo '<h2 class="woocommerce-Reviews-title">' .
								 __( 'Demo of Reviews', 'woocommerce-views' ) .
								 '</h2>';
							echo '<ol class="commentlist">';
							wc_get_template(
								'single-product/review.php',
								array(
									'comment' => $fake_comment,
								)
							);
							if ( strpos( $shortcode, "template-source='toolset'" ) !== false ) {
								remove_filter( 'wc_get_template', array( $this, 'for_hacks_load_toolset_template' ), 10 );
							}
							echo '</ol>';
							echo '</div>';
							$comment_form = array(
								/* translators: %s is product title */
								'title_reply' => esc_html__( 'Add a review', 'woocommerce' ),
								/* translators: %s is product title */
								'title_reply_to' => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
								'title_reply_before' => '<span id="reply-title" class="comment-reply-title">',
								'title_reply_after' => '</span>',
								'comment_notes_after' => '',
								'label_submit' => esc_html__( 'Submit', 'woocommerce' ),
								'logged_in_as' => '',
								'comment_field' => '',
							);
							$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'woocommerce' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
								<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
								<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
								<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
								<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
								<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
								<option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
							</select></div>';
							$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

							comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
							echo '</div>';
						},
					],
				];
			}
		);
	}

	/**
	 * Restore previous data
	 */
	public function restore() {
		global $wp_query, $product, $comment;
		$wp_query = $this->wp_query; // phpcs:ignore
		$product = $this->product;
		$comment = $this->comment;
	}
}
