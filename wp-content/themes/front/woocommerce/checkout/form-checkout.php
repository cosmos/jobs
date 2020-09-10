<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', esc_html__( 'You must be logged in to checkout.', 'front' ) );
	return;
}

?>

<div class="container space-1 space-md-2">
    
    <?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>
	
    <form name="checkout" method="post" class="row checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
        <div class="col-lg-4 order-lg-2 mb-7 mb-lg-0">
        	<div class="pl-lg-4">
        		<div class="border shadow-soft rounded p-5 mb-4">
        			
        			<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

        			<div class="border-bottom pb-4 mb-4">
						<h3 id="order_review_heading" class="h5 mb-0"><?php esc_html_e( 'Order Summary', 'front' ); ?></h3>
					</div>
	
					<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

					<div id="order_review" class="woocommerce-checkout-review-order">
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					</div>

					<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
        		</div>

        	</div>
        </div>
        <div class="col-lg-8 order-lg-1">

            <?php do_action( 'front_wc_checkout_before_checkout_fields', $checkout ); ?>

        	<?php if ( $checkout->get_checkout_fields() ) : ?>

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<div id="customer_details">
					<?php do_action( 'woocommerce_checkout_billing' ); ?>
                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</div>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

			<?php endif; ?>

            <?php do_action( 'front_wc_checkout_after_checkout_fields', $checkout ); ?>

        </div>
    </form>
    
    <?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

</div>	