<?php
/*
Plugin Name: Shopno2 Move Secondary Navigation
Plugin URI: http://shopno2.com
Description:  SubMenu Above Header
Author: shopno2
Author URI: shopno2.com
Version:0.1


/* Reposition the primary navigation menu*/
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_header', 'genesis_do_subnav' );
