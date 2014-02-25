<?php
/**
 * Block class for the Soliloquy Headway Block.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Headway Block
 * @author	Thomas Griffin
 */
class Tgmsp_Headway_Block extends HeadwayBlockAPI {
	
	/**
	 * The unique ID of the block.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $id = 'soliloquy';
	
	/**
	 * The name of the block.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'Soliloquy';
	
	/**
	 * The options class name for this block.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $options_class = 'Tgmsp_Headway_Options';
	
	/**
	 * Provides a description for the block addon.
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 */
	public $description = 'Inserts a Soliloquy slider into your Headway theme.';
	
	/**
	 * Displays content for the Soliloquy block for Headway.
	 *
	 * @since 1.0.0
	 *
	 * @param int $block The unique block ID for this block
	 */
	public function content( $block ) {
	
		/** Get the registered block option for this block instance */
		$slider_id = parent::get_setting( $block, 'slider-id', false );
		
		/** If there is no slider, display a message and stop executing this function */
		if ( ! $slider_id )
			return printf( '%s', Tgmsp_Headway_Strings::get_instance()->strings['no_slider'] );
			
		/** If we have reached this point, we have a valid slider, so let's output it */
		soliloquy_slider( $slider_id );
	
	}

}