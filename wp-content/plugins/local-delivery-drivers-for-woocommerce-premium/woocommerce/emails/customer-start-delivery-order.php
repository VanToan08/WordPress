<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>
<p><?php printf( esc_html__( 'Hi %s,', 'lddfw' ), esc_html( $order->get_billing_first_name() ) ); ?></p>
<?php /* translators: %s: Order number */ ?>
<p><?php printf( esc_html__( 'Just to let you know &mdash; the delivery for your order #%s has been started.', 'lddfw' ), esc_html( $order->get_order_number() ) ); ?></p>

<?php


// Tracking.
if ( '' !== get_option( 'lddfw_tracking_page', '' ) ) {
	$tracking_url = lddfw_tracking_page_url__premium_only( $order->get_id() );
	if ( '' !== $tracking_url ) {
		?>
			<p>
				<a style = "text-decoration: none; border-radius:4px; color:#fff; background-color: #3ED625; padding: 10px;display: inline-block; text-align: center;" href="<?php echo $tracking_url; ?>" ><?php echo esc_html__( 'Track your order', 'lddfw' ); ?></a>
			</p>
		<?php
	}
}

// ETA.
$route = $order->get_meta( 'lddfw_order_route' );
if ( ! empty( $route ) ) {
	$duration_text = $route['duration_text'];
	if ( '' !== $duration_text ) {
		?>
			<p><?php printf( esc_html__( 'Estimated time of arrival: %s', 'lddfw' ), esc_html( $duration_text ) ); ?></p>
		<?php
	}
}

$lddfw_driver_id = $order->get_meta( 'lddfw_driverid' );
if ( '' !== $lddfw_driver_id ) {
	$driver = new LDDFW_Driver();
	if ( '' !== $lddfw_driver_id ) {
		echo $driver->get_driver_info__premium_only( $lddfw_driver_id, 'html' );
		echo $driver->get_vehicle_info__premium_only( $lddfw_driver_id, 'html' );
	}
}


/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
