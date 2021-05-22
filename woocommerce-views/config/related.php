<?php

$containerStyles = [
	'backgroundColor',
	'margin',
	'padding',
	'border',
	'borderRadius',
	'boxShadow',
];

$headingStyles = 'all';

$productHeadingStyles = 'all';

$imageStyles = [
	'backgroundColor',
	'margin',
	'padding',
	'border',
	'borderRadius',
	'boxShadow',
];

$saleStyles = 'all';

$starsStyles =[
	'active' => [
		'type' => 'textColor',
		'label' => __( 'Active Color', 'woocommerce-views' )
	],
	'inactive' => [
		'type' => 'textColor',
		'label' => __( 'Inactive Color', 'woocommerce-views' )
	],
];

$priceStyles =[
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
];

$buttonStyles = 'all';

$itemStyles = [
	'backgroundColor',
	'margin',
	'padding',
	'border',
	'borderRadius',
	'boxShadow',
];

$allStyles = [
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
];

$fontStyles = [
	'font',
	'fontSize',
	'fontStyle',
	'fontWeight',
	'textDecoration',
	'lineHeight',
	'letterSpacing',
	'textTransform',
	'textShadow',
	'textColor',
];

// Config of Tabs
return [
	'slug' => 'related-products',
	'shortcode' => '[wpv-woo-related_products]',
	'title' => __( 'Related Products', 'woocommerce-views' ),
	'description' => __( 'Display the list of related products.', 'woocommerce-views' ),
	'keywords' => [
		__( 'related', 'woocommerce-views' ),
		'toolset',
		'woocommerce',
	],
	'supports' => [
		'customClassName' => false,
	],
	'css' => [
		'rootClass' => '&wooviews-related',
		'styleMap' => [
			// Onsale badget
			' ul.wooviews-related-list .onsale' => [
				'saleStyles' => $saleStyles,
			],
			'.amount' => [
				'priceStyles' => [ 'normal' ],
			],
			'del' => [
				'priceStyles' => [ 'regular' ],
			],
			'del .amount' => [
				'priceStyles' => [ 'regular' ],
			],
			'ins' => [
				'priceStyles' => [ 'sale' ],
			],
			'ins .amount' => [
				'priceStyles' => [ 'sale' ],
			],
			// Stars in comments
			'.star-rating span::before' => [
				'starsStyles' => [
					'active',
				],
			],
			'.star-rating::before' => [
				'starsStyles' => [
					'inactive',
				],
			],
			// Product Container
			'li' => [
				'itemStyles' => $itemStyles,
			],
			// Button
			'li .button' => [
				'buttonStyles' => $buttonStyles,
			],
			// Title
			'.wooviews-related > h2' => [
				'headingStyles' => $headingStyles,
			],
			// block Title
			'li > h2' => [
				'productHeadingStyles' => $productHeadingStyles,
			],
			'li > h3' => [
				'productHeadingStyles' => $productHeadingStyles,
			],
			// block Title
			'img' => [
				'imageStyles' => $imageStyles,
			],
			// Container styles
			'section.wooviews-related' => [
				'containerStyles' => $containerStyles,
			],
		],
	],
	'panels' => [
		'title-settings' => [
			'title' => __( 'Block Heading', 'woocommerce-views' ),
			'colorIndicators' => [
				'headingStyles' => [ 'textColor', 'backgroundColor' ],
			],
			'fields' => [
				'headingStyles' => $headingStyles,
			],
		],
		'image-settings' => [
			'title' => __( 'Image', 'woocommerce-views' ),
			'colorIndicators' => [
				'imageStyles' => [ 'backgroundColor' ],
			],
			'fields' => [
				'imageStyles' => $imageStyles,
			],
		],
		'item-title-settings' => [
			'title' => __( 'Product Heading', 'woocommerce-views' ),
			'colorIndicators' => [
				'productHeadingStyles' => [ 'textColor', 'backgroundColor' ],
			],
			'fields' => [
				'productHeadingStyles' => $productHeadingStyles,
			],
		],
		'sale-settings' => [
			'title' => __( 'Sale Badge', 'woocommerce-views' ),
			'colorIndicators' => [
				'saleStyles' => [ 'textColor', 'backgroundColor' ],
			],
			'fields' => [
				'saleStyles' => $saleStyles,
			],
		],
		'star-settings' => [
			'title' => __( 'Stars', 'woocommerce-views' ),
			'colorIndicators' => [
				'starsStyles' => array_keys( $starsStyles ),
			],
			'fields' => [
				'starsStyles' => array_keys( $starsStyles ),
			],
		],
		'price-settings' => [
			'title' => __( 'Price', 'woocommerce-views' ),
			'colorIndicators' => [
				'priceStyles' => array_keys( $priceStyles ),
			],
			'fields' => [
				'priceStyles' => array_keys( $priceStyles ),
			],
		],
		'submit-settings' => [
			'title' => __( 'Button', 'woocommerce-views' ),
			'colorIndicators' => [
				'buttonStyles' => [ 'textColor', 'backgroundColor' ],
			],
			'tabs' => [
				[
					'name' => 'normal',
					'title' => __( 'Normal', 'woocomerce-views' ),
					'pseudoClass' => '',
					'storageKey' => '',
				],
				[
					'name' => 'hover',
					'title' => __( 'Hover', 'woocomerce-views' ),
					'pseudoClass' => ' =>hover',
					'storageKey' => ' =>hover',
				],
			],
			'fields' => [
				'buttonStyles' => $buttonStyles,
			],
		],
		'item-settings' => [
			'title' => __( 'Product Container', 'woocommerce-views' ),
			'colorIndicators' => [
				'itemStyles' => [ 'backgroundColor' ],
			],
			'fields' => [
				'itemStyles' => $itemStyles,
			],
		],
		'container-settings' => [
			'title' => __( 'Block Container', 'woocommerce-views' ),
			'colorIndicators' => [
				'containerStyles' => [ 'backgroundColor' ],
			],
			'fields' => [
				'containerStyles' => $containerStyles,
			],
		],
	],
	'attributes' => [
		'style' => [
			'type' => 'object',
			'fields' => $containerStyles,
		],
		'headingStyles' => [
			'type' => 'object',
			'fields' => $allStyles,
		],
		'productHeadingStyles' => [
			'type' => 'object',
			'fields' => $allStyles,
		],
		'imageStyles' => [
			'type' => 'object',
			'fields' => $imageStyles,
		],
		'saleStyles' => [
			'type' => 'object',
			'fields' => $allStyles,
		],
		'starsStyles' => [
			'type' => 'object',
			'fields' => $starsStyles,
		],
		'priceStyles' => [
			'type' => 'object',
			'fields' => $priceStyles,
		],
		'buttonStyles' => [
			'type' => 'object',
			'fields' => $allStyles,
		],
		'itemStyles' => [
			'type' => 'object',
			'fields' => $allStyles,
		],
		'containerStyles' => [
			'type' => 'object',
			'fields' => $allStyles,
		],
	],
	'template' => [
		'sources' => [ WC_VIEWS_TEMPLATE_SOURCE_TOOLSET_SLUG, WC_VIEWS_TEMPLATE_SOURCE_WOOCOMMERCE_SLUG ],
		'default' => WC_VIEWS_TEMPLATE_SOURCE_TOOLSET_SLUG,
		'source' => [
			WC_VIEWS_TEMPLATE_SOURCE_TOOLSET_SLUG => [
				'attributes' => [
					'defaults' => [
						'saleStyles' => [
							'fontSize' => 12,
							'textColor' => [
								'r' => 255,
								'g' => 255,
								'b' => 255,
								'a' => 1,
							],
							'backgroundColor' => [
								'r' => 255,
								'g' => 131,
								'b' => 103,
								'a' => 1,
							],
							'margin' => [
								'enabled' => true,
							],
							'padding' => [
								'enabled' => true,
								'paddingTop' => '8px',
								'paddingLeft' => '12px',
								'paddingRight' => '12px',
								'paddingBottom' => '8px',
							],
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
						'buttonStyles' => [
							'fontSize' => 15,
							'textColor' => [
								'r' => 241,
								'g' => 241,
								'b' => 241,
								'a' => 1,
							],
							'backgroundColor' => [
								'r' => 68,
								'g' => 68,
								'b' => 68,
								'a' => 1,
							],
							'margin' => [
								'enabled' => true,
							],
							'padding' => [
								'enabled' => true,
								'paddingTop' => '15px',
								'paddingBottom' => '15px',
								'paddingLeft' => '20px',
								'paddingRight' => '20px',
							],
						],
						'starsStyles' => [
							'active' => [
								'r' =>228,
								'g' =>204,
								'b' =>41,
								'a' =>1,
							],
							'inactive' => [
								'r' =>193,
								'g' =>193,
								'b' =>193,
								'a' =>1,
							],
						],
					],
				],
			],
			WC_VIEWS_TEMPLATE_SOURCE_WOOCOMMERCE_SLUG => [
				'css' => [
					'rootClass' => '&woocommerce-related',
				],
				'attributes' => [
					'defaults' => [
					],
				],
			],
		],
	],
];
