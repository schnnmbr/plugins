<?php // phpcs:ignore

namespace WooViews\Rest;

use \ToolsetCommonEs\Rest\Route\IRoute;
use \ToolsetCommonEs\Rest\Route\ShortcodeRender;

/**
 * REST API class
 */
class API {
	/**
	 * API namespace
	 *
	 * @var string
	 */
	private $namespace = 'WooViews/Rest/API';

	/**
	 * Array of Routes
	 *
	 * @var IRoute[]
	 */
	private $routes = array();

	/**
	 * Adds a route
	 *
	 * @param IRoute $route Route.
	 */
	public function add_route( IRoute $route ) {
		$this->routes[] = $route;
	}

	/**
	 * Returns the list of version + route name
	 */
	public function get_routes_paths() {
		$list = [];
		foreach ( $this->routes as $route ) {
			$list[ $route->get_name() ] = $this->namespace . '/v' . $route->get_version() . '/' . $route->get_name();
		}
		return $list;
	}

	/**
	 * Inits Rest API
	 *
	 * @action rest_api_init 1
	 */
	public function rest_api_init() {
		foreach ( $this->routes as $route ) {
			$namespace_w_version = $this->namespace . '/v' . $route->get_version();
			$route_w_slash = '/' . $route->get_name();

			register_rest_route(
				$namespace_w_version,
				$route_w_slash,
				array(
					'methods'             => $route->get_method(),
					'callback'            => array( $route, 'callback' ),
					'permission_callback' => array( $route, 'permission_callback' ),
				)
			);
		}
	}
}
