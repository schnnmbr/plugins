<?php
/**
 * Shortcode class for the Soliloquy Filters Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Filters
 * @author	Thomas Griffin
 */
class Tgmsp_Filters_Shortcode {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	
		self::$instance = $this;
		
		/** Return early if Soliloquy is not active */
		if ( Tgmsp_Filters::soliloquy_is_not_active() )
			return;
	
		/** Customize the shortcode output for the image filters */
		add_filter( 'tgmsp_image_data', array( $this, 'filter_data' ), 10, 2 );
		add_filter( 'tgmsp_image_output', array( $this, 'set_image_filters' ), 10, 5 );
	
	}
	
	/**
	 * Send filter data when Soliloquy grabs image meta.
	 *
	 * @since 1.0.0
	 *
	 * @param array $image Image data Soliloquy uses to send to the current slider
	 * @param object $attachment The current attachment object
	 * @return array $image Amended image data with lightbox meta
	 */
	public function filter_data( $image, $attachment ) {
		
		/** Add the image filter to the list of items */
		$image['filter'] = get_post_meta( $image['id'], '_soliloquy_filters_image_filter', true );
		
		return apply_filters( 'tgmsp_filters_data', $image, $attachment );
			
	}
	
	/**
	 * Set filtered images in place if an image filter has been selected.
	 *
	 * @since 1.0.0
	 *
	 * @param string $html The current HTML output for the image
	 * @param int $id The current slider ID
	 * @param array $image Image data for the current image
	 * @param string $alt The current alt tag for the image
	 * @param string $title The current title of the image
	 * @return string $html The amended HTML output if a filtered image was selected
	 */
	public function set_image_filters( $html, $id, $image, $alt, $title ) {
	
		/** Check to see if a filter is available, and if so, let's apply it */
		if ( isset( $image['filter'] ) && ! empty( $image['filter'] ) && 'none' !== $image['filter'] ) {
			$meta = get_post_meta( $id, '_soliloquy_settings', true );
			
			/** Get the correct filtered image size */
			if ( isset( $meta['custom'] ) && $meta['custom'] )
				$src = wp_get_attachment_image_src( $image['id'], 'soliloquy-' . $image['filter'] . '-' . $meta['custom'] );
			else 
				$src = wp_get_attachment_image_src( $image['id'], 'soliloquy-' . $image['filter'] );
			
			/** Generate the new HTML */	
			$html = '<img class="soliloquy-item-image" src="' . esc_url( $src[0] ) . '" alt="' . esc_attr( $alt ) . '" title="' . esc_attr( $title ) . '" />';
		}
		
		/** Return the HTML */
		return $html;
		
	}
		
	/**
	 * Getter method for retrieving the object instance.
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {
	
		return self::$instance;
	
	}
	
}