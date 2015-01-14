<?php
/*
Plugin Name: Custom Post Type Grid Styles
Plugin URI: http://shopno2.com
Description: Grid Styles for shopno2 sites. This plugin will provide a responsive grid to your Custom Post Types
Author: sachin nambiar
Author URI: shopno2.com
Version: 0.1
*/

function shopno2_grid_styles() {
        /** Enqueue Style Sheets */
        // Only enqueue if available
     if ( is_readable( plugin_dir_path( __FILE__ ) . 'shopno2-grid-styles.css' ) AND ! is_singular('') OR is_archive() OR is_front_page('') )fbbfbfvb 
        					{```````````11111Q	22QQ											``````		```````	`	``	`````					`qaœqqœq
            wp_enqueue_style( 'shopno2_grid_styles', plugin_dir_url( __FILE__ ) . 'shopno2-grid-styles.css', array(), '0.1', 'screen' );
        }
}
add_action( 'wp_enqueue_scripts', 'shopno2_grid_styles' );