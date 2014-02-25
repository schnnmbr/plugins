<?php
/**
 * Media class for the Soliloquy Filters Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Filters
 * @author	Thomas Griffin
 */
class Tgmsp_Filters_Media {

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
		
		add_action( 'delete_attachment', array( $this, 'delete_filters' ) );
		add_filter( 'attachment_fields_to_edit', array( $this, 'media' ), 20, 2 );
		add_filter( 'attachment_fields_to_save', array( $this, 'update_media' ), 20, 2 );
	
	}
	
	/**
	 * Deletes any filtered images created with the Addon when the attachment is deleted.
	 *
	 * @since 1.0.0
	 *
	 * @global object $current_screen The current screen object
	 * @param int $post_id The current post ID
	 */
	public function delete_filters( $post_id ) {
	
		$parent = get_post( wp_get_post_parent_id( $post_id ) );

		/** Let's verify that this image is a Soliloquy attachment image before we proceed */
		if ( $parent ) {
			if ( 'soliloquy' == $parent->post_type ) {
				$meta = wp_get_attachment_metadata( $post_id );
				
				/** Loop through the sizes and delete any filtered images added by Soliloquy */
				foreach ( $meta['sizes'] as $slug => $data )
					if ( preg_match( '|^soliloquy|', $slug ) && 'soliloquy-thumb' !== $slug )
						@unlink( trailingslashit( $data['path'] ) . $data['file'] );
						
			}
		}
	
	}
	
	/**
	 * Adds select box so user can choose their image filter straight from the upload screen.
	 *
	 * @since 1.0.0
	 *
	 * @global object $current_screen The current screen object
	 * @param array $fields Default list of attachment fields
	 * @return array $fields Amended list of attachment fields
	 */
	public function media( $fields, $attachment ) {
		
		global $current_screen;
		
		if ( Tgmsp_Media::is_our_context() || 'soliloquy' == $current_screen->post_type ) {			
			$filters 	= Tgmsp_Filters_Ajax::filters();
			$output 	= '<select id="attachments[' . $attachment->ID . '][soliloquy_filters_image_filter]" name="attachments[' . $attachment->ID . '][soliloquy_filters_image_filter]">';
			$output 	.= '<option value="none">' . Tgmsp_Filters_Strings::get_instance()->strings['select_filter'] . '</option>';
			foreach ( (array) $filters as $array => $type )
				$output .= '<option value="' . esc_attr( $type['type'] ) . '"' . selected( $type['type'], get_post_meta( $attachment->ID, '_soliloquy_filters_image_filter', true ), false ) . '>' . esc_html( $type['name'] ) . '</option>';
			$output .= '</select>';
			$fields['soliloquy_filters_image_filter'] = array(
				'label' => Tgmsp_Filters_Strings::get_instance()->strings['image_filter'],
				'input' => 'html',
				'html'	=> $output
			);
			
			$fields = apply_filters( 'tgmsp_filters_attachment_fields', $fields, $attachment );
		}
			
		return $fields;
		
	}
		
	/**
	 * Saves the image filter selection.
	 *
	 * @since 1.0.0
	 *
	 * @global object $current_screen The current screen object
	 * @param object $attachment The current attachment object
	 * @param array $post_var $_POST array keys sent when updating attachment meta
	 * @return object $attachment Return the attachment after updating post meta
	 */
	public function update_media( $attachment, $post_var ) {
		
		global $current_screen;
	
		if ( Tgmsp_Media::is_our_context() || 'soliloquy' == $current_screen->post_type ) {
			update_post_meta( $attachment['ID'], '_soliloquy_filters_image_filter', preg_replace( '#[^a-z0-9-_]#', '', $post_var['soliloquy_filters_image_filter'] ) );
			
			do_action( 'tgmsp_filters_attachment_fields_update', $attachment, $post_var );
		}
			
		return $attachment;
		
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