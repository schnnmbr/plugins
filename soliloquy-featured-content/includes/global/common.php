<?php
/**
 * Metabox class.
 *
 * @since 2.2.2
 *
 * @package Soliloquy_Featured_Content_Common
 * @author  Tim Carr
 */
class Soliloquy_Featured_Content_Common {

    /**
     * Holds the class object.
     *
     * @since 2.2.2
     *
     * @var object
     */
    public static $instance;

    /**
     * Path to the file.
     *
     * @since 2.2.2
     *
     * @var string
     */
    public $file = __FILE__;

    /**
     * Holds the base class object.
     *
     * @since 2.2.2
     *
     * @var object
     */
    public $base;

    /**
     * Primary class constructor.
     *
     * @since 1.0.0
     */
    public function __construct() {

    	// Get base instance
    	$this->base = Soliloquy_Featured_Content::get_instance();

    	// Actions and filters
    	add_action( 'save_post', array( $this, 'flush_global_caches' ), 999 );
    	add_action( 'pre_post_update', array( $this, 'flush_global_caches' ), 999 );
    	add_action( 'soliloquy_flush_caches', array( $this, 'flush_caches' ), 10, 2 );

    }

    /**
     * Callback for post types to exclude from the dropdown select box.
     *
     * @since 1.0.0
     *
     * @return array Array of post types to exclude.
     */
    function get_post_types() {

        $post_types = apply_filters( 'soliloquy_fc_excluded_post_types', array( 'attachment', 'soliloquy', 'envira' ) );
        return (array) $post_types;

    }

    /**
     * Callback for taxonomies to exclude from the dropdown select box.
     *
     * @since 1.0.0
     *
     * @return array Array of taxonomies to exclude.
     */
    function get_taxonomies() {

        $taxonomies = apply_filters( 'soliloquy_fc_excluded_taxonomies', array( 'nav_menu' ) );
        return (array) $taxonomies;

    }

    /**
     * Callback for taxonomy relation options.
     *
     * @since 2.2.7
     *
     * @return array Array of taxonomies to exclude.
     */
    function get_taxonomy_relations() {

        $relations = array(
            'AND' => __( 'Posts must have ALL of the above taxonomy terms (AND)', 'soliloquy-fc' ),
            'IN' => __( 'Posts must have ANY of the above taxonomy terms (IN)', 'soliloquy-fc' ),   
        );

        // Allow relations to be filtered
        $relations = apply_filters( 'soliloquy_fc_taxonomy_relations', $relations );

        return (array) $relations;

    }

    /**
     * Returns the available orderby options for the query.
     *
     * @since 1.0.0
     *
     * @return array Array of orderby data.
     */
    function get_orderby() {

        $orderby = array(
            array(
                'name'  => __( 'Date', 'soliloquy-fc' ),
                'value' => 'date'
            ),
            array(
                'name'  => __( 'ID', 'soliloquy-fc' ),
                'value' => 'ID'
            ),
            array(
                'name'  => __( 'Author', 'soliloquy-fc' ),
                'value' => 'author'
            ),
            array(
                'name'  => __( 'Title', 'soliloquy-fc' ),
                'value' => 'title'
            ),
            array(
                'name'  => __( 'Menu Order', 'soliloquy-fc' ),
                'value' => 'menu_order'
            ),
            array(
                'name'  => __( 'Random', 'soliloquy-fc' ),
                'value' => 'rand'
            ),
            array(
                'name'  => __( 'Comment Count', 'soliloquy-fc' ),
                'value' => 'comment_count'
            ),
            array(
                'name'  => __( 'Post Name', 'soliloquy-fc' ),
                'value' => 'name'
            ),
            array(
                'name'  => __( 'Modified Date', 'soliloquy-fc' ),
                'value' => 'modified'
            ),
            array(
                'name'  => __( 'Meta Value', 'soliloquy-fc' ),
                'value' => 'meta_value',
            ),
            array(
                'name'  => __( 'Meta Value (Numeric)', 'soliloquy-fc' ),
                'value' => 'meta_value_num',
            ),  
        );

        return apply_filters( 'soliloquy_fc_orderby', $orderby );

    }

