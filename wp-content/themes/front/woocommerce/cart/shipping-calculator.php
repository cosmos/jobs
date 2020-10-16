<?php
/**
 * Shipping Calculator
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/shipping-calculator.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.0.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_shipping_calculator' ); ?>

<form class="woocommerce-shipping-calculator font-size-1" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

    <?php printf( '<a href="#" class="shipping-calculator-button link-muted">%s</a>', esc_html( ! empty( $button_text ) ? $button_text : esc_html__( 'Calculate shipping', 'front' ) ) ); ?>

    <section class="shipping-calculator-form mt-3" style="display:none;">

        <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_country', true ) ) : ?>
            <p class="form-group form-row-wide" id="calc_shipping_country_field">
                <select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state country_select form-control form-control-xs" rel="calc_shipping_state">
                    <option value=""><?php esc_html_e( 'Select a country&hellip;', 'front' ); ?></option>
                    <?php
                    foreach ( WC()->countries->get_shipping_countries() as $key => $value ) {
                        echo '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
                    }
                    ?>
                </select>
            </p>
        <?php endif; ?>

        <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_state', true ) ) : ?>
            <p class="form-group form-row-wide" id="calc_shipping_state_field">
                <?php
                $current_cc = WC()->customer->get_shipping_country();
                $current_r  = WC()->customer->get_shipping_state();
                $states     = WC()->countries->get_states( $current_cc );

                if ( is_array( $states ) && empty( $states ) ) {
                    ?>
                    <input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_attr_e( 'State / County', 'front' ); ?>" />
                    <?php
                } elseif ( is_array( $states ) ) {
                    ?>
                    <select name="calc_shipping_state" class="state_select form-control form-control-xs" id="calc_shipping_state" data-placeholder="<?php esc_attr_e( 'State / County', 'front' ); ?>">
                        <option value=""><?php esc_html_e( 'Select an option&hellip;', 'front' ); ?></option>
                        <?php
                        foreach ( $states as $ckey => $cvalue ) {
                            echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' . esc_html( $cvalue ) . '</option>';
                        }
                        ?>
                    </select>
                    <?php
                } else {
                    ?>
                    <input type="text" class="input-text form-control form-control-xs" value="<?php echo esc_attr( $current_r ); ?>" placeholder="<?php esc_attr_e( 'State / County', 'front' ); ?>" name="calc_shipping_state" id="calc_shipping_state" />
                    <?php
                }
                ?>
            </p>
        <?php endif; ?>

        <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', true ) ) : ?>
            <p class="form-group form-row-wide" id="calc_shipping_city_field">
                <input type="text" class="input-text form-control form-control-xs" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" placeholder="<?php esc_attr_e( 'City', 'front' ); ?>" name="calc_shipping_city" id="calc_shipping_city" />
            </p>
        <?php endif; ?>

        <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>
            <p class="form-group form-row-wide" id="calc_shipping_postcode_field">
                <input type="text" class="input-text form-control form-control-xs" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php esc_attr_e( 'Postcode / ZIP', 'front' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
            </p>
        <?php endif; ?>

        <button type="submit" name="calc_shipping" value="1" class="button btn btn-soft-secondary btn-xs"><?php esc_html_e( 'Update', 'front' ); ?></button>
        <?php wp_nonce_field( 'woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce' ); ?>
    </section>
</form>

<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>