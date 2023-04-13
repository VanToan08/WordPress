<?php

/**
 * class Checkout
 *
 * @link       https://appcheap.io
 * @since      3.1.0
 * @author     ngocdt
 *
 */

namespace AppBuilder\Api;

use AppBuilder\Data\CartData;

defined( 'ABSPATH' ) || exit;

class Checkout extends Base {

	private $gateways = [
		'paystack'               => 'AppBuilder\Gateway\PayStackGateway',
		'paytabs_all'            => 'AppBuilder\Gateway\PayTabsGateway',
		'myfatoorah_v2'          => 'AppBuilder\Gateway\MyFatoorahV2Gateway',
		'rave'                   => 'AppBuilder\Gateway\FlutterWaveGateway\FlutterWaveGateway',
		'woo-mercado-pago-basic' => 'AppBuilder\Gateway\MercadopagoGateway',
		'vnpay'                  => 'AppBuilder\Gateway\VnpayGateway',
		'razorpay'               => 'AppBuilder\Gateway\RazopayGateway',
	];

	public function __construct() {
		$this->namespace = constant( 'APP_BUILDER_REST_BASE' ) . '/v1';

		// Init hooks and filters
		new \AppBuilder\Gateway\RazopayGateway();
	}

	public function register_routes() {
		register_rest_route( $this->namespace, 'confirm-payment', array(
			'methods'             => \WP_REST_Server::CREATABLE,
			'callback'            => array( $this, 'confirm_payment' ),
			'permission_callback' => '__return_true',
		) );
	}

	public function confirm_payment( $request ) {
		$gateway = $request->get_param( 'gateway' );
		$action  = $request->get_param( 'action' );

		if ( $action == 'clean' ) {
			return rest_ensure_response( $this->clean_cart( $request ) );
		}

		if ( empty( $gateway ) ) {
			return new \WP_Error(
				"app_builder_payment_confirm",
				__( "The payment id not exits.", "app-builder" ),
				array(
					'status' => 403,
				)
			);
		}

		if ( isset( $this->gateways[ $gateway ] ) ) {
			$class = new $this->gateways[ $gateway ]();

			return rest_ensure_response( $class->confirm_payment( $request ) );
		}

		return new \WP_Error(
			"app_builder_payment_confirm",
			__( "The payment not implement yet.", "app-builder" ),
			array(
				'status' => 403,
			)
		);
	}

	public function clean_cart( $request ): array {
		$cart_key = $request->get_param( 'cart_key' );

		$cart = new CartData();
		$cart->remove_cart_by_cart_key( $cart_key );

		return [
			'redirect' => 'order',
		];
	}
}