    /**
     * Returns the available order options for the query.
     *
     * @since 1.0.0
     *
     * @return array Array of order data.
     */
    function get_order() {

        $order = array(
            array(
                'name'  => __( 'Descending Order', 'soliloquy-fc' ),
                'value' => 'DESC'
            ),
            array(
                'name'  => __( 'Ascending Order', 'soliloquy-fc' ),
                'value' => 'ASC'
            )
        );

        return apply_filters( 'soliloquy_fc_order', $order );

    }

    /**
     * Returns the available post status options for the query.
     *
     * @since 1.0.0
     *
     * @return array Array of post status data.
     */
    function get_statuses() {

        $statuses = get_post_stati( array( 'internal' => false ), 'objects' );
        return apply_filters( 'soliloquy_fc_statuses', $statuses );

    }

    /**
     * Returns the available content type options for the query output.
     *
     * @since 1.0.0
     *
     * @return array Array of content type data.
     */
    function get_content_types() {

        $types = array(
            array(
                'name'  => __( 'No Content', 'soliloquy-fc' ),
                'value' => 'none'
            ),
            array(
                'name'  => __( 'Post Content', 'soliloquy-fc' ),
                'value' => 'post_content'
            ),
            array(
                'name'  => __( 'Post Excerpt', 'soliloquy-fc' ),
                'value' => 'post_excerpt'
            )
        );

        return apply_filters( 'soliloquy_fc_content_types', $types );

    }

    /**
	 * Flushes the Featured Content data caches globally on save/update of any post.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id The current post ID.
	 */
	function flush_global_caches( $post_id ) {

	    // Good to go - let's flush the caches.
	    $sliders = Soliloquy::get_instance()->_get_sliders();
	    if ( $sliders ) {
	        foreach ( $sliders as $slider ) {
		        // Check slider ID exists
		        // Does not exist on slider creation
		        if ( !isset( $slider['id'] ) ) {
			        continue;
		        }
		        
	            // Delete the ID cache.
	            delete_transient( '_sol_cache_' . $slider['id'] );
	            delete_transient( '_sol_fc_' . $slider['id'] );

	            // Delete the slug cache.
	            $slug = get_post_meta( $slider['id'], '_sol_slider_data', true );
	            if ( ! empty( $slug['config']['slug'] ) ) {
	                delete_transient( '_sol_cache_' . $slug['config']['slug'] );
	                delete_transient( '_sol_fc_' . $slug['config']['slug'] );
	            }
	        }
	    }

	    // Flush the cache for the slider for this post too.
	    $object = get_post( $post_id );
	    delete_transient( '_sol_cache_' . $post_id );
	    delete_transient( '_sol_fc_' . $post_id );
	    if ( isset( $object->post_name ) ) {
	        delete_transient( '_sol_cache_' . $object->post_name );
	        delete_transient( '_sol_fc_' . $object->post_name );
	    }

	}

	/**
	 * Flushes the Featured Content data caches on save.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id The current post ID.
	 * @param string $slug The current slider slug.
	 */
	function flush_caches( $post_id, $slug ) {

	    delete_transient( '_sol_fc_' . $post_id );
	    delete_transient( '_sol_fc_' . $slug );

	}

    /**
     * Returns the singleton instance of the class.
     *
     * @since 1.0.0
     *
     * @return object The Envira_Pagination_Metaboxes object.
     */
    public static function get_instance() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Soliloquy_Featured_Content_Common ) ) {
            self::$instance = new Soliloquy_Featured_Content_Common();
        }

        return self::$instance;

    }

}

// Load the metabox class.
$soliloquy_featured_content_common = Soliloquy_Featured_Content_Common::get_instance();