<?php

// Register widgets.
function front_widgets_register() {

    if ( class_exists( 'Front' ) ) {
        include_once FRONT_EXTENSIONS_DIR . '/includes/widgets/class-front-random-posts-widget.php';
        register_widget( 'Front_Random_Posts_Widget' );
    }

    if ( class_exists( 'Front' ) && class_exists( 'WooCommerce' ) ) {
        include_once FRONT_EXTENSIONS_DIR . '/includes/widgets/class-front-widget-layered-nav.php';
        register_widget( 'Front_Layered_Nav_Widget' );
        include_once FRONT_EXTENSIONS_DIR . '/includes/widgets/class-front-widget-price-filter.php';
        register_widget( 'Front_Widget_Price_Filter' );
    }

    if ( class_exists( 'Front' ) && class_exists( 'WP_Job_Manager' ) ) {
        // Search Widget
        include_once FRONT_EXTENSIONS_DIR . '/includes/wp-job-manager/widgets/class-front-wpjm-widget-job-search.php';
        register_widget( 'Front_WPJM_Widget_Job_Search' );

        // Location Search Widget
        include_once FRONT_EXTENSIONS_DIR . '/includes/wp-job-manager/widgets/class-front-wpjm-widget-job-location-search.php';
        register_widget( 'Front_WPJM_Widget_Job_Location_Search' );

        // Filter Widget
        include_once FRONT_EXTENSIONS_DIR . '/includes/wp-job-manager/widgets/class-front-wpjm-widget-layered-nav.php';
        register_widget( 'Front_WPJM_Widget_Layered_Nav' );

        if ( class_exists( 'MAS_WP_Job_Manager_Company' ) ) {
            // Company ID Filter Widget
            include_once FRONT_EXTENSIONS_DIR . '/includes/wp-job-manager/widgets/class-front-wpjm-widget-campany-id-filter.php';
            register_widget( 'Front_WPJM_Widget_Company_ID' );
        } else {
            // Company Name Filter Widget
            include_once FRONT_EXTENSIONS_DIR . '/includes/wp-job-manager/widgets/class-front-wpjm-widget-campany-name-filter.php';
            register_widget( 'Front_WPJM_Widget_Company_Name' );
        }

        if ( class_exists( 'WP_Resume_Manager' ) ) {
            // Search Widget
            include_once FRONT_EXTENSIONS_DIR . '/includes/wp-job-manager-resumes/widgets/class-front-wpjmr-widget-resume-search.php';
            register_widget( 'Front_WPJMR_Widget_Resume_Search' );

            // Location Search Widget
            include_once FRONT_EXTENSIONS_DIR . '/includes/wp-job-manager-resumes/widgets/class-front-wpjmr-widget-resume-location-search.php';
            register_widget( 'Front_WPJMR_Widget_Resume_Location_Search' );

            // Filter Widget
            include_once FRONT_EXTENSIONS_DIR . '/includes/wp-job-manager-resumes/widgets/class-front-wpjmr-widget-layered-nav.php';
            register_widget( 'Front_WPJMR_Widget_Layered_Nav' );
        }
    }

    if ( class_exists( 'Front' ) && function_exists( 'hivepress' ) ) {
        // Category Widget
        include_once FRONT_EXTENSIONS_DIR . '/includes/hivepress-marketplace/widgets/class-front-hp-listings-categories-widget.php';
        register_widget( 'Front_HP_Listings_Categories_Widget' );

        // Verification Filter Widget
        include_once FRONT_EXTENSIONS_DIR . '/includes/hivepress-marketplace/widgets/class-front-hp-listings-verification-widget.php';
        register_widget( 'Front_HP_Listings_Verification_Widget' );

        // Listing Attributes Filter Widget
        include_once FRONT_EXTENSIONS_DIR . '/includes/hivepress-marketplace/widgets/class-front-hp-listings-attributes-filter-widget.php';
        register_widget( 'Front_HP_Listings_Attributes_Filter_Widget' );
    }
}

add_action( 'widgets_init', 'front_widgets_register' );

// Static Content Jetpack Share Remove
function front_mas_static_content_jetpack_sharing_remove_filters() {
    if( function_exists( 'sharing_display' ) ) {
        remove_filter( 'the_content', 'sharing_display', 19 );
    }
}

add_action( 'mas_static_content_before_shortcode_content', 'front_mas_static_content_jetpack_sharing_remove_filters' );

function front_mas_static_content_jetpack_sharing_add_filters() {
    if( function_exists( 'sharing_display' ) ) {
        add_filter( 'the_content', 'sharing_display', 19 );
    }
}

