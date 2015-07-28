<?php 

/* Add a meta box for Page Aliases when using the [pagetitle] and [page_subtitle] codes 
 * We use Headway's metabox API to add the options to the posts and pages screens
 */
	
if ( is_admin() )
add_action( 'init', 'utility_page_aliases_meta_boxes_setup' );

/* Setup meta box */
function utility_page_aliases_meta_boxes_setup() {

	 /* return if its not headway */
	if ( !class_exists('Headway') )
		return;
		
	headway_register_admin_meta_box('HeadwayUtilityBlockAliases');
	class HeadwayUtilityBlockAliases extends HeadwayAdminMetaBoxAPI {
		
		protected $id = 'page_aliases';
		
		protected $name = 'Headway Utility: Page Aliases';
		
		protected $post_types = array('page', 'post');
		
		protected $context = 'side';
								
		protected $inputs = array(
			'page_title_alias' => array(
				'id' => 'page_title_alias',
				'name' => 'Page Title',
				'type' => 'textarea',
				'description' => 'Add a page title.'
			),
			'page_subtitle_alias' => array(
				'id' => 'page_sub_title_alias',
				'name' => 'Page Sub Title',
				'type' => 'textarea',
				'description' => 'Add a page subtitle'
			),
		);
		
	}
}
