<?php
// Config of Product Price block.

return [
	'slug' => 'product-price',
	'shortcode' => '[wpv-woo-product-price]',
	'title' => __( 'Product Price', 'woocommerce-views' ),
	'description' => __( 'Display the product price.', 'woocommerce-views' ),
	'keywords' => [
		__( 'price', 'woocommerce-views' ),
		'toolset',
		'woocommerce',
	],
	'supports' => [
		'customClassName' => false,
	],
	'css' => [
		'rootClass' => '&wooviews-product-price',
		'styleMap' => [
			'' => [
				'style' => [
					'backgroundColor',
					'margin',
					'padding',
					'border',
					'borderRadius',
					'boxShadow',
				],
			],
			'.price' => [
				'style' => [
					'font',
					'fontSize',
					'fontStyle',
					'fontWeight',
					'textDecoration',
					'lineHeight',
					'letterSpacing',
					'textShadow',
					'textAlign',
				],
			],
			'.amount' => [
				'priceStyles' => [ 'normal' ],
				'style' => [
					'fontStyle',
					'textDecoration',
				],
			],
			[
				'selectors' => [
					'del',
					'del .amount',
				],
				'attributes' => [
					'priceStyles' => [ 'regular' ],
				]
			],
			[
				'selectors' => [
					'ins',
					'ins .amount',
				],
				'attributes' => [
					'priceStyles' => [ 'sale' ],
				]
			],
		],
	],
	'panels' => [
		'price-settings' => [
			'title' => __( 'Price', 'woocommerce-views' ),
			'colorIndicators' => [
				'priceStyles' => [ 'normal', 'regular', 'sale' ],
			],
			'fields' => [
				'priceStyles' => 'all',
				'style' => [
					'textAlign',
					'font',
					'fontSize',
					'fontStyle',
					'fontWeight',
					'textDecoration',
					'lineHeight',
					'letterSpacing',
					'textShadow',
				],
			],
		],
		'style-settings' => [
			'title' => __( 'Container', 'woocommerce-views' ),
			'colorIndicators' => [
				'style' => [ 'backgroundColor' ]
			],
			'fields' => [
				'style' => [
					'backgroundColor',
					'margin',
					'padding',
					'border',
					'borderRadius',
					'boxShadow',
				],
			]
		],
	],
	'attributes' => [
		'style' => [
			'type' => 'object',
			'fields' => [
				'backgroundColor',
				'margin',
				'padding',
				'border',
				'borderRadius',
				'boxShadow',
				'font',
				'fontSize',
				'fontStyle',
				'fontWeight',
				'textDecoration',
				'lineHeight',
				'letterSpacing',
				'textShadow',
				'textAlign',
			],
		],
		'priceStyles' => [
			'type' => 'object',
			'fields' => [
				'normal' => [
					'type' => 'textColor',
					'label' => __( 'Normal Price Color', 'woocommerce-views' )
				],
				'regular' => [
					'type' => 'textColor',
					'label' => __( 'Regular Price Color', 'woocommerce-views' )
				],
				'sale' => [
					'type' => 'textColor',
					'label' => __( 'Sale Price Color', 'woocommerce-views' )
				],
			],
		],
	],
	'template' => [
		'sources' => [ WC_VIEWS_TEMPLATE_SOURCE_TOOLSET_SLUG, WC_VIEWS_TEMPLATE_SOURCE_WOOCOMMERCE_SLUG ],
		'default' => WC_VIEWS_TEMPLATE_SOURCE_TOOLSET_SLUG,
		'source' => [
			WC_VIEWS_TEMPLATE_SOURCE_TOOLSET_SLUG => [
				'attributes' => [
					'defaults' => [
						'style' => [
							'fontSize' => 24,
						],
						'priceStyles' => [
							'normal' => [
								'r' => 0,
								'g' => 0,
								'b' => 0,
								'a' => 1,
							],
							'regular' => [
								'r' => 193,
								'g' => 193,
								'b' => 193,
								'a' => 1,
							],
							'sale' => [
								'r' => 0,
								'g' => 0,
								'b' => 0,
								'a' => 1,
							],
						],
					]
				]
			],
			WC_VIEWS_TEMPLATE_SOURCE_WOOCOMMERCE_SLUG => [
				'css' => [
					'rootClass' => '&woocommerce-product-price',
				],
				'attributes' => [
					'defaults' => [
						'style' => [],
						'linkStyle' => [],
					]
				]
			]
		]
	]
];
