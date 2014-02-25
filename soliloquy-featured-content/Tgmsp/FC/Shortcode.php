<?php
/**
 * Shortcode class for the Soliloquy Featured Content Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Featured Content
 * @author	Thomas Griffin
 */
class Tgmsp_FC_Shortcode {

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

		/** Customize the shortcode output for featured content */
		add_filter( 'tgmsp_get_slider_images_args', array( $this, 'query_args' ), 10, 2 );
		add_filter( 'tgmsp_get_image_data', array( $this, 'featured_image' ), 10, 4 );
		add_filter( 'tgmsp_image_data', array( $this, 'featured_image_data' ), 10, 3 );

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
	public function query_args( $args, $id ) {

		/** Bail early if we are not making a featured content slider */
		$meta = get_post_meta( $id, '_soliloquy_settings', true );
		if ( ! $meta || isset( $meta['type'] ) && 'featured' !== $meta['type'] )
			return $args;

		/** Let's customize the query based on what the user would like */
		$query_args = get_post_meta( $id, '_soliloquy_fc', true );
		$new_args 	= array();

		/** Only proceed if we have args to parse */
		if ( $query_args ) {
			/** Prepare any vars that need to be prepped */
			$exception = isset( $query_args['query'] ) && 'include' == $query_args['query'] ? 'post__in' : 'post__not_in';

			/** Modify the args with our new parameters */
			$new_args['post_parent'] 	= null;
			$new_args['post_mime_type']	= null;
			$new_args['post_type'] 		= isset( $query_args['post_types'] ) 		? (array) $query_args['post_types'] : $args['post_type'];
			$new_args['posts_per_page']	= isset( $query_args['number'] ) 			? absint( $query_args['number'] ) : $args['posts_per_page'];
			if ( 0 == $new_args['posts_per_page'] ) {
				unset( $new_args['posts_per_page'] );
				$new_args['no_paging'] = true;
			}

			/** Now we are going to check and see if we need to add new args to the array */
			if ( isset( $query_args['include_exclude'] ) && $query_args['include_exclude'][0] )
				$new_args[$exception] = array_map( 'absint', (array) $query_args['include_exclude'] );

			if ( isset( $query_args['orderby'] ) )
				$new_args['orderby'] = esc_attr( $query_args['orderby'] );

			if ( isset( $query_args['order'] ) )
				$new_args['order'] = esc_attr( $query_args['order'] );

			if ( isset( $query_args['offset'] ) )
				$new_args['offset'] = absint( $query_args['offset'] );

			if ( isset( $query_args['post_status'] ) )
				$new_args['post_status'] = esc_attr( $query_args['post_status'] );
			else
				$new_args['post_status'] = 'publish';

			/** Process custom taxonomies and terms for the slider */
			if ( isset( $query_args['terms'] ) && ! empty( $query_args['terms'][0] ) ) {
				$relation['relation'] = 'AND';
				foreach ( $query_args['terms'] as $term ) {
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
	 * @return string $image Amended HTML for the featured image
	 */
	public function featured_image( $image, $id, $post, $size ) {

		/** Bail early if we are not making a featured content slider */
		$meta = get_post_meta( $id, '_soliloquy_settings', true );
		if ( ! $meta || isset( $meta['type'] ) && 'featured' !== $meta['type'] )
			return $image;

		/** Let's grab the featured image for the featured content slider */
		$thumb_id = apply_filters( 'tgmsp_fc_thumbnail_id', get_post_thumbnail_id( $post->ID ), $id, $post, $size );

		/** If we have a featured image, return with that */
		if ( $thumb_id ) {
			return wp_get_attachment_image_src( $thumb_id, $size );
		} else {
			/** Get our featured content meta */
			$fc_data = get_post_meta( $id, '_soliloquy_fc', true );

			/** If there is no featured image, search for the first image in the post */
			preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', get_post_field( 'post_content', $post->ID ), $matches );

			/** If we have a match, display it, else show the default image URL */
			if ( isset( $matches ) && ! empty( $matches[1][0] ) ) {
				return array( esc_url( $matches[1][0] ), '', '' );
			} else {
				if ( isset( $fc_data['fallback'] ) && ! empty( $fc_data['fallback'] ) )
					return array( esc_url( $fc_data['fallback'] ), '', '' );
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
	 * @return array $data Amended array of image data
	 */
	public function featured_image_data( $data, $post, $id ) {

		/** Bail early if we are not making a featured content slider */
		$meta = get_post_meta( $id, '_soliloquy_settings', true );
		if ( ! $meta || isset( $meta['type'] ) && 'featured' !== $meta['type'] )
			return $data;

		/** Grab our featured metadata from the slider */
		$fc_data = get_post_meta( $id, '_soliloquy_fc', true );

		/** Let's customize the data output based on the featured content items we are using */
		$data['id'] 			= get_post_thumbnail_id( $post->ID );
		$data['alt'] 			= strip_tags( esc_attr( $post->post_title ) );
		$data['title']			= strip_tags( esc_attr( $post->post_title ) );

		/** Link the image to the post URL if the user has selected the option */
		if ( isset( $fc_data['post_url'] ) && $fc_data['post_url'] ) {
			$data['link']		= get_permalink( $post->ID );
			$data['linktitle'] 	= strip_tags( esc_attr( $post->post_title ) );
		} else {
			$data['link']		= '';
			$data['linktitle']	= '';
		}

		// Add a pre-data filter in the event you want to change the link locations.
		$data = apply_filters( 'tgmsp_fc_pre_image_data', $data, $post, $id );

		/** Prepare the caption variable to be concatenated with all of our featured data */
		$caption = '';

		/** If the user wants a post title, let's give it to them */
		if ( isset( $fc_data['post_title'] ) && $fc_data['post_title'] )
			$caption .= '<h2 class="soliloquy-fc-title">';

		if ( isset( $fc_data['post_title'] ) && $fc_data['post_title'] && isset( $fc_data['post_title_link'] ) && $fc_data['post_title_link'] )
			$caption .= '<a href="' . esc_url( $data['link'] ) . '" title="' . esc_attr( $data['linktitle'] ) . '">';

		if ( isset( $fc_data['post_title'] ) && $fc_data['post_title'] )
			$caption .= strip_tags( esc_html( $post->post_title ) );

		if ( isset( $fc_data['post_title'] ) && $fc_data['post_title'] && isset( $fc_data['post_title_link'] ) && $fc_data['post_title_link'] )
			$caption .= '</a>';

		if ( isset( $fc_data['post_title'] ) && $fc_data['post_title'] )
			$caption .= '</h2>';

		/** If the user wants post content, let's give it to them */
		if ( isset( $fc_data['content_type'] ) && 'post-content' == $fc_data['content_type'] && ! empty( $post->post_content ) ) {
			/** Prepare variables to be used in the caption content */
			$title_above 	= isset( $fc_data['post_title'] ) && $fc_data['post_title'] ? 'soliloquy-fc-title-above' : '';
			$content_length = isset( $fc_data['post_content_length'] ) ? absint( $fc_data['post_content_length'] ) : 80;
			$ellipses		= isset( $fc_data['ellipses'] ) && $fc_data['ellipses'] ? '&hellip;' : '';
			$caption .= '<p class="soliloquy-fc-content ' . $title_above . '">' . apply_filters( 'tgmsp_fc_post_content', wp_trim_words( strip_tags( $post->post_content ), $content_length, apply_filters( 'tgmsp_fc_post_content_ellipses', $ellipses, $data, $post, $id, $fc_data ) ), $data, $post, $id, $fc_data );

			/** If the user wants a read more link, let's give it to them */
			if ( isset( $fc_data['read_more'] ) && $fc_data['read_more'] ) {
				$read_more_text = isset( $fc_data['read_more_text'] ) ? strip_tags( $fc_data['read_more_text'] ) : Tgmsp_FC_Strings::get_instance()->strings['read_more_default'];
				$caption .= ' <a class="soliloquy-fc-read-more" href="' . esc_url( $data['link'] ) . '" title="' . esc_attr( $read_more_text ) . '">' . esc_html( $read_more_text ) . '</a>';
			}

			$caption .= '</p>';
		} elseif ( isset( $fc_data['content_type'] ) && 'post-excerpt' == $fc_data['content_type'] && ! empty( $post->post_excerpt ) ) {
		    $title_above = isset( $fc_data['post_title'] ) && $fc_data['post_title'] ? 'soliloquy-fc-title-above' : '';
		    $caption .= '<p class="soliloquy-fc-content ' . $title_above . '">' . apply_filters( 'tgmsp_fc_post_content', $post->post_excerpt, $data, $post, $id, $fc_data );

		    /** If the user wants a read more link, let's give it to them */
			if ( isset( $fc_data['read_more'] ) && $fc_data['read_more'] ) {
				$read_more_text = isset( $fc_data['read_more_text'] ) ? strip_tags( $fc_data['read_more_text'] ) : Tgmsp_FC_Strings::get_instance()->strings['read_more_default'];
				$caption .= ' <a class="soliloquy-fc-read-more" href="' . esc_url( $data['link'] ) . '" title="' . esc_attr( $read_more_text ) . '">' . esc_html( $read_more_text ) . '</a>';
			}

			$caption .= '</p>';
		} else {
			/** If the user wants a read more link, let's give it to them */
			if ( isset( $fc_data['read_more'] ) && $fc_data['read_more'] ) {
				$content_above 	= isset( $fc_data['post_title'] ) && $fc_data['post_title'] ? 'soliloquy-fc-content-above' : '';
				$read_more_text = isset( $fc_data['read_more_text'] ) ? strip_tags( $fc_data['read_more_text'] ) : Tgmsp_FC_Strings::get_instance()->strings['read_more_default'];
				$caption .= ' <a class="soliloquy-fc-read-more ' . $content_above . '" href="' . esc_url( $data['link'] ) . '" title="' . esc_attr( $read_more_text ) . '">' . esc_html( $read_more_text ) . '</a>';
			}
		}

		/** If our caption isn't empty, filter the caption output */
		if ( ! empty( $caption ) ) {
			add_filter( 'tgmsp_caption_output', array( $this, 'featured_caption' ), 10, 3 );
			$strip = apply_filters( 'tgmsp_fc_strip_caption_shortcodes', true, $id );
			if ( $strip )
				$caption = strip_shortcodes( $caption );
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
	 * @return string $html Amended HTML output for the caption
	 */
	public function featured_caption( $html, $id, $image ) {

		/** Determine if the user is using the default navigation bullets/pauseplay or not */
		$meta = get_post_meta( $id, '_soliloquy_settings', true );
		if ( ! $meta || isset( $meta['control'] ) && ! $meta['control'] )
			$is_bullets = '';
		else
			$is_bullets = 'soliloquy-fc-bullets';

		if ( ! $meta || isset( $meta['pauseplay'] ) && ! $meta['pauseplay'] )
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