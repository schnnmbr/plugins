<?php

/*
  Plugin Name: Pizazz ExcerptsPlus (Headway 3 Block)
  Plugin URI: http://guides.pizazzwp.com/excerptsplus/about-excerpts/
  Description: ExcerptsPlus is the Swiss Army Knife of content display, providing flexible and advanced content display. Adds a block that provides many more excerpt and content display options. Can be used to setup magazine layouts, featured post sliders, and even simple image galleries. In conjunction with custom posts types can create almost anything!
  Author: Chris Howard
  Author URI: http://pizazzwp.com
  Version: 3.4.9
  License: GNU GPL v2

 */

define('EPVERSION', '3.4.9');

define('EP_BLOCK_URL', plugin_dir_url(__FILE__));
define('EP_BLOCK_PATH', plugin_dir_path(__FILE__));

$upload_dir = wp_upload_dir();
define('EP_CACHE_URL', $upload_dir['baseurl'] . '/cache/pizazzwp/eplus');
define('EP_CACHE_PATH', $upload_dir['basedir'] . '/cache/pizazzwp/eplus');

define('EP_CACHE_URL_PREFIX', EP_CACHE_URL . '/eplus-');
define('EP_CACHE_PATH_PREFIX', EP_CACHE_PATH . '/eplus-');

define('EP_USER_GUIDE_URL', 'http://guides.pizazzwp.com/excerptsplus/about-excerpts/');

define('CHDEBUG', 'false');
define('CHDEBUGNOIMAGES', 'false'); // To test with no images. Do not delete.



if (!function_exists('pizazzwp_head'))
{
//	return false;
}
require EP_BLOCK_PATH . '/ep2_functions.php';

if (!class_exists('jo_Resize')) {
	require EP_BLOCK_PATH . '/includes/jo-resizer/jo_image_resizer.php';
}

require EP_BLOCK_PATH . '/ep2_admin.php';
//require EP_BLOCK_PATH.'/check-pizazz.php';
require_once EP_BLOCK_PATH . '/includes/dependency-check/ep-check-dependencies.php';

if (is_admin())
{
	add_action('admin_init', 'ep_initiate_updater');

	function ep_initiate_updater() {
		$opt_val = get_option('pizazz_options');
		if (class_exists('HeadwayUpdaterAPI') && empty($opt_val['val_update_method']))
		{

			$updater = new HeadwayUpdaterAPI(array(
				'slug'						 => 'excerptsplus',
				'path'						 => plugin_basename(__FILE__),
				'name'						 => 'ExcerptsPlus',
				'type'						 => 'block',
				'current_version'	 => EPVERSION
			));
		}
		else
		{
			require_once('wp-updates-plugin.php');
			$ep_update = new WPUpdatesPluginUpdater_255( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__));
      // Need to customize updater script if it changes for this var
//      if (empty($ep_update->response)) {
//         // Need to triple check!
//          // Load WP auto updater
//          require EP_BLOCK_PATH . '/libs/plugin-update-checker.php';
//          $ExcerptsPlusUpdateChecker = new PluginUpdateChecker(
//              'https://s3.amazonaws.com/341public/LATEST/versioninfo/excerptsplusmetadata.json',
//              __FILE__,
//              'pzexcerptsplus'
//          );
//      }
		}
	}

}
// Do an an version check in Pizazz
if (is_admin() && $_SERVER['QUERY_STRING'] === 'page=pizazz-help')
{
	add_action('pizazzwp_updates_excerptsplus', 'ep_check_version');
}

if (is_admin())
{
	add_action('admin_notices', 'ep_check_cache');
}

// Setup cache clearing as required
add_action('post_updated', 'ep_clear_post_image_cache');
add_action('headway_visual_editor_save', 'ep_clear_image_cache');

add_action('wp_footer', 'ep_quickread_code', 2);

register_deactivation_hook(__FILE__, 'ep_deactivate');


add_action('after_setup_theme', 'ep_register_block');

function ep_register_block() {
	if (!class_exists('HeadwayBlockAPI') )
	{
		return false;
	}
	EPFunctions::php_debug('ExcerptsPlus v' . EPVERSION);

	require EP_BLOCK_PATH . '/ep2_display.php';
	require EP_BLOCK_PATH . '/ep2_options.php';

	add_theme_support('post-formats', array('aside', 'gallery'));

	return headway_register_block('HeadwayExcerptsPBlock', substr(WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), '', plugin_basename(__FILE__)), 0, -1));
}

register_activation_hook(__FILE__, 'ep_activate');

