<?php
// Config of Rating

$starStyle =[
	'active' => [
		'type' => 'textColor',
		'label' => __( 'Active Color', 'woocommerce-views' )
	],
	'inactive' => [
		'type' => 'textColor',
		'label' => __( 'Inactive Color', 'woocommerce-views' )
	],
];

return [
	'slug' => 'ratings',
	'shortcode' => [
		'listing' => '[wpv-woo-products-rating-listing]',
		'single' => '[wpv-woo-single-products-rating]',
	],
	'title' => __( 'Rating', 'woocommerce-views' ),
	'description' => __( 'Display the product average rating.', 'woocommerce-views' ),
	'keywords' => [
		__( 'rating', 'woocommerce-views' ),
		'toolset',
		'woocommerce',
	],
	'supports' => [
		'customClassName' => false,
	],
	'css' => [
		'rootClass' => 'wooviews-rating',
		'styleMap' => [
			// Container
			'' => [
				'style' => [
					'backgroundColor',
					'margin',
					'padding',
					'border',
					'borderRadius',
					'boxShadow',
					'textAlign',
				],
			],
			// Star
			'.star-rating span::before' => [
				'starStyle' => [
					'active',
				],
			],
			'.star-rating::before' => [
				'starStyle' => [
					'inactive',
				],
			],
		],
	],
	'panels' => [
		'star-settings' => [
			'title' => __( 'Stars', 'woocomerce-views' ),
			'colorIndicators' => [
				'starStyle' => array_keys( $starStyle ),
			],
			'fields' => [
				'starStyle' => array_keys( $starStyle ),
			],
		],
		'style-settings' => [
			'title' => __( 'Container', 'woocommerce-views' ),
			'colorIndicators' => [
				'style' => [ 'backgroundColor' ],
			],
			'fields' => [
				'style' => [
					'backgroundColor',
					'margin',
					'padding',
					'border',
					'borderRadius',
					'boxShadow',
					'textAlign',
				],
			]
		]
	],
	'attributes' => [
		'starStyle' => [
			'type' => 'object',
			'fields' => $starStyle,
		],
		'style' => [
			'type' => 'object',
			'fields' => [
				'backgroundColor',
				'margin',
				'padding',
				'border',
				'borderRadius',
				'boxShadow',
				'textAlign',
			]
		],
		'type' => [
			'type' => 'string',
		],
	],
	'template' => [
		'sources' => [ WC_VIEWS_TEMPLATE_SOURCE_TOOLSET_SLUG, WC_VIEWS_TEMPLATE_SOURCE_WOOCOMMERCE_SLUG ],
		'default' => WC_VIEWS_TEMPLATE_SOURCE_TOOLSET_SLUG,
		'source' => [
			WC_VIEWS_TEMPLATE_SOURCE_TOOLSET_SLUG => [
				'attributes' => [
					'defaults' => [
						'starStyle' => [
							'active' => [
								'r' => 228,
								'g' => 204,
								'b' => 41,
								'a' => 1,
							],
							'inactive' => [
								'r' => 193,
								'g' => 193,
								'b' => 193,
								'a' => 1,
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
						'style' => [],
						'starStyle' => [],
					],
				],
			],
		],
	],
];
