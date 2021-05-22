<?php

namespace WooViews\Shortcode;

use ToolsetCommonEs\Library\WordPress\Actions;

/**
 * Class TemplateSource
 *
 * With 2.9.0 we added the option to switch for wooviews shortcodes the templates source. The problem
 * was that WooCommerce templates (plus themes overwriting them) are not displayed in the backend as they're
 * displayed on the frontend.
 * When the user selects to use Toolset as template source (default for new blocks), he will have a much better
 * backend / frontend experience.
 *
 * @package WooViews\Shortcode
 * @since 2.9.0
 */
class TemplateSource {
	const SOURCE_WOOCOMMERCE = 'woocommerce';
	const SOURCE_TOOLSET = 'toolset';

	/** @var Attributes */
	private $attributes;

	/** @var Actions */
	private $wp_actions;

	/** @var string */
	private $template_path;

	/**
	 * TemplateSource constructor.
	 *
	 * @param Attributes $attributes
	 * @param Actions $wp_actions
	 * @param $template_path
	 */
	public function __construct( Attributes $attributes, Actions $wp_actions, $template_path ) {
		$this->attributes = $attributes;
		$this->wp_actions = $wp_actions;
		$this->template_path = $template_path;
	}

	/**
	 * Checks if the 'template-source' shortcode attribute is 'toolset'.
	 */
	private function is_toolset() {
		return $this->attributes->get_template_source() === self::SOURCE_TOOLSET;
	}

	/**
	 * Called before running shortcode render function.
	 * Tasks:
	 *  - applies a filter to overwrite the template source if Toolset is wanted as source.
	 *
	 * @param $atts
	 */
	public function pre_shortcode_render( $atts ) {
		$this->attributes->set( $atts );

		if ( ! $this->is_toolset() ) {
			// No Toolset source.
			return;
		}

		$this->wp_actions->add_filter(
			'wc_get_template',
			array( $this, 'filter_wc_get_template_to_use_toolset_templates' ),
			PHP_INT_MAX - 1,
			4
		);

		$this->wp_actions->add_filter(
			'wc_get_template_part',
			array( $this, 'filter_wc_get_template_to_use_toolset_templates_part' ),
			PHP_INT_MAX - 1,
			3
		);
	}

	/**
	 * Called after running shortcode render function.
	 * Tasks:
	 *  - remove filter to overwrite template.
	 *
	 * @param $atts
	 */
	public function post_shortcode_render( $atts = null ) {
		if ( is_array( $atts ) ) {
			$this->attributes->set( $atts );
		}

		if ( ! $this->is_toolset() ) {
			// No toolset source. Abort without doing remove_filter(), which is way more heavy than is_toolset_source().
			return;
		}

		$this->wp_actions->remove_filter(
			'wc_get_template',
			array( $this, 'filter_wc_get_template_to_use_toolset_templates' ),
			PHP_INT_MAX - 1
		);

		$this->wp_actions->remove_filter(
			'wc_get_template_part',
			array( $this, 'filter_wc_get_template_to_use_toolset_templates_part' ),
			PHP_INT_MAX - 1
		);
	}

	/**
	 * Filter callback to switch to our templates instead of using WooCommerce & theme ones.
	 *
	 * @filter wc_get_template
	 *
	 * @param $template
	 * @param $name
	 * @param $args
	 * @param $template_path
	 *
	 * @return string|string[]
	 *
	 * @since 2.9.0
	 */
	public function filter_wc_get_template_to_use_toolset_templates( $template, $name, $args, $template_path = null ) {
		$toolset_template_path = $this->template_path . '/' . $name;

		if ( file_exists( $toolset_template_path ) ) {
			// Toolset template exists.
			return $toolset_template_path;
		}

		// Toolset template does not exist. Return original input.
		return $template;
	}

	/**
	 * Filter callback to switch to our templates parts instead of using WooCommerce & theme ones.
	 *
	 * @filter wc_get_template_part
	 *
	 * @param $template - Template path
	 * @param $slug - Template slug
	 * @param $name - Template name
	 *
	 * @return string|string[]
	 *
	 * @since 2.9.0
	 */
	public function filter_wc_get_template_to_use_toolset_templates_part( $template, $slug, $name ) {
		$file = "{$slug}-{$name}.php";
		$toolset_template_path = $this->template_path . '/' . $file;

		if ( file_exists( $toolset_template_path ) ) {
			// Toolset template exists.
			return $toolset_template_path;
		}

		// Toolset template does not exist. Return original input.
		return $template;
	}
}
