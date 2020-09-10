<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>

<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>
<div class="woocommerce-shipping-fields">
	<div class="shipping_address border-bottom pb-7 mb-7">

		<div class="mb-4">
			<h3 class="h4"><?php echo esc_html__( 'Shipping Address', 'front' ); ?></h3>
		</div>

		<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

		<div class="woocommerce-shipping-fields__field-wrapper row">
			<?php
			$fields = $checkout->get_checkout_fields( 'shipping' );

			foreach ( $fields as $key => $field ) {
				
				$full_width_fields = array( 'shipping_company', 'shipping_country', 'shipping_email' );

				if ( in_array( $key, $full_width_fields ) ) {
					$field['class'][] = 'col-md-12';
				} else {
					$field['class'][] = 'col-md-6';
				}

				$field['label_class'] = array( 'form-label' );
				$field['input_class'] = array( 'form-control' );
				$field['before']      = '<div class="js-form-message mb-6">';
				$field['after']       = '</div>';

				woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );

				if ( in_array('form-row-last', $field['class'] ) ) {
					?><div class="w-100"></div><?php
				}
			}
			?>
		</div>

		<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

	</div>
</div>
<?php endif; ?>