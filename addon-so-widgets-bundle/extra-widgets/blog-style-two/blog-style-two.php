<?php

/*
Widget Name: Blog Style Two
Description: Blog style Two.
Author: Ingenious Solutions
Author URI: http://ingenious-web.com/
*/

class Blog_Style_Two extends SiteOrigin_Widget {
	function __construct() {

		parent::__construct(
			'blog-style-two',
			__('Blog Style two', 'addon-so-widgets-bundle'),
			array(
				'description' => __('Blog style two.', 'addon-so-widgets-bundle'),
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


                'layout' => array(
                    'type' => 'radio',
                    'label' => __( 'Choose a Layout', 'addon-so-widgets-bundle' ),
                    'default' => 'col-md-6',
                    'options' => array(
                        'six columns' => __( '2 Column Layout', 'widget-form-fields-text-domain' ),
                        'one-third column' => __( '3 Column Layout', 'widget-form-fields-text-domain' ),
                        'three columns' => __( '4 Column Layout', 'widget-form-fields-text-domain' ),
                    )
                ),

                'blog_two_styling' => array(
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
		return 'blog-style-two-template';
	}

	function get_style_name($instance) {
		return 'blog-style-two-style';
	}

    function get_less_variables( $instance ) {
        return array(
            'title_color' => $instance['blog_two_styling']['title_color'],
            'content_color' => $instance['blog_two_styling']['content_color'],
            'meta_color' => $instance['blog_two_styling']['meta_color'],
        );
    }

}


siteorigin_widget_register('blog-style-two', __FILE__, 'Blog_Style_Two');