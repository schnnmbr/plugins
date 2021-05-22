<?php

namespace WooViews\Shortcode;

class Attributes {
	/** @var array */
	private $attributes = [];

	/**
	 * @param $attributes
	 */
	public function set( $attributes ) {
		$this->attributes = is_array( $attributes ) ?
			$attributes :
			[];
	}


	/**
	 * @param $key
	 * @param string $default
	 *
	 * @return mixed|string
	 */
	public function get( $key, $default = '' ) {
		if( array_key_exists( $key, $this->attributes ) ) {
			return $this->attributes[ $key ];
		}

		return $default;
	}

	/**
	 * @return string
	 */
	public function get_template_source() {
		// Get template-source. If there is no template source it means we have a shortcode created before the source
		// feature. In this case we need to use "WooCommerce" which reflects the old way.
		$source = $this->get( 'template-source', TemplateSource::SOURCE_WOOCOMMERCE );

		// Make sure the source is one of our supported sources.
		if( ! in_array( $source, [ TemplateSource::SOURCE_WOOCOMMERCE, TemplateSource::SOURCE_WOOCOMMERCE ] ) ) {
			// No supported source, use Toolset source.
			return TemplateSource::SOURCE_TOOLSET;
		}

		// All good. Return selected source.
		return $source;
	}
}
