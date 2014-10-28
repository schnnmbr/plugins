<?php

final class Themify_Builder_model {
	static public $modules = array();

	static public function register_module( $class, $settings ) {
		if ( class_exists( $class ) ) {

			$instance = new $class();

			self::$modules[ $instance->slug ] = $instance;

			if ( is_user_logged_in() ) {
				self::$modules[ $instance->slug ]->options = isset( $settings['options'] ) ? $settings['options'] : array();
				self::$modules[ $instance->slug ]->styling = isset( $settings['styling'] ) ? $settings['styling'] : array();
			}
			self::$modules[ $instance->slug ]->style_selectors = isset( $settings['styling_selector'] ) ? $settings['styling_selector'] : array();
		}
	}

	/**
	 * Check whether builder is active or not
	 * @return bool
	 */
	static public function builder_check() {
		if ( themify_builder_get('builder_is_active') == 'disable' ){
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Check whether module is active
	 * @param $name
	 * @return boolean
	 */
	static public function check_module_active( $name ) {
		if ( isset( self::$modules[ $name ] ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Check is frontend editor page
	 */
	static public function is_frontend_editor_page() {
		global $post;
		if ( is_user_logged_in() && current_user_can( 'edit_page', $post->ID ) ) {
			return true;
		} else{
			return false;
		}
	}
}