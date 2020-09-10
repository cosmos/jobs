<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! $order = wc_get_order( $order_id ) ) {
	return;
}

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

if ( $show_downloads ) {
	wc_get_template( 'order/order-downloads.php', array( 'downloads' => $downloads, 'show_title' => true ) );
}
?>
<div class="mb-6">
	<div class="row">
		<?php
			if ( $show_customer_details ) {
				wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
		} ?>

		<div class="col-sm-6 woocommerce-order-details font-size-1">
			<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>

			<div class="order_details mb-4">
				<?php
				do_action( 'woocommerce_order_details_before_order_table_items', $order );

				foreach ( $order_items as $item_id => $item ) {
					$product = $item->get_product();

					wc_get_template( 'order/order-details-item.php', array(
						'order'			     => $order,
						'item_id'		     => $item_id,
						'item'			     => $item,
						'show_purchase_note' => $show_purchase_note,
						'purchase_note'	     => $product ? $product->get_purchase_note() : '',
						'product'	         => $product,
					) );
				}

				do_action( 'woocommerce_order_details_after_order_table_items', $order );
				?>
				<h5 class="text-dark font-size-1 text-uppercase"><?php echo esc_html__( 'Transaction details:', 'front' ); ?></h5>
				<ul class="list-unstyled mb-0">
					<?php
						foreach ( $order->get_order_item_totals() as $key => $total ) {
							?>
							<li class="d-flex justify-content-between align-items-center mb-2">
								<span class="text-secondary" scope="row"><?php echo wp_kses_post( $total['label'] ); ?>&nbsp;</span>
								<span class="font-weight-medium"><?php echo wp_kses_post( $total['value'] ); ?></span>
							</li>
							<?php
						}
					?>
					<?php if ( $order->get_customer_note() ) : ?>
						<li class="d-flex justify-content-between align-items-center mb-2">
							<span class="text-secondary"><?php esc_html_e( 'Note:', 'front' ); ?></span>
							<span class="font-weight-medium"><?php echo wptexturize( $order->get_customer_note() ); ?></span>
						</li>
					<?php endif; ?>
				</ul>
				
			</div>

			<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
		</div>
	</div>
</div>
