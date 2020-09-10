<?php
/**
 * Front WP Job Manager Resume Class
 *
 * @package  front
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Front_WPJMR' ) ) :

    class Front_WPJMR {

        public function __construct() {
            $this->includes();
            add_filter( 'register_post_type_resume',  array( $this, 'modify_register_post_type_resumes' ) );
            add_filter( 'body_class', array( $this, 'resume_body_classes' ) );
            add_action( 'front_before_header', array( $this, 'remove_header_topbar_icons' ) );
            // add_filter( 'front_display_header_args', array( $this, 'header_args' ) );
            add_action( 'front_sidebar_args', array( $this, 'sidebar_register' ) );
            add_action( 'wp_ajax_front_live_search_resumes_suggest', array( __CLASS__, 'live_search_resumes_suggest' ) );
            add_action( 'wp_ajax_nopriv_front_live_search_resumes_suggest', array( __CLASS__, 'live_search_resumes_suggest' ) );
        }

        public function includes() {
            include_once get_template_directory() . '/inc/wp-job-manager-resumes/class-front-wpjmr-template-loader.php';
        }

        public function modify_register_post_type_resumes( $args ) {
            $args['show_in_rest'] = true;
            $resumes_page_id = front_wpjmr_get_page_id( 'resume' );
            if( current_theme_supports( 'resume-manager-archive' ) && $resumes_page_id && get_post( $resumes_page_id ) ) {
                $args['has_archive'] = urldecode( get_page_uri( $resumes_page_id ) );
                $args['rewrite'] = array(
                    'slug'       => esc_html_x( 'resume', 'Resume permalink - resave permalinks after changing this', 'front' ),
                    'with_front' => false,
                    'feeds'      => true,
                );
            }

            $args['exclude_from_search'] = false;

            return $args;
        }

        public function resume_body_classes( $classes ) {
            $classes[] = 'wpjmr-activated';

            if( is_post_type_archive( 'resume' ) || is_page( front_wpjmr_get_page_id( 'jobs' ) ) || is_page( front_wpjmr_get_page_id( 'candidate_dashboard' ) ) || is_page( front_wpjmr_get_page_id( 'submit_resume_form' ) ) || front_is_job_listing_taxonomy() || is_singular( 'resume' ) ) {
                $classes[] = 'front-wpjmr-pages';
            }

            if( current_theme_supports( 'resume-manager-archive' ) && ( is_post_type_archive( 'resume' ) || is_page( front_wpjmr_get_page_id( 'resume' ) ) || front_is_resume_taxonomy() ) ) {
                $classes[] = 'post-type-archive-resume';
            }

            return $classes;
        }

        public function remove_header_topbar_icons() {
            if( apply_filters( 'front_enable_resume_header_args', true ) && ( is_post_type_archive( 'resume' ) || is_page( front_wpjmr_get_page_id( 'jobs' ) ) || is_page( front_wpjmr_get_page_id( 'candidate_dashboard' ) ) || is_page( front_wpjmr_get_page_id( 'submit_resume_form' ) ) || front_is_job_listing_taxonomy() || is_singular( 'resume' ) ) ) {
                add_filter( 'front_header_topbar_cart_enable', '__return_false', 9 );
                add_filter( 'front_header_topbar_search_enable', '__return_false', 9 );
            }
        }

        public function header_args( $args ) {
            if( apply_filters( 'front_enable_resume_header_args', true ) && ( is_post_type_archive( 'resume' ) || is_page( front_wpjmr_get_page_id( 'jobs' ) ) || is_page( front_wpjmr_get_page_id( 'candidate_dashboard' ) ) || is_page( front_wpjmr_get_page_id( 'submit_resume_form' ) ) || front_is_job_listing_taxonomy() || is_singular( 'resume' ) ) ) {
                $args = wp_parse_args( array(), $args );
            }

            return $args;
        }

        public function sidebar_register( $sidebar_args ) {

            $sidebar_args['sidebar_resume'] = array(
                'name'        => esc_html__( 'Resume Sidebar', 'front' ),
                'id'          => 'sidebar-resume',
                'description' => esc_html__( 'Widgets added to this region will appear in the Resume page.', 'front' ),
            );

            return $sidebar_args;
        }

        public static function get_current_page_url() {
            if ( ! ( is_post_type_archive( 'resume' ) || is_page( front_wpjmr_get_page_id( 'resume' ) ) ) && ! front_is_resume_taxonomy() ) {
                return;
            }

            if ( defined( 'RESUMES_IS_ON_FRONT' ) ) {
                $link = home_url( '/' );
            } elseif ( is_post_type_archive( 'resume' ) || is_page( front_wpjmr_get_page_id( 'resume' ) ) ) {
                $link = get_permalink( front_wpjmr_get_page_id( 'resume' ) );
            } else {
                $queried_object = get_queried_object();
                $link = get_term_link( $queried_object->slug, $queried_object->taxonomy );
            }

            // Order by.
            if ( isset( $_GET['orderby'] ) ) {
                $link = add_query_arg( 'orderby', front_clean( wp_unslash( $_GET['orderby'] ) ), $link );
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
            if ( $_chosen_taxonomies = Front_WPJMR_Query::get_layered_nav_chosen_taxonomies() ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found, WordPress.CodeAnalysis.AssignmentInCondition.Found
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
            if ( $_chosen_taxonomies = Front_WPJMR_Query::get_layered_nav_chosen_taxonomies() ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found, WordPress.CodeAnalysis.AssignmentInCondition.Found
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

        public static function live_search_resumes_suggest() {
            $suggestions = array();
            $posts = get_posts( array(
                's'                 => $_REQUEST['term'],
                'post_type'         => 'resume',
                'posts_per_page'    => '8',
            ) );

            global $post;

            $results = array();
            foreach ( $posts as $post ) {
                setup_postdata( $post );
                $suggestion = array();
                $suggestion['label'] = html_entity_decode( $post->post_title, ENT_QUOTES, 'UTF-8' );
                $suggestion['link'] = get_permalink( $post->ID );
                
                $suggestions[] = $suggestion;
            }

            // JSON encode and echo
            $response = $_GET["callback"] . "(" . json_encode( $suggestions ) . ")";
            echo wp_kses_post( $response );

            // Don't forget to exit!
            exit;
        }
    }

endif;
return new Front_WPJMR();