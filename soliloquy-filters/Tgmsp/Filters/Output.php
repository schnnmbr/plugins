<?php
/**
 * Output class for the Soliloquy Filters Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Filters
 * @author	Thomas Griffin
 */
class Tgmsp_Filters_Output {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $instance;
	
	/**
	 * Holds a copy of the current image meta.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $meta;
	
	/**
	 * WordPress version to determine how we generate images.
	 *
	 * @since 1.0.5
	 *
	 * @var string
	 */
	protected $version;

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 1.0.0
	 *
	 * @param int $id The image attachment ID
	 * @param string $image The real path to the image being filtered
	 * @param string $filter The type of filter to be applied to the image
	 * @param array $size The width and height dimensions for the image (plus crop mode)
	 */
	public function __construct( $id, $image, $filter, $size ) {
	
		self::$instance = $this;
		
		/** Return early if Soliloquy is not active */
		if ( Tgmsp_Filters::soliloquy_is_not_active() )
			return;
		
		// Set the version to determine how we process images.	
		global $wp_version;
		$this->version = $wp_version;
		
		/** Only process the image if it truly exists */
		if ( @file_exists( $image ) )
			$this->apply_image_filters( $id, $image, $filter, $size );
	
	}
	
	/**
	 * Applies an image filter to the specified image. 
	 *
	 * @since 1.0.0
	 *
	 * @param int $id The image attachment ID
	 * @param string $image The real path to the image being filtered
	 * @param string $filter The type of filter to be applied to the image
	 * @param array $size The width and height dimensions for the image (plus crop mode)
	 */
	protected function apply_image_filters( $id, $image, $filter, $size ) {
	
		/** Set our meta property with the image attachment meta already stored */
		$this->meta = $this->get_metadata( $id );
		$new_file 	= substr( $image, 0, -4 ) . '-' . $size['slug'] . '-' . $filter . substr( $image, -4 );
		
		/** If the filtered image has already been created for this size and still exists, return early */
		if ( isset( $this->meta['sizes']['soliloquy-' . $filter] ) && ! empty( $this->meta['sizes']['soliloquy-' . $filter] ) && @file_exists( $new_file ) || isset( $this->meta['sizes']['soliloquy-' . $filter . '-' . $size['slug']] ) && ! empty( $this->meta['sizes']['soliloquy-' . $filter . '-' . $size['slug']] ) && @file_exists( $new_file ) )
			return;
			
		/** Provide a hook for addons to access */
		do_action( 'tgmsp_filters_start', $id, $image, $filter, $size, $this->meta );
			
		/** Prepare variables to be used for filtering */
		$path = wp_upload_dir();
		$path = $path['path'];
		list( $orig_w, $orig_h, $orig_type ) = @getimagesize( $image );
		
		/** Generate the new image and return the image resource */
		$new_image = $this->get_new_image( $image, $orig_type );
		
		/** Apply the filter to the image */
		if ( $this->apply_filter( $new_image, $filter ) )
			$this->generate_filtered_image( $new_image, $new_file, $orig_type );
			
		/** Apply the changes and make the updates */
		if ( isset( $size['slug'] ) && 'full' == $size['slug'] ) {
			$this->meta['sizes']['soliloquy-' . $filter] = array( 'file' => substr( strrchr( $new_file, '/' ), 1 ), 'width' => $orig_w, 'height' => $orig_h, 'path' => $path );
			
			/** Destroy the image resource to free up memory */
			imagedestroy( $new_image );
		} else {
			$thumb = image_resize( $new_file, $size['width'], $size['height'], $size['crop'] );
			
			/** Return early if there is an error creating the image */
			if ( is_wp_error( $thumb ) )
				return new WP_Error( 'filter-error', Tgmsp_Filters_Strings::get_instance()->strings['filter_error'] );
				
			list( $thumb_w, $thumb_h ) = @getimagesize( $thumb );
			$this->meta['sizes']['soliloquy-' . $filter . '-' . $size['slug']] = array( 'file' => wp_basename( $thumb ), 'width' => $thumb_w, 'height' => $thumb_h, 'path' => $path );
			
			/** Destroy the image resource to free up memory and remove the generated file */
			imagedestroy( $new_image );
			@unlink( $new_file );
		}
		
		/** Update the image metadata with our new filter */
		$this->update_metadata( $id, $this->meta );
		
		/** Provide a hook once the entire process has been completed */
		do_action( 'tgmsp_filters_end', $id, $image, $filter, $size, $this->meta );
	
	}
	
