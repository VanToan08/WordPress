<?php

/**
 * class StoreHook
 *
 * @link       https://appcheap.io
 * @author     ngocdt
 * @since      2.7.0
 *
 */

namespace AppBuilder\Hooks;

defined( 'ABSPATH' ) || exit;

class StoreHook {
	public function __construct() {
		add_action( 'woocommerce_blocks_checkout_update_order_from_request', array(
			$this,
			'update_order_billing_from_request'
		), 10, 2 );

		add_action( 'woocommerce_blocks_checkout_update_order_from_request', array(
			$this,
			'update_order_shipping_from_request'
		), 11, 2 );
	}

	/**
	 * Fires when the Checkout Block/Store API updates an order from the API request data.
	 *
	 * @param \WC_Order $order Order object.
	 * @param \WP_REST_Request $request Full details about the request.
	 */
	public function update_order_billing_from_request( $order, $request ) {

		if ( ! function_exists( 'WOOCCM' ) ) {
			return;
		}

		$order_id = $order->get_id();
		$data     = $request->get_param( 'billing_address' );

		if ( count( $fields = WOOCCM()->billing->get_fields() ) ) {

			foreach ( $fields as $field_id => $field ) {

				$key      = sprintf( '_%s', $field['key'] );
				$key_data = str_replace( '_billing_', '', $key );

				if ( ! empty( $data[ $key_data ] ) ) {

					$value = $data[ $key_data ];

					if ( $field['type'] == 'textarea' ) {
						update_post_meta( $order_id, $key, wp_kses( $value, false ) );
					} else if ( is_array( $value ) ) {
						update_post_meta( $order_id, $key, implode( ',', array_map( 'sanitize_text_field', $value ) ) );
					} else {
						update_post_meta( $order_id, $key, sanitize_text_field( $value ) );
					}
				}
			}
		}
	}

	/**
	 * Fires when the Checkout Block/Store API updates an order from the API request data.
	 *
	 * @param \WC_Order $order Order object.
	 * @param \WP_REST_Request $request Full details about the request.
	 */
	public function update_order_shipping_from_request( $order, $request ) {

		if ( ! function_exists( 'WOOCCM' ) ) {
			return;
		}

		$order_id = $order->get_id();
		$data     = $request->get_param( 'shipping_address' );

		if ( count( $fields = WOOCCM()->shipping->get_fields() ) ) {

			foreach ( $fields as $field_id => $field ) {

				$key      = sprintf( '_%s', $field['key'] );
				$key_data = str_replace( '_shipping_', '', $key );

				if ( ! empty( $data[ $key_data ] ) ) {

					$value = $data[ $key_data ];

					if ( $field['type'] == 'textarea' ) {
						update_post_meta( $order_id, $key, wp_kses( $value, false ) );
					} else if ( is_array( $value ) ) {
						update_post_meta( $order_id, $key, implode( ',', array_map( 'sanitize_text_field', $value ) ) );
					} else {
						update_post_meta( $order_id, $key, sanitize_text_field( $value ) );
					}
				}
			}
		}
	}
}
