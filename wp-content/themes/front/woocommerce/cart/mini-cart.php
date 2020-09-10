<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) :
    $header_cart_view = apply_filters( 'front_header_topbar_cart_view', 'dropdown' );?>

    <div class="card woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">

        <!-- Header -->
        <?php
            if ( $header_cart_view == 'dropdown' ) {
                ?>
                <div class="card-header bg-light py-3 px-5">
                    <span class="font-weight-semi-bold"><?php echo esc_html__( 'Your Shopping Cart', 'front' ); ?></span>
                </div><?php
            }
            else if ( $header_cart_view == 'modal' ) {
                ?>
                <header class="card-header bg-light py-3 px-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="h6 mb-0"><?php echo esc_html__( 'Your Shopping Cart', 'front' ); ?></h3>
                        <button type="button" class="close" aria-label="Close" onclick="Custombox.modal.close();">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </header><?php
            }
        ?>
        <!-- End Header -->

        <?php front_mini_cart_body(); ?>

        <?php front_mini_cart_footer(); ?>
        
    </div>

<?php else :
    $header_cart_view = apply_filters( 'front_header_topbar_cart_view', 'dropdown' );
    
    if ( $header_cart_view == 'dropdown' ) {
    ?>
        <span class="btn btn-icon btn-soft-primary rounded-circle mb-3">
            <span class="fas fa-shopping-basket btn-icon__inner"></span>
        </span>
        <span class="d-block woocommerce-mini-cart__empty-message"><?php esc_html_e( 'Your cart is empty.', 'front' ); ?></span><?php
    } else if ( $header_cart_view == 'modal' ) {
        ?>
        <div class="card">
            <!-- Header -->
            <header class="card-header bg-light py-3 px-5">
                <div class="d-flex justify-content-between align-items-center">
                <h3 class="h6 mb-0"><?php echo esc_html__( 'Your Shopping Cart', 'front' ); ?></h3>
                <button type="button" class="close" aria-label="Close" onclick="Custombox.modal.close();">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            </header>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body text-center p-5">
                <span class="btn btn-icon btn-soft-primary rounded-circle">
                    <span class="fas fa-shopping-basket btn-icon__inner"></span>
                </span>
            </div>
            <!-- End Body -->

            <!-- Footer -->
            <div class="card-footer text-center p-5">
                <?php 
                    front_mini_cart_view_cart_button();
                    front_mini_cart_view_shop_button();
                ?>
            </div>
            <!-- End Footer -->
        </div><?php
    }

endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>