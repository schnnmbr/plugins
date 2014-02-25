<?php
/**
 * Preview class for the Soliloquy Filters Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Filters
 * @author	Thomas Griffin
 */
class Tgmsp_Filters_Preview {

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
		
		add_action( 'tgmsp_preview_start', array( $this, 'preview_init' ) );
	
	}
	
	/**
	 * Init callback to make sure that filters and hooks are only executed in the Preview
	 * context.
	 *
	 * @since 1.0.0
	 *
	 * @param array $post_var The $_POST data from the Ajax request
	 */
	public function preview_init( $post_var ) {
	
		/** Only execute if there is a lightbox instance to process */
		foreach ( $post_var as $var ) {
			if ( is_array( $var ) ) {
				if ( isset( $var['soliloquy-filters-image-filter'] ) && 'none' !== $var['soliloquy-filters-image-filter'] ) {
					add_filter( 'tgmsp_image_output', array( $this, 'set_image_filters' ), 10, 6 );
					break;
				}
			}
		}
	
	}
	
	/**
	 * Set filtered images in place if an image filter has been selected. This method is customized
	 * for the Preview functionality part of the Addon.
	 *
	 * @since 1.0.0
	 *
	 * @global $array $_wp_additional_image_sizes Image size data added via add_image_size
	 * @param string $html The current HTML output for the image
	 * @param int $id The current slider ID
	 * @param array $image Image data for the current image
	 * @param string $alt The current alt tag for the image
	 * @param string $title The current title of the image
	 * @param array $post_var The current $_POST data submitted via Ajax
	 * @return string $html The amended HTML output if a filtered image was selected
	 */
	public function set_image_filters( $html, $id, $image, $alt, $title, $post_var ) {
	
		global $_wp_additional_image_sizes;
	
		/** Check to see if a filter is available, and if so, let's apply it */
		if ( isset( $post_var['soliloquymeta-' . $image['id']]['soliloquy-filters-image-filter'] ) && 'none' !== $post_var['soliloquymeta-' . $image['id']]['soliloquy-filters-image-filter'] ) {
			/** Get all registered image size data to send to the factory */
			foreach ( get_intermediate_image_sizes() as $size ) {
				$thumbs[$size] = array( 'width' => '', 'height' => '', 'crop' => false );
			
				if ( isset( $_wp_additional_image_sizes[$size]['width'] ) )
					$thumbs[$size]['width'] = absint( $_wp_additional_image_sizes[$size]['width'] );
				else
					$thumbs[$size]['width'] = get_option( $size . '_size_w' );
				
				if ( isset( $_wp_additional_image_sizes[$size]['height'] ) )
					$thumbs[$size]['height'] = absint( $_wp_additional_image_sizes[$size]['height'] );
				else
					$thumbs[$size]['height'] = get_option( $size . '_size_h' );
				
				if ( isset( $_wp_additional_image_sizes[$size]['crop'] ) )
					$thumbs[$size]['crop'] = absint( $_wp_additional_image_sizes[$size]['crop'] );
				else
					$thumbs[$size]['crop'] = get_option( $size . '_crop' );
			}
			
			/** We need to generate a filtered image now */
			$meta 	= Tgmsp_Filters_Output::get_metadata( $image['id'] );
			$file 	= wp_upload_dir();
			$path 	= trailingslashit( $file['basedir'] ) . $meta['file'];
			if ( isset( $post_var['soliloquy-default-size'] ) && 'default' == $post_var['soliloquy-default-size'] ||isset( $post_var['soliloquy-default-size'] ) && 'custom' == $post_var['soliloquy-default-size'] && 'full' == $post_var['soliloquy-custom-size'] )
				$size = array( 'width' => $image['width'], 'height' => $image['height'], 'crop' => false, 'slug' => 'full' );
			else
				$size = array( 'width' => absint( $thumbs[$post_var['soliloquy-custom-size']]['width'] ), 'height' => absint( $thumbs[$post_var['soliloquy-custom-size']]['height'] ), 'crop' => $thumbs[$post_var['soliloquy-custom-size']]['crop'], 'slug' => $post_var['soliloquy-custom-size'] );
			
			/** Generate the filtered image so that it can appear in the Preview */
			Tgmsp_Filters::factory( $image['id'], $path, $post_var['soliloquymeta-' . $image['id']]['soliloquy-filters-image-filter'], $size );
			
			/** Get the correct filtered image size */
			if ( isset( $post_var['soliloquy-default-size'] ) && 'custom' == $post_var['soliloquy-default-size'] )
				$src = wp_get_attachment_image_src( $image['id'], 'soliloquy-' . $post_var['soliloquymeta-' . $image['id']]['soliloquy-filters-image-filter'] . '-' . $post_var['soliloquy-custom-size'] );
			else 
				$src = wp_get_attachment_image_src( $image['id'], 'soliloquy-' . $post_var['soliloquymeta-' . $image['id']]['soliloquy-filters-image-filter'] );
			
			/** Generate the new HTML */	
			$html = '<img class="soliloquy-item-image" src="' . esc_url( $src[0] ) . '" alt="' . esc_attr( $post_var['soliloquymeta-' . $image['id']]['soliloquy-alt'] ) . '" title="' . esc_attr( $post_var['soliloquymeta-' . $image['id']]['soliloquy-title'] ) . '" />';
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