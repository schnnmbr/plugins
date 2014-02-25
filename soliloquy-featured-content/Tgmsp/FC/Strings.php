<?php
/**
 * Strings class for the Soliloquy Featured Content Addon.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy Featured Content
 * @author	Thomas Griffin
 */
class Tgmsp_FC_Strings {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Holds a copy of all the strings used by the Soliloquy Featured Content Addon.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $strings = array();

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

		$this->strings = apply_filters( 'tgmsp_fc_strings', array(
			'asc'						=> __( 'Ascending Order', 'soliloquy-fc' ),
			'author'					=> __( 'Author', 'soliloquy-fc' ),
			'comments'					=> __( 'Comments', 'soliloquy-fc' ),
			'content'					=> __( 'Content Settings', 'soliloquy-fc' ),
			'content_type'              => __( 'Select the type of content to display in the slider:', 'soliloquy-fc' ),
			'date'						=> __( 'Date', 'soliloquy-fc' ),
			'desc'						=> __( 'Descending Order', 'soliloquy-fc' ),
			'ellipses'					=> __( 'Append an ellipses to the post content?', 'soliloquy-fc' ),
			'ellipses_desc'				=> __( 'Places an ellipses after the last word of the post content.', 'soliloquy-fc' ),
			'exclude'					=> __( 'Exclude', 'soliloquy-fc' ),
			'fallback'					=> __( 'Specify a fallback image URL if no image is found:', 'soliloquy-fc' ),
			'fallback_desc'				=> __( 'Used if no images can be found.', 'soliloquy-fc' ),
			'featured_label'			=> __( 'Featured Content Slider', 'soliloquy-fc' ),
			'id'						=> __( 'ID', 'soliloquy-fc' ),
			'include'					=> __( 'Include', 'soliloquy-fc' ),
			'intro'						=> __( 'The Featured Content Slider will use images that have been set as a featured image in your posts, pages or custom post types. If you have not set featured images for the content type you want to include, consider using the Default Slider option instead.', 'soliloquy-fc' ),
			'menu_order'				=> __( 'Menu Order', 'soliloquy-fc' ),
			'modified_date'				=> __( 'Modified Date', 'soliloquy-fc' ),
			'no_content'                => __( 'No Content', 'soliloquy-fc' ),
			'post_content'				=> __( 'Post Content', 'soliloquy-fc' ),
			'post_excerpt'              => __( 'Post Excerpt', 'soliloquy-fc' ),
			'post_content_length' 		=> __( 'Set the number of words to display:', 'soliloquy-fc' ),
			'post_content_length_desc' 	=> __( 'Defaults to 40 words.', 'soliloquy-fc' ),
			'post_slug'					=> __( 'Post Slug', 'soliloquy-fc' ),
			'post_title'				=> __( 'Display the post title?', 'soliloquy-fc' ),
			'post_title_desc'			=> __( 'If unchecked, no post title will be displayed for the image.', 'soliloquy-fc' ),
			'post_title_link'			=> __( 'Link post title to the post URL?', 'soliloquy-fc' ),
			'post_title_link_desc'		=> __( 'If unchecked, the post title will not be linked to a URL.', 'soliloquy-fc' ),
			'post_url'					=> __( 'Link image to the post URL?', 'soliloquy-fc' ),
			'post_url_desc'				=> __( 'If unchecked, the image will not be linked to a URL.', 'soliloquy-fc' ),
			'query'						=> __( 'Query Settings', 'soliloquy-fc' ),
			'random'					=> __( 'Random', 'soliloquy-fc' ),
			'read_more'					=> __( 'Display a read more link?', 'soliloquy-fc' ),
			'read_more_desc'			=> __( 'If unchecked, no read more link will be displayed.', 'soliloquy-fc' ),
			'read_more_default'			=> __( 'Continue Reading...', 'soliloquy-fc' ),
			'read_more_text'			=> __( 'Set the read more link text:', 'soliloquy-fc' ),
			'read_more_text_desc'		=> __( 'Defaults to "Continue Reading..."', 'soliloquy-fc' ),
			'step_one'					=> __( 'Select your post type (or multiple post types if you prefer):', 'soliloquy-fc' ),
			'step_one_hold'				=> esc_attr__( 'Select post types to query (defaults to post)…', 'soliloquy-fc' ),
			'step_two'					=> __( 'Choose a term or terms to determine what content is included:', 'soliloquy-fc' ),
			'step_two_hold'				=> esc_attr__( 'Select term or terms (defaults to none)…', 'soliloquy-fc' ),
			'step_three'				=> __( 'Let\'s %s ONLY the following items:', 'soliloquy-fc' ),
			'step_three_hold'			=> esc_attr__( 'Make your selection (defaults to none)…', 'soliloquy-fc' ),
			'step_four'					=> __( 'Let\'s sort these posts by:', 'soliloquy-fc' ),
			'step_five'					=> __( 'Let\'s also order these posts by:', 'soliloquy-fc' ),
			'step_six'					=> __( 'Enter the maximum number of slides for the slider:', 'soliloquy-fc' ),
			'step_seven'				=> __( 'Enter the number of posts to offset:', 'soliloquy-fc' ),
			'step_eight'				=> __( 'Select the post status for the posts:', 'soliloquy-fc' ),
			'title'						=> __( 'Title', 'soliloquy-fc' )
		) );

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