	/**
	 * Helper function for generating and returning the new image resource needed
	 * for filtering.
	 *
	 * @since 1.0.0
	 *
	 * @param string $image The path to the normal image
	 * @param int $type A defined constant to determine the type of image being filtered
	 * @return resource An image resource
	 */
	protected function get_new_image( $image, $type ) {
	
		/** Generate the image resource */
		switch ( $type ) {
			case IMAGETYPE_GIF :
				$resource = imagecreatefromgif( $image );
				break;
			case IMAGETYPE_JPEG :
				$resource = imagecreatefromjpeg( $image );
				break;
			case IMAGETYPE_PNG :
				$resource = imagecreatefrompng( $image );
				break;
			default :
				$resource = apply_filters( 'tgmsp_filters_new_image_type', $image, $type );
				break;
		}
		
		/** Return the new image resource */
		return $resource;
	
	}
	
	/**
	 * Applies the image filter to the generated image.
	 *
	 * @since 1.0.0
	 *
	 * @param string $image The path to the normal image
	 * @param string $filter The type of filter to be applied to the image
	 * @return bool True on success, false on failure
	 */
	protected function apply_filter( $image, $filter ) {
	
		switch ( $filter ) {
			case 'brighten_25' :
				if ( imagefilter( $image, IMG_FILTER_BRIGHTNESS, 25 ) )
					return true;
				break;
			case 'brighten_50' :
				if ( imagefilter( $image, IMG_FILTER_BRIGHTNESS, 50 ) )
					return true;
				break;
			case 'brighten_75' :
				if ( imagefilter( $image, IMG_FILTER_BRIGHTNESS, 75 ) )
					return true;
				break;
			case 'brighten_100' :
				if ( imagefilter( $image, IMG_FILTER_BRIGHTNESS, 100 ) )
					return true;
				break;
			case 'colorize_blue' :
				if ( imagefilter( $image, IMG_FILTER_COLORIZE, 0, 0, 100 ) )
					return true;
				break;
			case 'colorize_green' :
				if ( imagefilter( $image, IMG_FILTER_COLORIZE, 0, 100, 0 ) )
					return true;
				break;
			case 'colorize_purple' :
				if ( imagefilter( $image, IMG_FILTER_COLORIZE, 50, -50, 50 ) )
					return true;
				break;
			case 'colorize_red' :
				if ( imagefilter( $image, IMG_FILTER_COLORIZE, 100, 0, 0 ) )
					return true;
				break;
			case 'colorize_yellow' :
				if ( imagefilter( $image, IMG_FILTER_COLORIZE, 100, 100, -100 ) )
					return true;
				break;
			case 'contrast' :
				if ( imagefilter( $image, IMG_FILTER_CONTRAST, -25 ) )
					return true;
				break;
			case 'emboss' :
				if ( imagefilter( $image, IMG_FILTER_EMBOSS ) )
					return true;
				break;
			case 'emboss_edge' :
				if ( imagefilter( $image, IMG_FILTER_EDGEDETECT ) )
					return true;
				break;
			case 'gaussian_blur' :
				if ( imagefilter( $image, IMG_FILTER_GAUSSIAN_BLUR ) )
					return true;
				break;
			case 'grayscale' :
				if ( imagefilter( $image, IMG_FILTER_GRAYSCALE ) )
					return true;
				break;
			case 'grayscale_blue' :
				$this->grayscale_blue( $image );
				return true;
				break;
			case 'grayscale_green' :
				$this->grayscale_green( $image );
				return true;
				break;
			case 'grayscale_red' :
				$this->grayscale_red( $image );
				return true;
				break;
			case 'mean_removal' :
				if ( imagefilter( $image, IMG_FILTER_MEAN_REMOVAL ) )
					return true;
				break;
			case 'photo_negative' :
				if ( imagefilter( $image, IMG_FILTER_NEGATE ) )
					return true;
				break;
			case 'selective_blur' :
				if ( imagefilter( $image, IMG_FILTER_SELECTIVE_BLUR ) )
					return true;
				break;
			case 'sepia' :
				$this->sepia( $image );
				return true;
				break;
			case 'sepia_100_50' :
				if ( imagefilter( $image, IMG_FILTER_GRAYSCALE ) && imagefilter( $image, IMG_FILTER_COLORIZE, 100, 50, 0 ) )
					return true;
				break;
			case 'sepia_100_70_50' :
				if ( imagefilter( $image, IMG_FILTER_GRAYSCALE ) && imagefilter( $image, IMG_FILTER_COLORIZE, 100, 70, 50 ) )
					return true;
				break;
			case 'sepia_90_60_30' :
				if ( imagefilter( $image, IMG_FILTER_GRAYSCALE ) && imagefilter( $image, IMG_FILTER_COLORIZE, 90, 60, 30 ) )
					return true;
				break;
			case 'sepia_60_60' :
				if ( imagefilter( $image, IMG_FILTER_GRAYSCALE ) && imagefilter( $image, IMG_FILTER_COLORIZE, 60, 60, 0 ) )
					return true;
				break;
			case 'sepia_90_90' :
				if ( imagefilter( $image, IMG_FILTER_GRAYSCALE ) && imagefilter( $image, IMG_FILTER_COLORIZE, 90, 90, 0 ) )
					return true;
				break;
			case 'sepia_45_45' :
				if ( imagefilter( $image, IMG_FILTER_GRAYSCALE ) && imagefilter( $image, IMG_FILTER_COLORIZE, 45, 45, 0 ) )
					return true;
				break;
			case 'smooth' :
				if ( imagefilter( $image, IMG_FILTER_SMOOTH, 50 ) )
					return true;
				break;
			default :
				do_action( 'tgmsp_filters_apply_image_filter', $image, $filter );
				break;
		}
		
		/** If we get here, the image filtering has failed, so return false */
		return false;
	
	}
	
