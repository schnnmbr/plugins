<?php // phpcs:ignore

namespace WooViews\Block\Style;

use ToolsetCommonEs\Block\Style\Attribute\Factory as FactoryStyleAttribute;
use ToolsetCommonEs\Block\Style\Block\ABlock;
use ToolsetCommonEs\Block\Style\Responsive\Devices\Devices;

/**
 * Class Add to Cart
 *
 * @package WooViews
 */
class AddToCart extends ABlock {
	const KEY_STYLES_FOR_BUTTON = 'button';
	const KEY_STYLES_FOR_CART = 'cart';
	const KEY_STYLES_FOR_ICON = 'icon';
	const KEY_STYLES_FOR_QUANTITY = 'quantity';
	const KEY_STYLES_FOR_TABLE = 'table';
	const KEY_STYLES_FOR_PRICE = 'price';

	const TABS = [
		'normal' => '',
		'hover' => ':hover',
		'added' => '.added',
		'loading' => '.loading',
	];

	private $default_config = [
		'buttonStyle' => [
			'lineHeight' => 36,
			'padding' => [
				'enabled' => true,
				'paddingRight' => '1.5em',
				'paddingLeft' => '1.5em',
				'paddingTop' => '0.5em',
				'paddingBottom' => '0.5em',
			],
			'textColor' => [ 'r' => 241, 'g' => 241, 'b' => 241, 'a' => 1 ],
			'backgroundColor' => [ 'r' => 68, 'g' => 68, 'b' => 68, 'a' => 1 ],
			'borderRadius' => [
				'topLeft' => 0,
				'topRight' => 0,
				'bottomLeft' => 0,
				'bottomRight' => 0,
			],
			'fontSize' => 16,
			'border' => [
				'top' => [
					'style' => 'solid',
					'width' => 1,
					'widthUnit' => 'px',
					'color' => [
						'hex' => '#444444',
						'source' => 'hex',
						'rgb' => [
							'r' => 68,
							'g' => 68,
							'b' => 68,
							'a' => 1,
						],
					],
				],
				'left' => [
					'style' => 'solid',
					'width' => 1,
					'widthUnit' => 'px',
					'color' => [
						'hex' => '#444444',
						'source' => 'hex',
						'rgb' => [
							'r' => 68,
							'g' => 68,
							'b' => 68,
							'a' => 1,
						],
					],
				],
				'right' => [
					'style' => 'solid',
					'width' => 1,
					'widthUnit' => 'px',
					'color' => [
						'hex' => '#444444',
						'source' => 'hex',
						'rgb' => [
							'r' => 68,
							'g' => 68,
							'b' => 68,
							'a' => 1,
						],
					],
				],
				'bottom' => [
					'style' => 'solid',
					'width' => 1,
					'widthUnit' => 'px',
					'color' => [
						'hex' => '#444444',
						'source' => 'hex',
						'rgb' => [
							'r' => 68,
							'g' => 68,
							'b' => 68,
							'a' => 1,
						],
					],
				],
			],
		],
		'quantityStyle' => [
			'lineHeight' => 36,
			'fontSize' => 16,
			'margin' => [
				'enabled' => true,
			],
			'padding' => [
				'enabled' => true,
				'paddingRight' => '0.5em',
				'paddingLeft' => '0.5em',
				'paddingTop' => '0.5em',
				'paddingBottom' => '0.5em',
			],
			'width' => 60,
			'widthUnit' => 'px',
		],
	];

