<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$is_registration_enabled = false;
if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) {
    $is_registration_enabled = true;
}

$login_tab_pane    = ' active';
$register_tab_pane = '';
if ( isset( $_POST['register'] ) ) {
    $login_tab_pane    = '';
    $register_tab_pane = ' active';
}
$front_my_account_login_form_welcome_text    = sprintf( '%s <span class="font-weight-semi-bold">%s</span>', esc_html__( 'Welcome', 'front' ), esc_html__( 'back', 'front' ));
$front_my_account_register_form_welcome_text = sprintf( '%s <span class="font-weight-semi-bold">%s</span>', esc_html__( 'Welcome to', 'front' ), get_bloginfo( 'name' ) );
?>
<div class="<?php echo esc_attr( is_page_template( 'template-login.php' ) ? 'row no-gutters' : 'container space-2' ); ?>">
    <div class="<?php echo esc_attr( is_page_template( 'template-login.php' ) ? 'col-md-8 col-lg-7 col-xl-6 offset-md-2 offset-lg-2 offset-xl-3 space-3 space-lg-0' : 'w-md-75 w-lg-50 mx-md-auto' ); ?>" id="customer_login">

        <?php do_action( 'woocommerce_before_customer_login_form' ); ?>

        <?php if ( $is_registration_enabled ) : ?>

            <div class="tab-content<?php echo esc_attr( is_page_template( 'template-login.php' ) ? ' mt-5' : '' ); ?>">

                <div class="tab-pane<?php echo esc_attr( $login_tab_pane ); ?>" id="customer-login-form" aria-labelledby="login-tab">

        <?php endif; ?>
                    <div class="mb-7">

                        <h2 class="h3 text-primary font-weight-normal mb-0"><?php echo apply_filters( 'front_my_account_login_form_title', wp_kses_post( $front_my_account_login_form_welcome_text ) ); ?></h2>

                        <p><?php echo apply_filters( 'front_my_account_login_form_desc', esc_html__( 'Login to manage your account.', 'front' ) ); ?></p>
                    </div>

                    <form class="woocommerce-form woocommerce-form-login login" method="post">

                        <?php do_action( 'woocommerce_login_form_start' ); ?>

                        <div class="form-group">
                            <label class="form-label" for="username"><?php esc_html_e( 'Email Address', 'front' ); ?></label>
                            <input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />

                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password">
                                <span class="d-flex justify-content-between align-items-center"><?php esc_html_e( 'Password', 'front' ); ?>
                                    <a class="link-muted text-capitalize font-weight-normal" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot Password?', 'front' ); ?>

                                    </a>
                                </span>
                            </label>
                            <input class="form-control woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
                        </div>

                        <?php do_action( 'woocommerce_login_form' ); ?>

                        <div class="row align-items-center mb-5">
                            <?php if ( $is_registration_enabled ) : ?>
                                <div class="col-6">
                                    <span class="small text-muted"><?php esc_html_e( 'Don&#039;t have an account?', 'front' ); ?></span>
                                    <a id="register-tab" class="small login login-register-tab-switcher" href="#customer-register-form" aria-controls="customer-register-form" aria-selected="true"><?php esc_html_e( 'Signup', 'front' ); ?></a>
                                </div>

                                <div class="col-6 text-right">
                                    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                                    <button type="submit" class="btn btn-primary transition-3d-hover woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'front' ); ?>"><?php esc_html_e( 'Get Started', 'front' ); ?></button>
                                </div>
                               <?php else: ?>

                                <div class="col-12 text-right">
                                    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                                    <button type="submit" class="btn btn-primary transition-3d-hover woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'front' ); ?>"><?php esc_html_e( 'Get Started', 'front' ); ?></button>
                                </div>
                                <?php endif; ?>
                            </div>

                        <?php do_action( 'woocommerce_login_form_end' ); ?>

                    </form>
        <?php if ( $is_registration_enabled ) : ?>
                </div>

                <div class="tab-pane<?php echo esc_attr( $register_tab_pane ); ?>" id="customer-register-form" aria-labelledby="register-tab">
                    <div class="mb-7">
                        <h2 class="h3 text-primary font-weight-normal mb-0"><?php echo apply_filters( 'front_my_account_register_form_title', wp_kses_post( $front_my_account_register_form_welcome_text ) );?></h2>
                        <p><?php echo apply_filters( 'front_my_account_register_form_desc', esc_html__( 'Fill out the form to get started.', 'front' ) ); ?></p>
                    </div>

                    <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

                        <?php do_action( 'woocommerce_register_form_start' ); ?>

                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                            <div class="form-group">
                                <label class="form-label" for="reg_username"><?php esc_html_e( 'Username', 'front' ); ?>&nbsp;<span class="required">*</span></label>
                                <input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                            </div>

                        <?php endif; ?>

                        <div class="form-group">
                            <label class="form-label" for="reg_email"><?php esc_html_e( 'Email address', 'front' ); ?></label>
                            <input type="email" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                        </div>

                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                            <div class="form-group js-form-message">
                                <label class="form-label" for="reg_password"><?php esc_html_e( 'Password', 'front' ); ?></label>
                                <input id="reg_password" type="password" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="newPassword" aria-label="Enter your password" required
                                   data-msg="Please enter your password."
                                   data-error-class="u-has-error"
                                   data-success-class="u-has-success"
                                   data-pwstrength-container="#changePasswordForm"
                                   data-pwstrength-progress="#passwordStrengthProgress"
                                   data-pwstrength-verdict="#passwordStrengthVerdict"
                                   data-pwstrength-progress-extra-classes="bg-white height-4">

                            </div>

                            <div class="form-group">
                                <label class="form-label" for="con_password"><?php esc_html_e( 'Confirm Password', 'front' ); ?></label>
                                <input type="password" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="password" id="con_password" autocomplete="new-password" />
                            </div>

                        <?php else : ?>

                            <p><?php esc_html_e( 'A password will be sent to your email address.', 'front' ); ?></p>

                        <?php endif; ?>
                        <?php if ( !empty( front_registration_privacy_policy_text()) ) { ?>
                            <div class="mb-5">
                                <div class="custom-control custom-checkbox d-flex align-items-center text-muted">

                                    <input type="checkbox" class="custom-control-input" id="termsCheckbox" name="termsCheckbox" required="" data-msg="Please accept our Terms and Conditions." data-error-class="u-has-error" data-success-class="u-has-success">

                                    <label class="custom-control-label woocommerce-privacy-policy-text" for="termsCheckbox">
                                        <small><?php echo front_registration_privacy_policy_text(); ?></small>
                                    </label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php do_action( 'woocommerce_register_form' ); ?>

                        <div class="row align-items-center mb-5">
                            <div class="col-5 col-sm-6">
                                <span class="small text-muted"><?php esc_html_e( 'Already have an account?', 'front' ); ?></span>
                                <a id="login-tab" class="small login login-register-tab-switcher" href="#customer-login-form" aria-controls="customer-login-form" aria-selected="true"><?php echo esc_html__( 'Login', 'front' ); ?></a>
                            </div>

                            <div class="col-7 col-sm-6 text-right">
                                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                                <button type="submit" class="btn btn-primary transition-3d-hover woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'front' ); ?>"><?php esc_html_e( 'Get Started', 'front' ); ?></button>
                            </div>
                        </div>

                        <?php do_action( 'woocommerce_register_form_end' ); ?>

                    </form>
                </div>

            </div>

        <?php endif; ?>
    </div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
