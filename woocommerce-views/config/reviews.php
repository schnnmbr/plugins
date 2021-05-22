<?php

return [
	'slug' => 'reviews',
	'shortcode' => '[wpv-woo-reviews]',
	'title' => __( 'Reviews', 'woocommerce-views' ),
	'description' => __( 'Display the product reviews, along with the "add a review" form.', 'woocommerce-views' ),
	'keywords' => [
		__( 'reviews', 'woocommerce-views' ),
		'toolset',
		'woocommerce',
	],
	'supports' => [
		'customClassName' => false,
	],
	'css' => [
		'rootClass' => 'wooviews-reviews',
		'styleMap' => [
			// Stars in form
			'#reviews%rootClass% #commentform p.stars a:not(.active)' => [
				'starsStyle' => [
					'inactive',
				],
			],
			'#reviews%rootClass% #commentform p.stars a::before' => [
				'starsStyle' => [
					'inactive',
				],
			],
			'#reviews%rootClass% #commentform p.stars a:hover ~ a::before' => [
				'starsStyle' => [
					'inactive',
				],
			],
			'#reviews%rootClass% #commentform p.stars a:hover::before' => [
				'starsStyle' => [
					'active',
				],
			],
			'#reviews%rootClass% #commentform p.stars a.active::before' => [
				'starsStyle' => [
					'active',
				],
			],
			'#reviews%rootClass% #commentform p.stars.selected a:not(.active)::before' => [
				'starsStyle' => [
					'active',
				],
			],
			'#reviews%rootClass% #commentform p.stars.selected a.active ~ a::before' => [
				'starsStyle' => [
					'inactive',
				],
			],
			'#reviews%rootClass% #commentform p.stars:hover a::before' => [
				'starsStyle' => [
					'active',
				],
			],
			// Stars in comments
			'#reviews%rootClass% #comments ol.commentlist li.wooviews-reviews-item .comment_container .star-rating span::before' => [
				'starsStyle' => [
					'fontSize',
					'active',
				],
			],
			'#reviews%rootClass% #comments ol.commentlist li.wooviews-reviews-item .comment_container .star-rating::before' => [
				'starsStyle' => [
					'fontSize',
					'inactive',
				],
			],
			// Avatar
			'#reviews%rootClass% #comments li.wooviews-reviews-item img.avatar' => [
				'avatarStyle' => 'all',
			],
			// Comment Meta
			'#reviews%rootClass% #comments li.wooviews-reviews-item .comment_container .comment-text p.meta' => [
				'metaStyle' => 'all',
			],
			'#reviews%rootClass% #comments li.wooviews-reviews-item .comment_container .comment-text p.meta strong' => [
				'metaStyle' => [
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
				],
			],
			'#reviews%rootClass% #comments li.wooviews-reviews-item .comment_container .comment-text p.meta span' => [
				'metaStyle' => [
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
				],
			],
			'#reviews%rootClass% #comments li.wooviews-reviews-item .comment_container .comment-text p.meta time' => [
				'metaStyle' => [
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
				],
			],
			// Comment Text
			'#reviews%rootClass% #comments li.wooviews-reviews-item .comment_container .comment-text div.description p' => [
				'commentTextStyle' => 'all',
			],
			// Form Title
			'#reviews%rootClass% .comment-reply-title' => [
				'formTitleStyle' => 'all',
			],
			// Form Labels
			'#reviews%rootClass% #commentform label' => [
				'formLabelStyle' => 'all',
			],
			// Form inputs
			'#reviews%rootClass% #commentform input[type="text"]' => [
				'formInputsStyles' => 'all',
			],
			'#reviews%rootClass% #commentform select' => [
				'formInputsStyles' => 'all',
			],
			'#reviews%rootClass% #commentform input[type="email"]' => [
				'formInputsStyles' => 'all',
			],
			'#reviews%rootClass% #commentform textarea' => [
				'formInputsStyles' => 'all',
			],
			'#reviews%rootClass% #commentform #comment' => [
				'formInputsStyles' => 'all',
			],
			// Submit button
			'#reviews%rootClass% #commentform #submit' => [
				'submitStyles' => 'all',
			],
			// Container
			'' => [
				'containerStyle' => 'all',
			],
		],
	],
	'panels' => [
		'avatar-settings' => [
			'title' => __( 'Avatar', 'woocommerce-views' ),
			'colorIndicators' => [
				'avatarStyle' => [ 'backgroundColor' ],
			],
			'fields' => [
				'avatarStyle' => 'all',
			],
		],
		'star-settings' => [
			'title' => __( 'Stars', 'woocommerce-views' ),
			'colorIndicators' => [
				'starsStyle' => [ 'active', 'inactive' ],
			],
			'fields' => [
				'starsStyle' => 'all',
			],
		],
		'meta-settings' => [
			'title' => __( 'Author & Date', 'woocommerce-views' ),
			'colorIndicators' => [
				'metaStyle' => [ 'textColor', 'backgroundColor' ],
			],
			'fields' => [
				'metaStyle' => 'all',
			],
		],
		'text-settings' => [
			'title' => __( 'Comment Paragraphs', 'woocommerce-views' ),
			'colorIndicators' => [
				'commentTextStyle' => [ 'textColor', 'backgroundColor' ],
			],
			'fields' => [
				'commentTextStyle' => 'all',
			],
		],
		'form-title-settings' => [
			'title' => __( 'Form Title', 'woocommerce-views' ),
			'colorIndicators' => [
				'formTitleStyle' => [ 'textColor', 'backgroundColor' ],
			],
			'fields' => [
				'formTitleStyle' => 'all',
			],
		],
		'form-label-settings' => [
			'title' => __( 'Form Labels', 'woocommerce-views' ),
			'colorIndicators' => [
				'formLabelStyle' => [ 'textColor', 'backgroundColor' ],
			],
			'fields' => [
				'formLabelStyle' => 'all',
			],
		],
		'form-inputs-settings' => [
			'title' => __( 'Form Inputs', 'woocommerce-views' ),
			'colorIndicators' => [
				'formInputsStyles' => [ 'textColor', 'backgroundColor' ],
			],
			'fields' => [
				'formInputsStyles' => 'all',
			],
		],
		'form-submit-settings' => [
			'title' => __( 'Submit Button', 'woocommerce-views' ),
			'colorIndicators' => [
				'submitStyles' => [ 'textColor', 'backgroundColor' ],
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
					'pseudoClass' => ':hover',
					'storageKey' => ':hover',
				],
			],
			'fields' => [
				'submitStyles' => 'all',
			],
		],
		'container-settings' => [
			'title' => __( 'Container', 'woocommerce-views' ),
			'colorIndicators' => [
				'containerStyle' => [ 'backgroundColor' ],
			],
			'fields' => [
				'containerStyle' => 'all',
			],
		],
	],
	'attributes' => [
		'containerStyle' => [
			'type' => 'object',
			'fields' => [
				'backgroundColor',
				'margin',
				'padding',
				'border',
				'borderRadius',
				'boxShadow',
			],
		],
		'avatarStyle' => [
			'type' => 'object',
			'fields' => [
				'backgroundColor',
				'margin',
				'padding',
				'border',
				'borderRadius',
				'boxShadow',
			],
		],
		'starsStyle' => [
			'type' => 'object',
			'fields' => [
				'fontSize',
				'active' => [
					'type' => 'textColor',
					'label' => __( 'Active Color', 'woocommerce-views' ),
				],
				'inactive' => [
					'type' => 'textColor',
					'label' => __( 'Inactive Color', 'woocommerce-views' ),
				],
			],
		],
		'metaStyle' => [
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
			],
		],
		'formLabelStyle' => [
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
			],
		],
		'formTitleStyle' => [
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
			],
		],
		'formInputsStyles' => [
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
			],
		],
		'submitStyles' => [
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
			],
		],
		'commentTextStyle' => [
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
						'avatarStyle' => [
							'margin' => [
								'enabled' => true,
								'marginRight' => '20px',
							],
							'padding' => [
								'enabled' => true,
							],
						],
						'starsStyle' => [
							'fontSize' => 16,
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
						'metaStyle' => [
							'fontSize' => 14,
							'textColor' => [
								'r' => 68,
								'g' => 68,
								'b' => 68,
								'a' => 1,
							],
						],
						'commentTextStyle' => [
							'fontSize' => 16,
							'textColor' => [
								'r' => 68,
								'g' => 68,
								'b' => 68,
								'a' => 1,
							],
							'margin' => [
								'enabled' => true,
								'marginTop' => '16px',
								'marginBottom' => '16px',
							],
							'padding' => [
								'enabled' => true,
							],
						],
						'formTitleStyle' => [
							'margin' => [
								'enabled' => true,
								'marginBottom' => '20px',
							],
							'padding' => [
								'enabled' => true,
							],
						],
						'formLabelStyle' => [
							'textColor' => [
								'r' => 68,
								'g' => 68,
								'b' => 68,
								'a' => 1,
							],
							'margin' => [
								'enabled' => true,
								'marginBottom' => '5px',
							],
							'padding' => [
								'enabled' => true,
							],
						],
						'formInputsStyles' => [
							'margin' => [
								'enabled' => true,
								'marginBottom' => '20px',
							],
							'padding' => [
								'enabled' => true,
								'paddingTop' => '0.5em',
								'paddingLeft' => '0.5em',
								'paddingRight' => '0.5em',
								'paddingBottom' => '0.5em',
							],
						],
						'submitStyles' => [
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
								'paddingTop' => '0.4em',
								'paddingBottom' => '0.4em',
								'paddingLeft' => '1.5em',
								'paddingRight' => '1.5em',
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
					'defaults' => [],
				],
			],
		],
	],
];
