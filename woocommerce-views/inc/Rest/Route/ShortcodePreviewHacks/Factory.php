<?php // phpcs:ignore

namespace WooViews\Rest\Route\ShortcodePreviewHacks;

use ToolsetCommonEs\Rest\Route\ShortcodePreviewHacks\Factory as ToolsetShortcodeHackFactory;
use ToolsetCommonEs\Rest\Route\ShortcodePreviewHacks\DisplayTabs as DisplayTabsES;

/**
 * This class returns the hacker class for a shortcode
 *
 * Some shortcodes need to hack the "enviroment" to render proper results. For example, shortcodes might need to load some data
 */
class Factory extends ToolsetShortcodeHackFactory {
	/**
	 * Returns the hack class for the shortcode
	 *
	 * @param int    $post_id Post ID.
	 * @param string $shortcode Shortcode.
	 */
	public function get_hack( $post_id, $shortcode ) {
		if ( preg_match( '/wpv-woo-buy-or-select/', $shortcode ) ) {
			return new BuyOrSelect( $post_id );
		} elseif ( preg_match( '/wpv-woo-buy-options/', $shortcode ) ) {
			return new BuyOptions( $post_id );
		} elseif ( preg_match( '/wpv-woo-list_attributes/', $shortcode ) ) {
			return new ListAttributes( $post_id );
		} elseif ( preg_match( '/wpv-woo-related_products/', $shortcode ) ) {
			return new RelatedProducts( $post_id );
		} elseif ( preg_match( '/wpv-woo-breadcrumb/', $shortcode ) ) {
			return new Breadcrumb( $post_id );
		} elseif ( preg_match( '/wpv-woo-reviews/', $shortcode ) ) {
			return new Reviews( $post_id, $shortcode );
		} elseif ( preg_match( '/wpv-woo-products-rating-listing/', $shortcode ) ) {
			return new RatingsListing( $post_id );
		} elseif ( preg_match( '/wpv-woo-single-products-rating/', $shortcode ) ) {
			return new RatingsSingle( $post_id, preg_match( '/template-source=\'toolset\'/', $shortcode ) );
		} elseif ( preg_match( '/wpv-woo-display-tabs/', $shortcode ) ) {
			return new Tabs( $post_id );
		}

		return parent::get_hack( $post_id, $shortcode );
	}
}
