<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="container space-2 space-lg-3">
	<div class="woocommerce-order">
			
			<?php if ( $order ) :

				do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>
				<div class="w-md-80 w-lg-50 text-center mx-md-auto mb-11">
					<?php if ( $order->has_status( 'failed' ) ) : ?>

						<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'front' ); ?></p>

						<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
							<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'front' ); ?></a>
							<?php if ( is_user_logged_in() ) : ?>
								<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'front' ); ?></a>
							<?php endif; ?>
						</p>

					<?php else : 

			            $title = apply_filters( 'front_thankyou_order_received_title', esc_html__( 'Your order is completed!', 'front' ) );
			            $desc  = apply_filters( 'front_thankyou_order_received_desc', esc_html__( 'Thank you for your order! Your order is being processed. You will receive an email confirmation when your order is completed.', 'front' ) );
				        ?>
				        <figure id="iconChecked" class="ie-height-90 max-width-11 mx-auto mb-3">
				            <img class="js-svg-injector" src="<?php echo get_template_directory_uri(); ?>/assets/svg/components/checked-icon.svg" alt="SVG" data-parent="#iconChecked">
				        </figure>

				        <div class="mb-5">
				            <h1 class="h3 font-weight-medium"><?php echo esc_html( $title ); ?></h1>
				            <p><?php echo esc_html( $desc ); ?></p>
				        </div>

				        <?php
					        $continue_shopping_text = apply_filters( 'front_continue_shopping_button_text', esc_html__( 'Continue Shopping', 'front' ) );
					        $continue_shopping_url = apply_filters( 'front_continue_shopping_button_text_url', get_permalink( wc_get_page_id( 'shop' ) ) );
					        
					    ?>
					    <a href="<?php echo esc_url( $continue_shopping_url ); ?>" class="btn btn-primary btn-pill transition-3d-hover px-5"><?php echo esc_html( $continue_shopping_text ); ?></a>

				    <?php endif; ?>
				
				</div>

				<div class="font-size-1 order-completed-payment-method mb-6">
					<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
				</div>
				<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

			<?php else : ?>

				<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'front' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

			<?php endif; ?>

	</div><!-- /.woocommerce-order -->
</div>