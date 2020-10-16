<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
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

/* translators: %s: Quantity. */
$labelledby = ! empty( $args['product_name'] ) ? sprintf( __( '%s quantity', 'front' ), wp_strip_all_tags( $args['product_name'] ) ) : '';

if ( isset( $input_field ) && $input_field == 'select' ) :

    $max_value = empty( $max_value ) || $max_value > 10 ? apply_filters( 'front_wc_quantity_input_default_max', 10 ) : $max_value;
    ?>
    <div class="quantity">
        <label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Quantity', 'front' ); ?></label>
        <select name="<?php echo esc_attr( $input_name ); ?>" id="<?php echo esc_attr( $input_id ); ?>" class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>" <?php if ( ! empty( $labelledby ) ) { ?>
                aria-label="<?php echo esc_attr( $labelledby ); ?>" <?php } ?>>
        <?php for ( $i = intval( $min_value ); $i <= intval( $max_value ); ) : ?>
            <option value="<?php echo esc_attr( $i ); ?>" <?php if ( $i == $input_value ) :?>selected<?php endif; ?>><?php echo esc_html( $i ); ?></option>
            <?php $i = $i + intval( $step ); ?>
        <?php endfor; ?>
        </select>
    </div>
    
    <?php

else :

    if ( $max_value && $min_value === $max_value ) {
        ?>
        <div class="quantity hidden">
            <input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
        </div>
        <?php
    } else {
        ?>
        <div class="quantity">
            <label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Quantity', 'front' ); ?></label>
            <input
                type="number"
                id="<?php echo esc_attr( $input_id ); ?>"
                class="js-result form-control h-auto border-0 rounded p-0 <?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
                step="<?php echo esc_attr( $step ); ?>"
                min="<?php echo esc_attr( $min_value ); ?>"
                max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
                name="<?php echo esc_attr( $input_name ); ?>"
                value="<?php echo esc_attr( $input_value ); ?>"
                title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'front' ); ?>"
                size="4"
                inputmode="<?php echo esc_attr( $inputmode ); ?>"
                <?php if ( ! empty( $labelledby ) ) { ?>
                aria-label="<?php echo esc_attr( $labelledby ); ?>" />
                <?php } ?>
        </div>
        <?php
    }

endif;