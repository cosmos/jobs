<?php
/**
 * Front WP Job Manager Class
 *
 * @package  front
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Front_WPJM' ) ) :

    /**
     * The Front WP Job Manager Integration class
     */
    class Front_WPJM {

        public function __construct() {
            $this->includes();
            add_action( 'init', array( $this, 'prepare_gutenberg_editor' ), 10 );
            add_filter( 'register_post_type_job_listing', array( $this, 'modify_register_post_type_job_listing' ) );
            add_filter( 'body_class', array( $this, 'wpjm_body_class' ) );
            add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
            add_action( 'front_before_header', array( $this, 'remove_header_topbar_icons' ) );
            // add_filter( 'front_display_header_args', array( $this, 'header_args' ) );
            add_filter( 'job_manager_enqueue_frontend_style', '__return_false', 30 );
            add_filter( 'front_sidebar_args', array( $this, 'sidebar_register' ) );
        }

        public function includes() {
            include_once get_template_directory() . '/inc/wp-job-manager/class-front-wpjm-template-loader.php';
        }

        public function modify_register_post_type_job_listing( $args ) {
            $args['show_in_rest'] = true;
            $args['template'] = array();
            $args['template_lock'] = false;
            $jobs_page_id = front_wpjm_get_page_id( 'jobs' );
            if( current_theme_supports( 'job-manager-archive' ) && $jobs_page_id && get_post( $jobs_page_id ) ) {
                $permalinks = WP_Job_Manager_Post_Types::get_permalink_structure();
                $args['has_archive'] = urldecode( get_page_uri( $jobs_page_id ) );
                $args['rewrite'] = $permalinks['job_rewrite_slug'] ? array(
                    'slug'       => $permalinks['job_rewrite_slug'],
                    'with_front' => false,
                    'feeds'      => true,
                ) : false;
            }

            return $args;
        }

        public function prepare_gutenberg_editor() {
            add_filter( 'allowed_block_types', array( $this, 'remove_force_classic_block' ), 10, 2 );
        }

        public function remove_force_classic_block( $allowed_block_types, $post ) {
            if ( 'job_listing' === $post->post_type ) {
                return true;
            }
            return $allowed_block_types;
        }

        public function wpjm_body_class( $classes ) {
            $classes[] = 'wpjm-activated';

            if( is_post_type_archive( 'job_listing' ) || is_page( front_wpjm_get_page_id( 'jobs' ) ) || is_page( front_wpjm_get_page_id( 'jobs-dashboard' ) ) || is_page( front_wpjm_get_page_id( 'post-a-job' ) ) || front_is_job_listing_taxonomy() || is_singular( 'job_listing' ) ) {
                $classes[] = 'front-wpjm-pages';
            }

            if( current_theme_supports( 'job-manager-archive' ) && ( is_post_type_archive( 'job_listing' ) || is_page( front_wpjm_get_page_id( 'jobs' ) ) || front_is_job_listing_taxonomy() ) ) {
                $classes[] = 'post-type-archive-job_listing';
            }

            if( is_singular( 'job_listing' ) ) {
                $classes[] = 'single-job_listing--' . front_get_wpjm_single_job_style();
            }

            return $classes;
        }

        public function excerpt_length( $length ) {
            global $post;
            if ( 'job_listing' === $post->post_type ) {
                return 30;
            }
            return $length;
        }

        public function remove_header_topbar_icons() {
            if( apply_filters( 'front_enable_job_header_args', true ) && ( is_post_type_archive( 'job_listing' ) || is_page( front_wpjm_get_page_id( 'jobs' ) ) || is_page( front_wpjm_get_page_id( 'jobs-dashboard' ) ) || is_page( front_wpjm_get_page_id( 'post-a-job' ) ) || front_is_job_listing_taxonomy() || is_singular( 'job_listing' ) ) ) {
                add_filter( 'front_header_topbar_cart_enable', '__return_false', 9 );
                add_filter( 'front_header_topbar_search_enable', '__return_false', 9 );
            }
        }

        public function header_args( $args ) {
            if( apply_filters( 'front_enable_job_header_args', true ) && ( is_post_type_archive( 'job_listing' ) || is_page( front_wpjm_get_page_id( 'jobs' ) ) || is_page( front_wpjm_get_page_id( 'jobs-dashboard' ) ) || is_page( front_wpjm_get_page_id( 'post-a-job' ) ) || front_is_job_listing_taxonomy() || is_singular( 'job_listing' ) ) ) {
                if( is_singular( 'job_listing' ) && ( front_get_wpjm_single_job_style() === 'style-2' ) ) {
                    $args = wp_parse_args( array(), $args );
                } else {
                    $args = wp_parse_args( array(
                        'enablePostion' => false,
                        'enableTransparent' => false,
                    ), $args );
                }
            }

            return $args;
        }

        public function sidebar_register( $sidebar_args ) {

            $sidebar_args['sidebar_job'] = array(
                'name'        => esc_html__( 'Jobs Sidebar', 'front' ),
                'id'          => 'sidebar-job',
                'description' => esc_html__( 'Widgets added to this region will appear in the jobs page.', 'front' ),
            );

            return $sidebar_args;
        }

        public static function get_current_page_url() {
            if ( ! ( is_post_type_archive( 'job_listing' ) || is_page( front_wpjm_get_page_id( 'jobs' ) ) ) && ! front_is_job_listing_taxonomy() ) {
                return;
            }

            if ( defined( 'JOBS_IS_ON_FRONT' ) ) {
                $link = home_url( '/' );
            } elseif ( is_post_type_archive( 'job_listing' ) || is_page( front_wpjm_get_page_id( 'jobs' ) ) ) {
                $link = get_permalink( front_wpjm_get_page_id( 'jobs' ) );
            } else {
                $queried_object = get_queried_object();
                $link = get_term_link( $queried_object->slug, $queried_object->taxonomy );
            }

            // Order by.
            if ( isset( $_GET['orderby'] ) ) {
                $link = add_query_arg( 'orderby', front_clean( wp_unslash( $_GET['orderby'] ) ), $link );
            }

            // Company Name.
            if ( isset( $_GET['company_name'] ) ) {
                $link = add_query_arg( 'company_name', front_clean( wp_unslash( $_GET['company_name'] ) ), $link );
            }

            // Company Id.
            if ( isset( $_GET['company_id'] ) ) {
                $link = add_query_arg( 'company_id', front_clean( wp_unslash( $_GET['company_id'] ) ), $link );
            }

            /**
             * Search Arg.
             * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
             */
            if ( get_search_query() ) {
                $link = add_query_arg( 'search_keywords', rawurlencode( wp_specialchars_decode( get_search_query() ) ), $link );
            }

            // Post Type Arg.
            if ( isset( $_GET['post_type'] ) ) {
                $link = add_query_arg( 'post_type', front_clean( wp_unslash( $_GET['post_type'] ) ), $link );
            }

            // Location Arg.
            if ( isset( $_GET['search_location'] ) ) {
                $link = add_query_arg( 'search_location', front_clean( wp_unslash( $_GET['search_location'] ) ), $link );
            }

            // Date Filter Arg.
            if ( isset( $_GET['posted_before'] ) ) {
                $link = add_query_arg( 'posted_before', front_clean( wp_unslash( $_GET['posted_before'] ) ), $link );
            }

            // All current filters.
            if ( $_chosen_taxonomies = Front_WPJM_Query::get_layered_nav_chosen_taxonomies() ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found, WordPress.CodeAnalysis.AssignmentInCondition.Found
                foreach ( $_chosen_taxonomies as $name => $data ) {
                    $filter_name = sanitize_title( $name );
                    if ( ! empty( $data['terms'] ) ) {
                        $link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
                    }
                    if ( 'or' === $data['query_type'] ) {
                        $link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
                    }
                }
            }

            return $link;
        }

        public static function get_current_page_query_args() {
            $args = array();

            // Order by.
            if ( isset( $_GET['orderby'] ) ) {
                $args['orderby'] = front_clean( wp_unslash( $_GET['orderby'] ) );
            }

            // Company Name.
            if ( isset( $_GET['company_name'] ) ) {
                $args['company_name'] = front_clean( wp_unslash( $_GET['company_name'] ) );
            }

            // Company ID.
            if ( isset( $_GET['company_id'] ) ) {
                $args['company_id'] = front_clean( wp_unslash( $_GET['company_id'] ) );
            }

            /**
             * Search Arg.
             * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
             */
            if ( get_search_query() ) {
                $args['search_keywords'] = rawurlencode( wp_specialchars_decode( get_search_query() ) );
            }

            // Post Type Arg.
            if ( isset( $_GET['post_type'] ) ) {
                $args['post_type'] = front_clean( wp_unslash( $_GET['post_type'] ) );
            }

            // Location Arg.
            if ( isset( $_GET['search_location'] ) ) {
                $args['search_location'] = front_clean( wp_unslash( $_GET['search_location'] ) );
            }

            // Date Filter Arg.
            if ( isset( $_GET['posted_before'] ) ) {
                $args['posted_before'] = front_clean( wp_unslash( $_GET['posted_before'] ) );
            }

            // All current filters.
            if ( $_chosen_taxonomies = Front_WPJM_Query::get_layered_nav_chosen_taxonomies() ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found, WordPress.CodeAnalysis.AssignmentInCondition.Found
                foreach ( $_chosen_taxonomies as $name => $data ) {
                    $filter_name = sanitize_title( $name );
                    if ( ! empty( $data['terms'] ) ) {
                        $args['filter_' . $filter_name] = implode( ',', $data['terms'] );
                    }
                    if ( 'or' === $data['query_type'] ) {
                        $args['query_type_' . $filter_name] = 'or';
                    }
                }
            }

            return $args;
        }
    }

endif;

return new Front_WPJM();