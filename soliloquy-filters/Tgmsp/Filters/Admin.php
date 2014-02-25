<?php
/**
 * Admin class for the Soliloquy Filters Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Filters
 * @author	Thomas Griffin
 */ 
class Tgmsp_Filters_Admin {

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
	
		add_action( 'admin_init', array( $this, 'deactivation' ) );
		add_action( 'tgmsp_save_slider_settings', array( $this, 'apply_image_filters' ), 10, 3 );
	
	}
	
	/**
	 * Deactivate the plugin if Soliloquy is not active and update the recently
	 * activate plugins with our plugin.
	 *
	 * @since 1.0.0
	 */
	public function deactivation() {
		
		/** Don't deactivate when doing a Soliloquy update or when editing Soliloquy from the Plugin Editor */
		if ( Tgmsp_Filters::soliloquy_is_not_active() ) {
			$recent = (array) get_option( 'recently_activated' );
			$recent[plugin_basename( Tgmsp_Filters::get_file() )] = time();
			update_option( 'recently_activated', $recent );
			deactivate_plugins( plugin_basename( Tgmsp_Filters::get_file() ) );
		}
		
	}
	
	/**
	 * Applies the necessary image filters to all image attachments for the slider.
	 *
	 * @since 1.0.0
	 *
	 * @global $array $_wp_additional_image_sizes Image size data added via add_image_size
	 * @param array $settings The current Soliloquy slider settings
	 * @param int $post_id The current post ID
	 * @param object The current post object
	 */
	public function apply_image_filters( $settings, $post_id, $post ) {
	
		global $_wp_additional_image_sizes;
	
		/** Get all the image attachments for the slider and the slider image size */
		$images = Tgmsp_Shortcode::get_images( $post_id, get_post_meta( $post_id, '_soliloquy_settings', true ) );
		if ( empty( $images ) )
			return;
			
		/** Determine the thumbnail slug */
		if ( isset( $settings['custom'] ) && $settings['custom'] )
			$slug = $settings['custom'];
		else
			$slug = 'full';
			
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
				
		/** Loop through the images and create a new image size for the applicable image filter */
		foreach ( $images as $image ) {
			/** Skip over images with no filter */
			if ( ! isset( $image['filter'] ) || isset( $image['filter'] ) && 'none' == $image['filter'] )
				continue;
				
			/** Prepare to pass variables to the image filter factory */
			$meta 	= Tgmsp_Filters_Output::get_metadata( $image['id'] );
			$file 	= wp_upload_dir();
			$path 	= trailingslashit( $file['basedir'] ) . $meta['file'];
			
			/** Send different data based on the slug */
			if ( 'full' == $slug )
				$size = array( 'width' => $image['width'], 'height' => $image['height'], 'crop' => false, 'slug' => $slug );
			else
				$size = array( 'width' => absint( $thumbs[$slug]['width'] ), 'height' => absint( $thumbs[$slug]['height'] ), 'crop' => $thumbs[$slug]['crop'], 'slug' => $slug );
			
			/** Generate the filtered image for the current size setting */
			Tgmsp_Filters::factory( $image['id'], $path, $image['filter'], $size );
		}
	
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