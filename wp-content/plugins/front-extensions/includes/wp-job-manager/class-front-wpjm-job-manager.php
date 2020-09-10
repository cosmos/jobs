<?php

class Front_WPJM_Job_Manager {

    public function __construct() {

        if ( $this->is_wpjm_activated() ) {
            $wpjm_shortcodes = WP_Job_Manager_Shortcodes::instance();
            add_action( 'init', array( $this, 'register_taxonomies' ) );
            add_filter( 'job_manager_settings', array( $this, 'job_manager_modified_settings' ) );
            remove_shortcode( 'jobs' );
            add_shortcode( 'jobs', array( $this, 'output_jobs' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
            remove_action( 'job_manager_job_filters_end', array( $wpjm_shortcodes, 'job_filter_job_types' ), 20 );
            remove_action( 'job_manager_job_filters_end', array( $wpjm_shortcodes, 'job_filter_results' ), 30 );
            add_action( 'job_manager_job_filters_search_jobs_end', array( $wpjm_shortcodes, 'job_filter_job_types' ), 20 );
            add_filter( 'job_manager_get_listings_result', array( $this, 'job_get_listings_result' ), 10, 2 );

            if( function_exists( 'front_custom_job_form' ) ) {
                add_shortcode( 'front_job_form', 'front_custom_job_form' );
            }

            if( is_admin() ) {
                include_once( dirname( __FILE__ ) . '/class-wp-job-manager-writepanels.php' );
            }

            include_once( dirname( __FILE__ ) . '/class-front-wpjm-form.php' );
            include_once( dirname( __FILE__ ) . '/class-front-wpjm-job-manager-resume.php' );
        }
    }

    public function is_wpjm_activated() {
        return class_exists( 'WP_Job_Manager' ) ? true : false;
    }

    public function job_get_listings_result( $result, $jobs ) {
        $result['showing'] = sprintf( _n( '%d Open Position', '%d Open Positions', $jobs->found_posts, 'front-extensions' ), $jobs->found_posts );
        return $result;
    }

    /**
     * Enqueue style.
     */
    public function admin_styles() {

        $screen    = get_current_screen();
        $screen_id = $screen ? $screen->id : '';

        if ( in_array( $screen_id, array( 'job_listing' ) ) ) {

            wp_register_style( 'front_wp_job_manager_admin_styles', Front_Extensions()->plugin_url() . '/assets/css/admin/admin.css', array(), FRONT_VERSION );
            wp_enqueue_style( 'front_wp_job_manager_admin_styles' );
        }
    }

    /**
     * Enqueue scripts.
     */
    public function admin_scripts() {
        global $wp_query, $post;

        $screen          = get_current_screen();
        $screen_id       = $screen ? $screen->id : '';
        $front_screen_id = sanitize_title( __( 'Front', 'front-extensions' ) );
        $suffix          = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        if ( in_array( $screen_id, array( 'job_listing' ) ) ) {
            wp_enqueue_media();
            wp_register_script( 'front-admin-wp-job-managero-meta-boxes', Front_Extensions()->plugin_url() . '/assets/js/admin/wp-job-manager-admin' . $suffix . '.js', array( 'jquery' ), FRONT_VERSION );
            wp_enqueue_script( 'front-admin-wp-job-managero-meta-boxes' );
        }
    }

    public function register_taxonomies() {
        if ( ! post_type_exists( 'job_listing' ) ) {
            return;
        }

        $admin_capability = 'manage_job_listings';

        /**
         * Taxonomies
         */
        $taxonomies_args = apply_filters( 'front_job_listing_taxonomies_list', array(
            'job_listing_salary'        => array(
                'singular'                  => esc_html__( 'Job Salary', 'front-extensions' ),
                'plural'                    => esc_html__( 'Job Salaries', 'front-extensions' ),
                'slug'                      => esc_html_x( 'job-salary', 'Job salary permalink - resave permalinks after changing this', 'front-extensions' ),
                'enable'                    => get_option('job_manager_enable_salary', true)
            ),
            'job_listing_project_length' => array(
                'singular'                  => esc_html__( 'Project Length', 'front-extensions' ),
                'plural'                    => esc_html__( 'Project Length', 'front-extensions' ),
                'slug'                      => esc_html_x( 'job-project-length', 'job project length permalink - resave permalinks after changing this', 'front-extensions' ),
                'enable'                    => get_option('job_manager_enable_project_length', true)
            ),
            'job_listing_working_environment' => array(
                'singular'                  => esc_html__( 'Working Environment', 'front-extensions' ),
                'plural'                    => esc_html__( 'Working Environment', 'front-extensions' ),
                'slug'                      => esc_html_x( 'job-working-environment', 'job working environment permalink - resave permalinks after changing this', 'front-extensions' ),
                'enable'                    => get_option('job_manager_enable_working_environment', true)
            ),
        ) );

        foreach ( $taxonomies_args as $taxonomy_name => $taxonomy_args ) {
            if( $taxonomy_args['enable'] ) {
                $singular  = $taxonomy_args['singular'];
                $plural    = $taxonomy_args['plural'];
                $slug      = $taxonomy_args['slug'];

                $args = apply_filters( 'register_taxonomy_{$taxonomy_name}_args', array(
                        'hierarchical'      => true,
                        'update_count_callback' => '_update_post_term_count',
                        'label'             => $plural,
                        'labels'            => array(
                            'name'              => $plural,
                            'singular_name'     => $singular,
                            'menu_name'         => ucwords( $plural ),
                            'search_items'      => sprintf( esc_html__( 'Search %s', 'front-extensions' ), $plural ),
                            'all_items'         => sprintf( esc_html__( 'All %s', 'front-extensions' ), $plural ),
                            'parent_item'       => sprintf( esc_html__( 'Parent %s', 'front-extensions' ), $singular ),
                            'parent_item_colon' => sprintf( esc_html__( 'Parent %s:', 'front-extensions' ), $singular ),
                            'edit_item'         => sprintf( esc_html__( 'Edit %s', 'front-extensions' ), $singular ),
                            'update_item'       => sprintf( esc_html__( 'Update %s', 'front-extensions' ), $singular ),
                            'add_new_item'      => sprintf( esc_html__( 'Add New %s', 'front-extensions' ), $singular ),
                            'new_item_name'     => sprintf( esc_html__( 'New %s Name', 'front-extensions' ),  $singular )
                        ),
                        'show_ui'               => true,
                        'show_in_rest'          => true,
                        'show_tagcloud'         => false,
                        'public'                => true,
                        'capabilities'          => array(
                            'manage_terms'      => $admin_capability,
                            'edit_terms'        => $admin_capability,
                            'delete_terms'      => $admin_capability,
                            'assign_terms'      => $admin_capability,
                        ),
                        'rewrite'           => array(
                            'slug'          => $slug,
                            'with_front'    => false,
                            'hierarchical'  => true
                        )
                    )
                );

                register_taxonomy( $taxonomy_name, 'job_listing', $args );
            }
        }

        if ( get_option( 'job_manager_enable_skills' ) ) {
            $singular  = __( 'Job Skill', 'front-extensions' );
            $plural    = __( 'Job Skills', 'front-extensions' );

            if ( current_theme_supports( 'job-manager-templates' ) ) {
                $rewrite     = array(
                    'slug'         => _x( 'job-skill', 'Resume skill slug - resave permalinks after changing this', 'front-extensions' ),
                    'with_front'   => false,
                    'hierarchical' => false
                );
            } else {
                $rewrite = false;
            }

            register_taxonomy( "job_listing_skill",
                array( "job_listing" ),
                array(
                    'hierarchical'          => false,
                    'update_count_callback' => '_update_post_term_count',
                    'label'                 => $plural,
                    'labels' => array(
                        'name'              => $plural,
                        'singular_name'     => $singular,
                        'search_items'      => sprintf( __( 'Search %s', 'front-extensions' ), $plural ),
                        'all_items'         => sprintf( __( 'All %s', 'front-extensions' ), $plural ),
                        'parent_item'       => sprintf( __( 'Parent %s', 'front-extensions' ), $singular ),
                        'parent_item_colon' => sprintf( __( 'Parent %s:', 'front-extensions' ), $singular ),
                        'edit_item'         => sprintf( __( 'Edit %s', 'front-extensions' ), $singular ),
                        'update_item'       => sprintf( __( 'Update %s', 'front-extensions' ), $singular ),
                        'add_new_item'      => sprintf( __( 'Add New %s', 'front-extensions' ), $singular ),
                        'new_item_name'     => sprintf( __( 'New %s Name', 'front-extensions' ),  $singular )
                    ),
                    'show_ui'               => true,
                    'show_in_rest'          => true,
                    'query_var'             => true,
                    'capabilities'          => array(
                        'manage_terms'      => $admin_capability,
                        'edit_terms'        => $admin_capability,
                        'delete_terms'      => $admin_capability,
                        'assign_terms'      => $admin_capability,
                    ),
                    'rewrite'               => $rewrite,
                )
            );
        }
    }

    public function output_jobs( $atts ) {
        global $wpjm_jobs_query;
        global $front_wpjm_job_view;
        
        ob_start();

        extract( $atts = shortcode_atts( apply_filters( 'job_manager_output_jobs_defaults', array(
            'per_page'                  => get_option( 'job_manager_per_page' ),
            'orderby'                   => 'featured',
            'order'                     => 'DESC',
            'view'                      => 'list',
            'columns'                   => 1,

            // Filters + cats
            'show_filters'              => true,
            'show_categories'           => true,
            'show_category_multiselect' => get_option( 'job_manager_enable_default_category_multiselect', false ),
            'show_pagination'           => false,
            'show_more'                 => true,

            // Limit what jobs are shown based on category, post status, and type
            'categories'                => '',
            'job_types'                 => '',
            'post_status'               => '',
            'featured'                  => null, // True to show only featured, false to hide featured, leave null to show both.
            'filled'                    => null, // True to show only filled, false to hide filled, leave null to show both/use the settings.

            // Default values for filters
            'location'                  => '',
            'keywords'                  => '',
            'selected_category'         => '',
            'selected_job_types'        => implode( ',', array_values( get_job_listing_types( 'id=>slug' ) ) ),

        ) ), $atts ) );

        if ( ! get_option( 'job_manager_enable_categories' ) ) {
            $show_categories = false;
        }

        // String and bool handling
        $show_filters              = $this->string_to_bool( $show_filters );
        $show_categories           = $this->string_to_bool( $show_categories );
        $show_category_multiselect = $this->string_to_bool( $show_category_multiselect );
        $show_more                 = $this->string_to_bool( $show_more );
        $show_pagination           = $this->string_to_bool( $show_pagination );

        if ( ! is_null( $featured ) ) {
            $featured = ( is_bool( $featured ) && $featured ) || in_array( $featured, array( '1', 'true', 'yes' ) ) ? true : false;
        }

        if ( ! is_null( $filled ) ) {
            $filled = ( is_bool( $filled ) && $filled ) || in_array( $filled, array( '1', 'true', 'yes' ) ) ? true : false;
        }

        // Array handling
        $categories         = is_array( $categories ) ? $categories : array_filter( array_map( 'trim', explode( ',', $categories ) ) );
        $job_types          = is_array( $job_types ) ? $job_types : array_filter( array_map( 'trim', explode( ',', $job_types ) ) );
        $post_status        = is_array( $post_status ) ? $post_status : array_filter( array_map( 'trim', explode( ',', $post_status ) ) );
        $selected_job_types = is_array( $selected_job_types ) ? $selected_job_types : array_filter( array_map( 'trim', explode( ',', $selected_job_types ) ) );

        // Get keywords and location from querystring if set
        if ( ! empty( $_GET['search_keywords'] ) ) {
            $keywords = sanitize_text_field( $_GET['search_keywords'] );
        }
        if ( ! empty( $_GET['search_location'] ) ) {
            $location = sanitize_text_field( $_GET['search_location'] );
        }
        if ( ! empty( $_GET['search_category'] ) ) {
            $selected_category = sanitize_text_field( $_GET['search_category'] );
        }

        $front_wpjm_job_view = $view;

        $data_attributes        = array(
            'location'        => $location,
            'keywords'        => $keywords,
            'show_filters'    => $show_filters ? 'true' : 'false',
            'show_pagination' => $show_pagination ? 'true' : 'false',
            'per_page'        => $per_page,
            'orderby'         => $orderby,
            'order'           => $order,
            'categories'      => implode( ',', $categories ),
            'categories'      => implode( ',', $categories ),
            'view'            => $front_wpjm_job_view,
            'columns'         => $columns,
        );

        if ( $show_filters ) {

            get_job_manager_template( 'job-filters.php', array( 'per_page' => $per_page, 'orderby' => $orderby, 'order' => $order, 'show_categories' => $show_categories, 'categories' => $categories, 'selected_category' => $selected_category, 'job_types' => $job_types, 'atts' => $atts, 'location' => $location, 'keywords' => $keywords, 'selected_job_types' => $selected_job_types, 'show_category_multiselect' => $show_category_multiselect ) );

            get_job_manager_template( 'job-listings-start.php', array( 'atts' => $atts ) );
            get_job_manager_template( 'job-listings-end.php', array( 'atts' => $atts ) );

            if ( ! $show_pagination && $show_more ) {
                echo '<a class="load_more_jobs btn btn-primary transition-3d-hover mx-auto mt-5 mt-lg-7" href="#" style="display:none;"><strong>' . esc_html__( 'Load more listings', 'front-extensions' ) . '</strong></a>';
            }

        } else {
            $jobs = get_job_listings( apply_filters( 'job_manager_output_jobs_args', array(
                'search_location'   => $location,
                'search_keywords'   => $keywords,
                'post_status'       => $post_status,
                'search_categories' => $categories,
                'job_types'         => $job_types,
                'orderby'           => $orderby,
                'order'             => $order,
                'posts_per_page'    => $per_page,
                'featured'          => $featured,
                'filled'            => $filled
            ) ) );

            if ( ! empty( $job_types ) ) {
                $data_attributes[ 'job_types' ] = implode( ',', $job_types );
            }

            if ( $jobs->have_posts() ) : ?>

                <?php do_action( 'front_wpjm_before_shortcode_job_listings_start', $jobs, $atts ); ?>
                
                <?php get_job_manager_template( 'job-listings-start.php', array( 'atts' => $atts ) ); ?>

                <?php while ( $jobs->have_posts() ) : $jobs->the_post(); ?>
                    <?php get_job_manager_template_part( 'content-job_listing', $front_wpjm_job_view ); ?>
                <?php endwhile; ?>

                <?php get_job_manager_template( 'job-listings-end.php', array( 'atts' => $atts ) ); ?>

                <?php if ( $jobs->found_posts > $per_page && $show_more ) : ?>

                    <?php wp_enqueue_script( 'wp-job-manager-ajax-filters' ); ?>

                    <?php if ( $show_pagination ) : ?>
                        <?php echo get_job_listing_pagination( $jobs->max_num_pages ); ?>
                    <?php else : ?>
                        <a class="load_more_jobs btn btn-primary transition-3d-hover mx-auto mt-5 mt-lg-7" href="#"><strong><?php esc_html_e( 'Load more listings', 'front-extensions' ); ?></strong></a>
                    <?php endif; ?>

                <?php endif; ?>

            <?php else :
                do_action( 'job_manager_output_jobs_no_results' );
            endif;

            wp_reset_postdata();
        }

        $job_listings_output = apply_filters( 'job_manager_job_listings_output', ob_get_clean() );

        $front_wpjm_job_view = '';

        $data_attributes_string = '';
        if ( ! is_null( $featured ) ) {
            $data_attributes[ 'featured' ]    = $featured ? 'true' : 'false';
        }
        if ( ! is_null( $filled ) ) {
            $data_attributes[ 'filled' ]      = $filled ? 'true' : 'false';
        }
        if ( ! empty( $post_status ) ) {
            $data_attributes[ 'post_status' ] = implode( ',', $post_status );
        }
        foreach ( $data_attributes as $key => $value ) {
            $data_attributes_string .= 'data-' . esc_attr( $key ) . '="' . esc_attr( $value ) . '" ';
        }

        return '<div class="job_listings is_filtered' . esc_attr( " columns-{$columns}" ) . '" ' . $data_attributes_string . '>' . $job_listings_output . '</div>';
    }

    public function job_manager_modified_settings( $settings ) {
        if ( post_type_exists( "job_listing" ) ) {
            $settings['job_listings'][1][] = array(
                'name'       => 'job_manager_enable_salary',
                'std'        => '1',
                'label'      => esc_html__( 'Salary', 'front-extensions' ),
                'cb_label'   => esc_html__( 'Enable listing salary', 'front-extensions' ),
                'desc'       => esc_html__( 'This lets users select from a list of salary when submitting a job. Note: an admin has to create salary before site users can select them.', 'front-extensions' ),
                'type'       => 'checkbox',
                'attributes' => array(),
            );
            $settings['job_listings'][1][] = array(
                'name'       => 'job_manager_enable_project_length',
                'std'        => '1',
                'label'      => esc_html__( 'Project Length', 'front-extensions' ),
                'cb_label'   => esc_html__( 'Enable listing project length', 'front-extensions' ),
                'desc'       => esc_html__( 'This lets users select from a list of project length when submitting a job. Note: an admin has to create project length before site users can select them.', 'front-extensions' ),
                'type'       => 'checkbox',
                'attributes' => array(),
            );
            $settings['job_listings'][1][] = array(
                'name'       => 'job_manager_enable_working_environment',
                'std'        => '1',
                'label'      => esc_html__( 'Working Environment', 'front-extensions' ),
                'cb_label'   => esc_html__( 'Enable listing working environment', 'front-extensions' ),
                'desc'       => esc_html__( 'This lets users select from a list of working environment when submitting a job. Note: an admin has to create working environment before site users can select them.', 'front-extensions' ),
                'type'       => 'checkbox',
                'attributes' => array(),
            );
            $settings['job_listings'][1][] = array(
                'name'       => 'job_manager_enable_skills',
                'std'        => '1',
                'label'      => __( 'Skills', 'front-extensions' ),
                'cb_label'   => __( 'Enable Job skills', 'front-extensions' ),
                'desc'       => __( 'Choose whether to enable the job skills field. Skills can be added by users during job submission.', 'front-extensions' ),
                'type'       => 'checkbox',
                'attributes' => array(),
            );
            $settings['job_listings'][1][] = array(
                'name'        => 'job_manager_max_skills',
                'std'         => '',
                'label'       => __( 'Maximum Skills', 'front-extensions' ),
                'placeholder' => __( 'Unlimited', 'front-extensions' ),
                'desc'        => __( 'Enter the number of skills per job submission you wish to allow, or leave blank for unlimited skills.', 'front-extensions' ),
                'type'        => 'input',
            );
            $settings['job_listings'][1][] = array(
                'name'      => 'job_manager_jobs_listing_style',
                'std'       => 'grid',
                'label'     => esc_html__( 'Jobs Listing Style', 'front-extensions' ),
                'desc'      => esc_html__( 'Select the style for jobs listing page. This lets the plugin know the style of jobs listings.', 'front-extensions' ),
                'type'      => 'select',
                'options'   => array(
                    'grid'              => esc_html__( 'Grid', 'front-extensions' ),
                    'list'              => esc_html__( 'List', 'front-extensions' ),
                )
            );
            $settings['job_listings'][1][] = array(
                'name'      => 'job_manager_jobs_listing_layout',
                'std'       => 'fullwidth',
                'label'     => esc_html__( 'Jobs Listing Layout', 'front-extensions' ),
                'desc'      => esc_html__( 'Select the layout for jobs listing page', 'front-extensions' ),
                'type'      => 'select',
                'options'   => array(
                    'fullwidth'     => esc_html__( 'Full Width', 'front-extensions' ),
                    'right-sidebar' => esc_html__( 'Right Sidebar', 'front-extensions' ),
                )
            );
            $settings['job_listings'][1][] = array(
                'name'      => 'job_manager_single_job_style',
                'std'       => 'style-1',
                'label'     => esc_html__( 'Single Job Style', 'front-extensions' ),
                'desc'      => esc_html__( 'Select the style for single job page. This lets the plugin know the style of job single.', 'front-extensions' ),
                'type'      => 'select',
                'options'   => array(
                    'style-1'           => esc_html__( 'Style 1', 'front-extensions' ),
                    'style-2'           => esc_html__( 'Style 2', 'front-extensions' ),
                )
            );
        }

        return $settings;
    }

    /**
     * Gets string as a bool.
     *
     * @param  string $value
     * @return bool
     */
    public function string_to_bool( $value ) {
        return ( is_bool( $value ) && $value ) || in_array( $value, array( '1', 'true', 'yes' ) ) ? true : false;
    }
}

global $front_wpjm_job_manager;
$front_wpjm_job_manager = new Front_WPJM_Job_Manager();