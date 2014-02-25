<?php
/**
 * Shortcode class for the Soliloquy Crop Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Crop
 * @author	Thomas Griffin
 */
class Tgmsp_Crop_Shortcode {

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
		if ( Tgmsp_Crop::soliloquy_is_not_active() )
			return;

		/** Customize the shortcode output for the image filters */
		add_filter( 'tgmsp_get_image_data', array( $this, 'get_full_image' ), 100, 4 );
		add_filter( 'tgmsp_image_data', array( $this, 'filter_data' ), 100, 3 );

	}

	/**
	 * Force a full size image when using the "cropped" size.
	 *
	 * @since 1.0.0
	 *
	 * @param string $image Image HTML string
	 * @param int $id The current slider ID
	 * @param object $attachment The current image attachment
	 * @param string $size The size of image to retrieve
	 * @return string $image Amended image HTML for the full size image
	 */
	public function get_full_image( $image, $id, $attachment, $size ) {

		$meta = get_post_meta( $id, '_soliloquy_settings', true );
		if ( isset( $meta['default'] ) && 'cropped' !== $meta['default'] || did_action( 'tgmsp_preview_start' ) )
			return $image;

		return isset( $meta['type'] ) && 'featured' == $meta['type'] ? wp_get_attachment_image_src( get_post_thumbnail_id( $attachment->ID ), 'full' ) : wp_get_attachment_image_src( $attachment->ID, 'full' );

	}

	/**
	 * Send filter data when Soliloquy grabs image meta.
	 *
	 * @since 1.0.0
	 *
	 * @param array $image Image data Soliloquy uses to send to the current slider
	 * @param object $attachment The current attachment object
	 * @param int $slider_id The current slider ID
	 * @return array $image Amended image data with Crop src (if needed)
	 */
	public function filter_data( $image, $attachment, $slider_id ) {

		/** Return early if "cropped" is not the size chosen. */
		$meta = get_post_meta( $slider_id, '_soliloquy_settings', true );
		if ( isset( $meta['default'] ) && 'cropped' !== $meta['default'] || did_action( 'tgmsp_preview_start' ) )
			return $image;

		// If we have made it this far, we know we are about to use Crop, so define some constants for Crop.
		if ( ! defined( 'MEMORY_LIMIT' ) ) 			define( 'MEMORY_LIMIT', '128M' );
		if ( ! defined( 'ALLOW_EXTERNAL' ) ) 		define( 'ALLOW_EXTERNAL', false );
		if ( ! defined( 'FILE_CACHE_DIRECTORY' ) ) 	define( 'FILE_CACHE_DIRECTORY', Tgmsp_Crop::soliloquy_uploads_dir() . '/cache' );

		// Get Crop crop alignment setting.
		$tim 		= get_post_meta( $slider_id, '_soliloquy_crop', true );
		$url		= $image['src'];
		$args		= apply_filters( 'tgmsp_crop_image_args', array(
			'src' 	=> esc_url( $url ),
			'a'		=> isset( $tim['crop_position'] ) ? $tim['crop_position'] : 'c',
			'w'		=> isset( $meta['width'] ) ? $meta['width'] : 600,
			'h'		=> isset( $meta['height'] ) ? $meta['height'] : 600,
			'q'		=> 100
		) );
		$image['src'] = add_query_arg( $args, Tgmsp_Crop::get_crop_file_url() );

		return apply_filters( 'tgmsp_crop_data', $image, $attachment, $slider_id );

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