add_action( 'mas_static_content_after_shortcode_content', 'front_mas_static_content_jetpack_sharing_add_filters' );

// Jetpack
if ( ! function_exists( 'front_jetpack_sharing_remove_filters' ) ) {
    function front_jetpack_sharing_remove_filters() {
        if( function_exists( 'sharing_display' ) ) {
            remove_filter( 'the_content', 'sharing_display', 19 );
            remove_filter( 'the_excerpt', 'sharing_display', 19 );
        }
    }
}

add_action( 'front_before_portfolio', 'front_jetpack_sharing_remove_filters', 5 );
add_action( 'front_portfolio_single_post', 'front_jetpack_sharing_remove_filters', 5 );
add_action( 'front_single_post_before', 'front_jetpack_sharing_remove_filters', 5 );

function front_remove_sharedaddy_excerpt_sharing() {
    if( function_exists( 'sharing_display' ) ) {
        remove_filter( 'the_excerpt', 'sharing_display', 19 );
    }
}

function front_jp_jetpack_sharing_remove_filters( $content ) {
    if ( function_exists( 'sharing_display' ) && has_shortcode( $content, 'portfolio' ) ) {
        remove_filter( 'the_content', 'sharing_display', 19 );
        remove_filter( 'the_excerpt', 'sharing_display', 19 );
    }
    return $content;
}
add_filter( 'the_content', 'front_jp_jetpack_sharing_remove_filters' );

add_action( 'single_job_listing_before', 'front_remove_sharedaddy_excerpt_sharing' );
add_action( 'single_company_before', 'front_remove_sharedaddy_excerpt_sharing' );

add_action( 'show_user_profile', 'front_add_author_byline_field', 10, 1 );
add_action( 'edit_user_profile', 'front_add_author_byline_field', 10, 1 );

function front_add_author_byline_field( $user ) {
    ?><h3><?php echo esc_html__( 'Additional Profile Information', 'front-extensions' ); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="user_byline"><?php echo esc_html__( 'Author Byline', 'front-extensions' ); ?></label></th>
            <td>
                <input type="text" name="user_byline" id="user_byline" value="<?php echo esc_attr( get_the_author_meta( 'user_byline', $user->ID ) ); ?>" class="regular-text" /><br />
                <p class="description"><?php echo esc_html__( 'Displayed below author name in Single Srticle Classic in Front Theme', 'front-extensions' ); ?></p>
            </td>
        </tr>
    </table><?php
}

add_action( 'personal_options_update',  'front_save_author_byline_field' );
add_action( 'edit_user_profile_update', 'front_save_author_byline_field' );

function front_save_author_byline_field( $user_id ) {

    if ( ! current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    $user_byline = filter_input( INPUT_POST, 'user_byline', FILTER_SANITIZE_STRING );
    update_user_meta( $user_id, 'user_byline', $user_byline );
}

/**
 * WooCommerce
 */
if( function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated() ) {
    add_action( 'init', 'front_shipping_icons_descriptions_woocommerce_compatibility' );

    if ( ! function_exists( 'front_shipping_icons_descriptions_woocommerce_compatibility' ) ) {
        function front_shipping_icons_descriptions_woocommerce_compatibility() {
            if ( function_exists( 'alg_wc_shipping_icons_descs' ) ) {
                remove_filter( 'woocommerce_cart_shipping_method_full_label', array( alg_wc_shipping_icons_descs()->core, 'shipping_description' ), PHP_INT_MAX, 2 );
                add_filter( 'woocommerce_cart_shipping_method_full_label', 'front_shipping_icons_descriptions_shipping_description', 20, 2 );
            }
        }
    }
}

/**
 * MAS Company Reviews Integration
 */
if ( function_exists( 'front_is_mas_wp_job_manager_company_review_activated' ) && front_is_mas_wp_job_manager_company_review_activated() ) {
    if ( ! function_exists( 'front_modify_wpjmcr_walker_comment_before_title' ) ) {
        function front_modify_wpjmcr_walker_comment_before_title( $style ) {
            $display = mas_wpjmcr()->display;
            remove_filter( 'get_comment_text', array( $display, 'review_comment_text' ), 10, 3 );
            remove_filter( 'get_comment_text', array( $display, 'display_review_gallery' ), 11, 3 );
        }
    }

    add_action( 'front_wpjmcr_walker_comment_before_title', 'front_modify_wpjmcr_walker_comment_before_title' );
}