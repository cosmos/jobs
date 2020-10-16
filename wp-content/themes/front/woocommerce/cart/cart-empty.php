<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>
<!-- Cart Section -->
<div class="container space-2 space-lg-3">
    <div class="w-md-80 w-lg-50 text-center mx-md-auto">
        <?php 
        /*
         * @hooked wc_empty_cart_message - 10
         */
        do_action( 'woocommerce_cart_is_empty' );
        
        if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
        <a class="btn btn-primary btn-pill transition-3d-hover px-5 button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
            <?php echo esc_html__( 'Start Shopping', 'front' ); ?>
        </a>
        <?php endif; ?>
    </div>
</div>
<!-- End Cart Section -->