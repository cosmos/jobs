<?php
define( 'FRONT_MAIN_DEMO_IMPORT_FILE_NAME', 'Main' );
define( 'FRONT_MAIN_PREMIUM_DEMO_IMPORT_FILE_NAME', 'Main - Premium ( Includes Preview Images )' );

function front_ocdi_import_files() {
    $dd_path = trailingslashit( get_template_directory() ) . 'assets/dummy-data/';
    return apply_filters( 'front_ocdi_files_args', array(
        array(
            'import_file_name'             => 'Simple',
            'categories'                   => array( 'Front' ),
            'local_import_file'            => $dd_path . 'simple/dummy-data.xml',
            'local_import_widget_file'     => $dd_path . 'simple/widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => $dd_path . 'simple/redux-options.json',
                    'option_name' => 'front_options',
                ),
            ),
            'import_preview_image_url'     => 'https://transvelo.github.io/front/assets/images/screenshots/main.jpg',
            'import_notice'                => front_ocdi_get_import_notice( 'Simple' ),
            'preview_url'                  => 'https://demo.madrasthemes.com/front-demo-simple/',
        ),
        array(
            'import_file_name'             => FRONT_MAIN_DEMO_IMPORT_FILE_NAME,
            'categories'                   => array( 'Front' ),
            'local_import_file'            => $dd_path . 'main/dummy-data.xml',
            'local_import_widget_file'     => $dd_path . 'main/widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => $dd_path . 'main/redux-options.json',
                    'option_name' => 'front_options',
                ),
            ),
            'import_preview_image_url'     => 'https://transvelo.github.io/front/assets/images/screenshots/main.jpg',
            'import_notice'                => front_ocdi_get_import_notice( FRONT_MAIN_DEMO_IMPORT_FILE_NAME ),
            'preview_url'                  => 'https://demo.madrasthemes.com/front-demo/',
        ),
        array(
            'import_file_name'             => FRONT_MAIN_PREMIUM_DEMO_IMPORT_FILE_NAME,
            'categories'                   => array( 'Front' ),
            'local_import_file'            => $dd_path . 'main-premium/dummy-data.xml',
            'local_import_widget_file'     => $dd_path . 'main-premium/widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => $dd_path . 'main-premium/redux-options.json',
                    'option_name' => 'front_options',
                ),
            ),
            'import_preview_image_url'     => 'https://transvelo.github.io/front/assets/images/screenshots/main.jpg',
            'import_notice'                => front_ocdi_get_import_notice( FRONT_MAIN_PREMIUM_DEMO_IMPORT_FILE_NAME ),
            'preview_url'                  => 'https://demo.madrasthemes.com/front/',
        ),
        array(
            'import_file_name'             => 'Jobs',
            'categories'                   => array( 'Front' ),
            'local_import_file'            => front_is_wp_resume_manager_activated() ? $dd_path . 'jobs/dummy-data.xml' : $dd_path . 'jobs-without-core-addon-bundle/dummy-data.xml',
            'local_import_widget_file'     => front_is_wp_resume_manager_activated() ? $dd_path . 'jobs/widgets.wie' : $dd_path . 'jobs-without-core-addon-bundle/widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => front_is_wp_resume_manager_activated() ? $dd_path . 'jobs/redux-options.json' : $dd_path . 'jobs-without-core-addon-bundle/redux-options.json',
                    'option_name' => 'front_options',
                ),
            ),
            'import_preview_image_url'     => 'https://madrasthemes.github.io/assets/front/jobs.jpg',
            'import_notice'                => front_ocdi_get_import_notice( 'Jobs' ),
            'preview_url'                  => 'https://demo.madrasthemes.com/front-jobs/',
        ),
        array(
            'import_file_name'             => 'Crypto',
            'categories'                   => array( 'Front' ),
            'local_import_file'            => $dd_path . 'crypto/dummy-data.xml',
            'local_import_widget_file'     => $dd_path . 'crypto/widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => $dd_path . 'crypto/redux-options.json',
                    'option_name' => 'front_options',
                ),
            ),
            'import_preview_image_url'     => 'https://madrasthemes.github.io/assets/front/crypto.jpg',
            'import_notice'                => front_ocdi_get_import_notice( 'Crypto' ),
            'preview_url'                  => 'https://demo.madrasthemes.com/front-crypto/',
        ),
        array(
            'import_file_name'             => 'Help Desk',
            'categories'                   => array( 'Front' ),
            'local_import_file'            => $dd_path . 'help-desk/dummy-data.xml',
            'local_import_widget_file'     => $dd_path . 'help-desk/widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => $dd_path . 'help-desk/redux-options.json',
                    'option_name' => 'front_options',
                ),
            ),
            'import_preview_image_url'     => 'https://madrasthemes.github.io/assets/front/help-desk.jpg',
            'import_notice'                => front_ocdi_get_import_notice( 'Help Desk' ),
            'preview_url'                  => 'https://demo.madrasthemes.com/front-help-desk/',
        ),
        array(
            'import_file_name'             => 'App Marketplace',
            'categories'                   => array( 'Front' ),
            'local_import_file'            => $dd_path . 'app-marketplace/dummy-data.xml',
            'local_import_widget_file'     => $dd_path . 'app-marketplace/widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => $dd_path . 'app-marketplace/redux-options.json',
                    'option_name' => 'front_options',
                ),
            ),
            'import_preview_image_url'     => 'https://madrasthemes.github.io/assets/front/app-marketplace.jpg',
            'import_notice'                => front_ocdi_get_import_notice( 'App Marketplace' ),
            'preview_url'                  => 'https://demo.madrasthemes.com/front-app-marketplace/',
        ),
    ) );
}

