<?php
/**
 * Strings class for the Soliloquy Headway Block.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Headway Block
 * @author	Thomas Griffin
 */ 
class Tgmsp_Headway_Strings {

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
	
		$this->strings = apply_filters( 'tgmsp_headway_strings', array(
			'no_slider'	=> __( 'There is no slider to display.', 'soliloquy-headway' ),
			'select'	=> __( 'Select a Slider', 'soliloquy-headway' ),
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