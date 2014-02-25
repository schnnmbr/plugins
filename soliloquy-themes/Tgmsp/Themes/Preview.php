<?php
/**
 * Preview class for the Soliloquy Themes Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Themes
 * @author	Thomas Griffin
 */
class Tgmsp_Themes_Preview {

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
		
		add_action( 'tgmsp_preview_start', array( $this, 'preview_init' ) );
	
	}
	
	/**
	 * Init callback to make sure that filters and hooks are only executed in the Preview
	 * context.
	 *
	 * @since 1.0.0
	 *
	 * @param array $post_var The $_POST data from the Ajax request
	 */
	public function preview_init( $post_var ) {
	
		/** Only proceed if we have a theme selected */
		if ( isset( $post_var['soliloquy-theme'] ) ) {
			if ( 'default' == $post_var['soliloquy-theme'] ) {
				return;
			} else {
				add_action( 'tgmsp_before_slider_output', array( $this, 'enqueue_assets' ), 10, 6 );
				add_filter( 'tgmsp_slider_classes', array( $this, 'classes' ), 0, 2 );
			}
		}
	
	}
	
	/**
	 * Enqueue CSS for the selected themes (for Preview mode).
	 *
	 * @since 1.0.0
	 *
	 * @param int $id The current slider ID
	 * @param array $images All of the images within the slider
	 * @param array $soliloquy_data Array of data for the slider
	 * @param int $soliloquy_count The current slider on the page
	 * @param string $slider The slider HTML
	 * @param array $post_var The current $_POST data sent to the script
	 * @return null Return early if there are no images to loop through
	 */
	public function enqueue_assets( $id, $images, $soliloquy_data, $soliloquy_count, $slider, $post_var ) {
		
		/** Return early if there are no images to loop through */
		if ( empty( $images ) )
			return;
		
		/** Enqueue the custom CSS depending on which theme is chosen */
		if ( isset( $post_var['soliloquy-theme'] ) ) {
			switch ( $post_var['soliloquy-theme'] ) {
				case 'default' :
					break; // Do nothing if they choose the default theme
				case 'metro' :
					wp_enqueue_style( 'soliloquy-themes-metro' );
					break;
				default :
					do_action( 'tgmsp_themes_enqueue_assets', $id, $post_var );
					break;
			}
		}
		
	}
	
	/**
	 * Add custom classes to the slider to allow for custom CSS styling per theme (for Preview).
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes The current set of slider classes
	 * @param int $id The current slider ID
	 * @param array $post_var The current $_POST data sent to the script
	 * @return array $classes Amended set of slider classes
	 */
	public function classes( $classes, $id ) {
		
		/** Remove the regular filter for the Preview generation */
		remove_filter( 'tgmsp_slider_classes', array( Tgmsp_Themes_Shortcode::get_instance(), 'classes' ) );
		
		/** Add the custom CSS class based on theme selection */
		if ( isset( $_POST['soliloquy-theme'] ) )
			$classes[] = sanitize_html_class( strtolower( 'soliloquy-theme-' . $_POST['soliloquy-theme'] ), '' );
			
		return array_unique( $classes );
	
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