function front_ocdi_after_import_setup( $selected_import ) {

    // Assign front page and posts page (blog page) and other pages
    if ( FRONT_MAIN_DEMO_IMPORT_FILE_NAME === $selected_import['import_file_name'] || FRONT_MAIN_PREMIUM_DEMO_IMPORT_FILE_NAME === $selected_import['import_file_name'] || 'Simple' === $selected_import['import_file_name'] ) {

        // Assign menus to their locations.
        $primary                        = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
        $topbar_left                    = get_term_by( 'name', 'Topbar Links - Left', 'nav_menu' );
        $topbar_right                   = get_term_by( 'name', 'Topbar Links - Right', 'nav_menu' );
        $topbar_mobile                  = get_term_by( 'name', 'Topbar Links - Mobile', 'nav_menu' );
        $sidebar_footer_menu            = get_term_by( 'name', 'Header Sidebar Footer Menu', 'nav_menu' );
        $offcanvas_menu                 = get_term_by( 'name', 'Header Offcanvas Menu', 'nav_menu' );
        $footer_social_menu             = get_term_by( 'name', 'Footer Social Menu', 'nav_menu' );
        $footer_primary_menu            = get_term_by( 'name', 'Footer Primary Menu', 'nav_menu' );

        set_theme_mod( 'nav_menu_locations', array(
                'primary'               => $primary->term_id,
                'topbar_left'           => $topbar_left->term_id,
                'topbar_right'          => $topbar_right->term_id,
                'topbar_mobile'         => $topbar_mobile->term_id,
                'sidebar_footer_menu'   => $sidebar_footer_menu->term_id,
                'offcanvas_menu'        => $offcanvas_menu->term_id,
                'footer_social_menu'    => $footer_social_menu->term_id,
                'footer_primary_menu'   => $footer_primary_menu->term_id,
            )
        );

        // Assign Pages
        $front_page_id                  = get_page_by_title( 'Classic Agency' );
        $blog_page_id                   = get_page_by_title( 'Blog' );
        $shop_page_id                   = get_page_by_title( 'Shop' );
        $cart_page_id                   = get_page_by_title( 'Cart' );
        $checkout_page_id               = get_page_by_title( 'Checkout' );
        $myaccount_page_id              = get_page_by_title( 'My account' );
        $wishlist_page_id               = get_page_by_title( 'Wishlist' );

        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page_id->ID );
        update_option( 'page_for_posts', $blog_page_id->ID );
        update_option( 'woocommerce_shop_page_id', $shop_page_id->ID );
        update_option( 'woocommerce_cart_page_id', $cart_page_id->ID );
        update_option( 'woocommerce_checkout_page_id', $checkout_page_id->ID );
        update_option( 'woocommerce_myaccount_page_id', $myaccount_page_id->ID );
        update_option( 'yith_wcwl_wishlist_page_id', $wishlist_page_id->ID );

        // Enable Registration on "My Account" page
        update_option( 'woocommerce_enable_myaccount_registration', 'yes' );

        // Update Wishlist Position
        update_option( 'yith_wcwl_button_position', 'shortcode' );
    
        // Import WPForms
        if( FRONT_MAIN_DEMO_IMPORT_FILE_NAME === $selected_import['import_file_name'] ) {
            front_ocdi_import_wpforms( 'main' );
        } elseif( FRONT_MAIN_PREMIUM_DEMO_IMPORT_FILE_NAME === $selected_import['import_file_name'] ) {
            front_ocdi_import_wpforms( 'main-premium' );
        } elseif( 'Simple' === $selected_import['import_file_name'] ) {
            front_ocdi_import_wpforms( 'simple' );
        }

    } elseif ( 'Jobs' === $selected_import['import_file_name'] ) {

        // Assign menus to their locations.
        $primary                        = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
        $topbar_right                   = get_term_by( 'name', 'Topbar Links - Right', 'nav_menu' );
        $topbar_mobile                  = get_term_by( 'name', 'Topbar Links - Mobile', 'nav_menu' );

        set_theme_mod( 'nav_menu_locations', array(
                'primary'               => $primary->term_id,
                'topbar_right'          => $topbar_right->term_id,
                'topbar_mobile'         => $topbar_mobile->term_id,
            )
        );

        // Assign Pages
        $front_page_id                  = get_page_by_title( 'Jobs Home' );
        $blog_page_id                   = get_page_by_title( 'Blog' );
        $shop_page_id                   = get_page_by_title( 'Shop' );
        $cart_page_id                   = get_page_by_title( 'Cart' );
        $checkout_page_id               = get_page_by_title( 'Checkout' );
        $myaccount_page_id              = get_page_by_title( 'My account' );

        $jobs_page_id                   = get_page_by_title( 'Jobs' );
        $job_dashboard_page_id          = get_page_by_title( 'Job Dashboard' );
        $submit_job_page_id             = get_page_by_title( 'Post a Job' );

        $companies_page_id              = get_page_by_title( 'Companies' );
        $company_dashboard_page_id      = get_page_by_title( 'Company Dashboard' );
        $submit_company_page_id         = get_page_by_title( 'Submit Company' );

        $resumes_page_id                = get_page_by_title( 'Resumes' );
        $candidate_dashboard_page_id    = get_page_by_title( 'Candidate Dashboard' );
        $submit_resume_page_id          = get_page_by_title( 'Submit Resume' );

        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page_id->ID );
        update_option( 'page_for_posts', $blog_page_id->ID );
        update_option( 'woocommerce_shop_page_id', $shop_page_id->ID );
        update_option( 'woocommerce_cart_page_id', $cart_page_id->ID );
        update_option( 'woocommerce_checkout_page_id', $checkout_page_id->ID );
        update_option( 'woocommerce_myaccount_page_id', $myaccount_page_id->ID );

        // WP Job Manager
        update_option( 'job_manager_jobs_page_id', $jobs_page_id->ID );
        update_option( 'job_manager_job_dashboard_page_id', $job_dashboard_page_id->ID );
        update_option( 'job_manager_submit_job_form_page_id', $submit_job_page_id->ID );
        update_option( 'job_manager_per_page', '12' );

        // MAS WP Job Manager Company
        update_option( 'job_manager_companies_page_id', $companies_page_id->ID );
        update_option( 'job_manager_company_dashboard_page_id', $company_dashboard_page_id->ID );
        update_option( 'job_manager_submit_company_form_page_id', $submit_company_page_id->ID );
        update_option( 'job_manager_job_submission_required_company', '1' );

        // WP Job Manager Resumes
        update_option( 'resume_manager_resumes_page_id', $resumes_page_id->ID );
        update_option( 'resume_manager_candidate_dashboard_page_id', $candidate_dashboard_page_id->ID );
        update_option( 'resume_manager_submit_resume_form_page_id', $submit_resume_page_id->ID );
        update_option( 'resume_manager_per_page', '12' );

        // Enable Registration on "My Account" page
        update_option( 'woocommerce_enable_myaccount_registration', 'yes' );

    } elseif ( 'Crypto' === $selected_import['import_file_name'] ) {

        $front_page_id                  = get_page_by_title( 'Landing Page' );
        $blog_page_id                   = get_page_by_title( 'Blog' );

        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page_id->ID );
        update_option( 'page_for_posts', $blog_page_id->ID );

    } elseif ( 'Help Desk' === $selected_import['import_file_name'] ) {

        // Assign menus to their locations.
        $primary                        = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
        $topbar_right                   = get_term_by( 'name', 'Topbar Links - Right', 'nav_menu' );

        set_theme_mod( 'nav_menu_locations', array(
                'primary'               => $primary->term_id,
                'topbar_right'          => $topbar_right->term_id,
            )
        );

        // Assign Pages
        $front_page_id                  = get_page_by_title( 'Help Page' );
        $blog_page_id                   = get_page_by_title( 'Blog' );
        $docs_page_id                   = get_page_by_title( 'Documentation' );

        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page_id->ID );
        update_option( 'page_for_posts', $blog_page_id->ID );

        $settings = get_option( 'wedocs_settings', array() );
        $settings['docs_home'] = $docs_page_id->ID;

        update_option( 'wedocs_settings', $settings );

    } elseif ( 'App Marketplace' === $selected_import['import_file_name'] ) {

        // Assign menus to their locations.
        $primary                        = get_term_by( 'name', 'Primary Menu', 'nav_menu' );

        set_theme_mod( 'nav_menu_locations', array(
                'primary'               => $primary->term_id,
            )
        );

        // Assign Pages
        $front_page_id                  = get_page_by_title( 'App Page' );
        $blog_page_id                   = get_page_by_title( 'Blog' );
        $listings_page_id               = get_page_by_title( 'App Listings' );

        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page_id->ID );
        update_option( 'page_for_posts', $blog_page_id->ID );

        // Hivepress Settings
        update_option( 'hp_page_listings', $listings_page_id->ID );
        update_option( 'hp_listings_per_page', 12 );
        update_option( 'hp_listings_featured_per_page', 0 );
        update_option( 'hp_vendor_enable_display', 0 );
        update_option( 'hp_listing_enable_submission', 1 );

    }
}

