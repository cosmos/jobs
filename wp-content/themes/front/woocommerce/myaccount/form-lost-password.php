<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.2
 */

defined( 'ABSPATH' ) || exit;

$front_my_account_lost_password_form_welcome_text = sprintf( '%s <span class="font-weight-semi-bold">%s</span>', esc_html__( 'Forgot your', 'front' ), esc_html__( 'password?', 'front' ) );

?>

<div class="container space-2">
      <div class="w-md-75 w-lg-50 mx-md-auto position-relative">
		<?php do_action( 'woocommerce_before_lost_password_form' ); ?>

		<form method="post" class="woocommerce-ResetPassword lost_reset_password">

			<div class="mb-7">
			    <h1 class="h3 text-primary font-weight-normal mb-0"><?php echo apply_filters( 'front_woocommerce_lost_password_form_title', wp_kses_post( $front_my_account_lost_password_form_welcome_text ) ); ?></h1>
			    <p><?php echo apply_filters( 'front_woocommerce_lost_password_message', esc_html__( 'Enter your email address below and well get you back on track.', 'front' ) ); ?></p>
			</div><?php // @codingStandardsIgnoreLine ?>

			<div class="form-group">
				<label class="form-label" for="user_login"><?php esc_html_e( 'Email Address', 'front' ); ?></label>
				<input class="form-control woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" />
			</div>

			<div class="clear"></div>

			<?php do_action( 'woocommerce_lostpassword_form' ); ?>

			<div class="row align-items-center mb-5">
		        <div class="col-4 col-sm-6">
		            <a class="small link-muted" href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>"><?php esc_html_e( 'Back to sign in', 'front' ); ?></a>
		        </div>

		        <div class="col-8 col-sm-6 text-right">
		          	<input type="hidden" name="wc_reset_password" value="true" />
					<button type="submit" class="btn btn-primary transition-3d-hover woocommerce-Button button" value="<?php esc_attr_e( 'Reset password', 'front' ); ?>"><?php esc_html_e( 'Request Reset Link', 'front' ); ?></button>
		        </div>
		    </div>

			<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

		</form>
		<?php
		do_action( 'woocommerce_after_lost_password_form' ); ?>

	</div>
</div>