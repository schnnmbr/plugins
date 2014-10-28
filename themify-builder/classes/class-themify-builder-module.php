<?php

class Themify_Builder_Module {
	var $name;
	var $slug;
	var $options = array();
	var $styling = array();
	var $style_selectors = array();

	function __construct( $params ) {
		$this->name = $params['name'];
		$this->slug = $params['slug'];
	}
}