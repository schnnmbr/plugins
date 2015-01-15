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
        's2_headerbg_color',
        array(
            'default'     => '#FFF'

        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'headerbg_color',
            array(
                'label'      => __( 'HeaderBG Color', 's2' ),
                'section'    => 'colors',
                'settings'   => 's2_headerbg_color'
            )
    
        )
    );
    $wp_customize->add_setting(
        's2_sitetitle_color',
        array(
            'default'     => '#2b2b2b'

        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sitetitle_color',
            array(
                'label'      => __( 'SiteTitle Color', 's2' ),
                'section'    => 'colors',
                'settings'   => 's2_sitetitle_color'
            )
    
        )
    );
    $wp_customize->add_setting(
        's2_sitedescription_color',
        array(
            'default'     => '#3c3c3c'

        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sitedescription_color',
            array(
                'label'      => __( 'SiteDescription Color', 's2' ),
                'section'    => 'colors',
                'settings'   => 's2_sitedescription_color'
            )
    
        )
    );

     $wp_customize->add_setting(
        's2_nav_primarybg_color',
        array(
            'default'     => '#666'

        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'navprimarybg_color',
            array(
                'label'      => __( 'NavPrimaryBG Color', 's2' ),
                'section'    => 'colors',
                'settings'   => 's2_nav_primarybg_color'
            )
    
        )
    );

    $wp_customize->add_setting(
        's2_nav_primarysubnavbg_color',
        array(
            'default'     => '#666'

        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'navprimarysubnavbg_color',
            array(
                'label'      => __( 'NavPrimary SubnavBG Color', 's2' ),
                'section'    => 'colors',
                'settings'   => 's2_nav_primarysubnavbg_color'
            )
    
        )
    );

     $wp_customize->add_setting(
        's2_nav_primary_link_color',
        array(
            'default'     => '#999'

        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'navprimarylink_color',
            array(
                'label'      => __( 'NavPrimaryLink Color', 's2' ),
                'section'    => 'colors',
                'settings'   => 's2_nav_primary_link_color'
            )
    
        )
    );
    $wp_customize->add_setting(
        's2_nav_primary_linkhover_color',
        array(
            'default'     => '#FF0000'

        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'navprimarylinkhover_color',
            array(
                'label'      => __( 'NavPrimary LinkHover Color', 's2' ),
                'section'    => 'colors',
                'settings'   => 's2_nav_primary_linkhover_color'
            )
    
        )
    );


    $wp_customize->add_setting(
        's2_link_color',
        array(
            'default'     => '#1e73be'

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
        's2_entrybg_color',
        array(
            'default'     => '#FFFFFF'

        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'link_color',
            array(
                'label'      => __( 'EntryBG Color', 's2' ),
                'section'    => 'colors',
                'settings'   => 's2_entrybg_color'
            )
    
        )
    );



    $wp_customize->add_setting(
        's2_postinfo_color',
        array(
            'default'     => '#DDD'

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
            'default'     => '#222'

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
        's2_paginationactive_color',
        array(
            'default'     => '#222'

        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'paginationactive_color',
            array(
                'label'      => __( 'Pagination Active Color', 's2' ),
                'section'    => 'colors',
                'settings'   => 's2_paginationactive_color'
            )
    
        )
    );

    $wp_customize->add_setting(
        's2_paginationbg_color',
        array(
            'default'     => '#EEE'

        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'paginationbg_color',
            array(
                'label'      => __( 'Pagination BG Color', 's2' ),
                'section'    => 'colors',
                'settings'   => 's2_paginationbg_color'
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
        .entry {background: <?php echo get_theme_mod( 's2_entrybg_color' ); ?>;}
        .nav-primary .genesis-nav-menu a {color: <?php echo get_theme_mod( 's2_nav_primary_link_color' ); ?>;}
        .nav-primary .genesis-nav-menu a:hover{color: <?php echo get_theme_mod( 's2_nav_primary_linkhover_color' ); ?>;}
        .nav-primary {background: <?php echo get_theme_mod( 's2_nav_primarybg_color' ); ?>;}
        .genesis-nav-menu .sub-menu a {background: <?php echo get_theme_mod( 's2_nav_primarysubnavbg_color' ); ?>;}
        .site-header {background-color: <?php echo get_theme_mod( 's2_headerbg_color' ); ?>;}
        .site-title a, .site-title a:hover {color:<?php echo get_theme_mod( 's2_sitetitle_color' ); ?>;}
        .site-description {color:<?php echo get_theme_mod( 's2_sitedescription_color' ); ?>;}
       .nav-primary .genesis-nav-menu a {color: <?php echo get_theme_mod( 's2_nav_primary_link_color' ); ?>;}
	   .archive-pagination li a:hover, .archive-pagination li.active a {background: <?php echo get_theme_mod( 's2_paginationactive_color' ); ?>; }
       .archive-pagination li a {background:<?php echo get_theme_mod( 's2_paginationbg_color' ); ?>;}
       
    </style>
    <?php
}
add_action( 'wp_head', 's2_customizer_css' );