function ep_activate() {
  if (class_exists('TGM_Plugin_Activation')){
    TGM_Plugin_Activation::get_instance()->update_dismiss();
  }
	if (!class_exists('HeadwayBlockAPI'))
	{
		exit("Headway Theme v3 not active. Cannot activate the ExcerptsPlus block.");
	}

	// for each HW block, if it's a E+, then update its content type selection
	// $settings	 = HeadwayExcerptsPBlockOptions::get_settings( $block );
	//Install Pizazz


	return;

	//Kept this incase need something like it

	$blocks = HeadwayBlocksData::get_all_blocks();

	if (is_array($blocks))
	{

		foreach ($blocks as $block_id => $block)
		{

			if ($block['type'] == 'excerpts-plus')
			{
				echo $block['id'], ' : ', $block['type'], ' ';
				$field = HeadwayBlockAPI::get_setting($block, 'ep-content-in-post');
				if (is_array($field))
				{
					foreach ($field as $key => $value)
					{
						echo $value;
					}
				}
				else
				{
					if (!isset($field))
					{
						echo 'Default was true, so lets make this true';
						// Do we really want to do this? How will it affect those pre-3.1.1?
//			    	$block['settings']['ep-content-in-post'] = true;
//						HeadwayBlocksData::update_block($block['layout'], $block['id'],$block);
					}
					elseif ($field === false)
					{
						echo 'False';
					}
					elseif ($field == false)
					{
						echo 'False-ish';
					}
					elseif ($field == true)
					{
						echo 'True';
					}
				}
				echo '<br/>';
			}
		}
		exit;
	}
}

function ep_deactivate() {
	// empty headway cache
//	headway_clear_cache();
	// empty ep cache
	ep_clear_image_cache();
}

function ep_check_version() {
	//runs only in admin and user can manage
	// checks online version info
	// Presents download link to latest version
	// Provide link to changelog
	if (!current_user_can('manage_options'))
		return false;

	$latest_version_array = wp_remote_get('https://s3.amazonaws.com/341public/LATEST/versioninfo/epversion-block.txt', array('timeout' => 2));

	if (is_wp_error($latest_version_array))
	{
		echo 'Could not contact updates server. Try again later.';
		return false;
	}

	$latest_version	 = $latest_version_array['body'];
	$is_beta				 = strpos(EPVERSION, 'b');
	$current_version = ($is_beta) ? substr(EPVERSION, $is_beta) : EPVERSION;
	$is_new_version	 = version_compare($latest_version, $current_version, '>');
//		var_dump($current_version,$latest_version,$is_new_version);

	$pz_version_id = str_replace('.', '', $latest_version);
	if ($is_new_version)
	{

		echo '<div id="update-nag" class="pizazzwp-updates-available pzwp-show-update-excerptsplus">ExcerptsPlus ' . $latest_version . ' is available, you\'re running ' . EPVERSION . '!  Go to the <a href="' . get_site_url() . '/wp-admin/plugins.php">Plugins page</a> and update it.<br/>
				Or download and manually install it from here:
				<a href="https://s3.amazonaws.com/341public/LATEST/headway-excerptsplus-' . $pz_version_id . '.zip">headway-excerptsplus-' . $pz_version_id . '</a>
				</div>';
	}
	else
	{
		echo '<div style="font-weight:bold;margin-bottom:5px;">You have the latest version</div>';
		echo '<div class="pzwp-show-update-excerptsplus">You can re-download it at anytime from here:<br/>
				<a href="https://s3.amazonaws.com/341public/LATEST/headway-excerptsplus-' . $pz_version_id . '.zip">headway-excerptsplus-' . $pz_version_id . '</a>
				</div>';
	}
}

function ep_check_cache() {

	$pzep_err_level = error_reporting();

	// Check exists
	if (!is_dir(EP_CACHE_PATH))
	{
		$upload_dir = wp_upload_dir();
//		error_reporting(0);
//		mkdir($upload_dir['basedir'] . '/cache');
//		mkdir($upload_dir['basedir'] . '/cache/pizazzwp');
//		mkdir($upload_dir['basedir'] . '/cache/pizazzwp/eplus');
//		error_reporting($pzep_err_level);
		// Trying to use WPsversion instead.
		wp_mkdir_p($upload_dir['basedir'] . '/cache/pizazzwp/eplus' );
	}

	if (!is_dir(EP_CACHE_PATH))
	{
		echo '<div id="message" class="error"><p>Unable to create ExcerptsPlus Image Cache folders. You will have to manually create the following folders:</p>
			&nbsp;&nbsp;&nbsp;&nbsp;wp-content/uploads/cache<br/>
			&nbsp;&nbsp;&nbsp;&nbsp;wp-content/uploads/cache/pizazzwp<br/>
			&nbsp;&nbsp;&nbsp;&nbsp;wp-content/uploads/cache/pizazzwp/eplus<br/>
			<p>using FTP and set their permissions to 777<br/><br/></p>
		</div>';
	}

	// Check can write
	if (!is_writable(EP_CACHE_PATH))
	{
		echo '<div id="message" class="error"><p>ExcerptsPlus Image Cache folders are not writable.</p>';
		echo 'Check the permissions of: <strong>', EP_CACHE_PATH, '</strong>';
		echo ' using FTP and set its permissions to 755 or 777';
		echo '<br/><br/></div>';
	}
}

/**
 * Add meta links in Plugins table
 */

add_filter( 'plugin_row_meta', 'ep_plugin_meta_links', 10, 2 );
function ep_plugin_meta_links( $links, $file ) {

  $plugin = plugin_basename(__FILE__);

  // create link
  if ( $file == $plugin ) {
    return array_merge(
      $links,
      array( '<a href="https://s3.amazonaws.com/341public/LATEST/versioninfo/ep-changelog.html" target="_blank">Changelog</a>','<a href="http://guides.pizazzwp.com/excerptsplus/about-excerpts/" target="_blank">Online guide</a>','<a href="mailto:support@pizazzwp.com" target=_blank>User support</a>' )
    );
  }
  return $links;
}
