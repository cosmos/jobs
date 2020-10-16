<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
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
<div class="border-bottom mb-7 pb-7">
	
	<div class="woocommerce-billing-fields">
		<div class="mb-4">
			<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

				<h3 class="h4"><?php esc_html_e( 'Billing &amp; Shipping', 'front' ); ?></h3>

			<?php else : ?>

				<h3 class="h4"><?php esc_html_e( 'Billing details', 'front' ); ?></h3>

			<?php endif; ?>
		</div>

		<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

		<div class="woocommerce-billing-fields__field-wrapper row">
			<?php
			$fields = $checkout->get_checkout_fields( 'billing' );

			foreach ( $fields as $key => $field ) {

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

				woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );

				if ( in_array('form-row-last', $field['class'] ) ) {
					?><div class="w-100"></div><?php
				}
			}
			?>

		</div>

		<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
	</div>

	<div class="woocommerce-additional-fields">
		
		<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

		<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

			<?php if ( apply_filters( 'front_show_additional_information_title', false ) && ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) ) : ?>
				<div class="mb-4">
					<h3 class="h4"><?php esc_html_e( 'Additional information', 'front' ); ?></h3>
				</div>

			<?php endif; ?>

			<div class="woocommerce-additional-fields__field-wrapper row">
				<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>

					<?php 
						$field['class'][]     = 'col-md-12';
						$field['label_class'] = array( 'form-label' );
						$field['input_class'] = array( 'form-control' );
						$field['before']      = '<div class="js-form-message mb-6">';
						$field['after']       = '</div>';
					?>

					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				<?php endforeach; ?>
			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>

		<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

		<div class="row">

			<div class="col-12">
				<div id="ship-to-different-address" class="custom-control custom-checkbox d-flex align-items-center text-muted mb-2">
					<input id="ship-to-different-address-checkbox" class="custom-control-input woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" />
					<label for="ship-to-different-address-checkbox" class="custom-control-label woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
						 <small><?php esc_html_e( 'My Shipping address is different than my billing address.', 'front' ); ?></small>
					</label>
				</div>
			</div>

		</div>

		<?php endif; ?>

	</div>

	<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
		<div class="woocommerce-account-fields">
			
			<?php if ( ! $checkout->is_registration_required() ) : ?>

			<div class="row">
				<div class="col-12">
					<p class="form-row-wide create-account custom-control custom-checkbox d-flex align-items-center text-muted mb-2">
						<input class="custom-control-input woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?> type="checkbox" name="createaccount" value="1" />
						<label for="createaccount" class="custom-control-label woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
							<small><?php esc_html_e( 'Create an account?', 'front' ); ?></small>
						</label>
					</p>
				</div>
			</div>
			<?php endif; ?>

			<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

			<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

			<div class="create-account mt-3 row">
				<?php 
				$account_fields = $checkout->get_checkout_fields( 'account' );

				$col_class = count( $account_fields ) % 2 === 0 ? 'col-md-6' : 'col-md-12';

				foreach ( $account_fields as $key => $field ) :
					
					$field['class'][]     = $col_class;
					$field['label_class'] = array( 'form-label' );
					$field['input_class'] = array( 'form-control' );
					$field['before']      = '<div class="js-form-message">';
					$field['after']       = '</div>';

					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
				
				endforeach; 
				?>
				<div class="clear"></div>
			</div>

			<?php endif; ?>

			<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
			
		</div>
	<?php endif; ?>
</div>