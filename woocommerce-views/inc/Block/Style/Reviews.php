<?php // phpcs:ignore

namespace WooViews\Block\Style;

namespace WooViews\Block\Style;

use ToolsetCommonEs\Block\Style\Block\WithConfig;
use WooViews\Config\Block;

/**
 * Class Reviews
 *
 * @package WooViews
 */
class Reviews extends WithConfig {
	/**
	 * Returns the block class
	 *
	 * This block needs better specificity to avoid conflicts with themes
	 *
	 * @return string
	 */
	public function get_css_block_class() {
		return 'body.woocommerce ';
	}
}
