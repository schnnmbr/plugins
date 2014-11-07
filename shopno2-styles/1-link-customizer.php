<?php
/*
Plugin Name: 1 - link customizer
Plugin URI: http://shopno2.com
Description: Customise your link color
Author: sachin nambiar
Author URI: sachinnambiar.com
Version: 0.1
*/

//Add content Link Color In Theme Customizer
function s2_register_content_link_color( $wp_customize ) {

    $wp_customize->add_setting(
        's2_link_color',
        array(
            'default'     => '#000000'

        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'link_color',
            array(
                'label'      => __( 'Link Color', 's2' ),
                'section'    => 'colors',
                'settings'   => 's2_link_color'
            )
    
        )
    );
    $wp_customize->add_setting(
        's2_postinfo_color',
        array(
            'default'     => '#000000'

        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'postinfo_color',
            array(
                'label'      => __( 'PostInfo Color', 's2' ),
                'section'    => 'colors',
                'settings'   => 's2_postinfo_color'
            )
    
        )
    );
    $wp_customize->add_setting(
        's2_entrytitle_color',
        array(
            'default'     => '#000000'

        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'entrytitle_color',
            array(
                'label'      => __( 'Entry Title Color', 's2' ),
                'section'    => 'colors',
                'settings'   => 's2_entrytitle_color'
            )
    
        )
    );
      $wp_customize->add_setting(
        's2_headerbg_color',
        array(
            'default'     => '#000000'

        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'link_color',
            array(
                'label'      => __( 'HeaderBG Color', 's2' ),
                'section'    => 'colors',
                'settings'   => 's2_headerbg_color'
            )
    
        )
    );

}
add_action( 'customize_register', 's2_register_content_link_color' );



function s2_customizer_css() {
    ?>
    <style type="text/css">
        .entry-content a { color: <?php echo get_theme_mod( 's2_link_color' ); ?>; }
        a {color: <?php echo get_theme_mod( 's2_postinfo_color' ); ?>;}
        a:hover {color: <?php echo get_theme_mod( 's2_link_color' ); ?>;}
        .entry-title a, .sidebar .widget-title a {color: <?php echo get_theme_mod( 's2_entrytitle_color' ); ?>;}
        .entry-title a:hover, .sidebar .widget-title a:hover {color: <?php echo get_theme_mod( 's2_link_color' ); ?>;}
        .nav-primary .genesis-nav-menu a:hover, .nav-primary .genesis-nav-menu .current-menu-item > a, .nav-primary .genesis-nav-menu .sub-menu .current-menu-item > a:hover {color: <?php echo get_theme_mod( 's2_link_color' ); ?>;}
        .genesis-nav-menu a:hover,
        .genesis-nav-menu .current-menu-item > a,
        .genesis-nav-menu .sub-menu .current-menu-item > a:hover {color: <?php echo get_theme_mod( 's2_link_color' ); ?>;}
        .nav-primary {background-color: <?php echo get_theme_mod( 's2_entrytitle_color' ); ?>;}
        .site-header {background-color: <?php echo get_theme_mod( 's2_headerbg_color' ); ?>;}
    
    </style>
    <?php
}
add_action( 'wp_head', 's2_customizer_css' );