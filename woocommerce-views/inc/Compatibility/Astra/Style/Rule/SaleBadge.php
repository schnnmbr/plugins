<?php
namespace WooViews\Compatibility\Astra\Style\Rule;

class SaleBadge implements \ToolsetCommonEs\Compatibility\IRule {

	public function get_as_string(
		\ToolsetCommonEs\Compatibility\ISettings $settings,
		$base_selector = ''
	) {
		$css = '';

		// All Headings.
		$properties = [];

		// Background Color.
		$bg_color = $settings->get_primary_color();
		if ( ! empty( $bg_color ) ) {
			$properties[] = 'background-color: '. $bg_color . ';';

			// Text Color.
			if( function_exists( 'astra_get_foreground_color' ) ) {
				$text_color = astra_get_foreground_color( $bg_color );

				if( ! empty( $text_color ) && is_string( $text_color ) ) {
					$properties[] = 'color: '. $text_color . ';';
				}
			}
		}

		if( ! empty( $properties ) ) {
			$css .= $base_selector . '.woocommerce-wooviews-product-image span.onsale { ' .
					implode( ' ', $properties )  . '}';
		}

		return $css;
	}
}
