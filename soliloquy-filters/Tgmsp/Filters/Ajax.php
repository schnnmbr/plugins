<?php
/**
 * Ajax class for the Soliloquy Filters Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Filters
 * @author	Thomas Griffin
 */
class Tgmsp_Filters_Ajax {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	
		self::$instance = $this;
		
		/** Return early if Soliloquy is not active */
		if ( Tgmsp_Filters::soliloquy_is_not_active() )
			return;
	
		add_filter( 'tgmsp_ajax_refresh_callback', array( $this, 'refresh_images' ), 20, 2 );
		add_action( 'tgmsp_after_meta_defaults', array( $this, 'image_filters' ) );
		add_action( 'tgmsp_ajax_update_meta', array( $this, 'save_meta' ) );
	
	}
	
	/**
	 * Adds image filters select box to images array when refreshing images.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Data sent back to jQuery script for outputting
	 * @param object $attachment The current attachment object
	 * @return array $data Amended array of data with our lightbox info
	 */
	public function refresh_images( $data, $attachment ) {
		
		$filters 	= $this->filters();
		$content 	= '';
		
		$content 	.= '<label for="soliloquy-filters-image-filter-' . $attachment->ID . '">' . Tgmsp_Filters_Strings::get_instance()->strings['select_filter_type'] . '</label>';
		$content 	.= '<select id="soliloquy-filters-image-filter-' . $attachment->ID . '" class="soliloquy-filters-image-filter" name="_soliloquy_filters[image_filter]">';
		$content 		.= '<option value="none">' . Tgmsp_Filters_Strings::get_instance()->strings['select_filter'] . '</option>';
		foreach ( (array) $filters as $array => $type )
		$content 		.= '<option value="' . esc_attr( $type['type'] ) . '"' . selected( $type['type'], get_post_meta( $attachment->ID, '_soliloquy_filters_image_filter', true ), false ) . '>' . esc_html( $type['name'] ) . '</option>';
		$content 	.= '</select>';
		$content	= apply_filters( 'tgmsp_filters_ajax_content', $content, $data, $attachment );
		
		/** Send content within data array */
		$data['after_meta_defaults']['filters'] = '<tr id="soliloquy-filters-box-' . $attachment->ID . '" valign="middle"><th scope="row"><label for="soliloquy-filters-image-filter-' . $attachment->ID . '">' . Tgmsp_Filters_Strings::get_instance()->strings['image_filter'] . '</label></th><td id="soliloquy-filters-options-' . $attachment->ID . '" class="soliloquy-filters-options">' . $content . '</td></tr>';
			
		return apply_filters( 'tgmsp_filters_ajax_data', $data, $attachment );
		
	}
	
	/**
	 * Outputs the necessary HTML for enabling image filters for the image.
	 *
	 * @since 1.0.0
	 *
	 * @param object $attachment The current attachment object
	 */
	public function image_filters( $attachment ) {
			
		echo '<tr id="soliloquy-filters-box-' . $attachment->ID . '" valign="top">';
			echo '<th scope="row"><label for="soliloquy-filters-image-filter-' . $attachment->ID . '">' . Tgmsp_Filters_Strings::get_instance()->strings['image_filter'] . '</label></th>';
			echo '<td id="soliloquy-filters-options-' . $attachment->ID . '" class="soliloquy-filters-options">';
				$filters = $this->filters();
				echo '<label for="soliloquy-filters-image-filter-' . $attachment->ID . '">' . Tgmsp_Filters_Strings::get_instance()->strings['select_filter_type'] . '</label>';
				echo '<select id="soliloquy-filters-image-filter-' . $attachment->ID . '" class="soliloquy-filters-image-filter" name="_soliloquy_filters[image_filter]">';
				echo '<option value="none">' . Tgmsp_Filters_Strings::get_instance()->strings['select_filter'] . '</option>';
				foreach ( (array) $filters as $array => $type )
					echo '<option value="' . esc_attr( $type['type'] ) . '"' . selected( $type['type'], get_post_meta( $attachment->ID, '_soliloquy_filters_image_filter', true ), false ) . '>' . esc_html( $type['name'] ) . '</option>';
				echo '</select>';
			echo '</td>';
		echo '</tr>';
		
	}
		
	/**
	 * Saves the image filter entry when the user clicks to save meta.
	 *
	 * @since 1.0.0
	 *
	 * @param array $post_var $_POST array keys sent when saving image meta
	 */
	public function save_meta( $post_var ) {
		
		$attachment_id = absint( $post_var['attach'] );
		
		/** Update the post meta to add the image filter */
		update_post_meta( $attachment_id, '_soliloquy_filters_image_filter', preg_replace( '#[^a-z0-9-_]#', '', $post_var['soliloquy-filters-image-filter'] ) );
		
		do_action( 'tgmsp_filters_update_meta', $attachment_id, $post_var );
		
	}
	
	/**
	 * Default set of images filters that are used for images.
	 *
	 * @since 1.0.0
	 */
	public function filters() {
	
		$filters = array(
			array(
				'type'	=> 'brighten_25',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['brighten_25']
			),
			array(
				'type'	=> 'brighten_50',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['brighten_50']
			),
			array(
				'type'	=> 'brighten_75',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['brighten_75']
			),
			array(
				'type'	=> 'brighten_100',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['brighten_100']
			),
			array(
				'type'	=> 'colorize_blue',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['colorize_blue']
			),
			array(
				'type'	=> 'colorize_green',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['colorize_green']
			),
			array(
				'type'	=> 'colorize_purple',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['colorize_purple']
			),
			array(
				'type'	=> 'colorize_red',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['colorize_red']
			),
			array(
				'type'	=> 'colorize_yellow',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['colorize_yellow']
			),
			array(
				'type'	=> 'contrast',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['contrast']
			),
			array(
				'type'	=> 'emboss',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['emboss']
			),
			array(
				'type'	=> 'emboss_edge',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['emboss_edge']
			),
			array(
				'type'	=> 'gaussian_blur',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['gaussian_blur']
			),
			array(
				'type'	=> 'grayscale',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['grayscale']
			),
			array(
				'type'	=> 'grayscale_red',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['grayscale_red']
			),
			array(
				'type'	=> 'grayscale_green',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['grayscale_green']
			),
			array(
				'type'	=> 'grayscale_blue',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['grayscale_blue']
			),
			array(
				'type'	=> 'mean_removal',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['mean_removal']
			),
			array(
				'type'	=> 'photo_negative',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['photo_negative']
			),
			array(
				'type'	=> 'selective_blur',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['selective_blur']
			),
			array(
				'type'	=> 'sepia',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['sepia']
			),
			array(
				'type'	=> 'sepia_100_50',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['sepia_100_50']
			),
			array(
				'type'	=> 'sepia_100_70_50',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['sepia_100_70_50']
			),
			array(
				'type'	=> 'sepia_90_60_30',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['sepia_90_60_30']
			),
			array(
				'type'	=> 'sepia_60_60',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['sepia_60_60']
			),
			array(
				'type'	=> 'sepia_90_90',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['sepia_90_90']
			),
			array(
				'type'	=> 'sepia_45_45',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['sepia_45_45']
			),
			array(
				'type'	=> 'smooth',
				'name'	=> Tgmsp_Filters_Strings::get_instance()->strings['smooth']
			)
		);
		
		return apply_filters( 'tgmsp_filters_image_filters', $filters );
	
	}

	/**
	 * Getter method for retrieving the object instance.
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {
	
		return self::$instance;
	
	}
	
}