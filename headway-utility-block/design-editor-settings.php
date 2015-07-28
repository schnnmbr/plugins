<?php
/* Headway 3.2.5 has better support for the 'headway_element_data_defaults' filter */
if ( version_compare(HEADWAY_VERSION, '3.2.5', '>=') ) {
	add_action('init', 'utility_block_default_design_settings');

	if (!is_array(utility_block_default_design_settings()))
		return;

	add_filter('headway_element_data_defaults', 'utility_block_add_default_design_settings');
	function utility_block_add_default_design_settings($existing_defaults) {

		return array_merge($existing_defaults, utility_block_default_design_settings());

	}


} else {

	add_action('init', 'utility_pre325_default_design_settings');

	function utility_pre325_default_design_settings() {

		global $headway_default_element_data;

		if (!is_array(utility_block_default_design_settings()))
			return;

		$headway_default_element_data = array_merge($headway_default_element_data, utility_block_default_design_settings());

	}

}


function utility_block_default_design_settings() {
					
	$block = HeadwayUtilityBlock::$block;
					
	$utility_blocks = HeadwayBlocksData::get_blocks_by_type('utility-block');
	
	/* return if there are no blocks for this type.. else do the foreach */
	if ( !isset($utility_blocks) || !is_array($utility_blocks) )
		return;
		
	$new_default_element_data = array();
	
	foreach ($utility_blocks as $block_id => $block) {

		if ( !is_array($block) )
			$block = HeadwayBlocksData::get_block($block_id);
		
		if ( method_exists( 'HeadwayBlocksData', 'get_legacy_id' ) ) { 
			$block_id = HeadwayBlocksData::get_legacy_id($block);
		}

		$new_default_element_data['block-utility-block'] = array(
			'properties' => array(
				'overflow' => 'visible'
			)
		);
				
		$new_default_element_data['block-utility-block-logo-text'.$block_id] = array(
			'properties' => array(
				'font-size' => '33',
				'font-family' => 'Helvetica',
				'line-height' => '100',
				'color' => '555555',
				'text-decoration' => 'none'
			)
		);		
		$new_default_element_data['block-utility-block-menu-list-item'.$block_id] = array(
			'properties' => array(
				'padding-top' => '0',
				'padding-right' => '0',
				'padding-bottom' => '0',
				'padding-left' => '0'
			)
		);	

		$new_default_element_data['block-utility-block-sub-nav-menu'.$block_id] = array(
			'properties' => array(
				'background-color' => 'efefef'
			)
		);

		$new_default_element_data['block-utility-block-menu-item'.$block_id] = array(
			'properties' => array(
				'padding-top' => '10',
				'padding-right' => '10',
				'padding-bottom' => '10',
				'padding-left' => '10',
			),
			'special-element-state' => array(
				'hover' => array(
					'background-color' => 'efefef'
				)
			)
		);	
		
	}

	return $new_default_element_data;

}