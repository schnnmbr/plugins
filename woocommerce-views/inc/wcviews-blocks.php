<?php // phpcs:ignore
/**
 * Class for handling WooCommerce Views Gutenberg blocks
 *
 * @package WooViews
 */
use WooViews\Rest\Api;

/**
 * Handles WooCommerce Views Blocks
 */
class WCViews_Blocks {
	const WOOVIEWS_CATEGORY_SLUG           = 'woocommerce-views';
	const WOOVIEWS_BLOCK_NAMESPACE         = 'woocommerce-views';
	const WOOVIEWS_BLOCK_EDITOR_JS_HANDLE  = 'woocommerce_views-block-js';
	const WOOVIEWS_BLOCK_EDITOR_CSS_HANDLE = 'woocommerce_views-block-editor-css';
	const WOOVIEWS_BLOCK_CSS_HANDLE        = 'woocommerce_views-block-style-css';

	/**
	 * Rest API
	 *
	 * @var \WooViews\Rest\Api
	 */
	private $rest_api;

	/**
	 * Add the necessary hooks for the plugin initialization.
	 */
	public function initialize() {
		// Do nothing if Views is not installed, even if other Toolset PLugins providing DIC are available.
		if ( ! defined( 'WPV_VERSION' ) ) {
			return;
		}

		if ( ! defined( 'WV_BUNDLED_SCRIPT_PATH' ) ) {
			define( 'WV_BUNDLED_SCRIPT_PATH', WOOCOMMERCE_VIEWS_PLUGIN_URL . 'public/js' );
			define( 'WV_HMR_RUNNING', false );
		} else {
			define( 'WV_HMR_RUNNING', true );
		}

		add_filter( 'block_categories', array( $this, 'register_toolset_blocks_category' ), 20 );
		$this->enqueue_block_assets();
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );

		$dic = apply_filters( 'toolset_dic', false );

		// Views must be enabled, if dic is false, the client is using WCV without Views or an very old version of Views.
		if ( false === $dic ) {
			return;
		}

		$this->rest_api = $dic->make( '\WooViews\Rest\Api' );
		$this->rest_api->add_route( $dic->make( '\WooViews\Rest\Route\ShortcodeRender' ) );

