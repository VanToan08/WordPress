<?php

/**
 * class Cart
 *
 * @link       https://appcheap.io
 * @since      1.0.0
 * @author     ngocdt
 *
 */

namespace AppBuilder\Api;

defined( 'ABSPATH' ) || exit;

use AppBuilder\Utils;

class Cart extends Base {
	public function __construct() {
		$this->namespace = APP_BUILDER_REST_BASE . '/v1';
	}

	public function register_routes() {
		if ( isset( $_REQUEST['cart_key'] ) && Utils::is_rest_api_request() ) {
			add_filter( 'woocommerce_store_api_disable_nonce_check', '__return_true' );
		}

		register_rest_route( $this->namespace, 'clean-cart', array(
			'methods'             => \WP_REST_Server::CREATABLE,
			'callback'            => array( $this, 'clean_cart' ),
			'permission_callback' => '__return_true',
		) );
	}

	/**
	 *
	 * Delete cart by cart key
	 *
	 * @param $request
	 *
	 * @return \WP_Error|\WP_HTTP_Response|\WP_REST_Response
	 */
	public function clean_cart( $request ) {
		global $wpdb;

		$cart_key = $request->get_param( 'cart_key' );

		// Delete cart from database.
		$result = $wpdb->delete( $wpdb->prefix . APP_BUILDER_CART_TABLE, array( 'cart_key' => $cart_key ) );

		// Delete the persistent cart permanently.
		if ( get_current_user_id() && apply_filters( 'woocommerce_persistent_cart_enabled', true ) ) {
			delete_user_meta( get_current_user_id(), '_woocommerce_persistent_cart_' . get_current_blog_id() );
		}

		return rest_ensure_response( (bool) $result );
	}
}
