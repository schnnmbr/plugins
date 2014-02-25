<?php
/**
 * Shortcode class for the Soliloquy Themes Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Themes
 * @author	Thomas Griffin
 */
class Tgmsp_Themes_Shortcode {

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
	
		/** Customize the shortcode output for the slider themes */
		add_action( 'tgmsp_before_slider_output', array( $this, 'enqueue_assets' ), 10, 2 );
		add_filter( 'tgmsp_slider_classes', array( $this, 'classes' ), 10, 2 );
	
	}
	
	/**
	 * Enqueue CSS for the selected themes.
	 *
	 * @since 1.0.0
	 *
	 * @param int $id The current slider ID
	 * @param array $images All of the images within the slider
	 * @return null Return early if there are no images to loop through
	 */
	public function enqueue_assets( $id, $images ) {
		
		/** Return early if there are no images to loop through */
		if ( empty( $images ) )
			return;
			
		/** Get the theme for the current slider */
		$meta = get_post_meta( $id, '_soliloquy_settings', true );
		
		/** Enqueue the custom CSS depending on which theme is chosen */
		if ( isset( $meta['theme'] ) ) {
			switch ( $meta['theme'] ) {
				case 'default' :
					break; // Do nothing if they choose the default theme
				case 'metro' :
					wp_enqueue_style( 'soliloquy-themes-metro' );
					break;
				default :
					do_action( 'tgmsp_themes_enqueue_assets', $id, $images );
					break;
			}
		}
		
		// If there is only one slider on the page and it is a custom theme, let's remove the default CSS styles.
		global $soliloquy_data;
		$is_default_theme = false;
		
		foreach ( $soliloquy_data as $i => $slider ) {
			if ( ! isset( $slider['meta']['theme'] ) || isset( $slider['meta']['theme'] ) && 'default' == $slider['meta']['theme'] ) {
				$is_default_theme = true;
				break;
			}
		}
		
		// If there is no default theme active, dequeue the default style to improve speed and performance.
		if ( ! $is_default_theme )
			wp_dequeue_style( 'soliloquy-style' );
		
	}
	
	/**
	 * Add custom classes to the slider to allow for custom CSS styling per theme.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes The current set of slider classes
	 * @param int $id The current slider ID
	 * @return array $classes Amended set of slider classes
	 */
	public function classes( $classes, $id ) {
	
		/** Get the theme for the current slider */
		$meta = get_post_meta( $id, '_soliloquy_settings', true );
		
		/** Enqueue the custom CSS depending on which theme is chosen */
		if ( isset( $meta['theme'] ) )
			$classes[] = sanitize_html_class( strtolower( 'soliloquy-theme-' . $meta['theme'] ), '' );
			
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