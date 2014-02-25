<?php
/**
 * Options class for the Soliloquy Headway Block.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Headway Block
 * @author	Thomas Griffin
 */
class Tgmsp_Headway_Options extends HeadwayBlockOptionsAPI {
	
	/**
	 * Array of tabs for the slider options.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $tabs = array(
		'slider-setup' => 'Slider Setup'
	);
	
	/**
	 * Array slider options for the block.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $inputs = array(
		'slider-setup' 		=> array(
			'slider-id' 	=> array(
				'type' 		=> 'select',
				'name'		=> 'slider-id',
				'label'		=> 'Slider to Insert',
				'default'	=> '',
				'tooltip'	=> 'Select the slider that you want to insert into this block.',
				'options'	=> 'get_sliders()'
			)
		)
	);
	
	/**
	 * Callback function for returning a list of published sliders.
	 *
	 * @since 1.0.0
	 *
	 * @return array $options Array of published Soliloquy sliders
	 */
	public function get_sliders() {
	
		$sliders = get_posts( array( 'post_type' => 'soliloquy', 'posts_per_page' => -1, 'post_status' => 'publish' ) );
		$options = array( '' => Tgmsp_Headway_Strings::get_instance()->strings['select'] );
		
		/** Loop through the sliders and store them in the options array */
		if ( $sliders )
			foreach ( (array) $sliders as $slider )
				$options[$slider->ID] = $slider->post_title;
				
		return $options;
	
	}

}