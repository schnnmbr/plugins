<?php
/*
Plugin Name: 25 - Disable Visual Editor
Plugin URI: http://shopno2.com
Description: Disables Visual Editor for you. Mind that your customers might not know HTML.
Author: sachin nambiar
Author URI: shopno2.com
Version: 0.1
*/

add_filter('user_can_richedit' , create_function('' , 'return false;') , 50);