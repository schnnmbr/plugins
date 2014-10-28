<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//Run this after the admin has been initialized so they appear as standard WordPress notices.
if( isset( $_GET['page'] ) && ! isset( $_GET['action'] ) && $_GET['page'] == 'themify-builder' )
	add_action('admin_notices', 'themify_builder_check_version', 3);

if(defined('WP_DEBUG') && WP_DEBUG){
	delete_transient('themify_builder_new_update');
	delete_transient('themify_builder_check_update');
}

/**
 * Set transient saving the current date and time of last version checking
 */
function themify_builder_set_update(){
	$current = new stdClass();
	$current->lastChecked = time();
	set_transient( 'themify_builder_check_update', $current );
}

/**
 * Check for new update
 */
function themify_builder_check_version() {
	$notifications = '<style type="text/css">.notifications p.update {background: #F9F2C6;border: 1px solid #F2DE5B;} .notifications p{width: 765px;margin: 15px 0 0 5px;padding: 10px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;}</style>';
	$version = THEMIFY_BUILDER_VERSION;

	// Check update transient
	$current = get_transient('themify_builder_check_update'); // get last check transient
	$timeout = 60;
	$time_not_changed = isset( $current->lastChecked ) && $timeout > ( time() - $current->lastChecked );
	$newUpdate = get_transient('themify_builder_new_update'); // get new update transient

	if ( is_object( $newUpdate ) && $time_not_changed ) {
		if ( version_compare( $version, $newUpdate->version, '<') ) {
			$notifications .= sprintf( __('<p class="update %s">%s version %s is now available. <a href="%s" title="" class="%s" target="%s">Update now</a> or view the <a href="http://themify.me/logs/%s-changelogs" title="" class="" target="_blank">change log</a> for details.</p>', 'themify'), $newUpdate->login, ucwords('themify-builder'), $newUpdate->version, $newUpdate->url, $newUpdate->class, $newUpdate->target, 'themify-builder');
			echo '<div class="notifications">'. $notifications . '</div>';
		}
		return;
	}

	// get remote version
	$remote_version = themify_builder_get_remote_plugin_version( 'themify-builder' );

	// delete update checker transient
	delete_transient( 'themify_builder_check_update' );

	$class = "";
	$target = "";
	$url = "#";
	
	$new = new stdClass();
	$new->login = 'login';
	$new->version = $remote_version;
	$new->url = $url;
	$new->class = 'themify-builder-upgrade-plugin';
	$new->target = $target;

	if ( version_compare( $version, $remote_version, '<' ) ) {
		set_transient( 'themify_builder_new_update', $new );
		$notifications .= sprintf( __('<p class="update %s">%s version %s is now available. <a href="%s" title="" class="%s" target="%s">Update now</a> or view the <a href="http://themify.me/logs/%s-changelogs" title="" class="" target="_blank">change log</a> for details.</p>', 'themify'), $new->login, ucwords('themify-builder'), $new->version, $new->url, $new->class, $new->target, 'themify-builder');
	}

	// update transient
	themify_builder_set_update();

	echo '<div class="notifications">'. $notifications . '</div>';
}

/**
 * Check if update available
 */
function themify_builder_is_update_available() {
	$version = THEMIFY_BUILDER_VERSION;
	$newUpdate = get_transient('themify_builder_new_update'); // get new update transient

	if ( false === $newUpdate ) {
		$new_version = themify_builder_get_remote_plugin_version( 'themify-builder' );
	} else {
		$new_version = $newUpdate->version;
	}

	if ( version_compare( $version, $new_version, '<') ) {
		return true;
	} else {
		false;
	}
}

/**
 * Get remote version from server
 * @param string $name
 */
