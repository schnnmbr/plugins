<?php
// Config of Product Image block.
return [
	'slug' => 'product-image',
	'shortcode' => '[wpv-woo-product-image]',
	'title' => __( 'Product Image', 'woocommerce-views' ),
	'description' => __( 'Display the product image.', 'woocommerce-views' ),
	'keywords' => [
		__( 'image', 'woocommerce-views' ),
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
		'rootClass' => '&wooviews-product-image',
		'styleMap' => [
			'' => [
				'style' => [ 'maxWidth' ],
			],
			'figure img' => [
				'style' => [
					'backgroundColor',
					'margin',
					'padding',
					'border',
					'borderRadius',
					'boxShadow',
					'scale',
					'rotate',
				],
			],
			'ol' => [
				'gallery' => [
					'equalColumnsCount',
					'columnGap',
					'rowGap',
				]
			],
			'li img' => [
				'gallery' => [
					'backgroundColor',
					'border',
					'borderRadius',
					'boxShadow',
					'scale',
					'rotate',
				],
			],
			[
				'selectors' => [ 'li img:not(.flex-active)' ],
				'attributes' => [
					'gallery' => [ 'opacity' ]
				]
			],
			'.onsale' => [
				'sale-badge' => 'all',
			],
		],
	],
	'panels' => [
		'settings' => [
			'title' => __( 'Settings', 'woocommerce-views' ),
			'fields' => [
				'settings' => []
			]
		],
		'style-settings' => [
			'title' => __( 'Image', 'woocommerce-views' ),
			'tabs' =>  [
				[
					'name' => 'normal',
					'title' => __( 'Normal', 'wpv-views' ),
					'class' => null,
					'pseudoClass' => null,
					'storageKey' => null,
				],
				[
					'name' => 'hover',
					'title' => __( 'Hover', 'wpv-views' ),
					'pseudoClass' => ':hover',
					'storageKey' => ':hover',
				],
			],
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
					'scale',
					'rotate',
					'showZoomIcon',
				]
			]
		],
		'gallery-settings' => [
			'title' => __( 'Gallery Images', 'woocommerce-views' ),
			'tabs' =>  [
				[
					'name' => 'normal',
					'title' => __( 'Normal', 'wpv-views' ),
					'class' => null,
					'pseudoClass' => null,
					'storageKey' => null,
				],
				[
					'name' => 'hover',
					'title' => __( 'Hover', 'wpv-views' ),
					'pseudoClass' => ':hover',
					'storageKey' => ':hover',
				],
			],
			'colorIndicators' => [
				'gallery' => [ 'backgroundColor' ]
			],
			'fields' => [
				'gallery' => 'all'
			],
		],
		'sale-badge-settings' => [
			'title' => __( 'Sale Badge', 'woocommerce-views' ),
			'colorIndicators' => [
				'sale-badge' => [ 'textColor', 'backgroundColor' ]
			],
			'fields' => [
				'sale-badge' => 'all'
			]
		]
	],
	'attributes' => [
		'settings' => [
			'type' => 'object',
			'fields' => []
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
				'scale',
				'rotate',
				'showZoomIcon',
				'maxWidth',
			]
		],
		'gallery' => [
			'type' => 'object',
			'fields' => [
				'backgroundColor',
				'border',
				'borderRadius',
				'boxShadow',
				'scale',
				'rotate',
				'opacity' => [
					'type' => 'opacity',
					'label' => __( 'Opacity Inactive Image', 'woocommerce-views' )
				],
				'equalColumnsCount' => [
					'type' => 'equalColumnsCount',
					'label' => __( 'Images per Row', 'woocommerce-views' )
				],
				'columnGap' => [
					'type' => 'columnGap',
					'label' => __( 'Vertical Images Space', 'woocommerce-views' )
				],
				'rowGap' => [
					'type' => 'rowGap',
					'label' => __( 'Horizontal Images Space', 'woocommerce-views' )
				]
			]
		],
		'sale-badge' => [
			'type' => 'object',
			'fields' => [
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
				'textColor',
				'backgroundColor',
				'margin',
				'padding',
				'border',
				'borderRadius',
				'boxShadow',
				'scale',
				'rotate',
				'width',
				'widthUnit',
				'height',
				'heightUnit',
				'top',
				'bottom',
				'left',
				'right',
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
						'style' => [],
						'settings' => [
							'show_gallery' => true,
							'show_on_sale_badge' => true,
							'use_thumbnail_size' => false,
						],
						'gallery' => [
							'equalColumnsCount' => 4,
							'columnGap' => [
								'value' => 3,
								'unit' => 'px',
							],
							'rowGap' => [
								'value' => 3,
								'unit' => 'px',
							],

							'opacity' => 40,
							':hover' => [
								'opacity' => 100
							]
						],
						'sale-badge' => [
							'fontWeight' => 'bold',
							'textTransform' => 'uppercase',
							'textAlign' => 'center',
							'textColor' => [
								'r' => 255,
								'g' => 255,
								'b' => 255,
								'a' => 1,
							],
							'backgroundColor' => [
								'r' => 217,
								'g' => 79,
								'b' => 79,
								'a' => 1,
							],
							'margin' => [
								'enabled' => true,
							],
							'padding' => [
								'enabled' => true,
								'paddingTop' => '12px',
								'paddingRight' => '18px',
								'paddingBottom' => '12px',
								'paddingLeft' => '18px',
							],
							'left' => [
								'value' => 0,
								'unit' => 'px'
							],
							'top' => [
								'value' => 0,
								 'unit' => 'px'
							],
							'width' => 46,
							'widthUnit' => 'px'
						],

					]
				]
			],
			WC_VIEWS_TEMPLATE_SOURCE_WOOCOMMERCE_SLUG => [
				'disabled' => [
					'advanced' => [
						'fields' => [
							'blockAlign'
						]
					],
					'attributes' => [
						'gallery' => [
							'equalColumnsCount',
							'columnGap',
							'rowGap',
							'opacity'
						]
					]
				],
				'css' => [
					'rootClass' => '&woocommerce-wooviews-product-image',
				],
				'attributes' => [
					'defaults' => [
						'style' => [
							'showZoomIcon' => 'true',
						],
						'settings' => [
							'show_gallery' => 'true',
							'show_on_sale_badge' => 'true',
						],
						'sale-badge' => [],
					]
				]
			]
		]
	]
];
