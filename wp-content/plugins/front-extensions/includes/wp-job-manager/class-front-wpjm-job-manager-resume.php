<?php

class Front_WPJM_Job_Manager_Resume {

    public function __construct() {

        if ( $this->is_wpjmr_activated() ) {
            add_action( 'wp_enqueue_scripts', array( $this, 'remove_frontend_scripts' ) );
            add_action( 'init', array( $this, 'register_taxonomies' ) );
            add_action( 'init', array( $this, 'modify_taxonomy' ), 10 );
            add_filter( 'resume_manager_settings', array( $this, 'resume_manager_modified_settings' ) );

            if( is_admin() ) {
                include_once( dirname( __FILE__ ) . '/class-wp-job-manager-resume-writepanels.php' );
            }
        }
    }

    public function is_wpjmr_activated() {
        return class_exists( 'WP_Resume_Manager' ) ? true : false;
    }

    public function remove_frontend_scripts() {
        if( apply_filters( 'front_remove_resume_manger_frontend_style', true ) )
            wp_dequeue_style( 'wp-job-manager-resume-frontend' );
    }

    public function register_taxonomies() {
        if ( ! post_type_exists( 'resume' ) ) {
            return;
        }

        $admin_capability = 'manage_resumes';

        /**
         * Taxonomies
         */
        $taxonomies_args = apply_filters( 'front_resume_taxonomies_list', array() );

        if( empty( $taxonomies_args ) ) {
            return;
        }

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

                register_taxonomy( $taxonomy_name, 'resume', $args );
            }
        }
    }

    function modify_taxonomy() {
        if ( get_option('resume_manager_enable_categories') ) {
            // get the arguments of the already-registered taxonomy
            $resume_category_args = get_taxonomy( 'resume_category' ); // returns an object
            // make changes to the args
            $resume_category_args->show_in_rest = true;
            // re-register the taxonomy
            register_taxonomy( 'resume_category', 'resume', $resume_category_args );
        }

        if ( get_option('resume_manager_enable_skills') ) {
            // get the arguments of the already-registered taxonomy
            $resume_skill_args = get_taxonomy( 'resume_skill' ); // returns an object
            // make changes to the args
            $resume_skill_args->show_in_rest = true;
            // re-register the taxonomy
            register_taxonomy( 'resume_skill', 'resume', $resume_skill_args );
        }
    }

    public function resume_manager_modified_settings( $settings ) {
        $settings['resume_listings'][1][] = array(
            'name'      => 'resume_manager_resumes_listing_style',
            'std'       => 'grid',
            'label'     => esc_html__( 'Resumes Listings Style', 'front-extensions' ),
            'desc'      => esc_html__( 'Select the style for resumes listing style. This lets the plugin know the style of resumes listings.', 'front-extensions' ),
            'type'      => 'select',
            'options'   => array(
                'grid'              => esc_html__( 'Grid', 'front-extensions' ),
                'list'              => esc_html__( 'List', 'front-extensions' ),
            )
        );

        $settings['resume_listings'][1][] = array(
            'name'      => 'resume_manager_resumes_listing_sidebar',
            'std'       => 'fullwidth',
            'label'     => esc_html__( 'Resumes Listings Sidebar', 'front-extensions' ),
            'desc'      => esc_html__( 'Select the position for resumes listing sidebar. This lets the plugin know the position of resumes listings sidebar.', 'front-extensions' ),
            'type'      => 'select',
            'options'   => array(
                'fullwidth'     => esc_html__( 'Full Width', 'front-extensions' ),
                'right-sidebar' => esc_html__( 'Right Sidebar', 'front-extensions' ),
            )
        );

        return $settings;
    }
}

global $front_wpjm_job_manager_resume;
$front_wpjm_job_manager_resume = new Front_WPJM_Job_Manager_Resume();