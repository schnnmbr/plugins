<?php
namespace WooViews\Compatibility\Astra\Style\Rule;

class CartMessage implements \ToolsetCommonEs\Compatibility\IRule {

	public function get_as_string(
		\ToolsetCommonEs\Compatibility\ISettings $settings,
		$base_selector = ''
	) {
		$css = '';
		$base_selector .= '.wooviews-woocommerce-message .woocommerce-message';

		// Button
		$button_properties = $settings->get_button_properties();

		if( ! empty( $button_properties ) ) {
			$css .= $base_selector .
					' a.button { '.
					$button_properties .
					'}';
		}

		// Border & Icon Color.
		$color = $settings->get_link_color();

		if( ! empty( $color ) ) {
			$css .= $base_selector . ' { border-top-color: ' . $color . '; }';
			$css .= $base_selector . ':before { color: ' . $color . '; }';
		}

		return $css;
	}
}
