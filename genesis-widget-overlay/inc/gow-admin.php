<?php
/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the plugin Settings page.
 *
 * @package Genesis Overlay Widget
 * @subpackage Admin
 *
 * @since 1.0.0
 */

// Exit if accessed directly
defined( 'WPINC' ) or die;
/**
 * Register a metabox and default settings for the Genesis Simple Logo.
 *
 * @package Genesis\Admin
 */


class WPSTUDIO_Settings extends Genesis_Admin_Boxes {
    /**
     * Create an archive settings admin menu item and settings page for relevant custom post types.
     *
     * @since 1.0.0
     */
    public function __construct() {
        $settings_field = 'gow-settings';
        $page_id = 'genesis-overlay-widget';
        $menu_ops = array(
                'submenu' => array(
                'parent_slug' => 'genesis',
                'page_title'  => __( 'Genesis Overlay Widget Settings', 'genesis-overlay-widget' ),
                'menu_title'  => __( 'Overlay Widget', 'genesis-overlay-widget' )
            )
        );
        $page_ops = array(); // use defaults
        $center = current_theme_supports( 'genesis-responsive-viewport' ) ? 'mobile' : 'never';
        $default_settings = apply_filters(
            'gow_settings_defaults',
            array(
                'gow_css'           => 1,
                'gow_button'        => 'Push me',
                'gow_color'         => '#000',
                'gow_position'      => 'trigger-left',
                'gow_effect'        => 'overlay-scale',
                'gow_fixed'         => 'trigger-fixed',
                'gow_background'    => 'rgba(26,197,165,0.9)',
                'text_color'        => '#FFFFFF',
            )
        );
        $this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );
        add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitizer_filters' ) );
    }
    /**
     * Register each of the settings with a sanitization filter type.
     *
     * @since 1.0.0
     *
     * @uses genesis_add_option_filter() Assign filter to array of settings.
     *
     * @see \Genesis_Settings_Sanitizer::add_filter()
     */
    public function sanitizer_filters() {
        genesis_add_option_filter( 'no_html', $this->settings_field,
            array(
                'gow_button',
                'gow_color',
                'gow_position',
                'gow_effect',
                'gow_fixed',
                'gow_background',
                'text_color'
            )
        );
        genesis_add_option_filter( 'one_zero', $this->settings_field,
            array( 'gow_css' 
            ) 
        );
    }
    /**
     * Register Metabox for the Genesis Simple Logo.
     *
     * @param string $_genesis_theme_settings_pagehook
     * @uses  add_meta_box()
     * @since 1.0.0
     */
    function metaboxes() {
        add_meta_box( 'gow-settings', __( 'Plugin Settings', 'genesis-overlay-widget' ), array( $this, 'gow_settings' ), $this->pagehook, 'main', 'high' );
    }
    /**
     * Create Metabox which links to and explains the WordPress customizer.
     *
     * @uses  wp_customize_url()
     * @since 1.0.0
     */
    function gow_settings() {

        ?>

        <p>
            <label style="width: 180px; margin: 0 40px 0 0; display: inline-block;" for="<?php echo $this->get_field_id( 'gow_css' ); ?>"><?php _e( 'Load plugin styling?', 'genesis-overlay-widget' ); ?></label>
            <input type = "checkbox" name="<?php echo $this->get_field_name( 'gow_css' ); ?>" id="<?php echo $this->get_field_id( 'gow_css' ); ?>" value="1"<?php checked( $this->get_field_value( 'gow_css' ) ); ?> />
        </p>

        <hr class="div">

        <h4><?php _e( 'Settings Button', 'genesis-overlay-widget' );?></h4>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gow_button' ); ?>"><?php _e( 'Button Text', 'genesis-overlay-widget' ); ?></label>
            <input type="text" data-default-color="#ffffff" name="<?php echo $this->get_field_name( 'gow_button' );?>" id="<?php echo $this->get_field_id( 'gow_button' );?>?" value="<?php echo $this->get_field_value( 'gow_button' ); ?>" />
        </p>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gow_color' ); ?>"><?php _e( 'Button Color', 'genesis-overlay-widget' ); ?></label>
            <input type="text" data-default-color="#ffffff" name="<?php echo $this->get_field_name( 'gow_color' );?>" id="<?php echo $this->get_field_id( 'gow_color' );?>?" value="<?php echo $this->get_field_value( 'gow_color' ); ?>" />
        </p>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gow_position' ); ?>"><?php _e( 'Position Left', 'genesis-overlay-widget' ); ?></label>
            <input type="radio" name="<?php echo $this->get_field_name( 'gow_position' ); ?>" value="trigger-left" <?php checked( $this->get_field_value( 'gow_position' ), "trigger-left" ); ?> />
        </p>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gow_position' ); ?>"><?php _e( 'Position Right', 'genesis-overlay-widget' ); ?></label>
            <input type="radio" name="<?php echo $this->get_field_name( 'gow_position' ); ?>" value="trigger-right" <?php checked( $this->get_field_value( 'gow_position' ), "trigger-right" ); ?> />
        </p>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gow_fixed' ); ?>"><?php _e( 'Position Fixed', 'genesis-overlay-widget' ); ?></label>
            <input type="radio" name="<?php echo $this->get_field_name( 'gow_fixed' ); ?>" value="trigger-fixed" <?php checked( $this->get_field_value( 'gow_fixed' ), "trigger-fixed" ); ?> />
        </p>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gow_fixed' ); ?>"><?php _e( 'Position Absolute', 'genesis-overlay-widget' ); ?></label>
            <input type="radio" name="<?php echo $this->get_field_name( 'gow_fixed' ); ?>" value="trigger-absolute" <?php checked( $this->get_field_value( 'gow_fixed' ), "trigger-absolute" ); ?> />
        </p>

        <hr class="div">

        <h4><?php _e( 'Effect settings', 'genesis-overlay-widget' );?></h4>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gow_effect' ); ?>"><?php _e( 'Scale', 'genesis-overlay-widget' ); ?></label>
            <input type="radio" name="<?php echo $this->get_field_name( 'gow_effect' ); ?>" value="overlay-scale" <?php checked( $this->get_field_value( 'gow_effect' ), "overlay-scale" ); ?> />
        </p>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gow_effect' ); ?>"><?php _e( 'Corner', 'genesis-overlay-widget' ); ?></label>
            <input type="radio" name="<?php echo $this->get_field_name( 'gow_effect' ); ?>" value="overlay-corner" <?php checked( $this->get_field_value( 'gow_effect' ), "overlay-corner" ); ?> />
        </p>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gow_effect' ); ?>"><?php _e( 'Slide Down', 'genesis-overlay-widget' ); ?></label>
            <input type="radio" name="<?php echo $this->get_field_name( 'gow_effect' ); ?>" value="overlay-slidedown" <?php checked( $this->get_field_value( 'gow_effect' ), "overlay-slidedown" ); ?> />
        </p>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gow_effect' ); ?>"><?php _e( 'Door', 'genesis-overlay-widget' ); ?></label>
            <input type="radio" name="<?php echo $this->get_field_name( 'gow_effect' ); ?>" value="overlay-door" <?php checked( $this->get_field_value( 'gow_effect' ), "overlay-door" ); ?> />
        </p>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gow_effect' ); ?>"><?php _e( 'Content Push', 'genesis-overlay-widget' ); ?></label>
            <input type="radio" name="<?php echo $this->get_field_name( 'gow_effect' ); ?>" value="overlay-contentpush" <?php checked( $this->get_field_value( 'gow_effect' ), "overlay-contentpush" ); ?> />
        </p>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gow_effect' ); ?>"><?php _e( 'Content Scale', 'genesis-overlay-widget' ); ?></label>
            <input type="radio" name="<?php echo $this->get_field_name( 'gow_effect' ); ?>" value="overlay-contentscale" <?php checked( $this->get_field_value( 'gow_effect' ), "overlay-contentscale" ); ?> />
        </p>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gow_effect' ); ?>"><?php _e( 'Simple Genie', 'genesis-overlay-widget' ); ?></label>
            <input type="radio" name="<?php echo $this->get_field_name( 'gow_effect' ); ?>" value="overlay-simplegenie" <?php checked( $this->get_field_value( 'gow_effect' ), "overlay-simplegenie" ); ?> />
        </p>
        
        <hr class="div">

        <h4><?php _e( 'Color settings', 'genesis-overlay-widget' );?></h4>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gow_background' ); ?>"><?php _e( 'Background color', 'genesis-overlay-widget' ); ?></label>
            <input type="text" data-default-color="#333333" name="<?php echo $this->get_field_name( 'gow_background' );?>" id="<?php echo $this->get_field_id( 'gow_background' );?>" value="<?php echo $this->get_field_value( 'gow_background' ); ?>" />
        </p>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'text_color' ); ?>"><?php _e( 'Text color', 'genesis-overlay-widget' ); ?></label>
            <input type="text" data-default-color="#aaaaaa" name="<?php echo $this->get_field_name( 'text_color' );?>" id="<?php echo $this->get_field_id( 'text_color' );?>"  value="<?php echo $this->get_field_value( 'text_color' ); ?>" />
        </p>

        <hr class="div">

        <?php
    }

}