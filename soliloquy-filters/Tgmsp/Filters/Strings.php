<?php
/**
 * Strings class for the Soliloquy Filters Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Filters
 * @author	Thomas Griffin
 */ 
class Tgmsp_Filters_Strings {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $instance;
	
	/**
	 * Holds a copy of all the strings used by the Soliloquy Lightbox Addon.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $strings = array();

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
	
		$this->strings = apply_filters( 'tgmsp_filters_strings', array(
			'brighten_25'			=> __( 'Brighten 25', 'soliloquy-filters' ),
			'brighten_50'			=> __( 'Brighten 50', 'soliloquy-filters' ),
			'brighten_75'			=> __( 'Brighten 75', 'soliloquy-filters' ),
			'brighten_100'			=> __( 'Brighten 100', 'soliloquy-filters' ),
			'colorize_blue'			=> __( 'Colorize Blue', 'soliloquy-filters' ),
			'colorize_green'		=> __( 'Colorize Green', 'soliloquy-filters' ),
			'colorize_purple'		=> __( 'Colorize Purple', 'soliloquy-filters' ),
			'colorize_red'			=> __( 'Colorize Red', 'soliloquy-filters' ),
			'colorize_yellow'		=> __( 'Colorize Yellow', 'soliloquy-filters' ),
			'contrast'				=> __( 'Contrast', 'soliloquy-filters' ),
			'emboss'				=> __( 'Emboss', 'soliloquy-filters' ),
			'emboss_edge'			=> __( 'Emboss Edge', 'soliloquy-filters' ),
			'filter_error'			=> __( 'There was an error generating one or more of the image filters. Please try saving the slider again.', 'soliloquy-filters' ),
			'gaussian_blur'			=> __( 'Gaussian Blur', 'soliloquy-filters' ),
			'grayscale'				=> __( 'Grayscale', 'soliloquy-filters' ),
			'grayscale_blue'		=> __( 'Grayscale (minus blue)', 'soliloquy-filters' ),
			'grayscale_green'		=> __( 'Grayscale (minus green)', 'soliloquy-filters' ),
			'grayscale_red'			=> __( 'Grayscale (minus red)', 'soliloquy-filters' ),
			'image_filter'			=> __( 'Image Filter', 'soliloquy-filters' ),
			'mean_removal'			=> __( 'Mean Removal', 'soliloquy-filters' ),
			'photo_negative'		=> __( 'Photo Negative', 'soliloquy-filters' ),
			'select_filter' 		=> __( 'No Filter', 'soliloquy-filters' ),
			'select_filter_type' 	=> __( 'Select a filter for your image: ', 'soliloquy-filters' ),
			'selective_blur'		=> __( 'Selective Blur', 'soliloquy-filters' ),
			'sepia'					=> __( 'Sepia', 'soliloquy-filters' ),
			'sepia_100_50'			=> __( 'Sepia 100/50', 'soliloquy-filters' ),
			'sepia_100_70_50'		=> __( 'Sepia 100/70/50', 'soliloquy-filters' ),
			'sepia_90_60_30'		=> __( 'Sepia 90/60/30', 'soliloquy-filters' ),
			'sepia_60_60'			=> __( 'Sepia 60/60', 'soliloquy-filters' ),
			'sepia_90_90'			=> __( 'Sepia 90/90', 'soliloquy-filters' ),
			'sepia_45_45'			=> __( 'Sepia 45/45', 'soliloquy-filters' ),
			'smooth'				=> __( 'Smooth', 'soliloquy-filters' )
		) );
	
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