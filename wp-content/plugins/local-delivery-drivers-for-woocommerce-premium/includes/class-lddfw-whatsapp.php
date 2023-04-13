<?php
/**
 * Plugin WHATSAPP.
 *
 * All the WHATSAPP functions.
 *
 * @package    LDDFW
 * @subpackage LDDFW/includes
 * @author     powerfulwp <apowerfulwp@gmail.com>
 */

/**
 * Plugin WHATSAPP.
 *
 * All the WHATSAPP functions.
 *
 * @package    LDDFW
 * @subpackage LDDFW/includes
 * @author     powerfulwp <apowerfulwp@gmail.com>
 */
class LDDFW_WHATSAPP {


	/**
	 * Check whatsapp
	 *
	 * @param string $to_number whatsapp number.
	 * @param string $whatsapp_text whatsapp content.
	 * @return array
	 */
	public function lddfw_check_whatsapp__premium_only( $to_number, $whatsapp_text ) {
		$whatsapp_provider = get_option( 'lddfw_whatsapp_provider', '' );
		if ( '' === $whatsapp_provider ) {
			return array( 0, __( 'Failed to send WhatsApp, the WhatsApp provider is missing.', 'lddfw' ) );
		}
		if ( 'twilio' !== $whatsapp_provider ) {
			return array( 0, __( 'Failed to send WhatsApp, the WhatsApp provider is not supported.', 'lddfw' ) );
		}

		$sid = get_option( 'lddfw_whatsapp_api_sid', '' );
		if ( '' === $sid ) {
			return array( 0, __( 'Failed to send WhatsApp, the SID is missing.', 'lddfw' ) );
		}

		$auth_token = get_option( 'lddfw_whatsapp_api_auth_token', '' );
		if ( '' === $auth_token ) {
			return array( 0, __( 'Failed to send WhatsApp, the auth token is missing.', 'lddfw' ) );
		}

		$from_number = get_option( 'lddfw_whatsapp_api_phone', '' );
		if ( '' === $from_number ) {
			return array( 0, __( 'Failed to send WhatsApp, the WhatsApp phone number is missing.', 'lddfw' ) );
		}

		if ( '' === $to_number ) {
			return array( 0, __( 'Failed to send WhatsApp, the phone number is missing.', 'lddfw' ) );
		}
		if ( '' === $whatsapp_text ) {
			return array( 0, __( 'Failed to send WhatsApp, the WhatsApp text is missing.', 'lddfw' ) );
		}

		return array( 1, 'ok', 'lddfw' );
	}

	/**
	 * Sens whatsapp to customer
	 *
	 * @param int    $order_id order number.
	 * @param object $order order object.
	 * @param int    $order_status order status.
	 * @return array
	 */
	public function lddfw_send_whatsapp_to_customer__premium_only( $order_id, $order, $order_status ) {
		$driver_id             = $order->get_meta( 'lddfw_driverid' );
		$country_code          = $order->get_billing_country();
		$customer_phone_number = $order->get_billing_phone();

		$whatsapp_text = '';
		if ( get_option( 'lddfw_out_for_delivery_status', '' ) === 'wc-' . $order_status ) {
			$whatsapp_text = get_option( 'lddfw_whatsapp_out_for_delivery_template', '' );
		}

		if ( 'start_delivery' === $order_status ) {
			$whatsapp_text = get_option( 'lddfw_whatsapp_start_delivery_template', '' );
		}

		$result = $this->lddfw_check_whatsapp__premium_only( $customer_phone_number, $whatsapp_text );
		if ( 0 === $result[0] ) {
			return $result;
		}

		$customer_phone_number = lddfw_get_international_phone_number( $country_code, $customer_phone_number );

		$whatsapp_text = lddfw_replace_tags__premium_only( $whatsapp_text, $order_id, $order, $driver_id );

		return $this->lddfw_send_whatsapp__premium_only( $whatsapp_text, $customer_phone_number );
	}

	/**
	 * Send whatsapp to driver
	 *
	 * @param int    $order_id order number.
	 * @param object $order order object.
	 * @param int    $driver_id user id number.
	 * @return array
	 */
	public function lddfw_send_whatsapp_to_driver__premium_only( $order_id, $order, $driver_id ) {
		$country_code        = get_user_meta( $driver_id, 'billing_country', true );
		$driver_phone_number = get_user_meta( $driver_id, 'billing_phone', true );
		$whatsapp_text       = get_option( 'lddfw_whatsapp_assign_to_driver_template', '' );

		$result = $this->lddfw_check_whatsapp__premium_only( $driver_phone_number, $whatsapp_text );
		if ( 0 === $result[0] ) {
			return $result;
		}

		$driver_phone_number = lddfw_get_international_phone_number( $country_code, $driver_phone_number );
		$whatsapp_text       = lddfw_replace_tags__premium_only( $whatsapp_text, $order_id, $order, $driver_id );
		return $this->lddfw_send_whatsapp__premium_only( $whatsapp_text, $driver_phone_number );
	}
	/**
	 * Sens whatsapp
	 *
	 * @param string $whatsapp_text whatsapp text.
	 * @param string $to_number whatsapp phone number.
	 * @return array
	 */
	public function lddfw_send_whatsapp__premium_only( $whatsapp_text, $to_number ) {
		$from_number       = get_option( 'lddfw_whatsapp_api_phone', '' );
		$whatsapp_provider = get_option( 'lddfw_whatsapp_provider', '' );
		$sid               = get_option( 'lddfw_whatsapp_api_sid', '' );
		$auth_token        = get_option( 'lddfw_whatsapp_api_auth_token', '' );
		if ( 'twilio' === $whatsapp_provider ) {
			return $this->lddfw_send_whatsapp_twilio__premium_only( $whatsapp_text, $from_number, $to_number, $sid, $auth_token );

		}
	}



	 /**
	  * Send WhatsApp by twilio.
	  *
	  * @param string $text WhatsApp text.
	  * @param string $from_number WhatsApp from phone number.
	  * @param string $to_number WhatsApp to phone number.
	  * @param string $sid sid number.
	  * @param string $auth_token token.
	  * @return array
	  */
	public function lddfw_send_whatsapp_twilio__premium_only( $text, $from_number, $to_number, $sid, $auth_token ) {

		$url  = "https://api.twilio.com/2010-04-01/Accounts/$sid/Messages.json";
		$data = array(
			'From' => 'whatsapp:' . $from_number,
			'To'   => 'whatsapp:' . $to_number,
			'Body' => $text,
		);
		$post = http_build_query( $data );
		$ch   = curl_init( $url );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
		curl_setopt( $ch, CURLOPT_USERPWD, "$sid:$auth_token" );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
		$return = curl_exec( $ch );
		curl_close( $ch );
		$json = json_decode( $return, true );
		if ( ( ! empty( $json['status'] ) ) && 'queued' === strval( $json['status'] ) ) {
			/* translators: %s: phone number */
			return array( 1, sprintf( __( 'WhatsApp has been sent successfully to %s', 'lddfw' ), $to_number ) );
		} else {
			/* translators: %s: phone number */
			return array( 0, sprintf( __( 'Failed to send WhatsApp to %1$s, status %2$s', 'lddfw' ), $to_number, $json['status'] . ' - ' . $json['message'] ) );
		}
	}
}
