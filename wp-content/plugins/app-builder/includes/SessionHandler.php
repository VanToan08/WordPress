<?php

defined( 'ABSPATH' ) || exit;

/**
 * Session handler class.
 */

if ( !class_exists( 'AppBuilderSessionHandler' ) ) {
	class AppBuilderSessionHandler extends WC_Session {

		/**
		 * Table name for cart data.
		 *
		 * @var string Custom cart table name
		 */
		protected $_table;

		/**
		 * Stores cart due to expire timestamp.
		 *
		 * @var string cart expiration timestamp
		 */
		protected $_cart_expiration;

		/**
		 * Key for the session.
		 *
		 * @var string
		 */
		protected $session_key;

		/**
		 * Constructor for the session class.
		 */
		public function __construct() {

			$this->session_key = 'app_builder_session_' . get_current_blog_id();

			global $wpdb;
			$this->_table = $wpdb->prefix . APP_BUILDER_CART_TABLE;
		}

		/**
		 * Get the session cookie
		 * @return bool
		 */
		public function get_session_cookie(): bool {
			return false;
		}

		/**
		 * Init hooks and session data.
		 */
		public function init() {

			$this->_cart_expiration = time();

			$cart_key = $this->get_cart_key();

			if ( ! empty( $cart_key ) ) {
				$this->restore_data( $cart_key );
			} else {

				if ( headers_sent() ) {
					headers_sent( $file, $line );
					trigger_error( // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error
						sprintf(
							'Session handler cannot start session - headers sent by %s on line $d',
							esc_html( $file ),
							esc_html( $line )
						),
						E_USER_NOTICE
					);

					return;
				}

				session_start(); // phpcs:ignore WordPress.VIP.SessionFunctionsUsage.session_session_start
				$this->_data = $_SESSION[ $this->session_key ]; // phpcs:ignore WordPress.VIP.SessionVariableUsage.SessionVarsProhibited
			}

			add_action( 'shutdown', array( $this, 'save_data' ), 20 );
			add_action( 'wp_logout', array( $this, 'destroy_session' ) );;

			if ( ! is_user_logged_in() ) {
				add_filter( 'nonce_user_logged_out', array( $this, 'nonce_user_logged_out' ) );
			}
		}

		/**
		 *
		 * Get cart key
		 *
		 * @return int|string
		 */
		public function get_cart_key() {
			$customer_id = '';

			if ( is_user_logged_in() ) {
				$customer_id = get_current_user_id();
			}

			if ( empty( $customer_id ) && isset( $_REQUEST['cart_key'] ) ) {
				$customer_id = sanitize_text_field( $_REQUEST['cart_key'] );
			}

			return $customer_id;
		}

		/**
		 * Generate a unique customer ID for guests, or return user ID if logged in.
		 *
		 * Uses Portable PHP password hashing framework to generate a unique cryptographically strong ID.
		 *
		 * @return string
		 */
		public function generate_customer_id() {
			$customer_id = $this->get_cart_key();

			if ( empty( $customer_id ) ) {
				require_once ABSPATH . 'wp-includes/class-phpass.php';
				$hasher      = new PasswordHash( 8, false );
				$customer_id = md5( $hasher->get_random_bytes( 32 ) );
			}

			return $customer_id;
		}

		/**
		 * Save data.
		 */
		public function save_data() {
			if ( $this->_dirty ) {

				$cart_key = $this->get_cart_key();

				if ( empty( $cart_key ) ) {
					$_SESSION[ $this->session_key ] = $this->_data;
				} else {
					global $wpdb;
					$wpdb->query(
						$wpdb->prepare(
							"INSERT INTO {$this->_table} (`cart_key`, `blog_id`, `cart_value`, `cart_expiry`) VALUES (%s, %s, %s, %d)
 					ON DUPLICATE KEY UPDATE `cart_key` = VALUES(`cart_key`), `cart_value` = VALUES(`cart_value`), `cart_expiry` = VALUES(`cart_expiry`)",
							$this->_customer_id,
							get_current_blog_id(),
							maybe_serialize( $this->_data ),
							$this->_cart_expiration
						)
					);
				}
				$this->_dirty = false;
			}
		}

		/**
		 * Destroy all session data.
		 */
		public function destroy_session() {

			$cart_key = $this->get_cart_key();

			if ( empty( $cart_key ) ) {
				unset( $_SESSION[ $this->session_key ] ); // phpcs:ignore WordPress.VIP.SessionVariableUsage.SessionVarsProhibited
			} else {
				global $wpdb;
				// Delete cart from database.
				$wpdb->delete( $this->_table, array( 'cart_key' => $this->_customer_id ) );
			}

			wc_empty_cart();
			$this->_data  = array();
			$this->_dirty = false;
		}

		/**
		 * Clean all cart expire
		 */
		public function cleanup_sessions() {
			global $wpdb;
			// The cart save forever
			// $wpdb->query( $wpdb->prepare( "DELETE FROM $this->_table WHERE cart_expiry < %d", time() ) );
		}

		/**
		 *
		 * Restore cart
		 *
		 * @param $customer_id
		 */
		public function restore_data( $customer_id ) {
			global $wpdb;

			$this->_customer_id = $customer_id;

			$value = $wpdb->get_var( $wpdb->prepare( "SELECT cart_value FROM $this->_table WHERE cart_key = %s", $customer_id ) );

			$this->_data = maybe_unserialize( $value );

		}

		/**
		 * When a user is logged out, ensure they have a unique nonce by using the customer/session ID.
		 *
		 * @param int $uid User ID.
		 *
		 * @return string
		 */
		public function nonce_user_logged_out( $uid ) {
			return $this->_customer_id ? $this->_customer_id : $uid;
		}
	}
}