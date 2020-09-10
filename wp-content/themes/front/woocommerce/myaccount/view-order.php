<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="card p-5 font-size-1">
	<h2 class="h3 woocommerce-order-details__title"><?php esc_html_e( 'Order details', 'front' ); ?></h2>
	<div class="row mb-6">
		<div class="col-3">
			<span class="text-secondary"><?php echo esc_html__( 'Order Number:', 'front' );?></span>
			<span class="font-weight-medium"><?php printf($order->get_order_number()); ?></span>
		</div>
		<div class="col-3">
			<span class="text-secondary"><?php echo esc_html__( 'Order Date:', 'front' );?></span>
			<span class="font-weight-medium"><?php printf(wc_format_datetime( $order->get_date_created() )); ?></span>
		</div>
		<div class="col-6">
			<span class="text-secondary"><?php echo esc_html__( 'Order Status:', 'front' );?></span>
			<span class="font-weight-medium"><?php printf(wc_get_order_status_name( $order->get_status() )); ?></span>
		</div>
	</div>

<?php if ( $notes = $order->get_customer_order_notes() ) : ?>
	<h4 class="h3"><?php esc_html_e( 'Order updates', 'front' ); ?></h4>
	<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ( $notes as $note ) : ?>
		<li class="woocommerce-OrderUpdate comment note">
			<div class="woocommerce-OrderUpdate-inner comment_container">
				<div class="woocommerce-OrderUpdate-text comment-text">
					<p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n( 'l jS \o\f F Y, h:ia', strtotime( $note->comment_date ) ); ?></p>
					<div class="woocommerce-OrderUpdate-description description">
						<?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
					</div>
	  				<div class="clear"></div>
	  			</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>

<?php do_action( 'woocommerce_view_order', $order_id ); ?>
