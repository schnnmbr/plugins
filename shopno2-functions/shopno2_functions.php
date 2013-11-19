<?php
/*
Plugin Name: Shopno2 Functions.php
Plugin URI: http://shopno2.com
Description: A simple plugin that contains all Custom Functions
Author: sachin nambiar
Author URI: shopno2.com
Version: 0.3
*/
 
/* Disallow direct access to the plugin file */
 
if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
	die('Sorry, but you cannot access this page directly.');
}
 
/** START ADDING CODE BELOW THIS LINE **/

// CUSTOM ADMIN MENU LINK FOR ALL SETTINGS
//   function all_settings_link() {
//    add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
//   }
//   add_action('admin_menu', 'all_settings_link');
   
/**
 * Generic function to show a message to the user using WP's
 * standard CSS classes to make use of the already-defined
 * message colour scheme.
 *
 * @param $message The message you want to tell the user.
 * @param $errormsg If true, the message is an error, so use
 * the red message style. If false, the message is a status
  * message, so use the yellow information message style.
 */
/*function showMessage($message, $errormsg = false)
{
    if ($errormsg) {
        echo '<div id="message" class="error">';
    }
    else {
        echo '<div id="message" class="updated fade">';
    }
 
    echo "<p><strong>$message</strong></p></div>";
}
*/
/**
 * Just show our message (with possible checking if we only want
 * to show message to certain users.
 */
/*function showAdminMessages()
{
    // Shows as an error message. You could add a link to the right page if you wanted.
    showMessage("You need to upgrade your database as soon as possible...", true);

    // Only show to admins
    if (user_can('manage_options') {
       showMessage("Hello admins!");
    }
}

/** 
  * Call showAdminMessages() when showing other admin 
  * messages. The message only gets shown in the admin
  * area, but not on the frontend of your WordPress site. 
  */
/*add_action('admin_notices', 'showAdminMessages'); 
*/



// Obscure login screen error messages
function shopno2_login_obscure(){ return 'Wrong Username/Password Combination';}
add_filter( 'login_errors', 'shopno2_login_obscure' );



function shopno2_custom_admin_bar_setting() {
	if (is_admin())
		return TRUE;
	else
		return FALSE;
}




 //Uncomment Below Line To Hide Admin Bar For Logged In Users
//add_filter ('show_admin_bar', 'shopno2_custom_admin_bar_setting');

 // remove wp version param from any enqueued scripts
function shopno2_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
//remove css jss from head
add_filter( 'style_loader_src', 'shopno2_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'shopno2_remove_wp_ver_css_js', 9999 );

// remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

function shopno2_remove_extra_meta_boxes() {
//remove_meta_box( 'postcustom' , 'post' , 'normal' ); // custom fields for posts
//remove_meta_box( 'postcustom' , 'page' , 'normal' ); // custom fields for pages
//remove_meta_box( 'postexcerpt' , 'post' , 'normal' ); // post excerpts
//remove_meta_box( 'postexcerpt' , 'page' , 'normal' ); // page excerpts
remove_meta_box( 'commentsdiv' , 'post' , 'normal' ); // recent comments for posts
remove_meta_box( 'commentsdiv' , 'page' , 'normal' ); // recent comments for pages
remove_meta_box( 'tagsdiv-post_tag' , 'post' , 'side' ); // post tags
remove_meta_box( 'tagsdiv-post_tag' , 'page' , 'side' ); // page tags
remove_meta_box( 'trackbacksdiv' , 'post' , 'normal' ); // post trackbacks
remove_meta_box( 'trackbacksdiv' , 'page' , 'normal' ); // page trackbacks
remove_meta_box( 'commentstatusdiv' , 'post' , 'normal' ); // allow comments for posts
remove_meta_box( 'commentstatusdiv' , 'page' , 'normal' ); // allow comments for pages
remove_meta_box('slugdiv','post','normal'); // post slug
remove_meta_box('slugdiv','page','normal'); // page slug
//remove_meta_box('pageparentdiv','page','side'); // Page Parent Attributes. Necessary to use page attributes.
}
add_action( 'admin_menu' , 'shopno2_remove_extra_meta_boxes' );

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

//Replace Howdy with a more corporate sounding "Hello"
function shopno2_replace_howdy( $wp_admin_bar ) {
    $my_account=$wp_admin_bar->get_node('my-account');
    $newtitle = str_replace( 'Howdy,', 'Hello', $my_account->title );            
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $newtitle,
    ) );
}
add_filter( 'admin_bar_menu', 'shopno2_replace_howdy',25 );

//Remove the theme editor menu which is anyway never allowed to use.
function shopno2_remove_editor_menu() {
  remove_action('admin_menu', '_add_themes_utility_last', 101);
}

add_action('_admin_menu', 'shopno2_remove_editor_menu', 1);

//Change Wordpress Verison in footer to fool hackers.
/*function shopno2_change_footer_version() {
  return '<a href="mailto:support@es.gy">email support</a>';
}
add_filter( 'update_footer', 'shopno2_change_footer_version', 9999 );
*/
//Custom Footer Text
function shopno2_remove_footer_admin () {
  echo '<i>Thank you for being our Customer! :) </i>';
}
add_filter('admin_footer_text', 'shopno2_remove_footer_admin');




/*shopno2 Login Screen*/
function shopno2_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.content_url('').'/mu-plugins/s2logo-72.png) !important; }
    </style>';
}

add_action('login_head', 'shopno2_custom_login_logo');

//shopno2 Admin Screen Branding
function shopno2_custom_logo() {
  echo '<style type="text/css">
    #header-logo { background-image: url('.content_url('').'/mu-plugins/s2logo-72.png) !important; }
    </style>';
}

add_action('admin_head', 'shopno2_custom_logo');


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
 
/*?>
