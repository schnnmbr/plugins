<?php
/**
 * Preview class for the Soliloquy Featured Content Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Featured Content
 * @author	Thomas Griffin
 */
class Tgmsp_FC_Preview {

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
		
		add_filter( 'tgmsp_preview_has_images', array( $this, 'has_images' ), 10, 2 );
		add_action( 'tgmsp_preview_start', array( $this, 'preview_init' ) );
	
	}
	
	/**
	 * Force the $has_images variable to be true for the preview area.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $has_images Whether or not the slider has attached images
	 * @param array $post_var The $_POST data from the Ajax request
	 * @return bool $has_images Force images var to be true
	 */
	public function has_images( $has_images, $post_var ) {
	
		if ( isset( $post_var['soliloquy-featured-slider'] ) && 'true' == $post_var['soliloquy-featured-slider'] )
			return true;
		else
			return $has_images;
	
	}
	
	/**
	 * Init callback to make sure that filters and hooks are only executed in the Preview
	 * context.
	 *
	 * @since 1.0.0
	 *
	 * @param array $post_var The $_POST data from the Ajax request
	 */
	public function preview_init( $post_var ) {
	
		if ( isset( $post_var['soliloquy-featured-slider'] ) && 'true' == $post_var['soliloquy-featured-slider'] ) {
			add_filter( 'tgmsp_get_slider_images_args', array( $this, 'query_args' ), 10, 3 );
			add_filter( 'tgmsp_get_image_data', array( $this, 'featured_image' ), 10, 5 );
			add_filter( 'tgmsp_image_data', array( $this, 'featured_image_data' ), 10, 4 );
		}
	
	}
	
	/**
	 * Filters the query args for getting the images for the slider. If a featured
	 * content slider is selected, we modify the query args to what the user has
	 * selected.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args The default image query args
	 * @param int $id The current slider ID
	 * @param array $post_var The $_POST data from the Ajax request
	 * @return array $classes Amended array of image query args
	 */
	public function query_args( $args, $id, $post_var ) {
			
		/** Prepare our new_args array */
		$new_args = array();
		
		/** Prepare any vars that need to be prepped */
		$exception = isset( $post_var['soliloquy-fc-choose-query'] ) && 'include' == $post_var['soliloquy-fc-choose-query'] ? 'post__in' : 'post__not_in';
			
		/** Modify the args with our new parameters */
		$new_args['post_parent'] 	= null;
		$new_args['post_mime_type']	= null;
		$new_args['post_type'] 		= isset( $post_var['soliloquy-fc-post-type'] ) && 'null' !== $post_var['soliloquy-fc-post-type'] ? (array) $post_var['soliloquy-fc-post-type'] : $args['post_type'];
		$new_args['posts_per_page']	= isset( $post_var['soliloquy-fc-number'] ) ? absint( $post_var['soliloquy-fc-number'] ) : $args['posts_per_page'];
		if ( 0 == $new_args['posts_per_page'] ) {
			unset( $new_args['posts_per_page'] );
			$new_args['no_paging'] = true;
		}
			
		/** Now we are going to check and see if we need to add new args to the array */
		if ( isset( $post_var['soliloquy-fc-include-exclude'] ) && ! empty( $post_var['soliloquy-fc-include-exclude'] ) && 'null' !== $post_var['soliloquy-fc-include-exclude'] )
			$new_args[$exception] = array_map( 'absint', (array) $post_var['soliloquy-fc-include-exclude'] );
				
		if ( isset( $post_var['soliloquy-fc-orderby'] ) )
			$new_args['orderby'] = esc_attr( $post_var['soliloquy-fc-orderby'] );
				
		if ( isset( $post_var['soliloquy-fc-order'] ) )
			$new_args['order'] = esc_attr( $post_var['soliloquy-fc-order'] );
				
		if ( isset( $post_var['soliloquy-fc-offset'] ) )
			$new_args['offset'] = absint( $post_var['soliloquy-fc-offset'] );
				
		if ( isset( $post_var['soliloquy-fc-post-status'] ) )
			$new_args['post_status'] = esc_attr( $post_var['soliloquy-fc-post-status'] );
		else
			$new_args['post_status'] = 'publish';
				
		/** If 'page' is part of the post type mix, stop here */
		if ( 'page' == $new_args['post_type'] || in_array( 'page', $new_args['post_type'] ) )
			return apply_filters( 'tgmsp_fc_query_args', wp_parse_args( $new_args, $args ), $args, $id, $new_args );
				
		/** Process custom taxonomies and terms for the slider */
		if ( isset( $post_var['soliloquy-fc-terms'] ) && ! empty( $post_var['soliloquy-fc-terms'] ) && 'null' !== $post_var['soliloquy-fc-terms'] ) {
			$relation['relation'] = 'AND';
			foreach ( $post_var['soliloquy-fc-terms'] as $term ) {
				$data 			= explode( '|', $term );
				$taxonomies[] 	= $data[0];
				$terms[] 		= $data;
			}

			foreach ( array_unique( $taxonomies ) as $tax ) {
				$tax_terms = array();
				foreach ( $terms as $term ) {
					if ( $tax == $term[0] )
						$tax_terms[] = $term[2];
				}
				$relation[] = array(
					'taxonomy' 			=> $tax,
					'field'    			=> 'slug',
					'terms'    			=> $tax_terms,
					'operator' 			=> 'IN',
					'include_children' 	=> false, 
				);
			}
			$new_args['tax_query'] = $relation;
		}
		
		/** Return the modified query args */
		return apply_filters( 'tgmsp_fc_query_args', wp_parse_args( $new_args, $args ), $args, $id, $new_args );
		
	}
	
	/**
	 * Filters the image be the featured image for the post instead of an
	 * image attachment if we have a featured content slider to output.
	 *
	 * If no featured image is found, we scan for the first image in the post.
	 * If there isn't an image in the post, we look for the fallback URL in
	 * our meta. If that doesn't exist, filter the output.
	 *
	 * @since 1.0.0
	 *
	 * @param string $image HTML for the image
	 * @param int $id The current slider ID
	 * @param object $post The current post object
	 * @param string $size The size of the featured image to retrieve
	 * @param array $post_var The $_POST data from the Ajax request
	 * @return string $image Amended HTML for the featured image
	 */
	public function featured_image( $image, $id, $post, $size, $post_var ) {
			
		/** Let's grab the featured image for the featured content slider */
		$thumb_id = apply_filters( 'tgmsp_fc_thumbnail_id', get_post_thumbnail_id( $post->ID ), $id, $post, $size );
		
		/** If we have a featured image, return with that */
		if ( $thumb_id ) {
			return wp_get_attachment_image_src( $thumb_id, $size );
		} else {		
			/** If there is no featured image, search for the first image in the post */
			preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', get_post_field( 'post_content', $post->ID ), $matches );

			/** If we have a match, display it, else show the default image URL */
			if ( isset( $matches ) && ! empty( $matches[1][0] ) ) {
				return array( esc_url( $matches[1][0] ), '', '' );
			} else {
				if ( isset( $post_var['soliloquy-fc-fallback'] ) && ! empty( $post_var['soliloquy-fc-fallback'] ) )
					return array( esc_url( $post_var['soliloquy-fc-fallback'] ), '', '' );
				else
					return apply_filters( 'tgmsp_fc_no_featured_image', false, $image, $id, $post );
			}	

		}
	
	}
	
	/**
	 * Filters the image data to be customized to the featured content
	 * context.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of image data
	 * @param object $post The current post object
	 * @param int $id The current slider ID
	 * @param array $post_var The $_POST data from the Ajax request
	 * @return array $data Amended array of image data
	 */
	public function featured_image_data( $data, $post, $id, $post_var ) {
			
		/** Let's customize the data output based on the featured content items we are using */
		$data['id'] 			= get_post_thumbnail_id( $post->ID );
		$data['alt'] 			= strip_tags( esc_attr( $post->post_title ) );
		$data['title']			= strip_tags( esc_attr( $post->post_title ) );
		
		/** Link the image to the post URL if the user has selected the option */
		if ( isset( $post_var['soliloquy-fc-post-url'] ) && 'true' == $post_var['soliloquy-fc-post-url'] ) {
			$data['link']		= get_permalink( $post->ID );
			$data['linktitle'] 	= strip_tags( esc_attr( $post->post_title ) );
		} else {
			$data['link']		= '';
			$data['linktitle']	= '';
		}
		
		/** Prepare the caption variable to be concatenated with all of our featured data */
		$caption = '';
		
		/** If the user wants a post title, let's give it to them */
		if ( isset( $post_var['soliloquy-fc-post-title'] ) && 'true' == $post_var['soliloquy-fc-post-title'] )
			$caption .= '<h2 class="soliloquy-fc-title">';
			
		if ( isset( $post_var['soliloquy-fc-post-title'] ) && 'true' == $post_var['soliloquy-fc-post-title'] && isset( $post_var['soliloquy-fc-post-title-link'] ) && 'true' == $post_var['soliloquy-fc-post-title-link'] )
			$caption .= '<a href="' . esc_url( $data['link'] ) . '" title="' . esc_attr( $data['linktitle'] ) . '">';
			
		if ( isset( $post_var['soliloquy-fc-post-title'] ) && 'true' == $post_var['soliloquy-fc-post-title'] )
			$caption .= strip_tags( esc_html( $data['title'] ) );
			
		if ( isset( $post_var['soliloquy-fc-post-title'] ) && 'true' == $post_var['soliloquy-fc-post-title'] && isset( $post_var['soliloquy-fc-post-title-link'] ) && 'true' == $post_var['soliloquy-fc-post-title-link'] )
			$caption .= '</a>';
			
		if ( isset( $post_var['soliloquy-fc-post-title'] ) && 'true' == $post_var['soliloquy-fc-post-title'] )
			$caption .= '</h2>';
			
		/** If the user wants post content, let's give it to them */
		if ( isset( $post_var['soliloquy-fc-post-content'] ) && 'true' == $post_var['soliloquy-fc-post-content'] && isset( $post->post_content ) && ! empty( $post->post_content ) ) {
			/** Prepare variables to be used in the caption content */
			$title_above 	= isset( $post_var['soliloquy-fc-post-content'] ) && 'true' == $post_var['soliloquy-fc-post-content'] ? 'soliloquy-fc-title-above' : '';
			$content_length = isset( $post_var['soliloquy-fc-post-content-length'] ) ? absint( $post_var['soliloquy-fc-post-content-length'] ) : 40;
			$ellipses		= isset( $post_var['soliloquy-fc-ellipses'] ) && 'true' == $post_var['soliloquy-fc-ellipses'] ? '&hellip;' : '';
			$caption .= '<p class="soliloquy-fc-content ' . $title_above . '">' . apply_filters( 'tgmsp_fc_post_content', wp_trim_words( strip_tags( $post->post_content ), $content_length, apply_filters( 'tgmsp_fc_post_content_ellipses', $ellipses, $data, $post, $id, $post_var ) ), $data, $post, $id, $post_var );
			
			/** If the user wants a read more link, let's give it to them */
			if ( isset( $post_var['soliloquy-fc-read-more'] ) && 'true' == $post_var['soliloquy-fc-read-more'] ) {
				$read_more_text = isset( $post_var['soliloquy-fc-read-more-text'] ) ? strip_tags( $post_var['soliloquy-fc-read-more-text'] ) : Tgmsp_FC_Strings::get_instance()->strings['read_more_default'];
				$caption .= ' <a class="soliloquy-fc-read-more" href="' . esc_url( $data['link'] ) . '" title="' . esc_attr( $read_more_text ) . '">' . esc_html( $read_more_text ) . '</a>';
			} 
			
			$caption .= '</p>';
		} else {
			/** If the user wants a read more link, let's give it to them */
			if ( isset( $post_var['soliloquy-fc-read-more'] ) && 'true' == $post_var['soliloquy-fc-read-more'] ) {
				$content_above 	= isset( $post_var['soliloquy-fc-post-title'] ) && 'true' == $post_var['soliloquy-fc-post-title'] ? 'soliloquy-fc-content-above' : '';
				$read_more_text = isset( $post_var['soliloquy-fc-read-more-text'] ) ? strip_tags( $post_var['soliloquy-fc-read-more-text'] ) : Tgmsp_FC_Strings::get_instance()->strings['read_more_default'];
				$caption .= ' <a class="soliloquy-fc-read-more ' . $content_above . '" href="' . esc_url( $data['link'] ) . '" title="' . esc_attr( $read_more_text ) . '">' . esc_html( $read_more_text ) . '</a>';
			}
		}
			
		/** If our caption isn't empty, filter the caption output */
		if ( ! empty( $caption ) ) {
			add_filter( 'tgmsp_caption_output', array( $this, 'featured_caption' ), 10, 4 );
			add_filter( 'tgmsp_caption_output', 'strip_shortcodes', 20 );
		}
			
		/** Send our caption data to the image */
		$data['caption'] = $caption;
		
		/** Return our customized image data */
		return apply_filters( 'tgmsp_fc_image_data', $data, $post, $id );
	
	}
	
	/**
	 * Filters the caption output for user-defined choices in the admin.
	 *
	 * @since 1.0.0
	 *
	 * @param string $html The HTML output for the caption
	 * @param int $id The current slider ID
	 * @param array $image Image data for the current slider image
	 * @param array $post_var The $_POST data from the Ajax request
	 * @return string $html Amended HTML output for the caption
	 */
	public function featured_caption( $html, $id, $image, $post_var ) {
	
		/** Determine if the user is using the default navigation bullets/pauseplay or not */
		if ( isset( $post_var['soliloquy-control'] ) && 'false' == $post_var['soliloquy-control'] )
			$is_bullets = '';
		else
			$is_bullets = 'soliloquy-fc-bullets';
			
		if ( isset( $post_var['soliloquy-pauseplay'] ) && 'false' == $post_var['soliloquy-pauseplay'] )
			$is_pauseplay = '';
		else
			$is_pauseplay = 'soliloquy-fc-pauseplay';
	
		/** Build out our caption input to be customized for the featured content display */
		$output = '<div class="soliloquy-caption">';
			$output .= '<div class="soliloquy-caption-inside soliloquy-fc-caption ' . $is_bullets . ' ' . $is_pauseplay . '">';
				$output .= $image['caption'];
			$output .= '</div>';
		$output .= '</div>';
		
		/** Return the amended caption output */
		return apply_filters( 'tgmsp_fc_image_caption', $output, $id, $image );
	
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