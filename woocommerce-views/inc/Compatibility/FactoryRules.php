<?php
namespace WooViews\Compatibility;


use ToolsetCommonEs\Compatibility\Theme\Astra\Astra;
use WooViews\Compatibility\Astra\Style\Rule\CartMessage;
use WooViews\Compatibility\Astra\Style\Rule\SaleBadge;

class FactoryRules {

	/** @var Astra */
	private $astra;

	public function __construct(
		Astra $astra
	) {
		$this->astra = $astra;
	}

	public function get_rules() {
		$rules = [];

		if( $this->astra->is_active() ) {
			$rules[] = new CartMessage();
			$rules[] = new SaleBadge();
		}

		return $rules;
	}
}
