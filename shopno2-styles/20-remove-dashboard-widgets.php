<?php
/*
Plugin Name: 20 - Remove Dashboard Widgets
Plugin URI: http://shopno2.com
Description: A simple plugin that applies better shopno2 security
Author: sachin nambiar
Author URI: shopno2.com
Version: 0.3
*/
/* Disallow direct access to the plugin file */
 
if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
	die('Sorry, but you cannot access this page directly.');
}
 
/** START ADDING CODE BELOW THIS LINE **/
// Remove Dashboard Widgets
function shopno2_remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side');
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side');
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal');
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal');
	remove_meta_box( 'dashboard_welcome', 'dashboard', 'normal');
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal');
	remove_action( 'welcome_panel', 'wp_welcome_panel' );
//	wp_deregister_script('postbox');//Disable Drag 'n' Drop of Metaboxesin Admin
} 

// Hook into the 'wp_dashboard_setup' action to register function
//add_action('wp_dashboard_setup', 'shopno2_remove_dashboard_widgets' );
add_action('admin_init', 'shopno2_remove_dashboard_widgets' );




//Shopno2 Admin Theme
//function shopno2_admin_head() {
//	echo '<link rel="stylesheet" type="text/css" href="' .plugins_url('admin.css', __FILE__). '">';


//add_action('admin_head', 'shopno2_admin_head');

//Comment "IN" if CUSTOM WELCOME PANEL is WANTED
/*function shopno2_welcome_panel() {

	?>


	<div class="custom-welcome-panel-content">
	<h1><?php _e( 'Welcome to shopno2 Content Management System!' ); ?></h1>
	<p class="about-description"><?php _e( 'You can create your own content right from this Dashboard!' ); ?></p>
	<div class="welcome-panel-column-container">
	<div class="welcome-panel-column">
		<h4><?php _e( "Let's Get Started" ); ?></h4>
		<a class="button button-primary button-hero load-customize hide-if-no-customize" href="post-new.php?post_type=page"><?php _e( 'Add a Site Page' ); ?></a>
			<p class="hide-if-no-customize"><?php printf( __( 'or, <a href="%s">Check Current Pages</a>' ), admin_url( 'edit.php?post_type=page' ) ); ?></p>
	</div>
	<div class="welcome-panel-column">

		<h4><?php _e( 'Next Steps' ); ?></h4>
		<ul>
		<?php if ( 'page' == get_option( 'show_on_front' ) && ! get_option( 'page_for_posts' ) ) : ?>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-edit-page">' . __( 'Edit your front page' ) . '</a>', get_edit_post_link( get_option( 'page_on_front' ) ) ); ?></li>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-add-page">' . __( 'Add additional pages' ) . '</a>', admin_url( 'post-new.php?post_type=page' ) ); ?></li>
		<?php elseif ( 'page' == get_option( 'show_on_front' ) ) : ?>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-edit-page">' . __( 'Edit your front page' ) . '</a>', get_edit_post_link( get_option( 'page_on_front' ) ) ); ?></li>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-add-page">' . __( 'Add additional pages' ) . '</a>', admin_url( 'post-new.php?post_type=page' ) ); ?></li>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-write-blog">' . __( 'Add a blog post' ) . '</a>', admin_url( 'post-new.php' ) ); ?></li>
		<?php else : ?>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-write-blog">' . __( 'Write your first blog post' ) . '</a>', admin_url( 'post-new.php' ) ); ?></li>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-add-page">' . __( 'Add an About page' ) . '</a>', admin_url( 'post-new.php?post_type=page' ) ); ?></li>
		<?php endif; ?>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-view-site">' . __( 'View your site' ) . '</a>', home_url( '/' ) ); ?></li>
		</ul>
	</div>
	<div class="welcome-panel-column welcome-panel-last">
		<h4><?php _e( 'More Actions' ); ?></h4>
		<ul>
			<li><?php printf( '<div class="welcome-icon welcome-widgets-menus">' . __( 'Manage <a href="%1$s">widgets</a> or <a href="%2$s">menus</a>' ) . '</div>', admin_url( 'widgets.php' ), admin_url( 'nav-menus.php' ) ); ?></li>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-comments">' . __( 'Turn comments on or off' ) . '</a>', admin_url( 'options-discussion.php' ) ); ?></li>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-learn-more">' . __( 'Learn more about getting started' ) . '</a>', __( 'http://codex.wordpress.org/First_Steps_With_WordPress' ) ); ?></li>
		</ul>
	</div>
	</div>
	<div class="">
	<h3><?php _e( 'shopno2 Support Options' ); ?></h3>
	<p class="about-description">Create a new paragraph!</p>
	<ol><li> <a href="http://es.gy/priority">Priority Support</a> </li>
		<li> <a href="http://es.gy/help">Forums</a>
	</ol>
	</div>
	</div>

<?php
}

add_action( 'welcome_panel', 'shopno2_welcome_panel' );
/** STOP ADDING CODE NOW**/
 
/* That's all folks! */
 
/*?>*/
