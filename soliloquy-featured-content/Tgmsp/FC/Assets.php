<?php
/**
 * Assets class for the Soliloquy Featured Content Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Featured Content
 * @author	Thomas Griffin
 */
class Tgmsp_FC_Assets {

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
		if ( Tgmsp_FC::soliloquy_is_not_active() )
			return;
			
		/** Load dev scripts and styles if in Soliloquy dev mode */
		$dev = defined( 'SOLILOQUY_DEV' ) && SOLILOQUY_DEV ? '-dev' : '';
	
		/** Register scripts and styles */
		wp_register_script( 'soliloquy-fc-admin', plugins_url( 'js/admin' . $dev . '.js', dirname( dirname( __FILE__ ) ) ), array( 'jquery' ), '1.0.0', true );
		wp_register_script( 'soliloquy-fc-chosen', plugins_url( 'js/chosen.jquery.min.js', dirname( dirname( __FILE__ ) ) ), array( 'jquery', 'jquery-ui-widget' ), '1.0.0', true );
		wp_register_style( 'soliloquy-fc-admin', plugins_url( 'css/admin' . $dev . '.css', dirname( dirname( __FILE__ ) ) ) );
		wp_register_style( 'soliloquy-fc-chosen', plugins_url( 'css/chosen.css', dirname( dirname( __FILE__ ) ) ) );
			
		/** Load all hooks and filters for the class */
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_assets' ) );
	
	}
	
	/**
	 * Register admin assets for the featured content addon.
	 *
	 * @since 1.0.0
	 * 
	 * @global int $id The current post ID
	 * @global object $post The current post object
	 */
	public function load_admin_assets() {
		
		global $id, $post;

		/** Only load for the Soliloquy post type add and edit screens */
		if ( Tgmsp::is_soliloquy_add_edit_screen() ) {
			/** Send the post ID along with our script */
			$post_id = ( null === $id ) ? $post->ID : $id;
			
			$args = apply_filters( 'tgmsp_fc_script_args', array(
				'id' 					=> $post_id,
				'post_content_length' 	=> 40,
				'post_nonce'			=> wp_create_nonce( 'soliloquy-fc-post-nonce' ),
				'posts_num'				=> 5,
				'read_more'				=> Tgmsp_FC_Strings::get_instance()->strings['read_more_default'],
				'term_nonce' 			=> wp_create_nonce( 'soliloquy-fc-term-nonce' )
			) );
			
			wp_enqueue_script( 'soliloquy-fc-admin' );
			wp_localize_script( 'soliloquy-fc-admin', 'soliloquy_fc', $args );
			wp_enqueue_script( 'soliloquy-fc-chosen' );
			wp_enqueue_style( 'soliloquy-fc-admin' );
			wp_enqueue_style( 'soliloquy-fc-chosen' );
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