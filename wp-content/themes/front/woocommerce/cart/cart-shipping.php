<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

$formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping  = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text          = '';
?>
<div class="woocommerce-shipping-totals shipping">
    <div class="media align-items-center mb-3">
        <h3 class="text-secondary font-size-1 font-weight-normal mb-0 mr-3"><?php echo wp_kses_post( $package_name ); ?></h3>
        <?php if ( $available_methods ) : ?>
        <div class="media-body text-right">
            <div class="font-weight-medium">
                <?php 
                foreach ( $available_methods as $method ) {
                    if ( $method->id == $chosen_method ) {
                        echo front_wc_get_shipping_method_cost( $method );
                        break;
                    }
                }
                ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php if ( $available_methods ) : ?>
        <div id="shipping_method" class="woocommerce-shipping-methods">
            <?php 
                $i = 1;
                $count_methods = count( $available_methods );
                foreach ( $available_methods as $method ) : ?>
                <div class="card border-0 mb-3">
                    <div class="card-body p-0">
                        <?php
                        if ( 1 < count( $available_methods ) ) {
                            printf( '<div class="custom-control custom-radio d-flex align-items-center small"><input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method custom-control-input" %4$s />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) ); // WPCS: XSS ok.
                            printf( '<label class="custom-control-label ml-1" for="shipping_method_%1$s_%2$s"><span class="d-block font-size-1 font-weight-medium mb-1">%3$s</span></label></div>', $index, esc_attr( sanitize_title( $method->id ) ), wc_cart_totals_shipping_method_label( $method ) ); // WPCS: XSS ok.
                        } else {
                            printf( '<div class="custom-control custom-radio d-flex align-items-center small"><input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method custom-control-input" checked />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // WPCS: XSS ok.
                            printf( '<label class="custom-control-label ml-1" for="shipping_method_%1$s_%2$s"><span class="d-block font-size-1 font-weight-medium mb-1">%3$s</span></label></div>', $index, esc_attr( sanitize_title( $method->id ) ), wc_cart_totals_shipping_method_label( $method ) ); // WPCS: XSS ok.
                        }
                        
                        do_action( 'woocommerce_after_shipping_rate', $method, $index );
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if ( is_cart() ) : ?>
            <p class="woocommerce-shipping-destination font-size-1 text-muted">
                <?php
                if ( $formatted_destination ) {
                    // Translators: $s shipping destination.
                    printf( wp_kses_post( __( 'Shipping to %s.', 'front' ) ), '<strong class="font-weight-medium">' . $formatted_destination . '</strong>' );
                    $calculator_text = esc_html__( 'Change address', 'front' );
                } else {
                    echo apply_filters( 'woocommerce_shipping_estimate_html', esc_html__( 'Shipping options will be updated during checkout.', 'front' ) );
                }
                ?>
            </p>
        <?php endif; ?>
        <?php
    elseif ( ! $has_calculated_shipping || ! $formatted_destination ) :
        echo '<div class="font-size-1 text-muted mb-3">' . wp_kses_post( apply_filters( 'woocommerce_shipping_may_be_available_html', esc_html__( 'Enter your address to view shipping options.', 'front' ) ) ) . '</div>';
    elseif ( ! is_cart() ) :
        echo '<div class="font-size-1 text-muted mb-3">' . wp_kses_post( apply_filters( 'woocommerce_no_shipping_available_html', esc_html__( 'There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'front' ) ) ) . '</div>';
    else :
        // Translators: $s shipping destination.
        echo '<div class="font-size-1 text-muted mb-3">' . wp_kses_post( apply_filters( 'woocommerce_cart_no_shipping_available_html', sprintf( esc_html__( 'No shipping options were found for %s.', 'front' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' ) ) ) . '</div>';
        $calculator_text = esc_html__( 'Enter a different address', 'front' );
    endif;
    ?>

    <?php if ( $show_package_details ) : ?>
        <?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></p>'; ?>
    <?php endif; ?>

    <?php if ( $show_shipping_calculator ) : ?>
        <?php woocommerce_shipping_calculator( $calculator_text ); ?>
    <?php endif; ?>
</div>