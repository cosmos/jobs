<?php
add_action( 'woocommerce_register_form', 'cosmos_extra_registation_fields' );
// add_action( 'front_header_topbar_user_account_view', 'cosmos_extra_registation_fields' );
function cosmos_extra_registation_fields() {
  ?>
  	<div class="row">
	    <div class="col-12 mb-3">
	      <label class="form-label" for="reg_role"><?php _e( 'Please select a user role', 'woocommerce' ); ?></label>
	      <select class="input-text" name="role" id="reg_role">
	      <option <?php if ( ! empty( $_POST['role'] ) && $_POST['role'] == 'candidate') esc_attr_e( 'selected' ); ?> value="candidate">Contributor</option>
	      <option <?php if ( ! empty( $_POST['role'] ) && $_POST['role'] == 'employer') esc_attr_e( 'selected' ); ?> value="employer">Project Owner</option>
	      </select>
	    </div>
	  </div>
  <?php
}

// Validate WooCommerce registration form custom fields.
add_action( 'woocommerce_register_post', 'cosmos_validate_reg_form_fields', 10, 3 );
function cosmos_validate_reg_form_fields($username, $email, $validation_errors) {
  if (isset($_POST['role']) && empty($_POST['role']) ) {
    $validation_errors->add('role_error', __('Role required!', 'woocommerce'));
  }
  return $validation_errors;
}

// Save WooCommerce registration form custom fields.
add_action( 'woocommerce_created_customer', 'cosmos_save_registration_form_fields' );
function cosmos_save_registration_form_fields( $customer_id ) {
  if ( isset($_POST['role']) ) {
    if( $_POST['role'] == 'candidate' ){
      $user = new WP_User($customer_id);
      $user->set_role('candidate');
    }
    if( $_POST['role'] == 'employer' ){
      $user = new WP_User($customer_id);
      $user->set_role('employer');
    }
  }
}
