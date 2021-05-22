<?php

namespace WooViews\Block\Style;

use ToolsetCommonEs\Block\Style\Attribute\Factory as FactoryStyleAttribute;
use ToolsetCommonEs\Block\Style\Block\WithConfig;
use ToolsetCommonEs\Library\MobileDetect\MobileDetect;

/**
 * Class Breadcrumb
 *
 * @package WooViews
 */
class ProductImage extends WithConfig {

	protected function get_css_selector_root() {
		// Thanks to WooCommerce that such explicit selectors are needed.
		return 'html body.woocommerce ' . parent::get_css_selector_root();
	}

	/**
	 * Extra CSS:
	 * - Add the rowGap also as margin top and margin bottom to the gallery images.
	 * - Hide gallery zoom icon.
	 *
	 * @param $css
	 *
	 * @return string
	 */
	protected function apply_individual_css( $css ) {
		// rowGap as margin top and margin bottom.
		if( $value = $this->find_in_block_values( ['gallery', 'rowGap', 'value' ] ) ) {
			$unit = $this->find_in_block_values( ['gallery', 'rowGap', 'unit' ], 'px' );

			$css .= $this->get_css_selector_root_with_template_selector() . ' div.images ol { '.
					'margin-top: ' . $value . $unit . ';'.
					'margin-bottom: ' . $value . $unit . '; }';
		}

		$show_zoom_icon = $this->find_in_block_values( ['style', 'showZoomIcon' ] );

		if( empty( $show_zoom_icon ) || $show_zoom_icon === 'false' ) {
			$css .= $this->get_css_selector_root_with_template_selector() . ' .woocommerce-product-gallery__trigger {' .
					'display: none; }';
		}



		return $css;
	}
}
