<?php
/**
* My Account Dashboard
*
* Shows the first intro screen on the account dashboard.
*
* This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
*
* HOWEVER, on occasion WooCommerce will need to update template files and you
* (the theme developer) will need to copy the new files to your theme to
* maintain compatibility. We try to do this as little as possible, but it does
* happen. When this occurs the version of the template file will be bumped and
* the readme will list any important changes.
*
* @see         https://docs.woocommerce.com/document/template-structure/
* @package     WooCommerce/Templates
* @version     4.4.0
*/

if ( ! defined( 'ABSPATH' ) ) {
exit; // Exit if accessed directly
}
?>

<div class="card-deck d-block d-lg-flex card-lg-gutters-3 mb-6">
    <!-- Card -->
    <div class="card card-frame mb-3">
        <a class="card-body p-5" href="<?php echo esc_url( wc_get_endpoint_url( 'orders' ));?>">
            <div class="media align-items-center">
                <span class="btn btn-lg btn-icon btn-soft-primary rounded-circle mr-4">
                    <span class="fas fa-box-open btn-icon__inner"></span>
                </span>
                <div class="media-body">
                    <h5 class="d-block text-dark mb-0"><?php esc_html_e( 'Your Order', 'front' ); ?></h5>
                    <small class="d-block text-secondary"><?php esc_html_e( 'Track, return or buy things again', 'front' ); ?></small>
                </div>
            </div>
        </a>
    </div>
    <!-- End Card -->

    <!-- Card -->
    <a class="card card-frame mb-3" href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ));?>">
        <div class="card-body p-5">
            <div class="media align-items-center">
                <span class="btn btn-lg btn-icon btn-soft-success rounded-circle mr-4">
                     <span class="fas fa-lock btn-icon__inner"></span>
                </span>
                <div class="media-body">
                    <h5 class="d-block text-dark mb-0"><?php esc_html_e( 'Login & Security', 'front' ); ?></h5>
                    <small class="d-block text-secondary"><?php esc_html_e( 'Edit login, name and mobile number', 'front' ); ?></small>
                </div>
            </div>
        </div>
    </a>
    <!-- End Card -->

    <!-- Card -->
    <a class="card card-frame mb-3" href="<?php echo esc_url(wc_get_endpoint_url( 'edit-address'));?>">
        <div class="card-body p-5">
            <div class="media align-items-center">
                <span class="btn btn-lg btn-icon btn-soft-warning rounded-circle mr-4">
                        <span class="fas fa-map-marker-alt btn-icon__inner"></span>
                </span>
                <div class="media-body">
                    <h5 class="d-block text-dark mb-0"><?php esc_html_e( 'Your Address', 'front' ); ?></h5>
                    <small class="d-block text-secondary"><?php esc_html_e( 'Edit Addresses for orders and gifts', 'front' ); ?></small>
                </div>
            </div>
        </div>
    </a>
    <!-- End Card -->
</div>

<?php
/**
* My Account dashboard.
*
* @since 2.6.0
*/
do_action( 'woocommerce_account_dashboard' );

/**
* Deprecated woocommerce_before_my_account action.
*
* @deprecated 2.6.0
*/
do_action( 'woocommerce_before_my_account' );

/**
* Deprecated woocommerce_after_my_account action.
*
* @deprecated 2.6.0
*/
do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
