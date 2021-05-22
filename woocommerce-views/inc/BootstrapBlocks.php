<?php

namespace WooViews;

/**
 * Class BootstrapBlocks
 *
 * Functional bootstraping of the WC blocks.
 *
 * @package WooViews
 */
class BootstrapBlocks {
	/**
	 * Init
	 */
	public function init() {
		add_action( 'init', [ $this, 'do_init' ], -10 );
		add_action( 'admin_init', [ $this, 'admin_init' ], 9 );
	}

	/**
	 * Load WooCommerce Views Blocks.
	 *
	 * @hook init
	 */
	public function do_init() {
		if ( ! class_exists( 'ToolsetCommonEs\Library\WordPress\Actions' ) ) {
			// Common ES not available / old version of Common ES.
			return;
		}
		// Load config.
		if ( file_exists( WOOCOMMERCE_VIEWS_PLUGIN_PATH . '/config.php' ) ) {
			$woocommerce_views_config = include WOOCOMMERCE_VIEWS_PLUGIN_PATH . '/config.php';
			add_filter( 'toolset-blocks-config', function ( $config ) use ( $woocommerce_views_config ) {
				$config['woocommerceViews'] = $woocommerce_views_config;

				return $config;
			}, 1, 10 );
		}

		// Show WC template paths.
		$this->show_template_paths();

		// After Views is enabled.
		add_action( 'init', array( $this, 'setup_blocks' ), 999 );
		add_action( 'init', array( $this, 'setup_blocks_styles' ), 1 );

		// Templates Source.
		$template_source = new \WooViews\Shortcode\TemplateSource(
			new \WooViews\Shortcode\Attributes(),
			new \ToolsetCommonEs\Library\WordPress\Actions(),
			WOOCOMMERCE_VIEWS_PLUGIN_PATH . '/templates'
		);

		add_action( 'wooblocks_action_pre_shortcode_render', [ $template_source, 'pre_shortcode_render' ] );
		add_action( 'wooblocks_action_post_shortcode_render', [ $template_source, 'post_shortcode_render' ] );

		if ( ! is_admin() ) {
			$dic = apply_filters( 'toolset_dic', false );
			$frontend = $dic->make( '\WooViews\PublicDependencies\Frontend' );
			// - ExternalResources
			$frontend->add_content_based_dependency( $dic->make( '\WooViews\PublicDependencies\Dependency\ExternalResources' ) );

			// - Load Dependecies
			$frontend->load();
		}
	}

	/**
	 * Setup
	 */
	public function setup_blocks() {
		// Blocks.
		require WOOCOMMERCE_VIEWS_PLUGIN_PATH . '/inc/wcviews-blocks.php';
		$wcv_blocks = new \WCViews_Blocks();
		$wcv_blocks->initialize();
	}

	/**
	 * Block styles setup
	 */
	public function setup_blocks_styles() {
		// Common ES Blocks Styles - Add Block Factory for blocks of "Toolset Blocks".
		add_filter(
			'toolset_common_es_block_factories',
			function( $block_factories ) {
				$dic = apply_filters( 'toolset_dic', false );

				if ( ! $dic ) {
					return $block_factories;
				}

				// Load block factory.
				try {
					$block_factory = $dic->make( '\WooViews\Block\Style\Factory' );
				} catch ( \Exception $e ) {
					return $block_factories;
				}

				if ( $block_factory ) {
					$block_factories[] = $block_factory;
				}
				return $block_factories;
			},
			10,
			1
		);
	}

	public function admin_init() {
		add_filter( 'toolset_common_es_compatibility_style_backend_editor_rule', function( $rules ) {
			if ( ! is_array( $rules ) ) {
				// Check if something has changed in CommonES.
				return $rules;
			}

			$dic = apply_filters( 'toolset_dic', false );

			if ( ! $dic ) {
				return $rules;
			}

			/** @var \WooViews\Compatibility\FactoryRules $factory_rules */
			$factory_rules = $dic->make( '\WooViews\Compatibility\FactoryRules' );

			return array_merge( $rules, $factory_rules->get_rules() );
		} );
	}

	/**
	 * Show template paths.
	 *
	 * Add to wp-config.php:
	 * define( 'WC_VIEWS_DISPLAY_TOOLSET_TEMPLATE_PATH', true );
	 */
	private function show_template_paths() {
		if ( defined( 'WC_VIEWS_DISPLAY_TOOLSET_TEMPLATE_PATH' ) && WC_VIEWS_DISPLAY_TOOLSET_TEMPLATE_PATH ) {
			$echo_template = function( $template, $name, $args, $template_path = null ) {
				preg_match( '#(?:plugins|themes).(.*)#', $template, $matches );

				$border_color = preg_match( '#woocommerce-views#', $template ) ?
					'#ed793e' :
					'grey';

				echo '<div style="' .
					 'font-family: monospace;' .
					 'font-size: 11px;' .
					 'border-left: 2px solid ' . $border_color . ';' .
					 'color: black;' .
					 'padding-left: 10px;' .
					 'margin: 2px;"' .
					 '>' . $matches[1] . '</div>';
				return $template;
			};

			add_filter(
				'wc_get_template',
				$echo_template,
				PHP_INT_MAX,
				4
			);
			add_filter(
				'wc_get_template_part',
				$echo_template,
				PHP_INT_MAX,
				4
			);
		}
	}
}
