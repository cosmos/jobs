<?php

function front_wpjm_get_page_id( $page ) {

    $option_name = '';
    switch( $page ) {
        case 'jobs':
            $option_name = 'job_manager_jobs_page_id';
        break;
        case 'jobs-dashboard':
            $option_name = 'job_manager_job_dashboard_page_id';
        break;
        case 'post-a-job':
            $option_name = 'job_manager_submit_job_form_page_id';
        break;
    }

    $page_id = 0;

    if ( ! empty( $option_name ) ) {
        $page_id = get_option( $option_name );
    }

    $page_id = apply_filters( 'front_wpjm_get_' . $page . '_page_id', $page_id );
    return $page_id ? absint( $page_id ) : -1;
}

if ( ! function_exists( 'front_is_job_listing_taxonomy' ) ) {

    /**
     * Is_job_listing_taxonomy - Returns true when viewing a job_listing taxonomy archive.
     *
     * @return bool
     */
    function front_is_job_listing_taxonomy() {
        return is_tax( get_object_taxonomies( 'job_listing' ) );
    }
}

/**
 * Sets up the front_wpjm_loop global from the passed args or from the main query.
 *
 * @param array $args Args to pass into the global.
 */
function front_wpjm_setup_loop( $args = array() ) {
    $default_args = array(
        'loop'         => 0,
        'columns'      => 1,
        'name'         => '',
        'is_shortcode' => false,
        'is_paginated' => true,
        'is_search'    => false,
        'is_filtered'  => false,
        'total'        => 0,
        'total_pages'  => 0,
        'per_page'     => 0,
        'current_page' => 1,
    );

    // If this is a main WC query, use global args as defaults.
    if ( $GLOBALS['wp_query']->get( 'front_wpjm_query' ) ) {
        $default_args = array_merge( $default_args, array(
            'is_search'    => $GLOBALS['wp_query']->is_search(),
            'total'        => $GLOBALS['wp_query']->found_posts,
            'total_pages'  => $GLOBALS['wp_query']->max_num_pages,
            'per_page'     => $GLOBALS['wp_query']->get( 'posts_per_page' ),
            'current_page' => max( 1, $GLOBALS['wp_query']->get( 'paged', 1 ) ),
        ) );
    }

    // Merge any existing values.
    if ( isset( $GLOBALS['front_wpjm_loop'] ) ) {
        $default_args = array_merge( $default_args, $GLOBALS['front_wpjm_loop'] );
    }

    $GLOBALS['front_wpjm_loop'] = wp_parse_args( $args, $default_args );
}

/**
 * Resets the front_wpjm_loop global.
 *
 */
function front_wpjm_reset_loop() {
    unset( $GLOBALS['front_wpjm_loop'] );
}

/**
 * Gets a property from the front_wpjm_loop global.
 *
 * @param string $prop Prop to get.
 * @param string $default Default if the prop does not exist.
 * @return mixed
 */
function front_wpjm_get_loop_prop( $prop, $default = '' ) {
    front_wpjm_setup_loop(); // Ensure shop loop is setup.

    return isset( $GLOBALS['front_wpjm_loop'], $GLOBALS['front_wpjm_loop'][ $prop ] ) ? $GLOBALS['front_wpjm_loop'][ $prop ] : $default;
}

/**
 * Sets a property in the front_wpjm_loop global.
 *
 * @param string $prop Prop to set.
 * @param string $value Value to set.
 */
function front_wpjm_set_loop_prop( $prop, $value = '' ) {
    if ( ! isset( $GLOBALS['front_wpjm_loop'] ) ) {
        front_wpjm_setup_loop();
    }
    $GLOBALS['front_wpjm_loop'][ $prop ] = $value;
}

function front_wpjm_get_all_taxonomies() {
    $taxonomies = array();

    $taxonomy_objects = get_object_taxonomies( 'job_listing', 'objects' );
    foreach ( $taxonomy_objects as $taxonomy_object ) {
        $taxonomies[] = array(
            'taxonomy'  => $taxonomy_object->name,
            'name'      => $taxonomy_object->label,
        );
    }

    return $taxonomies;
}

function front_wpjm_get_all_date_filters() {
    return apply_filters( 'front_wpjm_get_all_date_filters' , array(
        '1-hour'    => esc_html__( 'Last Hour', 'front' ),
        '24-hours'  => esc_html__( 'Last 24 Hours', 'front' ),
        '7-days'    => esc_html__( 'Last 7 Days', 'front' ),
        '14-days'   => esc_html__( 'Last 14 Days', 'front' ),
        '30-days'   => esc_html__( 'Last 30 Days', 'front' ),
        'all'       => esc_html__( 'All', 'front' ),
    ) );
}

class Front_WPJM_Query {

    /**
     * Reference to the main job query on the page.
     *
     * @var array
     */
    private static $front_wpjm_query;

    /**
     * Stores chosen taxonomies.
     *
     * @var array
     */
    private static $_chosen_taxonomies;

    public function __construct() {
        if ( ! is_admin() ) {
            add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
        }
    }

    /**
     * Are we currently on the front page?
     *
     * @param WP_Query $q Query instance.
     * @return bool
     */
    private function is_showing_page_on_front( $q ) {
        return $q->is_home() && 'page' === get_option( 'show_on_front' );
    }

    /**
     * Is the front page a page we define?
     *
     * @param int $page_id Page ID.
     * @return bool
     */
    private function page_on_front_is( $page_id ) {
        return absint( get_option( 'page_on_front' ) ) === absint( $page_id );
    }