function front_ocdi_before_widgets_import() {

    $sidebars_widgets = get_option('sidebars_widgets');
    $all_widgets = array();

    array_walk_recursive( $sidebars_widgets, function ($item, $key) use ( &$all_widgets ) {
        if( ! isset( $all_widgets[$key] ) ) {
            $all_widgets[$key] = $item;
        } else {
            $all_widgets[] = $item;
        }
    } );

    if( isset( $all_widgets['array_version'] ) ) {
        $array_version = $all_widgets['array_version'];
        unset( $all_widgets['array_version'] );
    }

    $new_sidebars_widgets = array_fill_keys( array_keys( $sidebars_widgets ), array() );

    $new_sidebars_widgets['wp_inactive_widgets'] = $all_widgets;
    if( isset( $array_version ) ) {
        $new_sidebars_widgets['array_version'] = $array_version;
    }

    update_option( 'sidebars_widgets', $new_sidebars_widgets );
}

function front_ocdi_before_content_import( $selected_import ) {

    if ( FRONT_MAIN_DEMO_IMPORT_FILE_NAME === $selected_import['import_file_name'] || FRONT_MAIN_PREMIUM_DEMO_IMPORT_FILE_NAME === $selected_import['import_file_name'] || 'Simple' === $selected_import['import_file_name'] ) {
    } elseif ( 'Jobs' === $selected_import['import_file_name'] ) {

        // Disable Porfolio
        if ( class_exists( 'Jetpack_Portfolio' ) ) {
            update_option( Jetpack_Portfolio::OPTION_NAME, '0' );
        }

    } elseif ( 'Crypto' === $selected_import['import_file_name'] ) {

        // Disable Porfolio
        if ( class_exists( 'Jetpack_Portfolio' ) ) {
            update_option( Jetpack_Portfolio::OPTION_NAME, '0' );
        }

    } elseif ( 'Help Desk' === $selected_import['import_file_name'] ) {

        // Disable Porfolio
        if ( class_exists( 'Jetpack_Portfolio' ) ) {
            update_option( Jetpack_Portfolio::OPTION_NAME, '0' );
        }

        // Disable Testimonial
        if ( class_exists( 'Jetpack_Testimonial' ) ) {
            update_option( Jetpack_Testimonial::OPTION_NAME, '0' );
        }

    } elseif ( 'App Marketplace' === $selected_import['import_file_name'] ) {
    }
}

