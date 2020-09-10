<?php
/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<li class="row align-items-center wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>">
	<div class="col-6">
		<h4 class="h6 mb-0 payment-method__title">
			<label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>" class="d-block mb-0">
				<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />
				<span class="ml-2"><?php echo wp_kses_post( $gateway->get_title() ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></span>
			</label>
		</h4>
	</div>
	<div class="col-6 text-md-right payment-method__icon">
		<?php echo wp_kses_post( $gateway->get_icon() ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
	</div>
	
		 
	<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
		<div class="col-12 mt-4 payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>" <?php if ( ! $gateway->chosen ) : /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>style="display:none;"<?php endif; /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>>
			<div class="bg-light p-4 mb-n4 payment-box__inner">
				<?php $gateway->payment_fields(); ?>
			</div>
		</div>
	<?php endif; ?>
	<div class="col-12"><hr class="my-4"></div>
</li>
