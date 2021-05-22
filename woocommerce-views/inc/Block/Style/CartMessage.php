<?php

namespace WooViews\Block\Style;

use ToolsetCommonEs\Block\Style\Block\WithConfig;
use ToolsetCommonEs\Library\MobileDetect\MobileDetect;
use WooViews\Config\Block;

/**
 * Class Cart Message
 *
 * @package WooViews
 */
class CartMessage extends WithConfig {
	/**
	 * Use message type colors for the box border color when the "Border use Message Type Colors" is active.
	 *
	 * @param $css
	 *
	 * @return string
	 */
	protected function apply_individual_css( $css ) {
		if( ! $this->find_in_block_values( ['style', 'borderUseMessageColors' ] ) ) {
			return $css;
		}

		if( $color = $this->find_in_block_values( [ 'typeStyle', 'colorSuccess' ] ) ) {
			$css .= $this->get_css_selector_root_with_template_selector() .
					' .woocommerce-message { border-color: rgba('
					. $color['r'] . ',' . $color['g'] . ',' . $color['b'] . ',' . $color['a'] . '); }';
		}

		if( $color = $this->find_in_block_values( [ 'typeStyle', 'colorInfo' ] ) ) {
			$css .= $this->get_css_selector_root_with_template_selector() .
					' .woocommerce-info { border-color: rgba('
					. $color['r'] . ',' . $color['g'] . ',' . $color['b'] . ',' . $color['a'] . '); }';
		}

		if( $color = $this->find_in_block_values( [ 'typeStyle', 'colorError' ] ) ) {
			$css .= $this->get_css_selector_root_with_template_selector() .
					' .woocommerce-error { border-color: rgba('
					. $color['r'] . ',' . $color['g'] . ',' . $color['b'] . ',' . $color['a'] . '); }';
		}

		return $css;
	}
}
