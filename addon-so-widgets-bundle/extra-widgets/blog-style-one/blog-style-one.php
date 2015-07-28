<?php

/*
Widget Name: Blog Style One
Description: Blog style One.
Author: Ingenious Solutions
Author URI: http://ingenious-web.com/
*/

class Blog_Style_One extends SiteOrigin_Widget {
	function __construct() {

		parent::__construct(
			'blog-style-one',
			__('Blog Style One', 'blog-style-one-text-domain'),
			array(
				'description' => __('Blog style One.', 'addon-so-widgets-bundle'),
                'panels_icon' => 'dashicons dashicons-welcome-write-blog',
                'panels_groups' => array('addonso')
			),
			array(

			),

			array(
				'widget_title' => array(
					'type' => 'text',
					'label' => __('Widget Title', 'addon-so-widgets-bundle'),
					'default' => ''
				),


                'posts' => array(
                    'type' => 'posts',
                    'label' => __('Select Posts', 'addon-so-widgets-bundle'),
                ),

                'blog_one_styling' => array(
                    'type' => 'section',
                    'label' => __( 'Widget styling' , 'widget-form-fields-text-domain' ),
                    'hide' => true,
                    'fields' => array(

                        'title_color' => array(
                            'type' => 'color',
                            'label' => __( 'Title color', 'widget-form-fields-text-domain' ),
                            'default' => ''
                        ),

                        'content_color' => array(
                            'type' => 'color',
                            'label' => __( 'Content color', 'widget-form-fields-text-domain' ),
                            'default' => ''
                        ),

                        'meta_color' => array(
                            'type' => 'color',
                            'label' => __( 'Meta color', 'widget-form-fields-text-domain' ),
                            'default' => ''
                        ),


                    )
                ),



            ),


			plugin_dir_path(__FILE__)
		);
	}

	function get_template_name($instance) {
		return 'blog-style-one-template';
	}

	function get_style_name($instance) {
		return 'blog-style-one-style';
	}

    function get_less_variables( $instance ) {
        return array(
            'title_color' => $instance['blog_one_styling']['title_color'],
            'content_color' => $instance['blog_one_styling']['content_color'],
            'meta_color' => $instance['blog_one_styling']['meta_color'],
        );
    }




}

siteorigin_widget_register('blog-style-one', __FILE__, 'Blog_Style_One');