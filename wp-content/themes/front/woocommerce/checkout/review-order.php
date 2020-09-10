<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="shop_table woocommerce-checkout-review-order-table">
	<div>
		<?php
			do_action( 'woocommerce_review_order_before_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<div class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?> border-bottom pb-4 mb-4">
						<div class="media">
							<div class="position-relative max-width-10 w-100 mr-3">
								<?php echo wp_kses_post( $_product->get_image( 'woocommerce_thumbnail', array( 'class' => 'img-fluid' ) ) ); ?>
								<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <span class="product-quantity badge badge-sm badge-primary badge-pos rounded-circle">' . sprintf( '%s', $cart_item['quantity'] ) . '</span>', $cart_item, $cart_item_key ); ?>
							</div>
							<div class="media-body">
								<h2 class="h6 product-name"><?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ); ?></h2>
								<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
								<div class="product-total text-secondary font-size-1">
									<span><?php echo esc_html__( 'Price: ', 'front' ); ?></span>
								<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
								</div>
							</div>
						</div>
					</div>
					<?php
				}
			}

			do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</div>
	<div class="border-bottom pb-4 mb-4">

		<div class="cart-subtotal media align-items-center mb-3">
			<h3 class="text-secondary font-size-1 font-weight-normal mb-0 mr-3"><?php esc_html_e( 'Subtotal', 'front' ); ?></h3>
			<div class="media-body text-right">
				<span class="font-weight-medium">
					<?php wc_cart_totals_subtotal_html(); ?>
				</span>
			</div>
		</div>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?> media align-items-center mb-3">
				<h3 class="text-secondary font-size-1 font-weight-normal mb-0 mr-3"><?php wc_cart_totals_coupon_label( $coupon ); ?></h3>
				<div class="media-body text-right">
					<span class="font-weight-medium"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
				</div>
			</div>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="fee media align-items-center mb-3">
				<h3 class="text-secondary font-size-1 font-weight-normal mb-0 mr-3"><?php echo esc_html( $fee->name ); ?></h3>
				<div class="media-body text-right">
					<span class="font-weight-medium"><?php wc_cart_totals_fee_html( $fee ); ?></span>
				</div>
			</div>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<div class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?> media align-items-center mt-3">
						<h3 class="text-secondary font-size-1 font-weight-normal mb-0 mr-3"><?php echo esc_html( $tax->label ); ?></h3>
						<div class="media-body text-right">
							<span class="font-weight-medium"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="tax-total media align-items-center">
					<h3 class="text-secondary font-size-1 font-weight-normal mb-0 mr-3"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></h3>
					<div class="media-body text-right">
						<span class="font-weight-medium"><?php wc_cart_totals_taxes_total_html(); ?></span>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>

	</div>

	<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

	<div class="order-total media align-items-center">
		<h3 class="text-secondary font-size-1 font-weight-normal mb-0 mr-3"><?php esc_html_e( 'Total', 'front' ); ?></h3>
		<div class="media-body text-right">
			<span class="font-weight-medium"><?php wc_cart_totals_order_total_html(); ?></span>
		</div>
	</div>

	<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
</div>
