<?php
/**
 * Admin class for the Soliloquy Crop Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Filters
 * @author	Thomas Griffin
 */ 
class Tgmsp_Crop_Admin {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $instance;
	
	/**
	 * Holds the menu pagehook string.
	 *
	 * @since 1.0.0
	 *
	 * @var bool|string
	 */
	private $menu_hook = false;

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	
		self::$instance = $this;
	
		add_action( 'admin_init', array( $this, 'deactivation' ) );
		add_filter( 'tgmsp_default_sizes', array( $this, 'crop_size' ) );
		add_filter( 'tgmsp_slider_settings', array( $this, 'preserve_image_size' ), 10, 3 );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_crop_settings' ), 10, 2 );
		
		// Only process if any necessary components of the Addon are missing.
		if ( ! Tgmsp_Crop::soliloquy_uploads_dir_exists() || ! Tgmsp_Crop::crop_dir_exists() ) {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'admin_notices', array( $this, 'notices' ) );
		}
	
	}
	
	/**
	 * Deactivate the plugin if Soliloquy is not active and update the recently
	 * activate plugins with our plugin.
	 *
	 * @since 1.0.0
	 */
	public function deactivation() {
		
		/** Don't deactivate when doing a Soliloquy update or when editing Soliloquy from the Plugin Editor */
		if ( Tgmsp_Crop::soliloquy_is_not_active() ) {
			$recent = (array) get_option( 'recently_activated' );
			$recent[plugin_basename( Tgmsp_Crop::get_file() )] = time();
			update_option( 'recently_activated', $recent );
			deactivate_plugins( plugin_basename( Tgmsp_Crop::get_file() ) );
		}
		
	}
	
	/**
	 * Filters the default slider sizes to add a new size for the Crop
	 * Addon - "cropped".
	 *
	 * @since 1.0.0
	 *
	 * @param array $sizes Default slider sizes
	 * @return array $sizes Amended array of slider sizes with "cropped" added
	 */
	public function crop_size( $sizes ) {
		
		$sizes[] = 'cropped';
		return $sizes;
		
	}
	
	/**
	 * If the "cropped" option is chosen, the custom slider size dimensions are 
	 * preserved for Crop resizing.
	 *
	 * @since 1.0.0
	 *
	 * @param array $settings Default Soliloquy meta settings
	 * @param object $post The current post object
	 * @param int $post_id The current post ID
	 * @return array $settings Amended settings with size preserved
	 */
	public function preserve_image_size( $settings, $post, $post_id ) {
		
		// Return early if the "cropped" size has not been chosen.
		if ( isset( $settings['default'] ) && 'cropped' != $settings['default'] )
			return $settings;
			
		// Preserve user selected image sizes.
		$settings['width']	= preg_match( '|^\d+%{0,1}$|', trim( $_POST['_soliloquy_settings']['width'] ) ) ? trim( $_POST['_soliloquy_settings']['width'] ) : 600;
		$settings['height']	= preg_match( '|^\d+%{0,1}$|', trim( $_POST['_soliloquy_settings']['height'] ) ) ? trim( $_POST['_soliloquy_settings']['height'] ) : 300;
		return $settings;
		
	}
	
	/**
	 * Adds the Soliloquy Crop metabox to the Soliloquy edit screen.
	 *
	 * @since 1.0.0
	 */
	public function add_meta_boxes() {
	
		add_meta_box( 'soliloquy_crop_settings', Tgmsp_Crop_Strings::get_instance()->strings['crop_settings'], array( $this, 'crop_settings' ), 'soliloquy', 'normal', 'core' );
	
	}
	
	/**
	 * Callback function for the Soliloquy Crop metabox.
	 *
	 * @since 1.0.0
	 *
	 * @param object $post The current post object
	 */
	public function crop_settings( $post ) {
	
		/** Always keep security first */
		wp_nonce_field( 'soliloquy_crop_settings', 'soliloquy_crop_settings' );
		
		do_action( 'tgmsp_crop_before_settings_table', $post );
		
		?>
		<table class="form-table">
			<tbody>
				<?php do_action( 'tgmsp_crop_before_setting_crop_position', $post ); ?>
				<tr id="soliloquy-crop-position-box" valign="middle">
					<th scope="row"><label for="soliloquy-crop-position"><?php echo Tgmsp_Crop_Strings::get_instance()->strings['crop_position']; ?></label></th>
					<td>
						<?php
							$positions = $this->crop_positions();
							echo '<select id="soliloquy-crop-position" name="_soliloquy_crop[crop_position]">';
							foreach ( (array) $positions as $array => $data )
								echo '<option value="' . esc_attr( $data['type'] ) . '"' . selected( $data['type'], Tgmsp_Admin::get_custom_field( '_soliloquy_crop', 'crop_position' ), false ) . '>' . esc_html( $data['name'] ) . '</option>';
							echo '</select>';
						?>
						<span class="description"><?php echo Tgmsp_Crop_Strings::get_instance()->strings['crop_desc']; ?></span>
					</td>
				</tr>
				<?php do_action( 'tgmsp_crop_end_of_settings', $post ); ?>
			</tbody>
		</table>
		<?php
		
		do_action( 'tgmsp_crop_after_settings', $post );
	
	}
	
	/**
	 * Save crop settings post meta fields added to Soliloquy metaboxes.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id The post ID
	 * @param object $post Current post object data
	 */
	public function save_crop_settings( $post_id, $post ) {

		/** Bail out if we fail a security check */
		if ( ! isset( $_POST[sanitize_key( 'soliloquy_crop_settings' )] ) || ! wp_verify_nonce( $_POST[sanitize_key( 'soliloquy_crop_settings' )], 'soliloquy_crop_settings' ) )
			return $post_id;

		/** Bail out if running an autosave, ajax or a cron */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
			return;
		if ( defined( 'DOING_CRON' ) && DOING_CRON )
			return;

		/** Bail out if the user doesn't have the correct permissions to update the slider */
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return $post_id;

		/** All security checks passed, so let's store our data */
		$settings = isset( $_POST['_soliloquy_crop'] ) ? $_POST['_soliloquy_crop'] : '';
		
		/** Sanitize all data before updating */
		$settings['crop_position'] = preg_replace( '#[^a-z0-9-_]#', '', $_POST['_soliloquy_crop']['crop_position'] );

		do_action( 'tgmsp_crop_save_settings', $settings, $post_id, $post );

		/** Update post meta with sanitized values */
		update_post_meta( $post_id, '_soliloquy_crop', $settings );

	}
	
	/**
	 * Adds a menu item to the Soliloquy post type.
	 *
	 * @since 1.0.0
	 */
	public function admin_menu() {

		$this->menu_hook = add_submenu_page( 'edit.php?post_type=soliloquy', Tgmsp_Crop_Strings::get_instance()->strings['page_title'], Tgmsp_Crop_Strings::get_instance()->strings['menu_title'], apply_filters( 'tgmsp_crop_settings_cap', 'manage_options' ), 'soliloquy-crop-settings', array( $this, 'soliloquy_crop_settings' ) );

	}
	
	/**
	 * Outputs the Crop settings page callback.
	 *
	 * @since 1.0.0
	 */
	public function soliloquy_crop_settings() {
		
		echo '<div class="wrap soliloquy-settings">';
			// If we are attempting to install the components, just do it.
			if ( isset( $_GET['soliloquy-crop-install'] ) && $_GET['soliloquy-crop-install'] || isset( $_POST['soliloquy-crop-install'] ) && $_POST['soliloquy-crop-install'] ) {
				if ( $this->do_crop_install() ) {
					return;
				} else {
					screen_icon( 'soliloquy' );
					echo '<h2 class="soliloquy-settings-title">' . esc_html( get_admin_page_title() ) . '</h2>';
					echo '<div id="tgmsp-crop-success" class="updated">';
						echo '<p><strong>' . Tgmsp_Crop_Strings::get_instance()->strings['success_tim'] . '</strong></p>';
					echo '</div>';
					echo '<style type="text/css">#adminmenu .wp-submenu li.current { display: none !important; }</style>';
				}
			} else {
				screen_icon( 'soliloquy' );
				echo '<h2 class="soliloquy-settings-title">' . esc_html( get_admin_page_title() ) . '</h2>';
				echo '<p>' . Tgmsp_Crop_Strings::get_instance()->strings['install_tim'] . '</p>';
				echo '<form id="soliloquy-crop-install" method="post" action="">';
					echo '<input type="hidden" name="soliloquy-crop-nonce" value="' . wp_create_nonce( 'soliloquy-crop-nonce' ) . '" />';
					submit_button(
						Tgmsp_Crop_Strings::get_instance()->strings['submit_tim'],
						'primary',
						'soliloquy-crop-install'
					);
				echo '</form>';
			}
		echo '</div>';

	}
	
	/**
	 * Handles the installation of the necessary Crop components, which
	 * include the Soliloquy uploads directory, the main Crop file and
	 * the Crop cache directory.
	 *
	 * @since 1.0.0
	 *
	 * @return null Return early if we need extra credentials from the user
	 */
	private function do_crop_install() {
		
		// Return early if we fail a security check.
		check_admin_referer( 'soliloquy-crop-nonce', 'soliloquy-crop-nonce' );
		
		$url 	= add_query_arg( 
			array( 
				'post_type' 					=> 'soliloquy', 
				'page' 							=> 'soliloquy-crop-settings', 
				'soliloquy-crop-install' 	=> true, 
				'soliloquy-crop-nonce' 		=> wp_create_nonce( 'soliloquy-crop-nonce' ) 
			), 
			admin_url( 'edit.php' ) 
		);
		$method = ''; // Will be populated by WP_Filesystem.
		if ( false === ( $creds = request_filesystem_credentials( $url, $method, false, false, null ) ) )
			return true;

		if ( ! WP_Filesystem( $creds ) ) {
			request_filesystem_credentials( $url, $method, true, false, null ); // Setup WP_Filesystem
			return true;
		}
		
		// If we have reached this point, we know the $wp_filesystem object is populated.
		global $wp_filesystem;
		
		// Create the Soliloquy uploads directory if it does not already exist.
		if ( ! Tgmsp_Crop::soliloquy_uploads_dir_exists() )
			$wp_filesystem->mkdir( Tgmsp_Crop::soliloquy_uploads_dir() );
			
		// Create the Crop cache directory and set the correct permissions if it does not already exist.
		if ( ! Tgmsp_Crop::crop_dir_exists() )
			$wp_filesystem->mkdir( Tgmsp_Crop::soliloquy_uploads_dir() . '/cache', 0775 );
			
		// Return false at the end to specify if the action has completed successfully.
		return false;
		
	}
	
	/**
	 * Outputs a notice if any of the necessary components of the Crop Addon are
	 * missing from the current WordPress install.
	 *
	 * @since 1.0.0
	 *
	 * @return null Return early if on the Crop settings page
	 */
	public function notices() {
		
		if ( $this->menu_hook && $this->menu_hook == get_current_screen()->base )
			return;
			
		add_settings_error( 'tgmsp-crop', 'tgmsp-crop-error', sprintf( Tgmsp_Crop_Strings::get_instance()->strings['missing_items'], add_query_arg( array( 'post_type' => 'soliloquy', 'page' => 'soliloquy-crop-settings', 'soliloquy-crop-install' => true, 'soliloquy-crop-nonce' => wp_create_nonce( 'soliloquy-crop-nonce' ) ), admin_url( 'edit.php' ) ) ), 'updated' );
		settings_errors( 'tgmsp-crop' );
		
		
	}
	
	/**
	 * Default Crop crop positions that can be filtered.
	 *
	 * @since 1.0.0
	 */
	public function crop_positions() {
	
		$positions = array(
			array(
				'type'	=> 'c',
				'name'	=> Tgmsp_Crop_Strings::get_instance()->strings['center']
			),
			array(
				'type'	=> 't',
				'name'	=> Tgmsp_Crop_Strings::get_instance()->strings['top']
			),
			array(
				'type'	=> 'tr',
				'name'	=> Tgmsp_Crop_Strings::get_instance()->strings['top_right']
			),
			array(
				'type'	=> 'tl',
				'name'	=> Tgmsp_Crop_Strings::get_instance()->strings['top_left']
			),
			array(
				'type'	=> 'b',
				'name'	=> Tgmsp_Crop_Strings::get_instance()->strings['bottom']
			),
			array(
				'type'	=> 'br',
				'name'	=> Tgmsp_Crop_Strings::get_instance()->strings['bottom_right']
			),
			array(
				'type'	=> 'bl',
				'name'	=> Tgmsp_Crop_Strings::get_instance()->strings['bottom_left']
			),
			array(
				'type'	=> 'l',
				'name'	=> Tgmsp_Crop_Strings::get_instance()->strings['left']
			),
			array(
				'type'	=> 'r',
				'name'	=> Tgmsp_Crop_Strings::get_instance()->strings['right']
			)
		);
		
		return apply_filters( 'tgmsp_crop_crop_positions', $positions );
	
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