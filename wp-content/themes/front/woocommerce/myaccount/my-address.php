<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' => esc_html__( 'Billing address', 'front' ),
		'shipping' => esc_html__( 'Shipping address', 'front' ),
	), $customer_id );
} else {
	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' => esc_html__( 'Billing address', 'front' ),
	), $customer_id );
}

$oldcol = 1;
$col    = 1;
?>
<div class="mb-3">
	<h2 class="h5 mb-0">
		<?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'front' ) ); ?>
	</h2>
</div>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	<div class="card-deck d-block d-md-flex u-columns woocommerce-Addresses col2-set addresses">
<?php endif; ?>

<?php foreach ( $get_addresses as $name => $title ) : ?>

	<div class="card mb-4 mb-md-0 p-5 woocommerce-Address">
		<header class="row justify-content-between align-items-end woocommerce-Address-title title">
            <div class="col-6">
                <h2 class="h5 mb-0"><?php echo wp_kses_post( $title ); ?></h2>
            </div>
            <div class="col-6 text-right">
                <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit link-muted"><?php esc_html_e( 'Edit', 'front' ); ?></a>
            </div>
        </header>

        <hr class="mt-2 mb-4">


		<address class="font-size-1 text-secondary"><?php
		$getter  = "get_billing";
		$address = array();

		if ( 0 === $customer_id ) {
			$customer_id = get_current_user_id();
		}

		$customer = new WC_Customer( $customer_id );

		if ( is_callable( array( $customer, $getter ) ) ) {
			$address = $customer->$getter();
			unset( $address['email'], $address['tel'] );
		}
	
		$address_title = '';
        if( isset( $address['company'] ) ) {
            $address_title = $address['company'];
            unset( $address['company'] );
        } elseif( isset( $address['first_name'], $address['last_name'] ) ) {
            $address_title = $address['first_name'] . ' ' . $address['last_name'];
            unset( $address['first_name'] );
            unset( $address['last_name'] );
        }

        if(! empty( $address_title ) ) {
            ?><span class="d-block h5 text-dark"><?php echo esc_html( $address_title ); ?></span><?php
        }

		$address = WC()->countries->get_formatted_address( apply_filters( 'woocommerce_my_account_my_address_formatted_address', $address, $customer->get_id(), 'billing' ) );

        if( $address ) {
            echo wp_kses_post( $address );
        } else {
            echo esc_html__( 'You have not set up this type of address yet.', 'front' );
        }
		?></address>
	</div>

<?php endforeach; ?>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	</div>
<?php endif;