function front_ocdi_get_import_notice( $import_file_name = FRONT_MAIN_DEMO_IMPORT_FILE_NAME ) {
    $time_taken = '3-5';
    if ( FRONT_MAIN_PREMIUM_DEMO_IMPORT_FILE_NAME === $import_file_name ) {
        $time_taken = '5-10';
    }

    $instructions = '<div class="front-ocdi-import-instructions">' . sprintf( esc_html__( 'Import process may take %s minutes. If you facing any issues please contact our support.', 'front' ), $time_taken ) . '</div>';
    $instructions .= '<div class="front-ocdi-install-plugin-instructions">' . esc_html__( 'Before you begin, make sure all the required plugins are activated.', 'front' ) . '</div>';

    return $instructions;
}

function front_ocdi_confirmation_dialog_options( $options ) {
    $tgmpa_instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
    $selected_demo = get_option( 'front_tgmpa_selected_demo', 'simple' );

    $dialogClass = 'wp-dialog';

    if( true !== $tgmpa_instance->is_tgmpa_complete() ) {
        $dialogClass .= ' disable-import-btn';
    }

    return array_merge( $options, array(
        'dialogClass' => $dialogClass,
    ) );
}

function front_ocdi_plugin_intro_text( $default_text ) {
    ob_start();
    front_tgmpa_demo_selector_notice();
    $notice_info = ob_get_clean();

    return $default_text . $notice_info;
}

