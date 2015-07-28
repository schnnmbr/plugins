<?php 
/*
Plugin Name: Remove Orphan Shortcodes
Plugin URI: http://mekshq.com
Description: Quickly remove unused (orphan) shortcode tags from your content.
Author: MeksHQ
Version: 1.0
Author URI: http://mekshq.com
*/

if(!function_exists('remove_orphan_shortcodes')){

	/* Hook shortcodes removal function to the_content filter */
	add_filter('the_content', 'remove_orphan_shortcodes', 0);

	/* Main function which finds and hides unused shortcodes */
	function remove_orphan_shortcodes($content) {
		global $shortcode_tags;
		
		//Check for active shortcodes
		$active_shortcodes = ( is_array($shortcode_tags) && !empty($shortcode_tags) ) ? array_keys($shortcode_tags) : array();
		
		$hack = md5(microtime());
		$content = str_replace("/",$hack, $content); //avoid "/" chars in content breaks preg_replace
		
		if(!empty($active_shortcodes)){
			//Be sure to keep active shortcodes
			$keep_active = implode("|", $active_shortcodes);
			$content= preg_replace( "~(?:\[/?)(?!(?:$keep_active))[^/\]]+/?\]~s", '', $content );
		} else {
			//Strip all shortcodes
			$content = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $content);			
		}
		
		$content = str_replace($hack,"/",$content); // set "/" back to its place
			
	  	return $content;
	}

}

?>