<?php
/**
 * Strings class for the Soliloquy Crop Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Crop
 * @author	Thomas Griffin
 */ 
class Tgmsp_Crop_Strings {

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
		if ( Tgmsp_Crop::soliloquy_is_not_active() )
			return;
	
		$this->strings = apply_filters( 'tgmsp_crop_strings', array(
			'bottom'			=> __( 'Bottom', 'soliloquy-crop' ),
			'bottom_left'		=> __( 'Bottom Left', 'soliloquy-crop' ),
			'bottom_right'		=> __( 'Bottom Right', 'soliloquy-crop' ),
			'center'			=> __( 'Center', 'soliloquy-crop' ),
			'crop_desc'			=> __( 'Sets the crop alignment parameter for your resized images.', 'soliloquy-crop' ),
			'crop_position'		=> __( 'Crop Position', 'soliloquy-crop' ),
			'cropped_desc'		=> __( 'Images will be cropped to this size via the Crop Addon.', 'soliloquy-crop' ),
			'install_tim'		=> __( 'In order for the Crop Addon to function correctly, a few necessary components must be installed. These components allow you to serve cached re-sized images to your visitors, which greatly increases the speed and performance of your sliders.', 'soliloquy-crop' ),
			'left'				=> __( 'Left', 'soliloquy-crop' ),
			'menu_title'		=> __( 'Crop Settings', 'soliloquy-crop' ),
			'missing_items' 	=> __( 'The Crop Addon must be configured before use, and you are missing necessary components. <a href="%s">Click here to install the necessary components</a>.', 'soliloquy-crop' ),
			'page_title'		=> __( 'Soliloquy Crop Settings', 'soliloquy-crop' ),
			'right'				=> __( 'Right', 'soliloquy-crop' ),
			'submit_tim'		=> __( 'Click Here to Install the Necessary Crop Addon Components', 'soliloquy-crop' ),
			'success_tim'		=> __( 'Congratulations! All of the necessary components have been installed successfully. You can now use the Crop Addon with your sliders.', 'soliloquy-crop' ),
			'crop_settings' => __( 'Soliloquy Crop Settings', 'soliloquy-crop' ),
			'top'				=> __( 'Top', 'soliloquy-crop' ),
			'top_left'			=> __( 'Top Left', 'soliloquy-crop' ),
			'top_right'			=> __( 'Top Right', 'soliloquy-crop' )
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