	/**
	 * Generates the newly filtered image.
	 *
	 * @since 1.0.0
	 *
	 * @param string $image The path to the normal image
	 * @param string $file The new location path of the filtered image
	 * @param int $type A defined constant to determine the type of image being filtered
	 * @return bool True on success, false on failure
	 */
	protected function generate_filtered_image( $image, $file, $type ) {
	
		/** Generate the filtered image */
		switch ( $type ) {
			case IMAGETYPE_GIF :
				imagegif( $image, $file );
				break;
			case IMAGETYPE_JPEG :
				imagejpeg( $image, $file, apply_filters( 'tgmsp_filters_jpeg_quality', 90 ) );
				break;
			case IMAGETYPE_PNG :
				imagealphablending( $image, false );
				imagesavealpha( $image, true );
				imagepng( $image, $file );
				break;
			default :
				do_action( 'tgmsp_filters_generate_filtered_image', $image, $file, $type );
				break;
		}
	
	}
	
	/**
	 * Helper function for adding a sepia filter to the image. This function is taken from
	 * the ImageFX plugin.
	 *
	 * @since 1.0.0
	 *
	 * @link http://wordpress.org/extend/plugins/imagefx/
	 *
	 * @param string $image The image to be filtered
	 */
	protected function sepia( $image ) {
	
		$width  = imagesx( $image );
		$height = imagesy( $image );
		
		for ( $_x = 0; $_x < $width; $_x++ ) {
			for ( $_y = 0; $_y < $height; $_y++ ) {
				$rgb = imagecolorat( $image, $_x, $_y );
				$r   = ($rgb>>16)&0xFF;
				$g   = ($rgb>>8)&0xFF;
				$b   = $rgb&0xFF;

				$y   = $r * 0.299 + $g * 0.587 + $b * 0.114;
				$i   = 0.15 * 0xFF;
				$q   = - 0.001 * 0xFF;

				$r   = $y + 0.956 * $i + 0.621 * $q;
				$g   = $y - 0.272 * $i - 0.647 * $q;
				$b   = $y - 1.105 * $i + 1.702 * $q;

				if ( $r < 0 || $r > 0xFF ) { $r = ( $r < 0 ) ? 0 : 0xFF; }
				if ( $g < 0 || $g > 0xFF ) { $g = ( $g < 0 ) ? 0 : 0xFF; }
				if ( $b < 0 || $b > 0xFF ) { $b = ( $b < 0 ) ? 0 : 0xFF; }

				$color = imagecolorallocate( $image, $r, $g, $b );
				imagesetpixel( $image, $_x, $_y, $color );
			}
		}
	
	}
	
