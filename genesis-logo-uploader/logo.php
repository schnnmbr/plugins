<?php
/*
Plugin Name: Easy Genesis Logo Uploader
Plugin URI: 
Description: Enable you to simply upload your logo to a Genesis Child Theme.
Version: 0.1.1
Author: Sure Fire Web Services Inc.
Author URI: http://surefirewebservices.com
License: GPL 2
Text Domain: sf-logo-updater
Domain Path: /languages/
*/


// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define( 'SFLU_EDD_URL', 'http://surefirewebservices.com' ); // IMPORTANT: change the name of this constant to something unique to prevent conflicts with other plugins using this system
 // the name of your product. This is the title of your product in EDD and should match the download title in EDD exactly
define( 'SFLU_EDD_GEN_LOGO', 'Genesis Logo Uploader Plugin' ); // IMPORTANT: change the name of this constant to something unique to prevent conflicts with other plugins using this system
// Define Text Domain
define( 'SFLU_DOMAIN', 'sf-logo-updater' );


add_action( 'init', 'sflu_widget_init' );

/**
 * Set Text Domain
 */
function sflu_widget_init() {
       load_plugin_textdomain( SFLU_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );      
}

register_activation_hook( __FILE__, 'sflu_activation_check' );
/**
 * Checks for activated Genesis Framework before allowing plugin to activate.
 *
 * @since 1.0.0
 *
 * @uses  load_plugin_textdomain()
 * @uses  get_template_directory()
 * @uses  deactivate_plugins()
 * @uses  wp_die()
 * @author  David Decker (http://deckerweb.de/)
 */
function sflu_activation_check() {

	/** Load translations to display for the activation message. */
	load_plugin_textdomain( 'surefire-logo-uploader', FALSE, SFLU_DOMAIN );

	/** Check for activated Genesis Framework (= template/parent theme) */
	if ( ! class_exists( 'Genesis_Admin_Upgraded' ) ) {

		/** If no Genesis, deactivate ourself */
		deactivate_plugins( plugin_basename( __FILE__ ) );

		/** Message: no Genesis active */
		$sflu_deactivation_message = sprintf(
			__( 'Sorry, you cannot activate the %1$s plugin unless you have installed the %2$sGenesis Framework%3$s.', 'surefire-logo-uploader' ),
			__( 'SureFire Genesis Logo Uploader', 'surefire-logo-uploader' ),
			'<a href="http://surefirewebservices.com/go/genesis/" target="_new"><strong><em>',
			'</em></strong></a>'
		);

		/** Deactivation message */
		wp_die(
			$sflu_deactivation_message,
			__( 'Plugin', 'surefire-logo-uploader' ) . ': ' . __( 'SureFire Logo Uploader', 'surefire-logo-uploader' ),
			array( 'back_link' => true )
		);

	}  // end-if Genesis check

}  // end of function sflu_activation_check

// Custom Header Check
add_action('admin_notices', 'sflu_custom_header_support');
function sflu_custom_header_support() {
	if ( current_theme_supports( 'custom-header' ) ) {
		echo '<div class="updated"><p>Oh No!! You have custom_header activated in your functions.php.  Open that file and remove: <br /> add_theme_support( \'custom-header\' ); </p></div>';
		return;
	}
}

/**
 * Apply Actions to Replace Logo
 *
 * Set's the required actions to replace the current logo IF the theme settings are set to 'image' AND 
 * the theme mod exists.
 *
 * @since 1.0.0
 * @uses genesis_get_option() Get theme setting value.
 * @uses get_theme_mod() Retrieves a modification setting for the current theme.
 * 
 */
add_action('genesis_before', 'sflu_do_logo');
function sflu_do_logo() {
	if ( genesis_get_option('blog_title') == 'image' && get_theme_mod( 'sflu_logo' ) ) {
		remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
		add_action( 'genesis_site_title', 'sflu_replace_logo' );
	}
}

/**
 * Replaces Site Logo
 *
 * Applies the uploaded image to the genesis_site_title hook.
 *
 * @since 1.0.1
 * @uses genesis_get_option() Get theme setting value.
 * @uses get_theme_mod() Retrieves a modification setting for the current theme.
 * 
 */
function sflu_replace_logo() {
	$sf_get_logo = get_theme_mod( 'sflu_logo' );
 	if ( genesis_get_option('blog_title') == 'image' && get_theme_mod( 'sflu_logo' ) )
 		echo '<div class="site-logo"><a href="' . site_url() . '"><img src="' . $sf_get_logo .'"></a></div>';
}

/**
 * Adds the uploader.
 *
 * Adds the logo uploader to the theme customization screen.
 * 
 * @since 1.0.0
 */
function sflu_logo_uploader( $wp_customize ) {
    
    if ( current_theme_supports( 'custom-header' ) ) {
		return;
	}
    
    // Add the section to the theme customizer in WP
    $wp_customize->add_section( 'sflu_logo_section' , array(
	    'title'       => __( 'Upload Logo', SFLU_DOMAIN ),
	    'priority'    => 30,
	    'description' => __( 'Upload your logo to the header of the site.', SFLU_DOMAIN ),
	) );

	// Register the new setting
	$wp_customize->add_setting( 'sflu_logo' );

	// Tell WP to use an image uploader using WP_Customize_Image_Control
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sflu_logo', array(
	    'label'    => __( 'Logo', SFLU_DOMAIN ),
	    'section'  => 'sflu_logo_section',
	    'settings' => 'sflu_logo',
	) ) );

}
add_action('customize_register', 'sflu_logo_uploader');