<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     2.3.6
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

    <?php do_action( 'woocommerce_before_cart_totals' ); ?>

    <div class="border-bottom pb-4 mb-4">
        <h2 class="h5 mb-0"><?php esc_html_e( 'Order Summary', 'front' ); ?></h2>
    </div>

    <div class="border-bottom pb-4 mb-4">
        <div class="media align-items-center mb-3">
            <h3 class="text-secondary font-size-1 font-weight-normal mb-0 mr-3"><?php printf( esc_html__( 'Cart subtotal (%s)', 'front' ), WC()->cart->get_cart_contents_count() ); ?></h3>
            <div class="media-body text-right">
                <span class="font-weight-medium"><?php wc_cart_totals_subtotal_html(); ?></span>
            </div>
        </div>

    <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
        <div class="media align-items-center mb-3 cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
            <h3 class="text-secondary font-size-1 font-weight-normal mb-0 mr-3"><?php wc_cart_totals_coupon_label( $coupon ); ?></h3>

            <div class="media-body text-right">
                <span class="font-weight-medium"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
            </div>
        </div>
    <?php endforeach; ?>
            
        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

            <?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

            <?php wc_cart_totals_shipping_html(); ?>

            <?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

        <?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

            <div class="shipping">
                <h3 class="text-secondary font-size-1 font-weight-normal mb-0 mr-3"><?php esc_html_e( 'Shipping', 'front' ); ?></h3>
                <div><?php woocommerce_shipping_calculator(); ?></div>
            </div>

        <?php endif; ?>

    </div>

    <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
        <div class="media align-items-center mb-3 fee">
            <h3 class="text-secondary font-size-1 font-weight-normal mb-0 mr-3"><?php echo esc_html( $fee->name ); ?></h3>
            <div class="media-body text-right">
                <span class="font-weight-medium"><?php wc_cart_totals_fee_html( $fee ); ?></span>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) :
        $taxable_address = WC()->customer->get_taxable_address();
        $estimated_text  = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
                ? sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'front' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] )
                : '';

        if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
            <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
                <div class="media align-items-center mb-3 tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
                    <h3 class="text-secondary font-size-1 font-weight-normal mb-0 mr-3"><?php echo esc_html( $tax->label ) . $estimated_text; ?></h3>
                    <div class="media-body text-right">
                        <span class="font-weight-medium"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="media align-items-center mb-3 tax-total">
                <h3 class="text-secondary font-size-1 font-weight-normal mb-0 mr-3"><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; ?></h3>
                <div class="media-body text-right">
                    <span class="font-weight-medium"><?php wc_cart_totals_taxes_total_html(); ?></span>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

    <div class="media align-items-center mb-4 order-total">
        <h3 class="text-secondary font-size-1 font-weight-normal mb-0 mr-3"><?php esc_html_e( 'Total', 'front' ); ?></h3>
        <div class="media-body text-right">
            <span class="font-weight-medium"><?php wc_cart_totals_order_total_html(); ?></span>
        </div>
    </div>

    <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

    <div class="wc-proceed-to-checkout">
        <?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
    </div>

    <?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>