<?php
/**
 * Admin class for the Soliloquy Themes Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Themes
 * @author	Thomas Griffin
 */ 
class Tgmsp_Themes_Admin {

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
	
		add_action( 'admin_init', array( $this, 'deactivation' ) );
		add_action( 'tgmsp_before_setting_animation', array( $this, 'themes' ) );
		add_action( 'tgmsp_save_slider_settings', array( $this, 'save_theme' ), 10, 3 );
	
	}
	
	/**
	 * Deactivate the plugin if Soliloquy is not active and update the recently
	 * activate plugins with our plugin.
	 *
	 * @since 1.0.0
	 */
	public function deactivation() {
		
		/** Don't deactivate when doing a Soliloquy update or when editing Soliloquy from the Plugin Editor */
		if ( Tgmsp_Themes::soliloquy_is_not_active() ) {
			$recent = (array) get_option( 'recently_activated' );
			$recent[plugin_basename( Tgmsp_Themes::get_file() )] = time();
			update_option( 'recently_activated', $recent );
			deactivate_plugins( plugin_basename( Tgmsp_Themes::get_file() ) );
		}
		
	}
	
	/**
	 * Outputs the field for a user to select a custom theme for Soliloquy.
	 *
	 * @since 1.0.0
	 *
	 * @param object The current post object
	 */
	public function themes( $post ) {
	
		?>
		<tr id="soliloquy-themes-box" valign="middle">
			<th scope="row"><?php echo Tgmsp_Themes_Strings::get_instance()->strings['slider_theme']; ?></th>
			<td>
			<?php
				$themes = $this->get_themes();
				echo '<select id="soliloquy-theme" name="_soliloquy_settings[theme]">';
					foreach ( $themes as $theme => $data ) {
						echo '<option value="' . esc_attr( $data['slug'] ) . '"' . selected( $data['slug'], Tgmsp_Admin::get_custom_field( '_soliloquy_settings', 'theme' ), false ) . '>' . esc_html( $data['name'] ) . '</option>';
					}
				echo '</select>';
			?>
			</td>
		</tr>
		<?php
	
	}
	
	/**
	 * Saves the user chosen theme for Soliloquy.
	 *
	 * @since 1.0.0
	 *
	 * @param array $settings The current Soliloquy slider settings
	 * @param int $post_id The current post ID
	 * @param object The current post object
	 */
	public function save_theme( $settings, $post_id, $post ) {
	
		if ( isset( $settings['theme'] ) )
			$settings['theme'] = preg_replace( '#[^a-z0-9-_]#', '', $settings['theme'] );
			
		update_post_meta( $post_id, '_soliloquy_settings', $settings ); 
	
	}
	
	/**
	 * Helper function for retrieving the custom themes for Soliloquy.
	 *
	 * @since 1.0.0
	 */
	private function get_themes() {
	
		$themes = array(
			array(
				'name' 	=> Tgmsp_Themes_Strings::get_instance()->strings['default'],
				'slug'	=> 'default'
			),
			array(
				'name' 	=> Tgmsp_Themes_Strings::get_instance()->strings['metro'],
				'slug'	=> 'metro'
			)
		);
		
		return apply_filters( 'tgmsp_themes_list', $themes );
	
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