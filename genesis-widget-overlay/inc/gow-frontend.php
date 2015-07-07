<?php

defined( 'WPINC' ) or die;

add_action( 'widgets_init', 'wpstudio_add_widget_area');
function wpstudio_add_widget_area() {
	genesis_register_sidebar( array(
		'id'			=> 'overlaywidget',
		'name'			=> __( 'Overlay Widget', 'genesis-overlay-widget' ),
		'description'	=> __( 'Overlay Widget.', 'genesis-overlay-widget' ) ) );
}


add_action( 'genesis_after', 'wpstudio_add_widget' );
function wpstudio_add_widget(){
if (is_active_sidebar( 'overlaywidget' )) {


		echo '<div class="overlay ' . genesis_get_option( 'gow_effect', 'gow-settings' ) . '"';
		if ( genesis_get_option( 'gow_background', 'gow-settings' ) ) {
		echo ' style="background-color: '. genesis_get_option( 'gow_background' , 'gow-settings') .'"';
		}
		if ( genesis_get_option( 'text_color', 'gow-settings' ) ) {
		echo ' style="color: '. genesis_get_option( 'text_color' , 'gow-settings') .'';
		}
		echo ';">';

		echo '<button type="button" class="overlay-close">Close</button>';			
		dynamic_sidebar( 'overlaywidget' );
		echo '</div>';

	}

}

// Add triger to right navigation header
add_filter( 'genesis_before', 'wpstudio_button_menu' );
function wpstudio_button_menu() {

	$classes = array(
	genesis_get_option( 'gow_position' , 'gow-settings' ),
	genesis_get_option( 'gow_fixed' , 'gow-settings' )
);

$classes = implode(' ', $classes);

	echo '<a href="#" style="background-color:'. genesis_get_option( 'gow_color' , 'gow-settings')  .'" id="trigger-overlay" class="' . $classes . '">' . genesis_get_option( 'gow_button', 'gow-settings' ) . '</a>';

}

?>