if( ! function_exists( 'front_tgmpa_demo_selector_update' ) ) {
    function front_tgmpa_demo_selector_update() {

        if( isset( $_GET[ 'front_tgmpa_selected_demo' ] ) && in_array( $_GET[ 'front_tgmpa_selected_demo' ], array( 'simple', 'main', 'jobs', 'crypto', 'help-desk', 'app-marketplace' ) ) ) {
            update_option( 'front_tgmpa_selected_demo', strtolower( $_GET[ 'front_tgmpa_selected_demo' ] ) );
            if( $_GET[ 'front_tgmpa_selected_demo' ] == 'main' ) {
                $sidebars_json = '{"0":{"id":"cs-1","name":"Footer Default v1 Column 1 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"1":{"id":"cs-2","name":"Footer Default v1 Column 2 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"2":{"id":"cs-3","name":"Footer Default v1 Column 3 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"3":{"id":"cs-4","name":"Footer Default v1 Column 4 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"4":{"id":"cs-5","name":"Footer Default v3 Column 1 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"5":{"id":"cs-6","name":"Footer Default v3 Column 2 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"6":{"id":"cs-7","name":"Footer Default v3 Column 3 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"7":{"id":"cs-8","name":"Footer Default v3 Column 4 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"8":{"name":"Footer Dark v1 Column 2 Widget","id":"cs-9","description":"","class":"","before_widget":"<div id=\"%1$s\" class=\"widget %2$s mb-4\">","after_widget":"</div>","before_title":"<h3 class=\"h6 widget__title\">","after_title":"</h3>","cs-key":"cs-9"},"9":{"id":"cs-10","name":"Footer Dark v1 Column 3 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"10":{"id":"cs-11","name":"Footer Default v13 Column 1 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"11":{"id":"cs-12","name":"Footer Primary Column 2 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"12":{"id":"cs-13","name":"Footer Dark v2 Column 4 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"13":{"name":"Footer Dark v4 Column 1 Widget","id":"cs-14","description":"","class":"","before_widget":"<div id=\"%1$s\" class=\"widget %2$s mb-4\">","after_widget":"</div>","before_title":"<h3 class=\"h6 widget__title\">","after_title":"</h3>","cs-key":"cs-14"},"14":{"id":"cs-15","name":"Footer Dark v4 Column v2 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"15":{"name":"Footer Dark v4 Column 3 Widget","id":"cs-16","description":"","class":"","before_widget":"<div id=\"%1$s\" class=\"widget %2$s mb-4\">","after_widget":"</div>","before_title":"<h3 class=\"h6 widget__title\">","after_title":"</h3>","cs-key":"cs-16"},"16":{"id":"cs-17","name":"Footer Default v9 Column 2 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"17":{"id":"cs-18","name":"Footer Default v9 Column 3 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"18":{"id":"cs-19","name":"Footer Default v9 Column 1 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"19":{"id":"cs-20","name":"Footer Default v9 Column 4 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"20":{"id":"cs-21","name":"Footer Default v8 Column 3 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"21":{"name":"Footer Default v8 Column 2 Widget","id":"cs-22","description":"","class":"","before_widget":"<div id=\"%1$s\" class=\"widget %2$s mb-4\">","after_widget":"</div>","before_title":"<h3 class=\"h6 widget__title\">","after_title":"</h3>","cs-key":"cs-22"},"22":{"id":"cs-23","name":"Footer Default v10 Column 3 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"23":{"name":"Footer Default v11 Column 1 Widget","id":"cs-24","description":"","class":"","before_widget":"<div id=\"%1$s\" class=\"widget %2$s mb-4\">","after_widget":"</div>","before_title":"<h3 class=\"h6 widget__title\">","after_title":"</h3>","cs-key":"cs-24"},"24":{"id":"cs-25","name":"Footer Default v11 Column 2 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"25":{"id":"cs-26","name":"Footer Default v15 Column 1 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"26":{"id":"cs-27","name":"Footer Default v15 Column 2 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""},"27":{"id":"cs-28","name":"Footer Default v15 Column 3 Widget","description":"","before_widget":"","before_title":"","after_widget":"","after_title":""}}';
                $sidebars = json_decode( $sidebars_json, true );
                update_option( 'cs_sidebars', $sidebars );
            }

            // Redirect and strip query string.
            wp_redirect( esc_url_raw( admin_url( 'themes.php?page=pt-one-click-demo-import' ) ) );
        }
    }
}

