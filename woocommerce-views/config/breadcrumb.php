<?php
// Config of Breadcrumb(s) block.
return [
	'slug' => 'breadcrumb',
	'shortcode' => '[wpv-woo-breadcrumb]',
	'title' => __( 'Breadcrumbs', 'woocommerce-views' ),
	'description' => __( 'Display WooCommerce breadcrumbs.', 'woocommerce-views' ),
	'keywords' => [
		__( 'breadcrumb', 'woocommerce-views' ),
		'toolset',
		'woocommerce',
	],
	'supports' => [
		'customClassName' => false
	],
	'advanced' => [
		'storageKey' => 'style',
		'fields' => [
			'id',
			'classes',
			'blockHide',
			'blockAlign' => [
				// 'left', 'center', 'right', 'wide', 'full'
				'controls' => [ 'left', 'right' ]
			],
			'maxWidth' => [
				'label' => __( 'Block Max-Width', 'woocommerce-views' ),
				// Do not allow % as the images also use % as width and that ends in odd results as we do not know
				// what the first absolute width in the DOM tree.
				// Possible values: [ 'px', '%', 'em', 'rem', 'vw', 'vmax', 'vmin' ]
				'allowedUnits' => [ 'px', 'em', 'rem', 'vw', 'vmax', 'vmin' ],
				'defaultUnit' => 'px',
			],
		]
	],
	'css' => [
		'rootClass' => 'wooviews-breadcrumb',
		'styleMap' => [
			'' => [
				'style' => 'all',
			],
			'a' => [
				'linkStyle' => 'all',
			],
		],
	],
	'panels' => [
		'style-settings' => [
			'title' => __( 'General', 'woocommerce-views' ),
			'colorIndicators' => [
				'style' => [ 'textColor', 'backgroundColor' ]
			],
			'fields' => [
				'style' => [
					'textColor',
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
					'textTransform',
					'textShadow',
				]
			]
		],
		'link-settings' => [
			'title' => __( 'Link', 'woocommerce-views' ),
			'tabs' => 'normal-hover-active',
			'colorIndicators' => [
				'linkStyle' => [ 'textColor' ]
			],
			'fields' => [
				'linkStyle' => 'all'
			]
		],
	],
	'attributes' => [
		'style' => [
			'type' => 'object',
			'fields' => [
				'textColor',
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
				'textTransform',
				'textShadow',
				'maxWidth',
			]
		],
		'linkStyle' => [
			'type' => 'object',
			'fields' => [
				'textColor',
				'font',
				'fontSize',
				'fontStyle',
				'fontWeight',
				'textDecoration',
				'lineHeight',
				'letterSpacing',
				'textTransform',
				'textShadow',
			]
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
							'textColor' => [ 'r' => 51, 'g' => 51, 'b' => 51, 'a' => 1 ],
							'margin' => [
								'enabled' => true,
								'marginBottom' => '2em',
							],
						],
						'linkStyle' => [
							'textColor' => [ 'r' => 153, 'g' => 153, 'b' => 153, 'a' => 1 ],
							':hover' => [
								'textColor' => [ 'r' => 51, 'g' => 51, 'b' => 51, 'a' => 1 ]
							],
							':active' => [
								'textColor' => [ 'r' => 51, 'g' => 51, 'b' => 51, 'a' => 1 ]
							]
						],
					]
				]
			],
			WC_VIEWS_TEMPLATE_SOURCE_WOOCOMMERCE_SLUG => [
				'css' => [
					'rootClass' => 'woocommerce-breadcrumb',
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
