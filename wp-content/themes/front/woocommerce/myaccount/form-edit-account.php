<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<div class="row">
		<div class="col-sm-6 mb-6 woocommerce-form-row woocommerce-form-row--first form-row-first">
			<label for="account_first_name" class="form-label"><?php esc_html_e( 'First name', 'front' ); ?>&nbsp;<span class="required text-danger">*</span></label>
			<div class="form-group">
				<input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
			</div>
		</div>
		<div class="col-sm-6 mb-6 woocommerce-form-row woocommerce-form-row--last form-row-last">
			<label for="account_last_name" class="form-label"><?php esc_html_e( 'Last name', 'front' ); ?>&nbsp;<span class="required text-danger">*</span></label>
			<div class="form-group">
				<input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />		
			</div>
		</div>
	</div>

	<div class="row">
		<div class="mb-6 col-sm-12">
			<label for="account_display_name" class="form-label"><?php esc_html_e( 'Display name', 'front' ); ?>&nbsp;<span class="required text-danger">*</span></label>
			<div class="form-group">
				<input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> <small class="form-text text-muted"><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'front' ); ?></small>
			</div>
		</div>
	</div>

	<div class="clear"></div>
	<div class="row">
		<div class="mb-6 col-sm-12">
			<label for="account_email" class="form-label"><?php esc_html_e( 'Email address', 'front' ); ?>&nbsp;<span class="required text-danger">*</span></label>
			<div class="form-group">
				<input type="email" class="form-control woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
			</div>
		</div>
	</div>
	<hr class="mt-1 mb-7">

	<div class= "mb-3">
		<h2 class="h5 mb-0"><?php esc_html_e( 'Password change', 'front' ); ?></h2>
	</div>

	<div class="mb-6">
		<label for="password_current" class="form-label"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'front' ); ?></label>
		<div class="form-group">
			<input type="password" class="form-control woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
		</div>
	</div>
	<div class="mb-6">
		<label for="password_1" class="form-label"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'front' ); ?></label>
		<input type="password" class="form-control woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
	</div>
	<div class="mb-6">
		<label for="password_2" class="form-label"><?php esc_html_e( 'Confirm new password', 'front' ); ?></label>
		<div class="form-group">
			<input type="password" class="form-control woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
		</div>
	</div>
	<div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p>
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
		<button type="submit" class="btn btn-sm btn-primary transition-3d-hover mr-1 woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'front' ); ?>"><?php esc_html_e( 'Save changes', 'front' ); ?></button>
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
