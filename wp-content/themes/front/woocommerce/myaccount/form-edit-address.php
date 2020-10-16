<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

$page_title = ( 'billing' === $load_address ) ? esc_html__( 'Billing address', 'front' ) : esc_html__( 'Shipping address', 'front' );

do_action( 'woocommerce_before_edit_account_address_form' ); ?>

<?php if ( ! $load_address ) : ?>
	<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>

	<form method="post">
		<div class="mb-4">
			<h3 class="h4"><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title, $load_address ); ?></h3>
		</div>
		<?php // @codingStandardsIgnoreLine ?>

		<div class="woocommerce-address-fields">
			<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

			<div class="woocommerce-address-fields__field-wrapper row">
				<?php
					foreach ( $address as $key => $field ) {

						$full_width_fields = array( 'billing_company', 'billing_country', 'billing_email' );

						if ( in_array( $key, $full_width_fields ) ) {
							$field['class'][] = 'col-md-12';
						} else {
							$field['class'][] = 'col-md-6';
						}

						$field['label_class'] = array( 'form-label' );
						$field['input_class'] = array( 'form-control' );
						$field['before']      = '<div class="js-form-message mb-6">';
						$field['after']       = '</div>';
						if (empty($field['label'])) {
							$field['label'] = $field['placeholder'];
						}

						woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );

						if ( in_array('form-row-last', $field['class'] ) ) {
							?><div class="w-100"></div><?php
						}
					}
				?>
			</div>

			<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>

			<p>
				<button type="submit" class="btn btn-sm btn-primary transition-3d-hover mr-1 button" name="save_address" value="<?php esc_attr_e( 'Save address', 'front' ); ?>"><?php esc_html_e( 'Save address', 'front' ); ?></button>
				<?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
				<input type="hidden" name="action" value="edit_address" />
			</p>
		</div>

	</form>

<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
