<?php
/**
 * Aseets class for the Soliloquy Crop Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Crop
 * @author	Thomas Griffin
 */
class Tgmsp_Crop_Assets {

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
		
		/** Load dev scripts and styles if in Soliloquy dev mode */
		$dev = defined( 'SOLILOQUY_DEV' ) && SOLILOQUY_DEV ? '-dev' : '';
	
		/** Register scripts and styles */
		wp_register_script( 'soliloquy-crop-admin', plugins_url( 'js/admin' . $dev . '.js', dirname( dirname( __FILE__ ) ) ), array( 'jquery' ), '1.0.0', true );
			
		/** Load all hooks and filters for the class */
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_assets' ) );
	
	}
	
	/**
	 * Register admin assets for the carousel addon.
	 *
	 * @since 1.0.0
	 */
	public function load_admin_assets() {

		/** Only load for the Soliloquy post type add and edit screens */
		if ( Tgmsp::is_soliloquy_add_edit_screen() ) {
			wp_enqueue_script( 'soliloquy-crop-admin' );
			wp_localize_script( 'soliloquy-crop-admin', 'soliloquy_crop', array(
				'desc' => Tgmsp_Crop_Strings::get_instance()->strings['cropped_desc']
			) );
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