<?php // phpcs:ignore

namespace WooViews\Block\Style;

use ToolsetCommonEs\Block\Style\Block\WithConfig;
use WooViews\Config\Block;

/**
 * Class ProductTabs
 *
 * @package WooViews
 */
class ProductTabs extends WithConfig {
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

	/**
	 * Gets font data
	 */
	public function get_font( $devices = [ Devices::DEVICE_DESKTOP => true ], $attribute = 'style' ) {
		$config = $this->get_block_config();

		$tabFontNotExists = (
			! array_key_exists( 'tabStyle', $config ) ||
			! is_array( $config['tabStyle'] ) ||
			! array_key_exists( 'font', $config['tabStyle'] )
		);
		$tabActiveFontNotExists = ! $tabFontNotExists && (
			! array_key_exists( '.active', $config['tabStyle'] ) ||
			! is_array( $config['tabStyle']['.active'] ) ||
			! array_key_exists( 'font', $config['tabStyle']['.active'] )
		);

		$fonts = array();
		if ( array_key_exists( 'tabStyle', $config ) &&
			is_array( $config['tabStyle'] ) &&
			array_key_exists( 'font', $config['tabStyle'] )
		) {
			$fonts[] = array(
				'family' => $config['tabStyle']['font'],
				'variant' => isset( $config['tabStyle']['fontVariant'] ) ?
					$config['tabStyle']['fontVariant'] :
					'regular',
			);
		}
		if ( isset( $config['tabStyle'] ) &&
			array_key_exists( '.active', $config['tabStyle'] ) &&
			is_array( $config['tabStyle']['.active'] ) &&
			array_key_exists( 'font', $config['tabStyle']['.active'] )
		) {
			$fonts[] = array(
				'family' => $config['tabStyle']['.active']['font'],
				'variant' => isset( $config['tabStyle']['.active']['fontVariant'] ) ?
					$config['tabStyle']['.active']['fontVariant'] :
					'regular',
			);
		}
		return $fonts;
	}
}
