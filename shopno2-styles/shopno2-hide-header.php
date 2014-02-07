<?php
/*
Plugin Name: Shopno2 Hide Header
Plugin URI: http://shopno2.com
Description: Hides Header
Author: shopno2.com
Author URI: shopno2.com
Version: 0.1
*/

/** Remove Header */


remove_action( 'genesis_site_title', 'genesis_seo_title' ); 
remove_action( 'genesis_site_description', 'genesis_site_description' ); 
