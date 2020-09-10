<?php

/**
 * Template Hooks used in WooCommerce
 */

require_once get_template_directory() . '/inc/woocommerce/template-hooks/product-item.php';
require_once get_template_directory() . '/inc/woocommerce/template-hooks/single-product.php';
require_once get_template_directory() . '/inc/woocommerce/template-hooks/my-account.php';

/**
 * Cart Page Hooks
 */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'front_output_cross_sell_products' );
add_filter( 'woocommerce_cart_shipping_method_full_label', 'front_wc_cart_shipping_method_full_label', 10, 2 );

/**
 * Shop Page Hooks
 */
add_filter( 'woocommerce_product_categories_widget_args', 'front_modify_wc_product_cat_widget_args', 10 );

/**
 * Header
 */
add_action( 'front_topbar_icons', 'front_header_cart', 20 );

/**
 * Popup & Sidebar Mini Cart
 */
add_action('wp_footer', 'front_cart_modal_popup', 998); 
add_action('wp_footer', 'front_cart_content_sidebar', 999);

/**
 * Mini Cart buttons
 */
add_action( 'woocommerce_widget_shopping_cart_buttons', function() {
    // Removing Buttons
    remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
    remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

    // Adding customized Buttons
    add_action( 'woocommerce_widget_shopping_cart_buttons', 'front_mini_cart_view_cart_button', 10 );
    add_action( 'woocommerce_widget_shopping_cart_buttons', 'front_mini_cart_view_shop_button', 20 );
}, 1 );

/**
 * Cart fragment
 *
 * @see front_cart_link_fragment()
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'front_cart_link_fragment' );

remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'woocommerce_checkout_after_customer_details', 'woocommerce_checkout_payment', 10 );

add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );
add_filter( 'woocommerce_is_attribute_in_product_name', '__return_false' );

add_filter( 'woocommerce_cart_totals_coupon_html', 'front_wc_cart_totals_coupon_html', 10, 3 );

function front_wc_cart_totals_coupon_html( $coupon_html, $coupon, $discount_amount_html ) {
    $coupon_html = $discount_amount_html . ' <a href="' . esc_url( add_query_arg( 'remove_coupon', rawurlencode( $coupon->get_code() ), defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url() ) ) . '" class="woocommerce-remove-coupon text-secondary font-weight-normal small d-block" data-coupon="' . esc_attr( $coupon->get_code() ) . '"><i class="far fa-trash-alt mr-1"></i>' . esc_html__( 'Remove', 'front' ) . '</a>';
    return $coupon_html;
}

remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
add_action( 'woocommerce_cart_is_empty', 'front_wc_empty_cart_message', 10 );

if ( ! function_exists( 'front_wc_empty_cart_message' ) ) {
    function front_wc_empty_cart_message() {
            $title = apply_filters( 'front_cart_empty_message_title', esc_html__( 'Your cart is currently empty', 'front' ) );
            $desc  = apply_filters( 'front_cart_empty_message_desc', esc_html__( 'Before proceed to checkout you must add some products to your shopping cart. You will find a lot of interesting products on our "Shop" page.', 'front' ) );
        ?>
        <figure id="iconEmptyCart" class="svg-preloader ie-height-111 max-width-15 mx-auto mb-3">
            <img class="js-svg-injector" src="<?php echo get_template_directory_uri(); ?>/assets/svg/icons/icon-66.svg" alt="SVG" data-parent="#iconEmptyCart">
        </figure>
        <div class="mb-5">
            <h1 class="h3 font-weight-medium"><?php echo esc_html( $title ); ?></h1>
            <p><?php echo esc_html( $desc ); ?></p>
        </div>
        <?php
    }
}

add_action( 'woocommerce_credit_card_form_start', 'front_wc_credit_card_form_start', 10 );
add_action( 'woocommerce_credit_card_form_end', 'front_wc_credit_card_form_end', 10 );

function front_wc_credit_card_form_start() {
    ?><div class="row"><?php
}

function front_wc_credit_card_form_end() {
    ?></div><!-- /.row --><?php
}