	/**
	 * Helper function for adding a grayscale (minus blue) filter to the image. This function is taken from
	 * the ImageFX plugin.
	 *
	 * @since 1.0.0
	 *
	 * @link http://wordpress.org/extend/plugins/imagefx/
	 *
	 * @param string $image The image to be filtered
	 */
	protected function grayscale_blue( $image ) {
	
		$width  = imagesx( $image );
    	$height = imagesy( $image );
    	
    	for ( $x = 0; $x < $width; $x++ ) {
        	for ( $y = 0; $y < $height; $y++ ) {
            	$rgb = imagecolorat( $image, $x, $y );
            	$r   = ($rgb>>16)&0xFF;
            	$g   = ($rgb>>8)&0xFF;
            	$b   = $rgb&0xFF;
            	$bw  = ( int ) ( ( $r + $g + $b ) / 3 );
            	if ( ! ( $b > ( $g + $r ) * .5 ) ) { 
            		$color = imagecolorallocate( $image, $bw, $bw, $bw );
            		imagesetpixel( $image, $x, $y, $color );
            	}
        	}
    	}
	
	}
	
	/**
	 * Helper function for adding a grayscale (minus green) filter to the image. This function is taken from
	 * the ImageFX plugin.
	 *
	 * @since 1.0.0
	 *
	 * @link http://wordpress.org/extend/plugins/imagefx/
	 *
	 * @param string $image The image to be filtered
	 */
	protected function grayscale_green( $image ) {
	
		$width  = imagesx( $image );
    	$height = imagesy( $image );
    	
    	for ( $x = 0; $x < $width; $x++ ) {
        	for ( $y = 0; $y < $height; $y++ ) {
            	$rgb = imagecolorat( $image, $x, $y );
            	$r   = ($rgb>>16)&0xFF;
            	$g   = ($rgb>>8)&0xFF;
            	$b   = $rgb&0xFF;
            	$bw  = ( int ) ( ( $r + $g + $b ) / 3 );
            	if ( ! ( $g > ( $r + $b ) * 2 ) ) { 
            		$color = imagecolorallocate( $image, $bw, $bw, $bw );
            		imagesetpixel( $image, $x, $y, $color );
            	}
        	}
    	}
	
	}
	
	/**
	 * Helper function for adding a grayscale (minus red) filter to the image. This function is taken from
	 * the ImageFX plugin.
	 *
	 * @since 1.0.0
	 *
	 * @link http://wordpress.org/extend/plugins/imagefx/
	 *
	 * @param string $image The image to be filtered
	 */
	protected function grayscale_red( $image ) {
	
		$width  = imagesx( $image );
    	$height = imagesy( $image );
    	
    	for ( $x = 0; $x < $width; $x++ ) {
        	for( $y = 0; $y < $height; $y++ ) {
            	$rgb = imagecolorat( $image, $x, $y );
            	$r   = ($rgb>>16)&0xFF;
            	$g   = ($rgb>>8)&0xFF;
            	$b   = $rgb&0xFF;
            	$bw  = ( int )( ( $r + $g + $b ) / 3 );
            	if ( ! ( $r > ( $g + $b ) * 2.2 ) ) { 
            		$color = imagecolorallocate( $image, $bw, $bw, $bw );
            		imagesetpixel( $image, $x, $y, $color );
            	}
        	}
    	}
	
	}
	
	/**
	 * Helper function for sanitizing and returning the image attachment metadata.
	 *
	 * @since 1.0.0
	 *
	 * @param int $id The image attachment ID
	 * @return array The meta for the attachment
	 */
	public static function get_metadata( $id ) {
	
		$id = absint( $id );
		return wp_get_attachment_metadata( $id );
	
	}
	
	/**
	 * Helper function for sanitizing and returning the image attachment metadata.
	 *
	 * @since 1.0.0
	 *
	 * @param int $id The image attachment ID
	 * @param array $meta The new image meta to be updated
	 * @return array The meta for the attachment
	 */
	public static function update_metadata( $id, $meta ) {
	
		$id = absint( $id );
		wp_update_attachment_metadata( $id, $meta );
	
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