    public function pre_get_posts( $q ) {
        if ( ! $q->is_main_query() ){
            return;
        }

        // When orderby is set, WordPress shows posts on the front-page. Get around that here.
        if ( $this->is_showing_page_on_front( $q ) && $this->page_on_front_is( front_wpjm_get_page_id( 'jobs' ) ) ) {
            $_query = wp_parse_args( $q->query );
            if ( empty( $_query ) || ! array_diff( array_keys( $_query ), array( 'preview', 'page', 'paged', 'cpage', 'orderby' ) ) ) {
                $q->set( 'page_id', (int) get_option( 'page_on_front' ) );
                $q->is_page = true;
                $q->is_home = false;

                // WP supporting themes show post type archive.
                $q->set( 'post_type', 'job_listing' );
            }
        }

        // Special check for jobs with the PRODUCT POST TYPE ARCHIVE on front.
        if ( $q->is_page() && 'page' === get_option( 'show_on_front' ) && absint( $q->get( 'page_id' ) ) === front_wpjm_get_page_id( 'jobs' ) ) {
            // This is a front-page jobs.
            $q->set( 'post_type', 'job_listing' );
            $q->set( 'page_id', '' );

            if ( isset( $q->query['paged'] ) ) {
                $q->set( 'paged', $q->query['paged'] );
            }

            // Define a variable so we know this is the front page jobs later on.
            if( ! defined( 'JOBS_IS_ON_FRONT' ) ) {
                define( 'JOBS_IS_ON_FRONT', true );
            }

            // Get the actual WP page to avoid errors and let us use is_front_page().
            // This is hacky but works. Awaiting https://core.trac.wordpress.org/ticket/21096.
            global $wp_post_types;

            $jobs_page = get_post( front_wpjm_get_page_id( 'jobs' ) );

            $wp_post_types['job_listing']->ID         = $jobs_page->ID;
            $wp_post_types['job_listing']->post_title = $jobs_page->post_title;
            $wp_post_types['job_listing']->post_name  = $jobs_page->post_name;
            $wp_post_types['job_listing']->post_type  = $jobs_page->post_type;
            $wp_post_types['job_listing']->ancestors  = get_ancestors( $jobs_page->ID, $jobs_page->post_type );

            // Fix conditional Functions like is_front_page.
            $q->is_singular          = false;
            $q->is_post_type_archive = true;
            $q->is_archive           = true;
            $q->is_page              = true;

            // Remove post type archive name from front page title tag.
            add_filter( 'post_type_archive_title', '__return_empty_string', 5 );
        } elseif ( ! $q->is_post_type_archive( 'job_listing' ) && ! $q->is_tax( get_object_taxonomies( 'job_listing' ) ) ) {
            // Only apply to job_listing categories, the job_listing post archive, the jobs page, and job_listing taxonomies.
            return;
        }

        if ( ! is_feed() ) {
            $ordering = $this->get_catalog_ordering_args();
            $q->set( 'orderby', $ordering['orderby'] );
            $q->set( 'order', $ordering['order'] );

            if ( isset( $ordering['meta_key'] ) ) {
                $q->set( 'meta_key', $ordering['meta_key'] );
            }
        }

        // Query vars that affect posts shown.
        $this->get_search_query( $q );
        $q->set( 'meta_query', $this->get_meta_query( $q->get( 'meta_query' ), true ) );
        $q->set( 'tax_query', $this->get_tax_query( $q->get( 'tax_query' ), true ) );
        $q->set( 'date_query', $this->get_date_query( $q->get( 'date_query' ), true ) );
        $q->set( 'front_wpjm_query', 'job_listing_query' );
        $q->set( 'posts_per_page', $this->get_posts_per_page( $q->get( 'posts_per_page' ), true ) );

        // Hide Expired jobs
        if ( 0 === intval( get_option( 'job_manager_hide_expired', get_option( 'job_manager_hide_expired_content', 1 ) ) ) ) {
            $post_status = array( 'publish', 'expired' );
        } else {
            $post_status = array( 'publish' );
        }

        $q->set( 'post_status', $post_status );

        // Store reference to this query.
        self::$front_wpjm_query = $q;
    }

    /**
     * Appends meta queries to an array.
     *
     * @param  array $meta_query Meta query.
     * @param  bool  $main_query If is main query.
     * @return array
     */
    public function get_search_query( $q ) {
        if ( ! empty( $_GET['search_keywords'] ) ) {
            global $job_manager_keyword;
            $job_manager_keyword = sanitize_text_field( $_GET['search_keywords'] );

            if ( ! empty( $job_manager_keyword ) && strlen( $job_manager_keyword ) >= apply_filters( 'job_manager_get_listings_keyword_length_threshold', 2 ) ) {
                $q->set( 's' , $job_manager_keyword );
                add_filter( 'posts_search', 'get_job_listings_keyword_search' );
            }
        } elseif ( ! empty( $_GET['s'] ) ) {
            global $job_manager_keyword;
            $job_manager_keyword = sanitize_text_field( $_GET['s'] );

            if ( ! empty( $job_manager_keyword ) && strlen( $job_manager_keyword ) >= apply_filters( 'job_manager_get_listings_keyword_length_threshold', 2 ) ) {
                add_filter( 'posts_search', 'get_job_listings_keyword_search' );
            }
        }
    }

    /**
     * Appends meta queries to an array.
     *
     * @param  array $meta_query Meta query.
     * @param  bool  $main_query If is main query.
     * @return array
     */
    public function get_meta_query( $meta_query = array(), $main_query = false ) {
        if ( ! is_array( $meta_query ) ) {
            $meta_query = array();
        }

        $meta_query['search_location_filter'] = $this->search_location_filter_meta_query();
        $meta_query['company_name_filter'] = $this->company_name_filter_meta_query();
        $meta_query['company_id_filter'] = $this->company_id_filter_meta_query();

        if ( 1 === absint( get_option( 'job_manager_hide_filled_positions' ) ) ) {
            $meta_query[] = array(
                'key'     => '_filled',
                'value'   => '1',
                'compare' => '!=',
            );
        }

        return array_filter( apply_filters( 'front_job_listing_query_meta_query', $meta_query, $this ) );
    }

