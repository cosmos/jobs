<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_reset_password_form' );
?>
<div class="container space-2">
      <div class="w-md-75 w-lg-50 mx-md-auto position-relative">

		<form method="post" class="woocommerce-ResetPassword lost_reset_password">

			<p><?php echo apply_filters( 'woocommerce_reset_password_message', esc_html__( 'Enter a new password below.', 'front' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

			<div class="form-group">
				<label class="form-label" for="password_1"><?php esc_html_e( 'New password', 'front' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="password" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="password_1" id="password_1" autocomplete="new-password" />
			</div>
			<div class="form-group">
				<label class="form-label" for="password_2"><?php esc_html_e( 'Re-enter new password', 'front' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="password" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="password_2" id="password_2" autocomplete="new-password" />
			</div>

			<input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
			<input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />

			<div class="clear"></div>

			<?php do_action( 'woocommerce_resetpassword_form' ); ?>

			<div class="form-group">
				<input type="hidden" name="wc_reset_password" value="true" />
				<button type="submit" class="btn btn-primary transition-3d-hover woocommerce-Button button" value="<?php esc_attr_e( 'Save', 'front' ); ?>"><?php esc_html_e( 'Save', 'front' ); ?></button>
			</div>

			<?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>

		</form>
	</div>
</div>
<?php
do_action( 'woocommerce_after_reset_password_form' );