		add_action( 'rest_api_init', array( $this, 'rest_api_init' ) );
	}

	/**
	 * Register the Toolset blocks category.
	 *
	 * @param array $categories The array with the categories of the Gutenberg widgets.
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function register_toolset_blocks_category( $categories ) {
		if ( ! array_search( self::WOOVIEWS_CATEGORY_SLUG, array_column( $categories, 'slug' ), true ) ) {
			$categories = array_merge(
				$categories,
				array(
					array(
						'slug'  => self::WOOVIEWS_CATEGORY_SLUG,
						'title' => __( 'Toolset WooCommerce', 'woocommerce_views' ),
					),
				)
			);
		}

		return $categories;
	}

	/**
	 * Enqueue Gutenberg block assets for backend editor.
	 *
	 * @uses {wp-blocks} for block type registration & related functions.
	 * @uses {wp-element} for WP Element abstraction — structure of blocks.
	 * @uses {wp-i18n} to internationalize the block's text.
	 * @uses {wp-editor} for WP editor styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_block_editor_assets() {
		global $post, $wpdb, $wp_rest;

		// Editor Scripts.
		$script_dependencies = array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
			'wp-editor',
			'toolset-common-es',
		);

		// This is no longer needed when this bug is fixed:
		// https://github.com/webpack-contrib/mini-css-extract-plugin/issues/147 .
		$script_dependencies = $this->workaround_webpack4_bug( $script_dependencies );

		wp_enqueue_script(
			self::WOOVIEWS_BLOCK_EDITOR_JS_HANDLE,
			WV_BUNDLED_SCRIPT_PATH . '/blocks.js',
			$script_dependencies,
			WC_VIEWS_VERSION,
			true // Enqueue the script in the footer.
		);

		$view_id = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT DISTINCT post_id FROM {$wpdb->postmeta}
				WHERE meta_key = '_view_loop_template'
				AND meta_value = %d",
				$post->ID
			)
		);

		$post_type      = $post->post_type;
		$views_settings = 'view-template' === $post_type ?
			apply_filters( 'wpv_filter_wpv_get_view_settings', [], $view_id ) :
			[];

		$shortcodes_gui = new WCViews_shortcodes_gui();

		$localization_array = array(
			'namespace'           => self::WOOVIEWS_BLOCK_NAMESPACE,
			'category'            => self::WOOVIEWS_CATEGORY_SLUG,
			'views_settings'      => $views_settings,
			'wp_rest_nonce'       => wp_create_nonce( 'wp_rest' ),
			'routes'              => $this->rest_api->get_routes_paths(),
			'shortcodes_settings' => $shortcodes_gui->get_shortcodes_data(),
		);

		wp_localize_script(
			self::WOOVIEWS_BLOCK_EDITOR_JS_HANDLE,
			'wooViewsData',
			$localization_array
		);

		wp_set_script_translations( self::WOOVIEWS_BLOCK_EDITOR_JS_HANDLE, 'woocommerce_views', WOOCOMMERCE_VIEWS_PATH . '/languages/' );

		// Hot Module Replacement.
		if ( ! WV_HMR_RUNNING ) {
			// Only load css when hmr is NOT active, otherwise it's included in the js.
			wp_enqueue_style(
				self::WOOVIEWS_BLOCK_EDITOR_CSS_HANDLE,
				WOOCOMMERCE_VIEWS_PLUGIN_URL . 'public/css/edit.css',
				array(
					'wp-edit-blocks',
					'toolset-common-es',
				),
				WC_VIEWS_VERSION
			);
		} else {
			// if HMR is loaded we still need to load Toolset Common Es style.
			wp_enqueue_style( 'toolset-common-es' );
		}
	}

	/**
	 * Enqueue Gutenberg block assets for both frontend + backend.
	 *
	 * @uses {wp-editor} for WP editor styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_block_assets() {
		if ( WV_HMR_RUNNING && is_admin() ) {
			// Not needed when hmr is active.
			return;
		}

		// Frontend Styles.
		wp_enqueue_style(
			self::WOOVIEWS_BLOCK_CSS_HANDLE,
			WOOCOMMERCE_VIEWS_PLUGIN_URL . 'public/css/style.css',
			array( 'wp-editor', 'toolset-common-es' ),
			WC_VIEWS_VERSION
		);
	}

	/**
	 * Workaround for Webpack4 issue
	 * https://github.com/webpack-contrib/mini-css-extract-plugin/issues/147
	 *
	 * Once issue is fixed we can also remove /public/js/edit.js and
	 * /public/js/style.js from our repo.
	 *
	 * @param array $script_dependencies Previous depencencies.
	 * @return array
	 */
	private function workaround_webpack4_bug( $script_dependencies ) {
		if ( WV_HMR_RUNNING ) {
				// Not needed when hmr is active.
				return $script_dependencies;
		}

		wp_register_script(
			'woocommerce_views-block-edit-js',
			WV_BUNDLED_SCRIPT_PATH . '/edit.js',
			[],
			WC_VIEWS_VERSION,
			true
		);

		wp_register_script(
			'woocommerce_views-block-style-js',
			WV_BUNDLED_SCRIPT_PATH . '/style.js',
			[],
			WC_VIEWS_VERSION,
			true
		);

		$script_dependencies[] = 'woocommerce_views-block-edit-js';
		$script_dependencies[] = 'woocommerce_views-block-style-js';

		return $script_dependencies;
	}

	/**
	 * Loads Rest API if in dashboard.
	 */
	public function rest_api_init() {
		// Backend (is_admin() does not work on rest requests itself, so we also need to load on any rest request).
		if ( is_admin() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
			$this->rest_api->rest_api_init();
		}
	}
}