    /**
     * Appends tax queries to an array.
     *
     * @param  array $tax_query  Tax query.
     * @param  bool  $main_query If is main query.
     * @return array
     */
    public function get_tax_query( $tax_query = array(), $main_query = false ) {
        if ( ! is_array( $tax_query ) ) {
            $tax_query = array(
                'relation' => 'AND',
            );
        }

        // Layered nav filters on terms.
        if ( $main_query ) {
            foreach ( $this->get_layered_nav_chosen_taxonomies() as $taxonomy => $data ) {
                $tax_query[] = array(
                    'taxonomy'         => $taxonomy,
                    'field'            => 'slug',
                    'terms'            => $data['terms'],
                    'operator'         => 'and' === $data['query_type'] ? 'AND' : 'IN',
                    'include_children' => false,
                );
            }
        }

        // Filter by category.
        if ( ! empty( $_GET['search_category'] ) ) {
            $categories = is_array( $_GET['search_category'] ) ? $_GET['search_category'] : array_filter( array_map( 'trim', explode( ',', $_GET['search_category'] ) ) );
            $field      = is_numeric( $categories[0] ) ? 'term_id' : 'slug';
            $operator   = 'all' === get_option( 'job_manager_category_filter_type', 'all' ) && sizeof( $categories ) > 1 ? 'AND' : 'IN';
            $tax_query[] = array(
                'taxonomy'         => 'job_listing_category',
                'field'            => $field,
                'terms'            => array_values( $categories ),
                'include_children' => $operator !== 'AND' ,
                'operator'         => $operator
            );
        }

        return array_filter( apply_filters( 'front_job_listing_query_tax_query', $tax_query, $this ) );
    }

    /**
     * Appends date queries to an array.
     *
     * @param  array $date_query Date query.
     * @param  bool  $main_query If is main query.
     * @return array
     */
    public function get_date_query( $date_query = array(), $main_query = false ) {
        if ( ! is_array( $date_query ) ) {
            $date_query = array();
        }

        if ( ! empty( $_GET['posted_before'] ) ) {
            $posted_before  = front_clean( wp_unslash( $_GET['posted_before'] ) );
            $posted_arr     = explode( '-', $posted_before );
            $date_query[] = array(
                'after' => implode( ' ', $posted_arr ) . ' ago'
            );
        }

        return array_filter( apply_filters( 'front_job_listing_query_date_query', $date_query, $this ) );
    }

    /**
     * Return posts_per_page value.
     *
     * @param  int   $per_page posts_per_page value.
     * @param  bool  $main_query If is main query.
     * @return int
     */
    public function get_posts_per_page( $per_page = 10, $main_query = false ) {
        if( $main_query ) {
            $per_page = get_option( 'job_manager_per_page' );
        }

        return intval( apply_filters( 'front_job_listing_query_posts_per_page', $per_page ) );
    }

    /**
     * Return a meta query for filtering by location.
     *
     * @return array
     */
    private function search_location_filter_meta_query() {
        if ( ! empty( $_GET['search_location'] ) ) {
            $location_meta_keys = array( 'geolocation_formatted_address', '_job_location', 'geolocation_state_long' );
            $location_search    = array( 'relation' => 'OR' );
            foreach ( $location_meta_keys as $meta_key ) {
                $location_search[] = array(
                    'key'     => $meta_key,
                    'value'   => $_GET['search_location'],
                    'compare' => 'like'
                );
            }

            return $location_search;
        }

        return array();
    }

    /**
     * Return a meta query for filtering by company name.
     *
     * @return array
     */
    private function company_name_filter_meta_query() {
        $company_names = ! empty( $_GET['company_name'] ) ? explode( ',', front_clean( wp_unslash( $_GET['company_name'] ) ) ) : array();
        if ( ! empty( $company_names ) ) {
            $company_name_search    = array( 'relation' => 'OR' );
            foreach ( $company_names as $company_name ) {
                $company_name_search[] = array(
                    'key'     => '_company_name',
                    'value'   => $company_name,
                    'compare' => '=',
                );
            }

            return $company_name_search;
        }

        return array();
    }

    /**
     * Return a meta query for filtering by company id.
     *
     * @return array
     */
    private function company_id_filter_meta_query() {
        $company_ids = ! empty( $_GET['company_id'] ) ? explode( ',', front_clean( wp_unslash( $_GET['company_id'] ) ) ) : array();
        if ( ! empty( $company_ids ) ) {
            $company_id_search    = array( 'relation' => 'OR' );
            foreach ( $company_ids as $company_id ) {
                $company_id_search[] = array(
                    'key'     => '_company_id',
                    'value'   => $company_id,
                    'compare' => '=',
                );
            }

            return $company_id_search;
        }

        return array();
    }

    /**
     * Returns an array of arguments for ordering jobs based on the selected values.
     *
     * @param string $orderby Order by param.
     * @param string $order Order param.
     * @return array
     */
    public function get_catalog_ordering_args( $orderby = '', $order = '' ) {
        // Get ordering from query string unless defined.
        if ( ! $orderby ) {
            $orderby_value = isset( $_GET['orderby'] ) ? front_clean( (string) wp_unslash( $_GET['orderby'] ) ) : front_clean( get_query_var( 'orderby' ) ); // WPCS: sanitization ok, input var ok, CSRF ok.

            if ( ! $orderby_value ) {
                if ( is_search() ) {
                    $orderby_value = 'relevance';
                } else {
                    $orderby_value = apply_filters( 'front_job_listing_default_catalog_orderby', 'date' );
                }
            }

            // Get order + orderby args from string.
            $orderby_value = explode( '-', $orderby_value );
            $orderby       = esc_attr( $orderby_value[0] );
            $order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : $order;
        }

        $orderby = strtolower( $orderby );
        $order   = strtoupper( $order );
        $args    = array(
            'orderby'  => $orderby,
            'order'    => ( 'DESC' === $order ) ? 'DESC' : 'ASC',
            'meta_key' => '', // @codingStandardsIgnoreLine
        );

        switch ( $orderby ) {
            case 'menu_order':
                $args['orderby'] = 'menu_order title';
                break;
            case 'title':
                $args['orderby'] = 'title';
                $args['order']   = ( 'DESC' === $order ) ? 'DESC' : 'ASC';
                break;
            case 'relevance':
                $args['orderby'] = 'relevance';
                $args['order']   = 'DESC';
                break;
            case 'rand':
                $args['orderby'] = 'rand'; // @codingStandardsIgnoreLine
                break;
            case 'date':
                $args['orderby'] = 'date ID';
                $args['order']   = ( 'ASC' === $order ) ? 'ASC' : 'DESC';
                break;
            case 'featured':
                $args['orderby'] = 'meta_value date ID';
                $args['meta_key'] = '_featured';
                $args['order']   = ( 'ASC' === $order ) ? 'ASC' : 'DESC';
                break;
        }

        return apply_filters( 'front_job_listing_get_catalog_ordering_args', $args );
    }

