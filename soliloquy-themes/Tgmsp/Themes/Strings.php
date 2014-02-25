<?php
/**
 * Strings class for the Soliloquy Themes Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Themes
 * @author	Thomas Griffin
 */ 
class Tgmsp_Themes_Strings {

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
		if ( Tgmsp_Themes::soliloquy_is_not_active() )
			return;
	
		$this->strings = apply_filters( 'tgmsp_themes_strings', array(
			'default'		=> __( 'Default', 'soliloquy-themes' ),
			'metro'			=> __( 'Metro', 'soliloquy-themes' ),
			'slider_theme'	=> __( 'Slider Theme', 'soliloquy-themes' )
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