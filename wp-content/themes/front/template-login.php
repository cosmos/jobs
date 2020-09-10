<?php
/**
 * Template name: Login & My Account
 *
 * @package front
 */

$is_woocommerce_activated = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();
$is_job_manager_activated = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

if ( is_user_logged_in() && $is_woocommerce_activated && get_option('woocommerce_myaccount_page_id') ) {
    wp_redirect( get_permalink( get_option('woocommerce_myaccount_page_id') ) );
    exit;
} else if ( is_user_logged_in() && $is_job_manager_activated && get_option( 'job_manager_job_dashboard_page_id' ) ) {
    wp_redirect( get_permalink( get_option( 'job_manager_job_dashboard_page_id' ) ) );
    exit;
} else if ( ! $is_woocommerce_activated && ! $is_job_manager_activated ) {
    wp_redirect( home_url( '/' ) );
    exit;
}

get_header(); ?>
    
    <div class="d-flex align-items-center position-relative height-lg-100vh">
        <div class="col-lg-5 col-xl-4 d-none d-lg-flex align-items-center gradient-half-primary-v1 height-lg-100vh px-0">
            <div class="w-100 p-5">
                <?php while ( have_posts() ) : the_post();

                    do_action( 'front_login_myaccount_before' );

                    get_template_part( 'templates/contents/content', 'page' );

                    do_action( 'front_login_myaccount_after' );

                endwhile; // End of the loop. ?>   
            </div>
        </div>
        <div class="container">
            <?php 
                if ( ! is_user_logged_in() ) {
                    if ( $is_woocommerce_activated ) {
                        echo do_shortcode( '[woocommerce_my_account]' );
                    } else if ( $is_job_manager_activated ) {
                        echo do_shortcode( '[front_job_form]' );
                    }
                }
            ?>
        </div>
    </div>

<?php get_footer(); ?>