    /**
     * Get the main query which job queries ran against.
     *
     * @return array
     */
    public static function get_main_query() {
        return self::$front_wpjm_query;
    }

    /**
     * Get the tax query which was used by the main query.
     *
     * @return array
     */
    public static function get_main_tax_query() {
        $tax_query = isset( self::$front_wpjm_query->tax_query, self::$front_wpjm_query->tax_query->queries ) ? self::$front_wpjm_query->tax_query->queries : array();

        return $tax_query;
    }

    /**
     * Get the meta query which was used by the main query.
     *
     * @return array
     */
    public static function get_main_meta_query() {
        $args       = isset( self::$front_wpjm_query->query_vars ) ? self::$front_wpjm_query->query_vars : array();
        $meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

        return $meta_query;
    }

    /**
     * Get the date query which was used by the main query.
     *
     * @return array
     */
    public static function get_main_date_query() {
        $date_query = isset( self::$front_wpjm_query->date_query, self::$front_wpjm_query->date_query->queries ) ? self::$front_wpjm_query->date_query->queries : array();

        return $date_query;
    }

    /**
     * Based on WP_Query::parse_search
     */
    public static function get_main_search_query_sql() {
        global $wpdb;

        $args       = isset( self::$front_wpjm_query->query_vars ) ? self::$front_wpjm_query->query_vars : array();
        $search_terms = isset( $args['search_terms'] ) ? $args['search_terms'] : array();
        $sql          = array();

        foreach ( $search_terms as $term ) {
            // Terms prefixed with '-' should be excluded.
            $include = '-' !== substr( $term, 0, 1 );

            if ( $include ) {
                $like_op  = 'LIKE';
                $andor_op = 'OR';
            } else {
                $like_op  = 'NOT LIKE';
                $andor_op = 'AND';
                $term     = substr( $term, 1 );
            }

            $like  = '%' . $wpdb->esc_like( $term ) . '%';
            $sql[] = $wpdb->prepare( "(($wpdb->posts.post_title $like_op %s) $andor_op ($wpdb->posts.post_excerpt $like_op %s) $andor_op ($wpdb->posts.post_content $like_op %s))", $like, $like, $like ); // unprepared SQL ok.
        }

        if ( ! empty( $sql ) && ! is_user_logged_in() ) {
            $sql[] = "($wpdb->posts.post_password = '')";
        }

        return implode( ' AND ', $sql );
    }

    /**
     * Get an array of taxonomies and terms selected with the layered nav widget.
     *
     * @return array
     */
    public static function get_layered_nav_chosen_taxonomies() {
        if ( ! is_array( self::$_chosen_taxonomies ) ) {
            self::$_chosen_taxonomies = array();
            $taxonomies     = front_wpjm_get_all_taxonomies();

            if ( ! empty( $taxonomies ) ) {
                foreach ( $taxonomies as $tax ) {
                    $taxonomy = $tax['taxonomy'];
                    $filter_terms = ! empty( $_GET[ 'filter_' . $taxonomy ] ) ? explode( ',', front_clean( wp_unslash( $_GET[ 'filter_' . $taxonomy ] ) ) ) : array(); // WPCS: sanitization ok, input var ok, CSRF ok.

                    if ( empty( $filter_terms ) || ! taxonomy_exists( $taxonomy ) ) {
                        continue;
                    }

                    $query_type                                     = ! empty( $_GET[ 'query_type_' . $taxonomy ] ) && in_array( $_GET[ 'query_type_' . $taxonomy ], array( 'and', 'or' ), true ) ? front_clean( wp_unslash( $_GET[ 'query_type_' . $taxonomy ] ) ) : ''; // WPCS: sanitization ok, input var ok, CSRF ok.
                    self::$_chosen_taxonomies[ $taxonomy ]['terms'] = array_map( 'sanitize_title', $filter_terms ); // Ensures correct encoding.
                    self::$_chosen_taxonomies[ $taxonomy ]['query_type'] = $query_type ? $query_type : apply_filters( 'front_wpjm_layered_nav_default_query_type', 'and' );
                }
            }
        }
        return self::$_chosen_taxonomies;
    }
}

$front_wpjm_query = new Front_WPJM_Query();

if ( ! function_exists( 'front_get_wpjm_job_listing_style' ) ) {
    function front_get_wpjm_job_listing_style() {
        $style = get_option( 'job_manager_jobs_listing_style' ) ? get_option( 'job_manager_jobs_listing_style' ) : 'grid';
        return apply_filters( 'front_get_wpjm_job_listing_style', $style );
    }
}

if ( ! function_exists( 'front_get_wpjm_job_listing_layout' ) ) {
    function front_get_wpjm_job_listing_layout() {
        $layout = get_option( 'job_manager_jobs_listing_layout' ) && is_active_sidebar( 'sidebar-job' )  ? get_option( 'job_manager_jobs_listing_layout' ) : 'fullwidth';
        return apply_filters( 'front_get_wpjm_job_listing_layout', $layout );
    }
}

if ( ! function_exists( 'front_get_wpjm_single_job_style' ) ) {
    function front_get_wpjm_single_job_style() {
        $style = get_option( 'job_manager_single_job_style' );
        return apply_filters( 'front_get_wpjm_job_single_style', $style );
    }
}

// if ( ! function_exists( 'front_submit_job_form_login_url' ) ) {
//     function front_submit_job_form_login_url( $login_page_url ) {
        
//         if ( ! empty( front_get_register_login_form_page() ) ) {
//             $login_page_url = get_permalink( front_get_register_login_form_page() ) . '#front-login-tab-content';
//         }

