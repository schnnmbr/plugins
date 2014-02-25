<?php
/**
 * Aseets class for the Soliloquy Themes Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Themes
 * @author	Thomas Griffin
 */
class Tgmsp_Themes_Assets {

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
		if ( Tgmsp_Themes::soliloquy_is_not_active() )
			return;

		/** Load dev scripts and styles if in Soliloquy dev mode */
		$dev = defined( 'SOLILOQUY_DEV' ) && SOLILOQUY_DEV ? '-dev' : '';

		/** Register scripts and styles */
		wp_register_style( 'soliloquy-themes-metro', plugins_url( 'themes/metro/soliloquy-metro' . $dev . '.css', dirname( dirname( __FILE__ ) ) ), array(), Tgmsp_Themes::get_instance()->version );

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