<?php // phpcs:ignore

namespace WooViews\Block\Style;

use ToolsetCommonEs\Block\Style\Attribute\Factory as FactoryStyleAttribute;
use ToolsetCommonEs\Block\Style\Block\ABlock;

/**
 * Class Cart Count
 *
 * @package WooViews
 */
class CartCount extends ABlock {
	const KEY_STYLES_FOR_CART_COUNT = 'count';

	/**
	 * Loads styles for specific block attribute
	 *
	 * @param FactoryStyleAttribute $factory Factory.
	 */
	public function load_block_specific_style_attributes( FactoryStyleAttribute $factory ) {
		$config = $this->get_block_config();
		if ( isset( $config['align'] ) ) {
			$style = $factory->get_attribute( 'text-align', $config['align'] );
			if ( $style ) {
				$this->add_style_attribute( $style, self::KEY_STYLES_FOR_CART_COUNT );
			}
		}
	}

	/**
	 * Gets CSS
	 *
	 * @param array   $config Config.
	 * @param boolean $force_apply Forced to apply.
	 * @return array
	 */
	public function get_css( $config = array(), $force_apply = false, $responsive_device = null ) {
		return parent::get_css( $this->css_config(), $force_apply );
	}

	/**
	 * Gets CSS Selector
	 *
	 * @param string $css_selector CSS Selector.
	 * @return string
	 */
	protected function get_css_selector( $css_selector = parent::CSS_SELECTOR_ROOT ) {
		if ( preg_match( '/%s/', $css_selector ) ) {
			$root = '[data-' . str_replace( '/', '-', $this->get_name() ) . '="' . $this->get_id() . '"]';
			return sprintf( $css_selector, $root );
		} else {
			return parent::get_css_selector();
		}
	}

	/**
	 * Generates CSS Config
	 *
	 * @return array
	 */
	private function css_config() {
		return array(
			parent::CSS_SELECTOR_ROOT             => array(
				parent::KEY_STYLES_FOR_COMMON_STYLES => array(
					'font-size',
					'font-family',
					'font-style',
					'font-weight',
					'line-height',
					'letter-spacing',
					'text-decoration',
					'text-shadow',
					'text-transform',
					'background-color',
					'border-radius',
					'color',
					'padding',
					'margin',
					'box-shadow',
					'border',
				),
				self::KEY_STYLES_FOR_CART_COUNT           => array(
					'text-align',
				),
			),
			'.woocommerce %s .wcviews_cart_count_output' => array(
				parent::KEY_STYLES_FOR_COMMON_STYLES => array(
					'font-size',
					'line-height',
					'font-family',
				),
			),
		);
	}
}