//         return $login_page_url;
//     }
// }

// add_filter( 'submit_job_form_login_url', 'front_submit_job_form_login_url' );

if( ! function_exists( 'front_get_taxomony_data' ) ) {
    function front_get_taxomony_data( $taxonomy = "job_listing_category", $post = null, $linkable = false, $linkable_class = '', $separator = ", " ) {
        if( ! is_object( $post ) ) {
            $post = get_post( $post );
        }

        if ( ! $post || ! taxonomy_exists( $taxonomy ) ) {
            return;
        }

        $terms = get_the_terms( $post->ID, $taxonomy );
        if ( $terms ) {
            if( $linkable ) {
                $term_links = array();
                foreach ( $terms as $term ){
                    $term_links[] = '<a href="' . esc_url( get_term_link( $term ) ) . '"' . ( !empty( $linkable_class ) ? ' class="' . esc_attr( $linkable_class ) . '"' : "" ) . '>' . esc_html( $term->name ) . '</a>';
                }
                $output = implode( $separator, $term_links );
            } else {
                $term_names = wp_list_pluck( $terms, 'name' );
                $output = implode( $separator, $term_names );
            }

            return apply_filters( 'front_the_taxomony_data', $output );
        }
    }
}

if ( ! function_exists( 'front_wpjm_wpcf7_notification_email' ) ) {
    function front_wpjm_wpcf7_notification_email( $components, $cf7, $three = null ) {
        $forms = apply_filters( 'front_wpjm_wpcf7_notification_email_forms', array(
            'job_listing' => array(
                'contact' => get_option( 'job_manager_single_job_contact_form', false )
            ),
            'company' => array(
                'contact' => get_option( 'job_manager_single_company_contact_form', false )
            ),
            'resume' => array(
                'contact' => get_option( 'resume_manager_single_resume_contact_form', false )
            )
        ) );

        $submission = WPCF7_Submission::get_instance();
        $unit_tag = $submission->get_meta( 'unit_tag' );

        if ( ! preg_match( '/^wpcf7-f(\d+)-p(\d+)-o(\d+)$/', $unit_tag, $matches ) )
            return $components;

        $post_id = (int) $matches[2];
        $object = get_post( $post_id );

        // Prevent issues when the form is not submitted via a listing/resume page
        if ( ! isset( $forms[ $object->post_type ] ) ) {
            return $components;
        }

        if ( ! array_search( $cf7->id(), $forms[ $object->post_type ] ) ) {
            return $components;
        }

        // Bail if this is the second mail
        if ( isset( $three ) && 'mail_2' == $three->name() ) {
            return $components;
        }

        switch ( $object->post_type ) {
            case 'job_listing':
                $recipient = $object->_application ? $object->_application : '';
                break;

            case 'company':
                $recipient = $object->_company_email ? $object->_company_email : '';
                break;

            case 'resume':
                $recipient = $object->_candidate_email ? $object->_candidate_email : '';
                break;

            default:
                $recipient = '';
                break;
        }

        //if we couldn't find the email by now, get it from the listing owner/author
        if ( empty( $recipient ) ) {

            //just get the email of the listing author
            $owner_ID = $object->post_author;

            //retrieve the owner user data to get the email
            $owner_info = get_userdata( $owner_ID );

            if ( false !== $owner_info ) {
                $recipient = $owner_info->user_email;
            }
        }

        $components[ 'recipient' ] = $recipient;

        return $components;
    }
}

add_filter( 'wpcf7_mail_components', 'front_wpjm_wpcf7_notification_email', 10, 3 );

if ( ! function_exists( 'front_get_forms' ) ) {
    function front_get_forms() {
        $forms  = array( 0 => esc_html__( 'Please select a form', 'front' ) );

        if (function_exists('wpcf7')) {
            $_forms = get_posts(
                array(
                    'numberposts' => -1,
                    'post_type'   => 'wpcf7_contact_form',
                )
            );

            if ( ! empty( $_forms ) ) {

                foreach ( $_forms as $_form ) {
                    $forms[ $_form->ID ] = $_form->post_title;
                }
            }
        }

        return $forms;
    }
}

if ( ! function_exists( 'front_the_company_logo' ) ) {
    /**
     * Displays the company logo.
     *
     * @since 1.0.0
     * @param string      $size (default: 'full').
     * @param mixed       $default (default: null).
     * @param int|WP_Post $post (default: null).
     */
    function front_the_company_logo( $size = 'thumbnail', $class = 'img-fluid', $job_logo = true , $default = null, $post = null, $echo =true ) {
        $post = get_post( $post );
        $logo = get_the_company_logo( $post, $size );

        $job_logo = apply_filters( 'front_wpjm_job_logo_as_secondary', $job_logo );

        if ( has_post_thumbnail( $post ) && $job_logo ) {
            $company_logo = '<img class="' . esc_attr( $class ) . '" src="' . esc_url( $logo ) . '" alt="' . esc_attr( get_the_company_name( $post ) ) . '" />';
        } elseif( ( empty( $logo ) || ! $job_logo ) && !empty( $company = front_get_the_job_listing_company() ) && has_post_thumbnail( $company ) ) {
            $company_logo = get_the_post_thumbnail( $company, $size, array( 'class' => $class, 'alt' => get_the_company_name( $post ) ) );
        } elseif ( ! empty( $logo ) && ( strstr( $logo, 'http' ) || file_exists( $logo ) ) ) {
            if ( 'full' !== $size ) {
                $company_logo = job_manager_get_resized_image( $logo, $size );
            }
            $company_logo = '<img class="' . esc_attr( $class ) . '" src="' . esc_url( $logo ) . '" alt="' . esc_attr( get_the_company_name( $post ) ) . '" />';
        } elseif ( $default ) {
            $company_logo = '<img class="' . esc_attr( $class ) . '" src="' . esc_url( $default ) . '" alt="' . esc_attr( get_the_company_name( $post ) ) . '" />';
        } else {
            $company_logo = '<img class="' . esc_attr( $class ) . '" src="' . esc_url( apply_filters( 'job_manager_default_company_logo', JOB_MANAGER_PLUGIN_URL . '/assets/images/company.png' ) ) . '" alt="' . esc_attr( get_the_company_name( $post ) ) . '" />';
        }

        if( $echo ) {
            echo wp_kses_post( $company_logo );
        } else {
            return $company_logo;
        }
    }
}

