<?php
/**
 * Adjust shortcodes handler in compatibility to WordPress 4.2.3
 */

// Post-pre-process shotcodes.
// Sets at lower priority to catch unprocessed shortcodes.
add_filter( 'the_content', 'wcviews_preprocess_shortcodes_for_4_2_3', 11 );
// The filter applied to wpv-post-body shortcodes running without third party filters.
add_filter( 'wpv_filter_wpv_the_content_suppressed', 'wcviews_preprocess_shortcodes_for_4_2_3', 11 );
// The common filter that should replace the above one.
add_filter( 'toolset_the_content_basic_formatting', 'wcviews_preprocess_shortcodes_for_4_2_3', 11 );

function wcviews_preprocess_shortcodes_for_4_2_3($content) {

	$inner_expressions = array();

	//Support for legacy shortcodes to avoid breaking things in old sites.
	$inner_expressions[] = "/\\[(wpv-wooaddcart|wpv-wooaddcartbox|wpv-wooremovecart|wpv-woo-carturl).*?\\]/i";

	//Support for newer version of shortcodes
	$inner_expressions[] = "/\\[(wpv-woo-|wpv-add-).*?\\]/i";

	foreach ($inner_expressions as $shortcode) {
		$counts = preg_match_all($shortcode, $content, $matches);
		if($counts > 0) {
			foreach($matches[0] as &$match) {
				$replacement = do_shortcode($match);
				$resolved_match = $replacement;
				$content = str_replace($match, $resolved_match, $content);
			}
		}
	}

	return $content;
}

add_filter( 'wpv_filter_query', 'wcviews_modify_view_query', 999, 3 );

/**
 * Include the Order post type custom statuses by default in Views queries.
 *
 * The purpose of this change is that Orders can be listed without forcing a query filter by post status.
 * If this filter does not exist, and we are querying Orders, we should return all Orders.
 *
 * @param [type] $query
 * @param [type] $view_settings
 * @param [type] $id
 * @return void
 */
function wcviews_modify_view_query( $query, $view_settings, $id ) {
	if ( isset( $view_settings['post_status'] ) ) {
		return $query;
	}

	if ( false === defined( 'WC_VERSION' ) ) {
		return $query;
	}

	if ( in_array( 'shop_order', $view_settings['post_type'], true ) ) {
		$order_statuses = wc_get_order_statuses();
		$order_statuses_keys = array_keys( $order_statuses );
		$query['post_status'] = array_merge( $query['post_status'], $order_statuses_keys );
	}

	return $query;
}
