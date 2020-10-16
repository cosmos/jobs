<?php
/**
 * Order Item Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
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

if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
	return;
}
?>
<div class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order ) ); ?>">
	<h5 class="text-dark font-size-1 text-uppercase"><?php echo esc_html__( 'Product Info:', 'front' ); ?></h5>
	<ul class="list-unstyled mb-0">
		<li class="mb-2">
			<span class="text-secondary"><?php echo esc_html__( 'Product Name:', 'front' ); ?></span>
			<span class="font-weight-medium">
				<?php
					$is_visible        = $product && $product->is_visible();
					$product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order );

					echo apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $item->get_name() ) : $item->get_name(), $item, $is_visible );
				?>
			</span>
		</li>

		<?php do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );
		
			wc_display_item_meta( $item, $args = array(
				'before'       => '<li class="mb-2">',
				'after'        => '</li>',
				'separator'    => '</li><li>',
				'echo'         => true,
				'autop'        => false,
				'label_before' => '<span class="text-secondary wc-item-meta-label">',
				'label_after'  => ':</span>',

			) );
			
			do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false ); 
		?>

		<li class="mb-2">
			<span class="text-secondary"><?php echo esc_html__( 'Product Quantity:', 'front' ); ?>&nbsp;</span>
			<span class="font-weight-medium">
				<?php echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '%s', $item->get_quantity() ) . '</strong>', $item ); ?>
			</span>
		</li>

		<li class="mb-2">
			<span class="text-secondary"><?php echo esc_html__( 'Product Total:', 'front' ); ?>&nbsp;</span>
			<span class="font-weight-medium">
				<?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?>
			</span>
		</li>
	</ul>
</div>

<hr class="my-4">

<?php if ( $show_purchase_note && $purchase_note ) : ?>

<div class="woocommerce-table__product-purchase-note product-purchase-note">

	<span colspan="2"><?php echo wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ); ?></span>

</div>

<?php endif; ?>