if ( ! function_exists( 'front_the_job_status' ) ) {
    function front_the_job_status() {
        if( ! candidates_can_apply() ) :
            ?><span class="badge badge-xs badge-outline-danger badge-pos badge-pos--bottom-left rounded-circle" title="<?php esc_html_e( 'User Can\'t Apply for this Job', 'front' ) ?>"></span><?php
        endif;
    }
}

if ( ! function_exists( 'front_single_job_listing_application' ) ) {
    function front_single_job_listing_application() {
        if ( candidates_can_apply() ) {
            get_job_manager_template( 'job-application.php' );
        }
    }
}

if ( ! function_exists( 'front_single_job_listing_bookmark' ) ) {
    function front_single_job_listing_bookmark() {
        global $job_manager_bookmarks;
        ?>
        <div class="mr-2">
            <?php $job_manager_bookmarks->bookmark_form(); ?>
        </div>
        <?php
    }
}

if ( ! function_exists( 'front_get_the_meta_data' ) ) {
    function front_get_the_meta_data( $meta_key, $post = null, $post_type = 'job_listing', $trimed_link = false ) {
        if( ! post_type_exists( $post_type ) )
            return;

        $post = get_post( $post );
        $job_meta_data = get_post_meta( $post->ID, $meta_key, true );

        if( $trimed_link ) {
            if( substr( $job_meta_data, 0, 7 ) === "http://" ) {
                $job_meta_data = str_replace( 'http://', '', $job_meta_data);
            } elseif( substr( $job_meta_data, 0, 8 ) === "https://" ) {
                $job_meta_data = str_replace( 'https://', '', $job_meta_data);
            } else {
                $job_meta_data = $job_meta_data;
            }
        }

        return apply_filters( 'front_get_the_meta_data', $job_meta_data );
    }
}

if ( ! function_exists( 'front_get_the_job_listing_company_meta_data' ) ) {
    function front_get_the_job_listing_company_meta_data( $meta_key, $post = null ) {
        $post = get_post( $post );
        $company_meta_data = get_post_meta( $post->ID, $meta_key, true );

        if( empty( $company_meta_data ) && !empty( $company = front_get_the_job_listing_company( $post ) ) ) {
            $company_meta_data = get_post_meta( $company->ID, $meta_key, true );
        }

        return apply_filters( 'front_get_the_job_listing_company_meta_data', $company_meta_data );
    }
}

if ( ! function_exists( 'front_get_the_job_listing_company' ) ) {
    function front_get_the_job_listing_company( $post = null ) {
        $post = get_post( $post );

        if ( post_type_exists( 'company' ) || get_post_type( $post->ID ) == 'job_listings' ) {
            $company_id = get_post_meta( $post->ID, '_company_id', true );
            if( ! empty( $company_id ) ) {
                $company = get_post( $company_id );
                return apply_filters( 'front_the_company_for_job', $company );
            }
        }

        return null;
    }
}

if ( ! function_exists( 'front_get_the_job_listing_company_excerpt' ) ) {
    function front_get_the_job_listing_company_excerpt( $post = null ) {
        $post = get_post( $post );
        $excerpt = get_post_meta( $post->ID, '_company_about', true );

        if( empty( $excerpt ) && !empty( $company = front_get_the_job_listing_company( $post ) ) ) {
            $excerpt = get_the_excerpt( $company );
        }

        return apply_filters( 'front_the_company_excerpt', $excerpt );
    }
}

if ( ! function_exists( 'front_get_the_job_listing_company_contact_email' ) ) {
    function front_get_the_job_listing_company_contact_email( $post = null ) {
        $post = get_post( $post );
        $contact_email = get_post_meta( $post->ID, '_contact_email', true );

        if( empty( $contact_email ) && !empty( $company = front_get_the_job_listing_company( $post ) ) ) {
            $contact_email = get_post_meta( $company->ID, '_company_email', true );
        }

        return apply_filters( 'front_the_job_listing_company_contact_email', $contact_email );
    }
}

if ( ! function_exists( 'front_get_the_job_listing_company_contact_phone' ) ) {
    function front_get_the_job_listing_company_contact_phone( $post = null ) {
        $post = get_post( $post );
        $contact_phone = get_post_meta( $post->ID, '_contact_phone', true );

        if( empty( $contact_phone ) && !empty( $company = front_get_the_job_listing_company( $post ) ) ) {
            $contact_phone = get_post_meta( $company->ID, '_company_phone', true );
        }

        return apply_filters( 'front_the_job_listing_company_contact_phone', $contact_phone );
    }
}

