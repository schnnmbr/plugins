<?php
// Config of List Attributes block.
return [
	'slug' => 'list-attributes',
	'shortcode' => '[wpv-woo-list_attributes]',
	'title' => __( 'List Attributes', 'woocommerce-views' ),
	'description' => __( 'Display the product attributes, such as size or color.', 'woocommerce-views' ),
	'keywords' => [
		__( 'attributes', 'woocommerce-views' ),
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
		'rootClass' => 'wooviews-list-attributes',
		'styleMap' => [
			'' => [
				'style' => [ 'maxWidth' ],
				'tableStyle' => [
					'backgroundColor',
					'margin',
					'border',
					'boxShadow',
					'width',
					'widthUnit'
				]
			],
			[
				'selectors' => [
					'tr:nth-child(even) th',
					'tr:nth-child(even) td'
				],
				'attributes' => [
					'tableStyle' => [
						'secondTextColor',
						'secondBackgroundColor',
					],
				],
			],
			[
				'selectors' => [
					'tr:nth-child(even) td p'
				],
				'attributes' => [
					'tableStyle' => [
						'secondTextColor',
					],
				],
			],
			[
				'selectors' => [
					'th',
					'td'
				],
				'attributes' => [
					'tableStyle' => [
						'padding',
						'border',
						'textColor',
						'font',
						'fontSize',
						'lineHeight',
						'letterSpacing',
						'textShadow',
						'fontStyle',
						'fontWeight',
						'textDecoration',
						'textTransform',
					],
				],
			],
			[
				'selectors' => [
					'td p'
				],
				'attributes' => [
					'tableStyle' => [
						'textColor',
						'font',
						'fontSize',
						'lineHeight',
						'letterSpacing',
						'textShadow',
						'fontStyle',
						'fontWeight',
						'textDecoration',
						'textTransform',
					],
				],
			],
			[
				'selectors' => [
					'tr th.woocommerce-product-attributes-item__label',
					'tr th.wooviews-list-attributes-item__label',
				],
				'attributes' => [
					'labelStyle' => 'all'
				]
			],
			[
				'selectors' => [
					'tr td.woocommerce-product-attributes-item__value',
					'tr td.wooviews-list-attributes-item__value'
				],
				'attributes' => [
					'valueStyle' => [
						'backgroundColor',
						'margin',
						'padding',
						'border',
						'boxShadow',
					],
				]
			],
			[
				'selectors' => [
					'tr td.woocommerce-product-attributes-item__value p',
					'tr td.wooviews-list-attributes-item__value p',
				],
				'attributes' => [
					'valueStyle' => [
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
						'textAlign',
					],
				]
			],
		],
	],
	'panels' => [
		'table-settings' => [
			'title' => __( 'Table', 'woocommerce-views' ),
			'colorIndicators' => [
				'tableStyle' => [ 'textColor', 'secondTextColor', 'backgroundColor', 'secondBackgroundColor' ]
			],
			'fields' => [
				'tableStyle' => 'all'
			]
		],
		'label-settings' => [
			'title' => __( 'Label', 'woocommerce-views' ),
			'colorIndicators' => [
				'labelStyle' => [ 'textColor', 'backgroundColor' ]
			],
			'fields' => [
				'labelStyle' => 'all'
			]
		],
		'value-settings' => [
			'title' => __( 'Value', 'woocommerce-views' ),
			'colorIndicators' => [
				'valueStyle' => [ 'textColor', 'backgroundColor' ]
			],
			'fields' => [
				'valueStyle' => 'all'
			]
		],
	],
	'attributes' => [
		'style' => [
			'type' => 'object',
			'fields' => [ 'maxWidth' ]
		],
		'tableStyle' => [
			'type' => 'object',
			'fields' => [
				'textColor',
				'secondTextColor' => [
					'type' => 'textColor',
					'label' => __( '2nd Text Color', 'woocommerce-views' )
				],
				'font',
				'fontSize',
				'fontStyle',
				'fontWeight',
				'textDecoration',
				'lineHeight',
				'letterSpacing',
				'textTransform',
				'textShadow',
				'backgroundColor',
				'margin',
				'padding',
				'border',
				'boxShadow',
				'width',
				'widthUnit',
				'secondBackgroundColor' => [
					'type' => 'backgroundColor',
					'label' => __( '2nd Background Color', 'woocommerce-views' )
				],
			]
		],
		'labelStyle' => [
			'type' => 'object',
			'fields' => [
				'textColor',
				'font',
				'fontSize',
				'fontStyle',
				'fontWeight',
				'textDecoration',
				'textAlign',
				'lineHeight',
				'letterSpacing',
				'textTransform',
				'textShadow',
				'backgroundColor',
				'border',
			]
		],
		'valueStyle' => [
			'type' => 'object',
			'fields' => [
				'textColor',
				'font',
				'fontSize',
				'fontStyle',
				'fontWeight',
				'textDecoration',
				'lineHeight',
				'textAlign',
				'letterSpacing',
				'textTransform',
				'textShadow',
				'backgroundColor',
				'border',
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
						'tableStyle' => [
							'padding' => [
								'enabled' => true,
								'paddingTop' => '5px',
								'paddingRight' => '10px',
								'paddingBottom' => '5px',
								'paddingLeft' => '10px',
							],
							'border' => [
								'top'    => [
									'style'     => 'solid',
									'width'     => 1,
									'widthUnit' => 'px',
									'color'     => [
										'rgb'    => [ 'r' => 214, 'g' => 214, 'b' => 214, 'a' => 0.55 ],
									]
								],
								'right'  => [
									'style'     => 'solid',
									'width'     => 1,
									'widthUnit' => 'px',
									'color'     => [
										'rgb'    => [ 'r' => 214, 'g' => 214, 'b' => 214, 'a' => 0.55 ],
									]
								],
								'bottom' => [
									'style'     => 'solid',
									'width'     => 1,
									'widthUnit' => 'px',
									'color'     => [
										'rgb'    => [ 'r' => 214, 'g' => 214, 'b' => 214, 'a' => 0.55 ],
									]
								],
								'left'   => [
									'style'     => 'solid',
									'width'     => 1,
									'widthUnit' => 'px',
									'color'     => [
										'rgb'    => [ 'r' => 214, 'g' => 214, 'b' => 214, 'a' => 0.55 ],
									]
								]
							],
							'secondBackgroundColor' => [
								'r' => 242,
								'g' => 242,
								'b' => 242,
								'a' => 0.5,
							],
							'width' => 100,
							'widthUnit' => '%',

						],
						'labelStyle' => [
							'fontWeight' => 'bold',
							'textAlign' => 'left'
						],
						'valueStyle' => [],
					]
				]
			],
			WC_VIEWS_TEMPLATE_SOURCE_WOOCOMMERCE_SLUG => [
				'css' => [
					'rootClass' => 'woocommerce-product-attributes',
				],
				'attributes' => [
					'defaults' => [
						'tableStyle' => [],
						'labelStyle' => [],
						'valueStyle' => [],
					]
				]
			]
		]
	]
];
