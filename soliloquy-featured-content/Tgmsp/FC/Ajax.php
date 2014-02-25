<?php
/**
 * Ajax class for the Soliloquy Featured Content Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Featured Content
 * @author	Thomas Griffin
 */
class Tgmsp_FC_Ajax {

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
		if ( Tgmsp_FC::soliloquy_is_not_active() )
			return;
	
		add_action( 'wp_ajax_soliloquy_fc_refresh_terms', array( $this, 'refresh_terms' ) );
		add_action( 'wp_ajax_soliloquy_fc_refresh_posts', array( $this, 'refresh_posts' ) );
	
	}
	
	/**
	 * Refreshes the term list to show available terms for the selected post type.
	 *
	 * @since 1.0.0
	 */
	public function refresh_terms() {
		
		/** Do a security check first */
		check_ajax_referer( 'soliloquy-fc-term-nonce', 'nonce' );
		
		if ( ! isset( $_POST['post_type'] ) || isset( $_POST['post_type'] ) && empty( $_POST['post_type'] ) ) {
			echo json_encode( array( 'error' => true ) );
			die;
		}
		
		/** Prepare taxonomies array */
		$taxonomies = array();
		
		/** If we have more than one post type selected, we need to show terms based on it they share taxonomies */
		if ( count( $_POST['post_type'] ) > 1 ) {
			foreach ( $_POST['post_type'] as $type )
				$taxonomies[] = get_object_taxonomies( $type, 'objects' );
			
			if ( empty( $taxonomies ) ) {
				echo json_encode( array( 'error' => true ) );
				die;
			}
			
			/** Loop through the taxonomies and see if they share post type objects */
			$output = '';
			foreach ( $taxonomies as $array ) {
				foreach ( $array as $taxonomy ) {
					/** If the post_type and object_type arrays match, they share post types */
					if ( $_POST['post_type'] == $taxonomy->object_type ) {
						$terms = get_terms( $taxonomy );
						
						$output .= '<optgroup label="' . esc_attr( $taxonomy->labels->name ) . '">';
							foreach ( $terms as $term )
								$output .= '<option value="' . esc_attr( strtolower( $taxonomy->name ) . '|' . $term->term_id . '|' . $term->slug ) . '"' . selected( strtolower( $taxonomy->name ) . '|' . $term->term_id . '|' . $term->slug, in_array( strtolower( $taxonomy->name ) . '|' . $term->term_id . '|' . $term->slug, (array) Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'terms', null, absint( $_POST['id'] ) ) ) ? strtolower( $taxonomy->name ) . '|' . $term->term_id . '|' . $term->slug : '', false ) . '>' . esc_html( ucwords( $term->name ) ) . '</option>';
						$output .= '</optgroup>';
					} else {
						continue;
					}
				}
			}
			
			/** Send the output back to the script */
			if ( empty( $output ) ) {
				echo json_encode( array( 'error' => true ) );
				die;
			} else {
				echo json_encode( $output );
				die;
			}
		} else { 
			foreach ( $_POST['post_type'] as $type )
				$taxonomies[] = get_object_taxonomies( $type, 'objects' );
			
			if ( empty( $taxonomies ) ) {
				echo json_encode( array( 'error' => true ) );
				die;
			}
			
			/** Loop through the taxonomies and see if they share post type objects */
			$output = '';
			foreach ( $taxonomies as $array ) {
				foreach ( $array as $taxonomy ) {
					$terms = get_terms( $taxonomy->name );
						
					$output .= '<optgroup label="' . esc_attr( $taxonomy->labels->name ) . '">';
						foreach ( $terms as $term ) {
							$output .= '<option value="' . esc_attr( strtolower( $taxonomy->name ) . '|' . $term->term_id . '|' . $term->slug ) . '"' . selected( strtolower( $taxonomy->name ) . '|' . $term->term_id . '|' . $term->slug, in_array( strtolower( $taxonomy->name ) . '|' . $term->term_id . '|' . $term->slug, (array) Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'terms', null, absint( $_POST['id'] ) ) ) ? strtolower( $taxonomy->name ) . '|' . $term->term_id . '|' . $term->slug : '', false ) . '>' . esc_html( ucwords( $term->name ) ) . '</option>';
						}
					$output .= '</optgroup>';
				}
			}
			
			/** Send the output back to the script */
			if ( empty( $output ) ) {
				echo json_encode( array( 'error' => true ) );
				die;
			} else {
				echo json_encode( $output );
				die;
			}
		}
		
		echo json_encode( array( 'error' => true ) );
		die;
		
	}
	
	/**
	 * Refreshes the individual post selection list for the selected post type.
	 *
	 * @since 1.0.0
	 */
	public function refresh_posts() {
		
		/** Do a security check first */
		check_ajax_referer( 'soliloquy-fc-post-nonce', 'nonce' );
		
		if ( ! isset( $_POST['post_type'] ) || isset( $_POST['post_type'] ) && empty( $_POST['post_type'] ) ) {
			echo json_encode( array( 'error' => true ) );
			die;
		}
		
		/** There is only going to be one post type in this array, so we can reliably grab it this way */
		$posts = get_posts( array( 'post_type' => $_POST['post_type'][0], 'posts_per_page' => apply_filters( 'tgmsp_fc_max_queried_posts', 500 ), 'no_found_rows' => true, 'cache_results' => false ) );
		
		if ( $posts ) {
			$object = get_post_type_object( $_POST['post_type'][0] );
			$output = '<optgroup label="' . esc_attr( $object->labels->name ) . '">';
				foreach ( $posts as $post ) {
					$output .= '<option value="' . esc_attr( $post->ID ) . '"' . selected( $post->ID, in_array( $post->ID, (array) Tgmsp_Admin::get_custom_field( '_soliloquy_fc', 'include_exclude', null, absint( $_POST['id'] ) ) ) ? $post->ID  : '', false ) . '>' . esc_html( ucwords( $post->post_title ) ) . '</option>';
				}
			$output .= '</optgroup>';
			
			echo json_encode( $output );
			die;
		}
		
		echo json_encode( array( 'error' => true ) );
		die;
		
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