if ( ! function_exists( 'front_wpjm_job_catalog_ordering' ) ) {
    function front_wpjm_job_catalog_ordering() {
        if ( ! front_wpjm_get_loop_prop( 'is_paginated' ) || 0 >= front_wpjm_get_loop_prop( 'total', 0 ) ) {
            return;
        }

        $catalog_orderby_options = apply_filters( 'front_jobs_catalog_orderby', array(
            'featured'   => esc_html__( 'Featured', 'front' ),
            'date'       => esc_html__( 'New Job', 'front' ),
            'menu_order' => esc_html__( 'Menu Order', 'front' ),
            'title-asc'  => esc_html__( 'Name: Ascending', 'front' ),
            'title-desc' => esc_html__( 'Name: Descending', 'front' ),
        ) );

        $default_orderby = front_wpjm_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'front_job_listing_default_catalog_orderby', 'date' );
        $orderby         = isset( $_GET['orderby'] ) ? front_clean( wp_unslash( $_GET['orderby'] ) ) : $default_orderby; // WPCS: sanitization ok, input var ok, CSRF ok.

        if ( front_wpjm_get_loop_prop( 'is_search' ) ) {
            $catalog_orderby_options = array_merge( array( 'relevance' => esc_html__( 'Relevance', 'front' ) ), $catalog_orderby_options );

            unset( $catalog_orderby_options['menu_order'] );
        }

        if ( ! array_key_exists( $orderby, $catalog_orderby_options ) ) {
            $orderby = current( array_keys( $catalog_orderby_options ) );
        }

        $current_page_query_args = Front_WPJM::get_current_page_query_args();

        wp_enqueue_script( 'bootstrap-select' );
        wp_enqueue_script( 'front-hs-selectpicker' );

        ?>
        <form method="get">
            <select name="orderby" class="js-select selectpicker dropdown-select" onchange="this.form.submit();" data-width="fit" data-style="btn-soft-primary btn-xs" tabindex="-98">
                <?php foreach ( $catalog_orderby_options as $id => $catalog_orderby_option ) : ?>
                    <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $catalog_orderby_option ); ?></option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="paged" value="1" />
            <?php 
            if( is_array( $current_page_query_args ) && !empty(  $current_page_query_args  ) ) :
                foreach ( $current_page_query_args as $key => $current_page_query_arg ) :
                    if( $key != 'orderby' ) :
                        ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $current_page_query_arg ); ?>" ><?php
                    endif;
                endforeach;
            endif;
            ?>
        </form>
        <?php
    }
}

if ( ! function_exists( 'front_wpjm_job_control_bar_dropdown' ) ) {
    function front_wpjm_job_control_bar_dropdown( $show_on_none = '', $taxonomy = 'job_listing_category', $args = array() ) {
        if( ! taxonomy_exists( $taxonomy ) ) {
            return;
        }

        $default = array (
            'hide_empty' => false,
        );

        $current_page_query_args = Front_WPJM::get_current_page_query_args();

        $terms = get_terms( $taxonomy, $args );

        $name = 'filter_' . $taxonomy;

        $select = isset( $_GET[$name] ) ? front_clean( wp_unslash( $_GET[$name] ) ) : '';

        wp_enqueue_script( 'bootstrap-select' );
        wp_enqueue_script( 'front-hs-selectpicker' );

        if ( !empty( $terms ) ) :
            ?>
            <li class="list-inline-item mb-2">
                <form method="get">
                    <select id="<?php echo esc_attr( $taxonomy ); ?>" name="<?php echo esc_attr( $name ); ?>" class="js-select selectpicker dropdown-select" data-width="fit" data-style="btn-soft-primary btn-xs" tabindex="-98" onchange="this.form.submit();">
                        <option value=""><?php echo esc_html( $show_on_none ); ?></option>
                        <?php foreach ( $terms as $term ) : ?>
                            <option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $select, $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="paged" value="1" />
                    <?php 
                    if( is_array( $current_page_query_args ) && !empty(  $current_page_query_args  ) ) :
                        foreach ( $current_page_query_args as $key => $current_page_query_arg ) :
                            if( $key != $name ) :
                                ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $current_page_query_arg ); ?>" ><?php
                            endif;
                        endforeach;
                    endif;
                    ?>
                </form>
            </li>
            <?php 
        endif;
    }
}

