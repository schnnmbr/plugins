<?php
// Config of Cart-Message block.
return [
	'slug' => 'cart-message',
	'shortcode' => '[wpv-add-to-cart-message]',
	'title' => __( 'Cart Message', 'woocommerce-views' ),
	'description' => __( 'Displays a success message when a product is added to the cart. It can also show the \'out of stock\' message.', 'woocommerce-views' ),
	'keywords' => [
		__( 'cart message', 'woocommerce-views' ),
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
		'rootClass' => 'wooviews-cart-message',
		'styleMap' => [
			'' => [
				'style' => [ 'maxWidth' ],
			],
			// Success Message
			'.woocommerce-message' => [
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
				],
			],
			'.woocommerce-message .button' => [
				'buttonStyle' => 'all'
			],
			'.woocommerce-message:before' => [
				'typeStyle' => [ 'colorSuccess' ]
			],
			// Info Message
			'.woocommerce-info'  => [
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
				],
			],
			'.woocommerce-info .button' => [
				'buttonStyle' => 'all'
			],
			'.woocommerce-info:before' => [
				'typeStyle' => [ 'colorInfo' ]
			],
			// Error Message
			'.woocommerce-error'  => [
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
				],
			],
			'.woocommerce-error .button' => [
				'buttonStyle' => 'all'
			],
			'.woocommerce-error:before' => [
				'typeStyle' => [ 'colorError' ]
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
		'button-settings' => [
			'title' => __( 'Button', 'woocommerce-views' ),
			'tabs' => 'normal-hover-active',
			'colorIndicators' => [
				'buttonStyle' => [ 'textColor', 'backgroundColor' ]
			],
			'fields' => [
				'buttonStyle' => 'all'
			]
		],
		'type-settings' => [
			'title' => __( 'Type Colors', 'woocommerce-views' ),
			'colorIndicators' => [
				'typeStyle' => [ 'colorSuccess', 'colorInfo', 'colorError' ]
			],
			'fields' => [
				'typeStyle' => 'all'
			]
		]
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
		'buttonStyle' => [
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
			]
		],
		'typeStyle' => [
			'type' => 'object',
			'fields' => [
				'colorSuccess' => [
					'type' => 'textColor',
					'label' => __( 'Color Success', 'woocommerce-views' )
				],
				'colorInfo' => [
					'type' => 'textColor',
					'label' => __( 'Color Info', 'woocommerce-views' )
				],
				'colorError' => [
					'type' => 'textColor',
					'label' => __( 'Color Error', 'woocommerce-views' )
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
							'lineHeight' => 36,
							'margin' => [
								'enabled' => true,
								'marginBottom' => '2em',
							],
							'padding' => [
								'enabled' => true,
								'paddingTop' => '1em',
								'paddingRight' => '2em',
								'paddingBottom' => '1em',
								'paddingLeft' => '3.5em',
							],
							'backgroundColor' => [ 'r' => 245, 'g' => 245, 'b' => 245, 'a' => 1 ],
						],
						'buttonStyle' => [
							'lineHeight' => 36,
							'padding' => [
								'enabled' => true,
								'paddingTop' => '0px', // Required to prevent WC defaults on frontend.
								'paddingRight' => '1.5em',
								'paddingBottom' => '0px', // Required to prevent WC defaults on frontend.
								'paddingLeft' => '1.5em',
							],
							'textColor' => [ 'r' => 241, 'g' => 241, 'b' => 241, 'a' => 1 ],
							'backgroundColor' => [ 'r' => 68, 'g' => 68, 'b' => 68, 'a' => 1 ],
						],
						'typeStyle' => [
							'colorInfo' => [ 'r' => 0, 'g' => 160, 'b' => 210, 'a' => 1 ],
							'colorSuccess' => [ 'r' => 74, 'g' => 184, 'b' => 102, 'a' => 1 ],
							'colorError' => [ 'r' => 217, 'g' => 79, 'b' => 79, 'a' => 1 ],
						],
					]
				]
			],
			WC_VIEWS_TEMPLATE_SOURCE_WOOCOMMERCE_SLUG => [
				'css' => [
					'rootClass' => 'wooviews-woocommerce-message',
				],
				'attributes' => [
					'defaults' => [
						'style' => [],
						'buttonStyle' => [],
						'typeStyle' => []
					]
				]
			]
		]
	]
];