if( ! function_exists( 'front_tgmpa_demo_selector_notice' ) ) {
    function front_tgmpa_demo_selector_notice() {
        $selected_demo = get_option( 'front_tgmpa_selected_demo', 'simple' );
        $demos = array(
            'simple' => esc_html__( 'Simple', 'front' ),
            'main' => FRONT_MAIN_DEMO_IMPORT_FILE_NAME,
            'jobs' => esc_html__( 'Jobs', 'front' ),
            'crypto' => esc_html__( 'Crypto', 'front' ),
            'help-desk' => esc_html__( 'Help Desk', 'front' ),
            'app-marketplace' => esc_html__( 'App Marketplace', 'front' ),
        );
        ?>
        <div id="front-tgmpa-demo-selector-notice" class="notice notice-info">
            <p><strong><?php esc_html_e( 'Front Select Demo', 'front' ); ?></strong> &#8211; <?php esc_html_e( 'We should select any one demo here to install recommended plugins.', 'front' ); ?></p>
            <p>
                <?php foreach ( $demos as $key => $value ) { ?>
                    <a href="<?php echo esc_url( add_query_arg( 'front_tgmpa_selected_demo', $key, admin_url( 'admin.php' ) ) ); ?>" class="button<?php echo esc_attr( $selected_demo == $key ? '-primary' : '' ); ?>"><?php echo esc_html( $value ); ?></a>
                <?php } ?>
            </p>
        </div>
        <?php
    }
}