if ( ! function_exists( 'front_job_header_search_form' ) ) {
    /**
     * Display Job Header Search Form
     */
    function front_job_header_search_form( $args = array() ) {

        $defaults =  apply_filters( 'front_job_header_search_form_default_args', array(
            'keywords_title_text'       => esc_html__( 'what', 'front' ),
            'keywords_subtitle_text'    => esc_html__( 'job title, keywords, or company', 'front' ),
            'keywords_placeholder_text' => esc_html__( 'Keyword or title', 'front' ),
            'location_title_text'       => esc_html__( 'where', 'front' ),
            'location_subtitle_text'    => esc_html__( 'city, state, or zip code', 'front' ),
            'location_placeholder_text' => esc_html__( 'City, state, or zip', 'front' ),
            'category_title_text'       => esc_html__( 'which', 'front' ),
            'category_subtitle_text'    => esc_html__( 'department, industry, or specialism', 'front' ),
            'category_placeholder_text' => esc_html__( 'All Category', 'front' ),
            'search_button_text'        => esc_html__( 'Find Jobs', 'front' ),
            'background_color'          => 'bg-light',
            'current_page_url'          => '',
            'enable_container'          => true,
        ) );

        $args = wp_parse_args( $args, $defaults );

        extract( $args );

        $current_page_url = ! empty($current_page_url) ? $current_page_url : Front_WPJM::get_current_page_url();
        $current_page_query_args = Front_WPJM::get_current_page_query_args();

        ?>
        <div class="job-filters<?php echo esc_attr( !empty( $background_color ) ? ' ' . $background_color : '' ); ?>">
            <div class="<?php echo esc_attr( !empty( $enable_container ) ? 'container space-1' : '' ); ?>">
                <!-- Search Jobs Form -->
                <form class="job_filters_form" action="<?php echo esc_attr( $current_page_url ); ?>">
                    <?php do_action( 'job_manager_job_header_search_block_start' ); ?>
                    <div class="search_jobs row mb-2">
                        <?php do_action( 'job_manager_job_header_search_block_search_jobs_start' ); ?>

                        <div class="search_keywords col-lg-5 mb-4 mb-lg-0">
                            <!-- Input -->
                            <label for="search_keywords" class="d-block">
                                <span class="h4 d-block text-dark font-weight-semi-bold mb-0"><?php echo esc_html( $args['keywords_title_text'] ) ?></span>
                                <small class="d-block text-secondary">
                                    <?php echo esc_html( $args['keywords_subtitle_text'] ) ?>
                                </small>
                            </label>
                            <div class="js-focus-state">
                                <div class="input-group">
                                    <input type="text" name="search_keywords" id="search_keywords" class="form-control" placeholder="<?php echo esc_attr( $args['keywords_placeholder_text'] ) ?>" aria-label="<?php echo esc_attr( $args['keywords_placeholder_text'] ) ?>" aria-describedby="keywordInputAddon" value="<?php echo get_search_query(); ?>" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                        <span class="fas fa-search" id="keywordInputAddon"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- End Input -->
                        </div>
                        <div class="search_location col-lg-5 mb-4 mb-lg-0">
                            <!-- Input -->
                            <label for="search_location" class="d-block">
                                <span class="h4 d-block text-dark font-weight-semi-bold mb-0"><?php echo esc_html( $args['location_title_text'] ) ?></span>
                                <small class="d-block text-secondary">
                                    <?php echo esc_html( $args['location_subtitle_text'] ) ?>
                                </small>
                            </label>
                            <div class="js-focus-state">
                                <div class="input-group">
                                    <input type="text" name="search_location" id="search_location" class="form-control" placeholder="<?php echo esc_attr( $args['location_placeholder_text'] ) ?>" aria-label="<?php echo esc_attr( $args['location_placeholder_text'] ) ?>" aria-describedby="locationInputAddon" value="<?php echo esc_attr( isset( $_GET['search_location'] ) ? front_clean( wp_unslash( $_GET['search_location'] ) ) : '' ); ?>" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                        <span class="fas fa-map-marker-alt" id="locationInputAddon"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- End Input -->
                        </div>
                        <div class="search_submit col-lg-2 align-self-lg-end">
                            <button type="submit" class="btn btn-block btn-primary transition-3d-hover">
                                <?php echo esc_html( $search_button_text ); ?>
                            </button>
                        </div>
                        <input type="hidden" name="paged" value="1" />
                        <?php 
                        if( is_array( $current_page_query_args ) && !empty(  $current_page_query_args  ) ) :
                            foreach ( $current_page_query_args as $key => $current_page_query_arg ) :
                                if( $key != 'search_keywords' && $key != 'search_location'  ) :
                                    ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $current_page_query_arg ); ?>" ><?php
                                endif;
                            endforeach;
                        endif;
                        ?>

                        <?php do_action( 'job_manager_job_header_search_block_search_jobs_end' ); ?>
                    </div>
                    <?php do_action( 'job_manager_job_header_search_block_end' ); ?>
                    <!-- End Checkbox -->
                </form>
                <!-- End Search Jobs Form -->
            </div>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_single_sidebar_get_svg_icon_block_content' ) ) {
    function front_single_sidebar_get_svg_icon_block_content( $args = array() ) {
        if( count( $args ) > 0 ) :
            $contents = array();
            $outputs =  '';
            foreach( $args as $key => $arg ) {
                if( isset( $arg['text_1'], $arg['text_2'] ) && !empty( $arg['text_1'] && $arg['text_2'] ) && ( ( isset( $arg['svg'] ) && !empty( $arg['svg'] ) ) || ( isset( $arg['icon'] ) && !empty( $arg['icon'] ) ) ) ) :
                    ob_start();
                    ?>
                    <div class="text-center">
                        <?php if( isset( $arg['svg'] ) && !empty( $arg['svg'] ) ) :?>
                            <figure class="ie-height-48 max-width-5 mb-2 mx-auto">
                                <img src="<?php echo esc_attr( get_template_directory_uri() . $arg['svg'] ); ?>" alt="svgIcon" <?php echo isset( $args['dataParent'] ) ? ( 'class="js-svg-injector" data-parent="' . esc_attr( $args['dataParent'] ) . '"' ) : ""; ?>>
                            </figure>
                        <?php else : ?>
                            <figure class="ie-height-48 max-width-5 mb-2 mx-auto text-primary font-size-2">
                                <span class="<?php echo esc_attr( $arg['icon'] ); ?>"></span>
                            </figure>
                        <?php endif; ?>
                        <span class="h6 d-block font-weight-medium mb-0"><?php echo wp_kses_post( $arg['text_1'] ); ?></span>
                        <span class="d-block text-secondary font-size-1"><?php echo wp_kses_post( $arg['text_2'] ); ?></span>
                    </div>
                    <?php
                    $contents[] = ob_get_clean();
                endif;
            }

            if( ( $contents_count = count( $contents ) ) > 0 ) {
                $i = 0;
                foreach( $contents as $content ) {
                    $outputs .= '<div class="col-6' . ( ( ( $contents_count%2 !== 0 && $i < ( $contents_count-1 ) ) || ( $contents_count >= 2 && $i < ( $contents_count-2 ) ) ) ? esc_attr( ' mb-5' ) : '' ) . '">' . $content . '</div>';

                    $i++;
                }
                return $outputs;
            }
            return;
        endif;
        return;
    }
}

if( ! function_exists( 'front_single_get_linked_accounts_content' ) ) {
    function front_single_get_linked_accounts_content( Array $args = array() ) {
        if( count( $args ) > 0 ) :
            $contents = array();
            $outputs =  '';
            foreach( $args as $key => $arg ) {
                if( isset( $arg['text'], $arg['link'], $arg['image'] ) && !empty( $arg['text'] && $arg['link'] && $arg['image'] ) ) :
                    ob_start();
                    ?>
                    <a href="<?php echo esc_url( $arg['link'] ); ?>" target="_blank" class="media align-items-center mb-3">
                        <div class="u-sm-avatar mr-3">
                            <img src="<?php echo esc_url( $arg['image'] ); ?>" alt="<?php echo esc_attr( $key ); ?>" class="img-fluid">
                        </div>
                        <div class="media-body">
                            <h4 class="font-size-1 text-dark mb-0"><?php echo esc_html( $arg['text'] ) ?></h4>
                            <small class="d-block text-secondary"><?php echo esc_html( $arg['link'] ); ?></small>
                        </div>
                    </a>
                    <?php
                    $contents[] = ob_get_clean();
                endif;
            }

            if( ( $contents_count = count( $contents ) ) > 0 ) {
                $i = 0;
                foreach( $contents as $content ) {
                    $outputs .= '<div class="media align-items-center' . ( $i < ( $contents_count-1 ) ? esc_attr( ' mb-3' ) : '' ) . '">' . $content . '</div>';

                    $i++;
                }
                return $outputs;
            }
            return;
        endif;
        return;
    }
}