	/**
	 * Loads styles for specific block attribute
	 *
	 * @param FactoryStyleAttribute $factory Factory.
	 */
	public function load_block_specific_style_attributes( FactoryStyleAttribute $factory ) {
		$config = $this->get_block_config();
		$config = array_merge( $this->default_config, $config );

		if ( isset( $config['align'] ) ) {
			$justify_alignment = [
				'center' => 'center',
				'left' => 'flex-start',
				'right' => 'flex-end',
			];
			$style = $factory->get_attribute( 'justify-content', $justify_alignment[ $config['align'] ] );
			if ( $style ) {
				$this->add_style_attribute( $style, self::KEY_STYLES_FOR_COMMON_STYLES );
			}
		}

		/**
		 * Button Styles
		 */
		if ( isset( $config['buttonStyle'] ) && is_array( $config['buttonStyle'] ) ) {
			$css_config = $config['buttonStyle'];
			$rules      = [
				'textColor'       => 'color',
				'backgroundColor' => 'background-color',
				'margin'          => 'margin',
				'padding'         => 'padding',
				'border'          => 'border',
				'borderRadius'    => 'border-radius',
				'boxShadow'       => 'box-shadow',
				'font'            => 'font-family',
				'fontSize'        => 'font-size',
				'fontWeight'      => 'font-weight',
				'fontVariant'     => 'font-weight',
				'lineHeight'      => 'line-height',
				'letterSpacing'   => 'letter-spacing',
				'textTransform'   => 'text-transform',
				'textShadow'      => 'text-shadow',
			];

			foreach ( $rules as $type => $rule ) {
				foreach ( self::TABS as $tab => $pseudoclass ) {
					if ( ( ! $pseudoclass && isset( $css_config[ $type ] ) ) || ( $pseudoclass && isset( $css_config[$pseudoclass][ $type ] ) ) ) {
						$current_css_config = $pseudoclass ? $css_config[$pseudoclass][ $type ] : $css_config[ $type ];
						$style = $factory->get_attribute( $rule, $current_css_config );
						if ( $style ) {
							$this->add_style_attribute( $style, self::KEY_STYLES_FOR_BUTTON . $pseudoclass );
						}
					}
				}
			}
		}

		$icon_styles = isset( $config['icon'] ) && is_array( $config['icon'] ) ? $config['icon'] : false;

		if ( ! empty( $icon_styles ) ) {
			foreach ( self::TABS as $tab => $pseudoclass ) {
				// font family
				if ( ! empty( $icon_styles[ $tab ][ 'fontFamily' ] ) && ! empty( $icon_styles[ $tab ][ 'fontCode' ] ) ) {
					// Don't know why it is quoted with unicode characteres.
					$font_family = str_replace( 'u0022', '', $icon_styles[ $tab ]['fontFamily' ] );
					if ( $style = $factory->get_attribute( 'font-family', $font_family ) ) {
						$this->add_style_attribute( $style, self::KEY_STYLES_FOR_ICON . $tab );
					}
				}

				// Icon position
				if ( isset( $icon_styles[ $tab ][ 'position' ] ) && 'right' === $icon_styles[ $tab ][ 'position' ] ) {
					$float_right = array( 'float' => 'right' );
					if ( $style = $factory->get_attribute( 'float', $float_right ) ) {
						$this->add_style_attribute( $style, self::KEY_STYLES_FOR_ICON . $tab );
					}
				}

				// Icon rotation
				if ( isset( $icon_styles[ $tab ][ 'rotate' ] ) && $icon_styles[ $tab ][ 'rotate' ] ) {
					if ( $style = $factory->get_attribute( 'animation', [ 'animation' => 'wooviews-rotation 1.5s infinite linear' ] ) ) {
						$this->add_style_attribute( $style, self::KEY_STYLES_FOR_ICON . $tab );
					}
				}

				// Icon isolation
				if ( isset( $icon_styles[ $tab ][ 'alone' ] ) && $icon_styles[ $tab ][ 'alone' ] ) {
					if ( $style = $factory->get_attribute( 'display', 'none' ) ) {
						$this->add_style_attribute( $style, self::KEY_STYLES_FOR_ICON . $tab );
					}
				} else {
					if ( $style = $factory->get_attribute( 'display', 'inline-block' ) ) {
						$this->add_style_attribute( $style, self::KEY_STYLES_FOR_ICON . $tab );
					}
				}

				// font code
				$icon_style_font_code =
					isset( $icon_styles[ $tab ]['fontCode'] ) &&
					'' !== $icon_styles[ $tab ]['fontCode'] ?
						$icon_styles[ $tab ]['fontCode'] :
						false;
				if ( $icon_style_font_code ) {
					// I don't know why, font codes like '\f11f' are translated to \f => form feed (FF or 0x0C (12) in ASCII), breaking all CSS rules
					// I wasn't able to figure out why sometimes json_decode translates it properly and in a different WP site it doesn't wrongly
					// Solution: replace it :(
					$font_code = str_replace( "\f", '\f', $icon_styles[ $tab ]['fontCode' ] );
					if ( $style = $factory->get_attribute( 'content', $font_code ) ) {
						$this->add_style_attribute( $style, self::KEY_STYLES_FOR_ICON . $tab );
					}
				}

				// spacing
				$icon_style_spacing =
					$icon_style_font_code && // Spacing only makes sense when an icon is present.
					isset( $icon_styles[ $tab ]['spacing'] ) &&
					'' !== $icon_styles[ $tab ]['spacing']
					? $icon_styles[ $tab ]['spacing'] :
					false;
				if ( $icon_style_spacing ) {
					$position = isset( $icon_styles[ $tab ]['position'] ) ? $icon_styles[ $tab ]['position'] : 'left';
					$padding = array(
						'enabled' => true,
						'paddingTop' => null,
						'paddingBottom' => null,
						'paddingLeft' => null,
						'paddingRight' => null
					);

					if ( $position === 'left' ) {
						$padding['paddingLeft'] = '0px';
						$padding['paddingRight'] = $icon_styles[ $tab ][ 'spacing' ] . 'px';
					} else {
						$padding['paddingLeft'] = $icon_styles[ $tab ][ 'spacing' ] . 'px';
						$padding['paddingRight'] = '0px';
					}

					if ( $style = $factory->get_attribute( 'padding', $padding ) ) {
						$this->add_style_attribute( $style, self::KEY_STYLES_FOR_ICON . $tab );
					}
				}
			}
		}

		$quantity_styles = isset( $config['quantityStyle'] ) && is_array( $config['quantityStyle'] ) ? $config['quantityStyle'] : false;

		if ( ! empty( $quantity_styles ) ) {
			$quantity_rules = [
				'backgroundColor' => 'backgroundColor',
				'margin'          => 'margin',
				'padding'         => 'padding',
				'border'          => 'border',
				'borderRadius'    => 'border-radius',
				'width'           => 'width',
				'lineHeight'      => 'line-height',
			];

			foreach ( $quantity_rules as $type => $rule ) {
				if ( isset( $quantity_styles[ $type ] ) ) {
					if ( $type === 'width' ) {
						$style = $factory->get_attribute( $rule, $quantity_styles );
					} else {
						$style = $factory->get_attribute( $rule, $quantity_styles[ $type ] );
					}
					if ( $style ) {
						$this->add_style_attribute( $style, self::KEY_STYLES_FOR_QUANTITY );
					}
				}
			}
		}

		$table_styles = isset( $config['tableStyle'] ) && is_array( $config['tableStyle'] ) ? $config['tableStyle'] : false;

		if ( ! empty( $table_styles ) ) {
			$table_rules = [
				'background'      => 'background',
				'margin'          => 'margin',
				'padding'         => 'padding',
				'border'          => 'border',
				'borderRadius'    => 'border-radius',
			];

			foreach ( $table_rules as $type => $rule ) {
				if ( isset( $table_styles[ $type ] ) ) {
					$style = $factory->get_attribute( $rule, $table_styles[ $type ] );
					if ( $style ) {
						$this->add_style_attribute( $style, self::KEY_STYLES_FOR_TABLE );
					}
				}
			}
		}

		$price_styles = isset( $config['priceStyle'] ) && is_array( $config['priceStyle'] ) ? $config['priceStyle'] : false;


		if ( ! empty( $price_styles ) ) {
			$price_rules = [
				'colorSales'   => 'color',
				'colorRegular' => 'color',
				'colorNormal'  => 'color',
			];

			foreach ( $price_rules as $type => $rule ) {
				if ( isset( $price_styles[ $type ] ) ) {
					$style = $factory->get_attribute( $rule, $price_styles[ $type ] );
					if ( $style ) {
						$this->add_style_attribute( $style, self::KEY_STYLES_FOR_PRICE . $type );
					}
				}
			}
		}

		if ( isset( $config['quantityPositionReversed'] ) && $config['quantityPositionReversed'] ) {
			$position_css = [
				'flex-direction' => 'row-reverse',
				'justify-content' => 'flex-end',
			];
			foreach( $position_css as $rule => $value ) {
				$style = $factory->get_attribute( $rule, $value );
				if ( $style ) {
					$this->add_style_attribute( $style, self::KEY_STYLES_FOR_QUANTITY );
				}
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
	 * Checks if current block uses Toolset template
	 *
	 * @return boolean
	 */
	private function is_toolset_template() {
		$block_config = $this->get_block_config();
		return isset( $block_config['template'] ) && isset( $block_config['template']['source'] ) && 'toolset' === $block_config['template']['source'];
	}

	/**
	 * Generates CSS Config
	 *
	 * @return array
	 */
	private function css_config() {
		$root_class_name = defined( 'REST_REQUEST' ) && REST_REQUEST ? 'body.wp-admin' : 'body.woocommerce';
		$button_styles = [
			'color',
			'background-color',
			'margin',
			'padding',
			'border',
			'border-radius',
			'box-shadow',
			'font-family',
			'font-size',
			'line-height',
			'letter-spacing',
			'text-transform',
			'text-shadow',
		];

		// Unfortunately these are all the variables of button types offered by WC
		$rules = $this->is_toolset_template() ?
			[
				'button.wooviews-template-add_to_cart_button',
				'button.wooviews-template-add_to_cart_button.button',
				'a.button.wooviews-template-add_to_cart_button',
				'.wooviews-template-add_to_cart_button.button',
			] :
			[
				'button.add_to_cart_button',
				'button.add_to_cart_button.button',
				'a.add_to_cart_button.button',
				'.add_to_cart_button.button',
				'a.button',
				'a.button.wooviews-template-add_to_cart_button',
				'a.button.product_type_grouped',
				'button.button.wooviews-template-add_to_cart_button',
				'button.button.product_type_grouped',
			];

		$config = array(
			parent::CSS_SELECTOR_ROOT => array(
				parent::KEY_STYLES_FOR_COMMON_STYLES => array(
					'background-color',
					'margin',
					'padding',
					'border',
					'border-radius',
					'box-shadow',
				),
			),
		);
		$config[ $root_class_name . ' %s .cart' ] = array(
			self::KEY_STYLES_FOR_COMMON_STYLES => [ 'justify-content' ],
		);

		// Hack for single pages
		foreach( [ ' ', ' div.product ' ] as $page_type ) {
			foreach ( $rules as $rule ) {
				$config[ $root_class_name . $page_type . ' %s ' . $rule ] = array(
					self::KEY_STYLES_FOR_BUTTON => $button_styles,
				);
				$config[ $root_class_name . $page_type . ' %s ' . $rule . ':hover' ] = array(
					parent::KEY_STYLES_FOR_HOVER => $button_styles,
				);
				$config[ $root_class_name . $page_type . ' %s ' . $rule . ':active' ] = array(
					parent::KEY_STYLES_FOR_ACTIVE => $button_styles,
				);
				$config[ $root_class_name . $page_type . ' %s ' . $rule . ':visited' ] = array(
					self::KEY_STYLES_FOR_BUTTON => $button_styles,
				);
			};

			foreach ( self::TABS as $tab => $pseudoclass ) {
				foreach ( $rules as $rule ) {
					$config[ $root_class_name . $page_type . ' %s ' . $rule . $pseudoclass ] = array(
						self::KEY_STYLES_FOR_BUTTON . $pseudoclass => $button_styles,
					);
				}
				$config[ '%s ' . $pseudoclass . ' .wooviews-template-add_to_cart_button__icon' ] = array(
					self::KEY_STYLES_FOR_ICON . $tab => array(
						'font-family',
						'padding',
						'float',
					),
				);

				$config[ '%s ' . $pseudoclass . ' .wooviews-template-add_to_cart_button__text' ] = array(
					self::KEY_STYLES_FOR_ICON . $tab => array(
						'display',
					),
				);

				$config[ '%s .button' . $pseudoclass . ' .wooviews-template-add_to_cart_button__icon::before' ] = array(
					self::KEY_STYLES_FOR_ICON . $tab => array(
						'content',
						'animation',
					),
				);
			}

			$config[ $root_class_name . $page_type . ' %s form.cart .wooviews-template-quantity input[type=number]' ] = array(
				self::KEY_STYLES_FOR_QUANTITY => array(
					'background-color',
					'margin',
					'padding',
					'border',
					'border-radius',
					'width',
					'line-height',
				),
			);
		}

		$config[ $root_class_name . ' %s table.wooviews-template-table'] = array(
			self::KEY_STYLES_FOR_TABLE => array(
				'background',
				'margin',
			),
		);

		$config[ $root_class_name . ' div.product %s table.wooviews-template-table td'] = array(
			self::KEY_STYLES_FOR_TABLE => array(
				'padding',
				'border',
				'border-radius',
			),
		);

		$price_colors = [
			'colorNormal'  => [ '.wooviews-template-amount .amount' ],
			'colorRegular' => [ '.wooviews-template-amount del', '.wooviews-template-amount del .amount' ],
			'colorSales'   => [ '.wooviews-template-amount ins', '.wooviews-template-amount ins .amount' ],
		];
		foreach ( $price_colors as $color_type => $rules ) {
			foreach ( $rules as $rule ) {
				$config[ $root_class_name . ' %s ' . $rule ] = array(
					self::KEY_STYLES_FOR_PRICE . $color_type => array(
						'color',
					),
				);
			}
		}

		$config[ $root_class_name . ' %s .wooviews-template-quantity-button'] = array(
			self::KEY_STYLES_FOR_QUANTITY => array(
				'flex-direction',
				'justify-content',
			),
		);

		return $config;
	}

	/**
	 * Gets font data
	 */
	public function get_font( $devices = [ Devices::DEVICE_DESKTOP => true ], $attribute = 'style' ) {
		$config = $this->get_block_config();

		if ( empty( $config ) ||
			! array_key_exists( 'buttonStyle', $config ) ||
			! is_array( $config['buttonStyle'] ) ||
			! array_key_exists( 'font', $config['buttonStyle'] )
		) {
			return array();
		}

		return array(
			array(
				'family' => $config['buttonStyle']['font'],
				'variant' => isset( $config['buttonStyle']['fontVariant'] ) ?
					$config['buttonStyle']['fontVariant'] :
					'regular',
			),
		);
	}
}