function front_ocdi_admin_styles() {
    $selected_demo = get_option( 'front_tgmpa_selected_demo', 'simple' );
    $selected_demo_alt = '';
    if( $selected_demo == 'main' ) {
        $selected_demo_alt = 'main - premium ( includes preview images )';
    } elseif( $selected_demo == 'help-desk' ) {
        $selected_demo = 'help desk';
    } elseif( $selected_demo == 'app-marketplace' ) {
        $selected_demo = 'app marketplace';
    }
    $style = "
    .js-ocdi-gl-item-container .js-ocdi-gl-item:not([data-name='" . $selected_demo . "']):not([data-name='" . $selected_demo_alt . "']) .button-primary,
    .wp-dialog:not(.disable-import-btn) .front-ocdi-install-plugin-instructions,
    .wp-dialog.disable-import-btn .front-ocdi-import-instructions,
    .wp-dialog.disable-import-btn .ui-dialog-buttonpane button.button-primary {
        display: none;
    }
    ";
    wp_add_inline_style( 'ocdi-main-css', $style );
}

function front_wp_import_post_data_processed( $postdata, $data ) {
    $site_upload_dir_find_urls = array(
        'https://demo.madrasthemes.com/front-demo-simple/wp-content/uploads/sites/69',
        'https://demo.madrasthemes.com/front/wp-content/uploads/sites/54',
        'https://demo.madrasthemes.com/front-demo/wp-content/uploads/sites/61',
        'https://demo.madrasthemes.com/front-jobs/wp-content/uploads/sites/55',
        'https://demo.madrasthemes.com/front-jobs-without-core-addon-bundle/wp-content/uploads/sites/59',
        'https://demo.madrasthemes.com/front-crypto/wp-content/uploads/sites/57',
        'https://demo.madrasthemes.com/front-help-desk/wp-content/uploads/sites/58',
        'https://demo.madrasthemes.com/front-app-marketplace/wp-content/uploads/sites/89'
    );
    $site_upload_dir_url = $upload_dir = wp_get_upload_dir();
    $postdata = str_replace( $site_upload_dir_find_urls, $site_upload_dir_url['baseurl'], $postdata );

    $site_content_find_urls = array(
        'https://demo.madrasthemes.com/front-demo-simple/wp-content/',
        'https://demo.madrasthemes.com/front/wp-content/',
        'https://demo.madrasthemes.com/front-demo/wp-content/',
        'https://demo.madrasthemes.com/front-jobs/wp-content/',
        'https://demo.madrasthemes.com/front-jobs-without-core-addon-bundle/wp-content/',
        'https://demo.madrasthemes.com/front-crypto/wp-content/',
        'https://demo.madrasthemes.com/front-help-desk/wp-content/',
        'https://demo.madrasthemes.com/front-app-marketplace/wp-content/'
    );
    $site_content_url = content_url( '/' );
    $postdata = str_replace( $site_content_find_urls, $site_content_url, $postdata );

    $site_home_find_urls = array(
        'https://demo.madrasthemes.com/front-demo-simple/',
        'https://demo.madrasthemes.com/front/',
        'https://demo.madrasthemes.com/front-demo/',
        'https://demo.madrasthemes.com/front-jobs/',
        'https://demo.madrasthemes.com/front-jobs-without-core-addon-bundle/',
        'https://demo.madrasthemes.com/front-crypto/',
        'https://demo.madrasthemes.com/front-help-desk/',
        'https://demo.madrasthemes.com/front-app-marketplace/'
    );
    $site_home_url = home_url( '/' );
    $postdata = str_replace( $site_home_find_urls, $site_home_url, $postdata );

    if( defined( 'PT_OCDI_VERSION' ) && version_compare( PT_OCDI_VERSION, '2.6.0' , '<' ) ) {
        return wp_slash( $postdata );
    }

    return $postdata;
}

