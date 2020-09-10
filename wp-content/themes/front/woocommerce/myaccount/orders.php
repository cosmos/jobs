<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
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

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php if ( $has_orders ) : ?>
	<div class="card p-4">
		<div class="table-responsive u-datatable">
			<table
				class="js-datatable table table-borderless u-datatable__striped u-datatable__content u-datatable__trigger mb-0 woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table"
				data-dt-info="#datatableInfo"
				data-dt-search="#datatableSearch"
				data-dt-entries="#datatableEntries"
				data-dt-page-length="12"
				data-dt-is-responsive="false"
				data-dt-is-show-paging="true"
				data-dt-details-invoker=".js-datatabale-details"
				data-dt-select-all-control="#invoiceToggleAllCheckbox"

				data-dt-pagination="datatablePagination"
				data-dt-pagination-classes="pagination mb-0"
				data-dt-pagination-items-classes="page-item"
				data-dt-pagination-links-classes="page-link"

				data-dt-pagination-next-classes="page-item"
				data-dt-pagination-next-link-classes="page-link"
				data-dt-pagination-next-link-markup="<span aria-hidden=&quot;true&quot;>&raquo;</span>":

				data-dt-pagination-prev-classes="page-item"
				data-dt-pagination-prev-link-classes="page-link"
				data-dt-pagination-prev-link-markup="<span aria-hidden=&quot;true&quot;>&laquo;</span>"
			>
				<thead>
					<tr class="text-uppercase font-size-1">
						<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
							<th scope="col"  class="font-weight-medium woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>">
								<div class="d-flex justify-content-between align-items-center woocommerce-orders-table__header--text"><?php echo esc_html( $column_name ); ?>
									<div class="ml-2">
									  <span class="fas fa-angle-up u-datatable__thead-icon"></span>
									  <span class="fas fa-angle-down u-datatable__thead-icon"></span>
									</div>
								</div>
							</th>
						<?php endforeach; ?>
					</tr>
				</thead>

				<tbody class="font-size-1">
					<?php for ( $i=0; $i < count($customer_orders->orders); $i++ ){
						$order      = wc_get_order( $customer_orders->orders[$i] );
						$item_count = $order->get_item_count();
						$class = ( $i%2 == 1 ) ? ' even': ' odd';
					?>
					
					<tr class="js-datatabale-details woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ) . esc_attr($class) ; ?> order">
						<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>

							<?php 
							$text_color = '';
							switch ($order->get_status()){
								case 'on-hold':
								case 'pending':
								$text_color = 'text-warning';
								break; 
								case 'completed':
								case 'processing':
								$text_color = 'text-success';
								break;
								case 'cancelled':
								case 'refunded':
								case 'failed':
								$text_color = 'text-danger';
								break;
							}
							?>

							<td class="align-middle woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ) . esc_attr(("order-status" === $column_id ) ? ' ' . $text_color : ''); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
								<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
									<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

								<?php elseif ( 'order-number' === $column_id ) : ?>
									<a class="text-secondary font-weight-normal" href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
										<?php echo _x( '#', 'hash before order number', 'front' ) . $order->get_order_number(); ?>
									</a>

								<?php elseif ( 'order-date' === $column_id ) : ?>
									<span class="text-secondary"><time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time></span>

								<?php elseif ( 'order-status' === $column_id ) : ?>
									<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>


								<?php elseif ( 'order-total' === $column_id ) : ?>
									<span class="text-primary">
									<?php
									/* translators: 1: formatted order total 2: total order items */
									printf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'front' ), $order->get_formatted_order_total(), $item_count );
									?>
								</span>

								<?php elseif ( 'order-actions' === $column_id ) : ?>
									<?php
									$actions = wc_get_account_orders_actions( $order );

									if ( ! empty( $actions ) ) {
										foreach ( $actions as $key => $action ) {
											echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
										}
									}
									?>
								<?php endif; ?>
							</td>
						<?php endforeach; ?>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'front' ); ?></a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'front' ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else : ?>
	<div class="alert alert-warning fade show d-flex flex-row-reverse justify-content-between align-items-center woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
		<a class="woocommerce-Button button btn btn-outline-warning btn-sm" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php esc_html_e( 'Go shop', 'front' ); ?>
		</a>
		<?php esc_html_e( 'No order has been made yet.', 'front' ); ?>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
