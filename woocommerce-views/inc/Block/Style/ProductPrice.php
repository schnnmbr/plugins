<?php // phpcs:ignore

namespace WooViews\Block\Style;

use ToolsetCommonEs\Block\Style\Block\WithConfig;

/**
 * Class Product Price
 *
 * @package WooViews
 */
class ProductPrice extends WithConfig {
	protected function get_css_selector_root() {
		// Thanks to WooCommerce that such explicit selectors are needed.
		return 'html body.woocommerce ' . parent::get_css_selector_root();
	}
}