function front_wp_import_post_meta_data_processed( $meta_item, $post_id ) {
    if( isset( $meta_item['value'] ) ) {
        $site_home_find_urls = array(
            'https://demo.madrasthemes.com/front-demo-simple/',
            'https://demo.madrasthemes.com/front/',
            'https://demo.madrasthemes.com/front-demo/',
            'https://demo.madrasthemes.com/front-jobs/',
            'https://demo.madrasthemes.com/front-jobs-without-core-addon-bundle/',
            'https://demo.madrasthemes.com/front-crypto/',
            'https://demo.madrasthemes.com/front-help-desk/',
            'https://demo.madrasthemes.com/front-app-marketplace/'
        );
        $site_home_url = home_url( '/' );
        $meta_item['value'] = str_replace( $site_home_find_urls, $site_home_url, $meta_item['value'] );
    }

    return $meta_item;
}

function front_ocdi_import_wpforms( $demo_path = 'main' ) {
    if ( ! function_exists( 'wpforms' ) ) {
        return;
    }

    $forms = [
        [
            'file' => 'wpforms-subscribe-form-1.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-2.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-3.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-4.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-4-color-success.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-5.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-6.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-7.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-8.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-8-primary-color.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-9.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-10.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-11.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-12.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-13.json'
        ],
        [
            'file' => 'wpforms-contact-form-1.json'
        ],
        [
            'file' => 'wpforms-contact-form-1-title-center.json'
        ],
        [
            'file' => 'wpforms-contact-form-2.json'
        ],
        [
            'file' => 'wpforms-contact-form-3.json'
        ],
        [
            'file' => 'wpforms-contact-form-4.json'
        ],
        [
            'file' => 'wpforms-footer-subscribe-form-1.json'
        ],
        [
            'file' => 'wpforms-footer-subscribe-form-2.json'
        ],
    ];

    foreach ( $forms as $form ) {
        ob_start();
        front_get_template( $form['file'], array(), 'assets/dummy-data/' . $demo_path . '/wpforms/' );
        $form_json = ob_get_clean();
        $form_data = json_decode( $form_json, true );

        if ( empty( $form_data[0] ) ) {
            continue;
        }
        $form_data = $form_data[0];
        $form_title = $form_data['settings']['form_title'];

        if( !empty( $form_data['id'] ) ) {
            $form_content = array(
                'field_id' => '0',
                'settings' => array(
                    'form_title' => sanitize_text_field( $form_title ),
                    'form_desc'  => '',
                ),
            );

            // Merge args and create the form.
            $form = array(
                'import_id'     => (int) $form_data['id'],
                'post_title'    => esc_html( $form_title ),
                'post_status'   => 'publish',
                'post_type'     => 'wpforms',
                'post_content'  => wpforms_encode( $form_content ),
            );

            $form_id = wp_insert_post( $form );
        } else {
            // Create initial form to get the form ID.
            $form_id   = wpforms()->form->add( $form_title );
        }

        if ( empty( $form_id ) ) {
            continue;
        }

        $form_data['id'] = $form_id;
        // Save the form data to the new form.
        wpforms()->form->update( $form_id, $form_data );
    }
}