function themify_builder_get_remote_plugin_version( $name ) {
	$xml = new DOMDocument;
	$versions_url = 'http://themify.me/versions/versions.xml';
	$response = wp_remote_get( $versions_url );
	if( is_wp_error( $response ) ) 
		return;

	$body = trim( wp_remote_retrieve_body( $response ) );
	$xml->loadXML($body);
	$xml->preserveWhiteSpace = false;
	$xml->formatOutput = true;
	$xpath = new DOMXPath($xml);
	$query = "//version[@name='".$name."']";
	$version = '';

	$elements = $xpath->query($query);

	if( $elements->length ) {
		foreach ($elements as $field) {
			$version = $field->nodeValue;
		}
	}
	return $version;
}

/**
 * Updater called through wp_ajax_ action
 */
function themify_builder_updater(){
	
	// check version
	if ( ! themify_builder_is_update_available() ) {
		_e('The plugin is at the latest version.', 'themify');
		die();
	}

	//are we going to update a theme?
	$url = 'http://themify.me/files/themify-builder/themify-builder.zip';
	
	//If login is required
	if($_GET['login'] == 'true'){

			if(isset($_POST['password'])){
	            $cred = $_POST;
	            $filesystem = WP_Filesystem($cred);
	        }
			else{
				$filesystem = WP_Filesystem();
			}

			$response = wp_remote_post(
				'http://themify.me/member/login.php',
				array(
					'timeout' => 300,
					'headers' => array(
						
					),
					'body' => array(
						'amember_login' => $_POST['username'],
						'amember_pass'  => $_POST['password']
					)
			    )
			);

			//Was there some error connecting to the server?
			if( is_wp_error( $response ) ) {
				$errorCode = $response->get_error_code();
				echo 'Error: ' . $errorCode;
				die();
			}

			//Connection to server was successful. Test login cookie
			$amember_nr = false;
			foreach($response['cookies'] as $cookie){
				if($cookie->name == 'amember_nr'){
					$amember_nr = true;
				}
			}
			if(!$amember_nr){
				_e('You are not a Themify Member.', 'themify');
				die();
			}
	}
	
	//remote request is executed after all args have been set
	include ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	require_once(THEMIFY_BUILDER_CLASSES_DIR . '/class-themify-builder-upgrader.php');
	$title = __('Update Themify Builder plugin', 'themify');
	$nonce = 'upgrade-themify_plugin';
	
	$upgrader = new Themify_Builder_Upgrader( new Plugin_Upgrader_Skin(
		array(
			'plugin' => THEMIFY_BUILDER_SLUG,
			'title' => __('Update Builder')
		)
	));
	$upgrader->upgrade( THEMIFY_BUILDER_SLUG, $url, $response['cookies'] );
	
	//if we got this far, everything went ok!	
	die();
}

/**
 * Validate login credentials against Themify's membership system
 */
function themify_builder_validate_login(){
	$response = wp_remote_post(
		'http://themify.me/member/login.php',
		array(
			'timeout' => 300,
			'headers' => array(
				
			),
			'body' => array(
				'amember_login' => $_POST['username'],
				'amember_pass'  => $_POST['password']
			)
	    )
	);

	//Was there some error connecting to the server?
	if( is_wp_error( $response ) ) {
		$errorCode = $response->get_error_code();
		echo 'Error: ' . $errorCode;
		die();
	}

	//Connection to server was successful. Test login cookie
	$amember_nr = false;
	foreach($response['cookies'] as $cookie){
		if($cookie->name == 'amember_nr'){
			$amember_nr = true;
		}
	}
	if(!$amember_nr){
		echo 'false';
		die();
	}

	echo 'true';
	die();
}

//Executes themify_updater function using wp_ajax_ action hook
add_action('wp_ajax_themify_builder_validate_login', 'themify_builder_validate_login');

add_filter( 'update_plugin_complete_actions', 'themify_builder_upgrade_complete', 10, 2 );
function themify_builder_upgrade_complete($update_actions, $plugin) {
	if ( $plugin == THEMIFY_BUILDER_SLUG ) {
		$update_actions['themify_complete'] = '<a href="' . self_admin_url('admin.php?page=themify-builder') . '" title="' . __('Return to Builder Settings', 'themify') . '" target="_parent">' . __('Return to Builder Settings', 'themify') . '</a>';
	}
	return $update_actions;
}
?>