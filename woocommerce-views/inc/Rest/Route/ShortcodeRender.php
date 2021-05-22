<?php // phpcs:ignore

namespace WooViews\Rest\Route;

use WooViews\Rest\Route\ShortcodePreviewHacks\Factory as ShortcodeHackFactory;
use ToolsetCommonEs\Rest\Route\ARoute as ARoute;

/**
 * Handles shortcode rendering
 */
class ShortcodeRender extends ARoute {
	/**
	 * Route Name
	 *
	 * @var string
	 */
	protected $name = 'ShortcodeRender';
	/**
	 * Route version
	 *
	 * @var int
	 */
	protected $version = 1;

	/**
	 * Route callback
	 *
	 * @param \WP_REST_Request $rest_request Rest request.
	 * @return array
	 */
	public function callback( \WP_REST_Request $rest_request ) {
		$params = $rest_request->get_json_params();

		$result = [];

		$hack_factory = new ShortcodeHackFactory();
		foreach ( $params as $cachehash => $param ) {
			if ( isset( $param['current_post_id'] ) && isset( $param['shortcode'] ) ) {
				$hack = $hack_factory->get_hack( $param['current_post_id'], $param['shortcode'] );
				$hack->do_hack();
				$shortcode_content    = $this->get_content( $param['current_post_id'], $param['shortcode'] );
				$shortcode_content    = $hack->maybe_force_content( $shortcode_content );
				$result[ $cachehash ] = ! $shortcode_content && $hack->has_default_content() ? $hack->get_default_content() : $shortcode_content;
				$hack->restore();
			}
		}

		return $result;
	}

	/**
	 * Returns the api content
	 *
	 * @param int    $post_id Post ID.
	 * @param string $shortcode Shortcode.
	 * @return string
	 */
	protected function get_content( $post_id, $shortcode ) {
		global $post;
		$post = \WP_Post::get_instance( $post_id ); // phpcs:ignore

		$content = do_shortcode( $shortcode );

		if ( strpos( $content, '[' ) !== false ) {
			$content = do_shortcode( $content );
		}

		return $content;
	}

	/**
	 * Permissions callback
	 *
	 * @return boolean
	 */
	public function permission_callback() {
		// @todo check for Toolset Access permissions
		return current_user_can( 'edit_posts' );
	}
}
