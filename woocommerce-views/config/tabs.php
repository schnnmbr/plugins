<?php

$contentStyle = [
	'backgroundColor',
	'margin',
	'padding',
	'border',
	'borderRadius',
	'boxShadow',
];

$tabStyleLink = [
	'textColor',
	'font',
	'fontSize',
	'lineHeight',
	'letterSpacing',
	'textTransform',
	'textShadow',
];

$tabStyleContainer = [
	'backgroundColor',
	'margin',
	'padding',
	'border',
	'borderRadius',
	'boxShadow',
];

$tabsStyle = [
	'backgroundColor',
	'margin',
	'padding',
	'border',
	'borderRadius',
	'boxShadow',
];

// Config of Tabs
return [
	'slug' => 'product-tabs',
	'shortcode' => '[wpv-woo-display-tabs]',
	'title' => __( 'Product Tabs', 'woocommerce-views' ),
	'description' => __( 'Display the product tabs.', 'woocommerce-views' ),
	'keywords' => [
		__( 'tabs', 'woocommerce-views' ),
		'toolset',
		'woocommerce',
	],
	'supports' => [
		'customClassName' => false,
	],
	'css' => [
		'rootClass' => 'wooviews-tabs',
		'styleMap' => [
			// Tabs
			'ul.wc-tabs' => [
				'tabsStyle' => $tabsStyle,
			],
			'ul.wc-tabs li' => [
				'tabStyleContainer' => $tabStyleContainer,
			],
			'ul.wc-tabs li%pseudoClass% a' => [
				'tabStyleLink' => $tabStyleLink,
			],
			'.wc-tab' => [
				'contentStyle' => $contentStyle,
			],
		],
	],
	'panels' => [
		'tabs-settings' => [
			'title' => __( 'Tabs', 'woocomerce-views' ),
			'colorIndicators' => [
				'tabsStyle' => [ 'backgroundColor' ],
			],
			'fields' => [
				'tabsStyle' => $tabsStyle,
			],
		],
		'tab-settings' => [
			'title' => __( 'Tab', 'woocommerce-views' ),
			'colorIndicators' => [
				'tabStyleLink' => [ 'textColor' ],
				'tabStyleContainer' => [ 'backgroundColor' ],
			],
			'tabs' => [
				[
					'name' => 'normal',
					'title' => __( 'Normal', 'woocomerce-views' ),
					'pseudoClass' => '',
					'storageKey' => '',
				],
				[
					'name' => 'active',
					'title' => __( 'Active', 'woocomerce-views' ),
					'pseudoClass' => '.active',
					'storageKey' => '.active',
				],
			],
			'fields' => [
				'tabStyleLink' => $tabStyleLink,
				'tabStyleContainer' => $tabStyleContainer,
			],
		],
		'content-settings' => [
			'title' => __( 'Content', 'woocommerce-views' ),
			'colorIndicators' => [
				'contentStyle' => [ 'backgroundColor' ],
			],
			'fields' => [
				'contentStyle' => $contentStyle,
			],
		],
	],
	'attributes' => [
		'settings' => [
			'type' => 'object',
		],
		'contentStyle' => [
			'type' => 'object',
			'fields' => $contentStyle,
		],
		'tabsStyle' => [
			'type' => 'object',
			'fields' => $tabsStyle,
		],
		'tabStyleContainer' => [
			'type' => 'object',
			'fields' => $tabStyleContainer,
		],
		'tabStyleLink' => [
			'type' => 'object',
			'fields' => $tabStyleLink,
		],
	],
	'template' => [
		'sources' => [ WC_VIEWS_TEMPLATE_SOURCE_TOOLSET_SLUG, WC_VIEWS_TEMPLATE_SOURCE_WOOCOMMERCE_SLUG ],
		'default' => WC_VIEWS_TEMPLATE_SOURCE_TOOLSET_SLUG,
		'source' => [
			WC_VIEWS_TEMPLATE_SOURCE_TOOLSET_SLUG => [
				'attributes' => [
					'defaults' => [
						'tabsStyle' => [
							'margin' => [
								'enabled' => true,
								'marginBottom' => '50px',
							],
							'padding' => [
								'enabled' => true,
							],
							'border' => [
								'top' => [
									'style' => 'solid',
									'width' => NULL,
									'widthUnit' => 'px',
									'color' => [
										'hex' => '#000000',
										'rgb' =>  [
											'r' => 0,
											'g' => 0,
											'b' => 0,
											'a' => 1,
										],
									],
								],
								'right' => [
									'style' => 'solid',
									'width' => NULL,
									'widthUnit' => 'px',
									'color' => [
										'hex' => '#000000',
										'rgb' => [
											'r' => 0,
											'g' => 0,
											'b' => 0,
											'a' => 1,
										],
									],
								],
								'bottom' => [
									'style' => 'solid',
									'width' => 1,
									'widthUnit' => 'px',
									'color' => [
										'hex' => '#dddddd',
										'rgb' => [
											'r' => 221,
											'g' => 221,
											'b' => 221,
											'a' => 1,
										],
										'source' => 'hex',
									],
								],
								'left' => [
									'style' => 'solid',
									'width' => NULL,
									'widthUnit' => 'px',
									'color' =>
									[
										'hex' => '#000000',
										'rgb' =>
										[
											'r' => 0,
											'g' => 0,
											'b' => 0,
											'a' => 1,
										],
									],
								],
							],
						],
						'tabStyleContainer' => [
							'margin' => [
								'enabled' => true,
							],
							'padding' => [
								'enabled' => true,
								'paddingTop' => '15px',
								'paddingLeft' => '15px',
								'paddingRight' => '15px',
								'paddingBottom' => '15px',
							],
							'.active' => [
								'boxShadow' => [
									'enabled' => false,
									'label' => 'Box Shadow',
									'color' => [
										'hex' => '#ff8367',
										'rgb' => [
											'r' => 255,
											'g' => 131,
											'b' => 103,
											'a' => 1,
										],
										'source' => 'hex',
									],
									'horizontal' => 0,
									'vertical' => 4,
									'blur' => 0,
									'spread' => 0,
								],
								'padding' => [
									'enabled' => true,
								],
								'margin' => [
									'enabled' => true,
								],
								'border' => [
									'top' => [
										'style' => 'solid',
										'width' => 0,
										'widthUnit' => 'px',
										'color' => [
											'hex' => '#000000',
											'rgb' => [
												'r' => 0,
												'g' => 0,
												'b' => 0,
												'a' => 1,
											],
										],
									],
									'right' => [
										'style' => 'solid',
										'width' => 0,
										'widthUnit' => 'px',
										'color' => [
											'hex' => '#000000',
											'rgb' => [
												'r' => 0,
												'g' => 0,
												'b' => 0,
												'a' => 1,
											],
										],
									],
									'bottom' => [
										'style' => 'solid',
										'width' => 4,
										'widthUnit' => 'px',
										'color' => [
										'hex' => '#ff8367',
											'rgb' => [
												'r' => 255,
												'g' => 131,
												'b' => 103,
												'a' => 1,
											],
											'source' => 'hex',
										],
									],
									'left' => [
										'style' => 'solid',
										'width' => 0,
										'widthUnit' => 'px',
										'color' => [
											'hex' => '#000000',
											'rgb' => [
												'r' => 0,
												'g' => 0,
												'b' => 0,
												'a' => 1,
											],
										],
									],
								],
							],
						],
						'tabStyleLink' => [
							'textColor' => [
								'r' => 134,
								'g' => 136,
								'b' => 155,
								'a' => 1,
							],
							'.active' => [
								'textShadow' => [
									'enabled' => false,
									'label' => 'Box Shadow',
									'color' => [
										'hex' => '#ff8367',
										'rgb' => [
											'r' => 255,
											'g' => 131,
											'b' => 103,
											'a' => 1,
										],
										'source' => 'hex',
									],
									'horizontal' => 5,
									'vertical' => 5,
									'blur' => 10,
									'spread' => 0,
								],
								'textColor' => [
									'r' => 54,
									'g' => 58,
									'b' => 89,
									'a' => 1,
								],
								'lineHeight' => 0,
								'lineHeightUnit' => 'px',
							],
						],
					],
				],
			],
			WC_VIEWS_TEMPLATE_SOURCE_WOOCOMMERCE_SLUG => [
				'css' => [
					'rootClass' => 'woocommerce-product-rating',
				],
				'attributes' => [
					'defaults' => [
					],
				],
			],
		],
	],
];
