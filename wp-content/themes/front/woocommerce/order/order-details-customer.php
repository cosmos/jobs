<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
	<div class="col-sm-6 mb-3 mb-sm-0">
		<?php if ( $show_shipping ) : ?>

			<div class="mb-6 woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses">

		<?php endif; ?>

		<h5 class="text-dark font-size-1 text-uppercase woocommerce-column__title"><?php esc_html_e( 'Billing address:', 'front' ); ?></h5>

		<address class="text-secondary font-size-1">
			<?php 
				$address = '';
				if ( $order->has_billing_address() ) {
					$address = apply_filters( 'woocommerce_order_formatted_billing_address', $order->get_address( 'billing' ), $order );
					
					$address_title = '';
                    if( isset( $address['company'] )  && ! empty ($address['company']) ) {
                        $address_title = $address['company'];
                        unset( $address['company'] );
                    } elseif( isset( $address['first_name'], $address['last_name'] ) ) {
                        $address_title = $address['first_name'] . ' ' . $address['last_name'];
                        unset( $address['first_name'] );
                        unset( $address['last_name'] );
                    }

                    if(! empty( $address_title ) ) {
                        ?><h6 class="h5 text-dark"><?php echo esc_html( $address_title ); ?></h6><?php
                    }
                    $address = WC()->countries->get_formatted_address( $address, ', ' );
                   
                    echo wp_kses_post( $address );
				} else {
					echo esc_html__( 'N/A', 'front' );
				}

			?>

			<?php if ( $order->get_billing_phone() ) : ?>
				<span class="d-block woocommerce-customer-details--phone"><?php echo esc_html( $order->get_billing_phone() ); ?></span>
			<?php endif; ?>

			<?php if ( $order->get_billing_email() ) : ?>
				<span class="d-block woocommerce-customer-details--email"><?php echo esc_html( $order->get_billing_email() ); ?></span>
			<?php endif; ?>
		</address>

		<?php if ( $show_shipping ) : ?>

			</div><!-- /.col-1 -->

			<div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address">
				<h5 class="text-dark font-size-1 text-uppercase woocommerce-column__title"><?php esc_html_e( 'Shipping address:', 'front' ); ?></h5>
				<address class="text-secondary font-size-1">
					<?php 
					$address = '';
					if ( $order->has_shipping_address() ) {
						$address = apply_filters( 'woocommerce_order_formatted_shipping_address', $order->get_address( 'shipping' ), $order );

						$address_title = '';
                        if( isset( $address['company'] )  && ! empty ($address['company']) ) {
                            $address_title = $address['company'];
                            unset( $address['company'] );
                        } elseif( isset( $address['first_name'], $address['last_name'] ) ) {
                            $address_title = $address['first_name'] . ' ' . $address['last_name'];
                            unset( $address['first_name'] );
                            unset( $address['last_name'] );
                        }

                        if(! empty( $address_title ) ) {
                            ?><h6 class="h5 text-dark"><?php echo esc_html( $address_title ); ?></h6><?php
                        }

                        $address = WC()->countries->get_formatted_address( $address, ', ' );
                        
                        echo wp_kses_post( $address );
					} else {
						echo esc_html__( 'N/A', 'front' );
					}

					?>
				</address>
			</div><!-- /.col-2 -->


		<?php endif; ?>
	</div>

	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>
