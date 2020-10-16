<?php
/**
 * Order Downloads.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-downloads.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="woocommerce-order-downloads mb-6">
	<?php if ( isset( $show_title ) ) : ?>
		<h2 class="h3 woocommerce-order-downloads__title"><?php esc_html_e( 'Downloads', 'front' ); ?></h2>
	<?php endif; ?>

	<div class="card p-4">
		<div class="table-responsive-md u-datatable">
	        <table class="js-datatable table table-borderless u-datatable__striped u-datatable__content u-datatable__trigger mb-0 woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table"
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
	                     data-dt-pagination-next-link-markup='<span aria-hidden="true">&raquo;</span>'

	                     data-dt-pagination-prev-classes="page-item"
	                     data-dt-pagination-prev-link-classes="page-link"
	                     data-dt-pagination-prev-link-markup='<span aria-hidden="true">&laquo;</span>'>
				<thead>
		            <tr class="text-uppercase font-size-1">
						<?php foreach ( wc_get_account_downloads_columns() as $column_id => $column_name ) : ?>
						<th class="font-weight-medium <?php echo esc_attr( $column_id ); ?>">
							<div class="d-flex justify-content-between align-items-center"><?php echo esc_html( $column_name ); ?>
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
					<?php for ( $i=0; $i < count($downloads); $i++ ){
						$class = ( $i%2 == 1 ) ? ' even': ' odd';
						?>

						<tr class="js-datatabale-details <?php echo esc_attr($class) ; ?>">
							<?php foreach ( wc_get_account_downloads_columns() as $column_id => $column_name ) : ?>
								<td class="align-middle <?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
									<?php
									if ( has_action( 'woocommerce_account_downloads_column_' . $column_id ) ) {
										do_action( 'woocommerce_account_downloads_column_' . $column_id, $download[$i] );
									} else {
										switch ( $column_id ) {
											case 'download-product':
												if ( $downloads[$i]['product_url'] ) {
													echo '<a class="text-secondary" href="' . esc_url( $downloads[$i]['product_url'] ) . '">' . esc_html( $downloads[$i]['product_name'] ) . '</a>';
												} else {
													echo esc_html( $downloads[$i]['product_name'] );
												}
												break;
											case 'download-file':
												echo '<a href="' . esc_url( $downloads[$i]['download_url'] ) . '" class="woocommerce-MyAccount-downloads-file button alt">' . esc_html( $downloads[$i]['download_name'] ) . '</a>';
												break;
											case 'download-remaining':
												echo is_numeric( $downloads[$i]['downloads_remaining'] ) ? esc_html( $downloads[$i]['downloads_remaining'] ) : esc_html__( '&infin;', 'front' );
												break;
											case 'download-expires':
												if ( ! empty( $downloads[$i]['access_expires'] ) ) {
													echo '<span class="text-secondary"><time datetime="' . esc_attr( date( 'Y-m-d', strtotime( $downloads[$i]['access_expires'] ) ) ) . '" title="' . esc_attr( strtotime( $downloads[$i]['access_expires'] ) ) . '">' . esc_html( date_i18n( get_option( 'date_format' ), strtotime( $downloads[$i]['access_expires'] ) ) ) . '</span></time>';
												} else {
													esc_html_e( 'Never', 'front' );
												}
												break;
										}
									}
									?>
								</td>
							<?php endforeach; ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

</section>
