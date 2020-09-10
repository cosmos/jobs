<?php

function front_wpjmr_get_page_id( $page ) {

    $option_name = '';
    switch( $page ) {
        case 'resume':
            $option_name = 'resume_manager_resumes_page_id';
        break;
        case 'submit_resume_form':
            $option_name = 'resume_manager_submit_resume_form_page_id';
        break;
        case 'candidate_dashboard':
            $option_name = 'resume_manager_candidate_dashboard_page_id';
        break;
    }

    $page_id = 0;

    if ( ! empty( $option_name ) ) {
        $page_id = get_option( $option_name );
    }

    $page_id = apply_filters( 'front_wpjmr_get_' . $page . '_page_id', $page_id );
    return $page_id ? absint( $page_id ) : -1;
}

if ( ! function_exists( 'front_is_resume_taxonomy' ) ) {

    /**
     * Is_resume_taxonomy - Returns true when viewing a resume taxonomy archive.
     *
     * @return bool
     */
    function front_is_resume_taxonomy() {
        return is_tax( get_object_taxonomies( 'resume' ) );
    }
}

function front_add_showing_to_resume_listings_result( $results, $resumes ) {

    $search_location    = isset( $_REQUEST['search_location'] ) ? sanitize_text_field( stripslashes( $_REQUEST['search_location'] ) ) : '';
    $search_keywords    = isset( $_REQUEST['search_keywords'] ) ? sanitize_text_field( stripslashes( $_REQUEST['search_keywords'] ) ) : '';

    $showing     = '';
    $showing_all = false;

    if ( $resumes->post_count ) {

        $showing_all = true;

        $start = (int) $resumes->get( 'offset' ) + 1;
        $end   = $start + (int)$resumes->post_count - 1;

        if ( $resumes->max_num_pages > 1 ) {
            $showing = sprintf( esc_html__( 'Showing %s - %s of %s resumes', 'front'), $start, $end, $resumes->found_posts );
        } else {
            $showing =  sprintf( _n( 'Showing one job', 'Showing all %s resumes', $resumes->found_posts, 'front' ), $resumes->found_posts );
        }


        if ( ! empty( $search_keywords ) ) {
            $showing = wp_kses_post( sprintf( __( '%s matching <span class="highlight">%s</span>', 'front' ), $showing, $search_keywords ) );
        }

        if ( ! empty( $search_location ) ) {
            $showing = wp_kses_post( sprintf( __( '%s in <span class="highlight">%s</span>', 'front' ), $showing, $search_location ) );
        }
    }
    $results['showing']     = $showing;
    $results['showing_all'] = $showing_all;
    return $results;
}

if ( ! function_exists( 'front_wpjmr_page_title' ) ) {
    function front_wpjmr_page_title( $title ) {

        if( is_post_type_archive( 'resume' ) ) {
            $title = esc_html__( 'Candidates', 'front' );
        } elseif ( is_singular( 'resume' ) ) {
            $title = single_post_title( '', false );
        } elseif ( is_tax( get_object_taxonomies( 'resume' ) ) ) {
            $title = single_term_title( '', false );
        }

        return $title;
    }
}

if ( ! function_exists( 'front_wpjmr_page_subtitle' ) ) {
    function front_wpjmr_page_subtitle( $subtitle ) {

        if( is_post_type_archive( 'resume' ) ) {
            $subtitle = '';
        } elseif ( is_singular( 'resume' ) ) {
            $subtitle = '';
        }

        return $subtitle;
    }
}

/**
 * Sets up the front_wpjmr_loop global from the passed args or from the main query.
 *
 * @param array $args Args to pass into the global.
 */
function front_wpjmr_setup_loop( $args = array() ) {
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
    if ( $GLOBALS['wp_query']->get( 'front_wpjmr_query' ) ) {
        $default_args = array_merge( $default_args, array(
            'is_search'    => $GLOBALS['wp_query']->is_search(),
            // 'is_filtered'  => is_filtered(),
            'total'        => $GLOBALS['wp_query']->found_posts,
            'total_pages'  => $GLOBALS['wp_query']->max_num_pages,
            'per_page'     => $GLOBALS['wp_query']->get( 'posts_per_page' ),
            'current_page' => max( 1, $GLOBALS['wp_query']->get( 'paged', 1 ) ),
        ) );
    }

    // Merge any existing values.
    if ( isset( $GLOBALS['front_wpjmr_loop'] ) ) {
        $default_args = array_merge( $default_args, $GLOBALS['front_wpjmr_loop'] );
    }

    $GLOBALS['front_wpjmr_loop'] = wp_parse_args( $args, $default_args );
}

/**
 * Resets the front_wpjmr_loop global.
 *
 */
function front_wpjmr_reset_loop() {
    unset( $GLOBALS['front_wpjmr_loop'] );
}

/**
 * Gets a property from the front_wpjmr_loop global.
 *
 * @param string $prop Prop to get.
 * @param string $default Default if the prop does not exist.
 * @return mixed
 */
function front_wpjmr_get_loop_prop( $prop, $default = '' ) {
    front_wpjmr_setup_loop(); // Ensure shop loop is setup.

    return isset( $GLOBALS['front_wpjmr_loop'], $GLOBALS['front_wpjmr_loop'][ $prop ] ) ? $GLOBALS['front_wpjmr_loop'][ $prop ] : $default;
}

/**
 * Sets a property in the front_wpjmr_loop global.
 *
 * @param string $prop Prop to set.
 * @param string $value Value to set.
 */
function front_wpjmr_set_loop_prop( $prop, $value = '' ) {
    if ( ! isset( $GLOBALS['front_wpjmr_loop'] ) ) {
        front_wpjmr_setup_loop();
    }
    $GLOBALS['front_wpjmr_loop'][ $prop ] = $value;
}

if ( ! function_exists( 'front_get_resume_keyword_search' ) ) {
    /**
     * Adds join and where query for keywords.
     *
     * @since 1.0.0
     * @param string $search
     * @return string
     */
    function front_get_resume_keyword_search( $search ) {
        global $wpdb, $front_wpjmr_search_keyword;

        // Searchable Meta Keys: set to empty to search all meta keys
        $searchable_meta_keys = array(
            '_candidate_title',
            '_candidate_email',
            '_candidate_location',
            '_candidate_twitter',
            '_candidate_facebook',
        );

        $searchable_meta_keys = apply_filters( 'front_wpjmr_searchable_meta_keys', $searchable_meta_keys );

        // Set Search DB Conditions
        $conditions   = array();

        // Search Post Meta
        if( apply_filters( 'front_wpjmr_search_post_meta', true ) ) {

            // Only selected meta keys
            if( $searchable_meta_keys ) {
                $conditions[] = "{$wpdb->posts}.ID IN ( SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key IN ( '" . implode( "','", array_map( 'esc_sql', $searchable_meta_keys ) ) . "' ) AND meta_value LIKE '%" . esc_sql( $front_wpjmr_search_keyword ) . "%' )";
            } else {
                // No meta keys defined, search all post meta value
                $conditions[] = "{$wpdb->posts}.ID IN ( SELECT post_id FROM {$wpdb->postmeta} WHERE meta_value LIKE '%" . esc_sql( $front_wpjmr_search_keyword ) . "%' )";
            }
        }

        // Search taxonomy
        $conditions[] = "{$wpdb->posts}.ID IN ( SELECT object_id FROM {$wpdb->term_relationships} AS tr LEFT JOIN {$wpdb->term_taxonomy} AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id LEFT JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id WHERE t.name LIKE '%" . esc_sql( $front_wpjmr_search_keyword ) . "%' )";

        /**
         * Filters the conditions to use when querying job listings. Resulting array is joined with OR statements.
         *
         * @since 1.26.0
         *
         * @param array  $conditions          Conditions to join by OR when querying job listings.
         * @param string $front_wpjmr_search_keyword Search query.
         */
        $conditions = apply_filters( 'front_wpjmr_search_conditions', $conditions, $front_wpjmr_search_keyword );
        if ( empty( $conditions ) ) {
            return $search;
        }

        $conditions_str = implode( ' OR ', $conditions );

        if ( ! empty( $search ) ) {
            $search = preg_replace( '/^ AND /', '', $search );
            $search = " AND ( {$search} OR ( {$conditions_str} ) )";
        } else {
            $search = " AND ( {$conditions_str} )";
        }

        return $search;
    }
}

function front_wpjmr_get_all_date_filters() {
    return apply_filters( 'front_wpjmr_get_all_date_filters' , array(
        '1-hour'    => esc_html__( 'Last Hour', 'front' ),
        '24-hours'  => esc_html__( 'Last 24 Hours', 'front' ),
        '7-days'    => esc_html__( 'Last 7 Days', 'front' ),
        '14-days'   => esc_html__( 'Last 14 Days', 'front' ),
        '30-days'   => esc_html__( 'Last 30 Days', 'front' ),
        'all'       => esc_html__( 'All', 'front' ),
    ) );
}

function front_wpjmr_get_all_taxonomies() {
    $taxonomies = array();

    $taxonomy_objects = get_object_taxonomies( 'resume', 'objects' );
    foreach ( $taxonomy_objects as $taxonomy_object ) {
        $taxonomies[] = array(
            'taxonomy'  => $taxonomy_object->name,
            'name'      => $taxonomy_object->label,
        );
    }

    return $taxonomies;
}

class Front_WPJMR_Query {

    /**
     * Reference to the main job query on the page.
     *
     * @var array
     */
    private static $front_wpjmr_query;

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
        if ( $this->is_showing_page_on_front( $q ) && $this->page_on_front_is( front_wpjmr_get_page_id( 'resume' ) ) ) {
            $_query = wp_parse_args( $q->query );
            if ( empty( $_query ) || ! array_diff( array_keys( $_query ), array( 'preview', 'page', 'paged', 'cpage', 'orderby' ) ) ) {
                $q->set( 'page_id', (int) get_option( 'page_on_front' ) );
                $q->is_page = true;
                $q->is_home = false;

                // WP supporting themes show post type archive.
                $q->set( 'post_type', 'resume' );
            }
        }

        // Special check for resume with the PRODUCT POST TYPE ARCHIVE on front.
        if ( $q->is_page() && 'page' === get_option( 'show_on_front' ) && absint( $q->get( 'page_id' ) ) === front_wpjmr_get_page_id( 'resume' ) ) {
            // This is a front-page resume.
            $q->set( 'post_type', 'resume' );
            $q->set( 'page_id', '' );

            if ( isset( $q->query['paged'] ) ) {
                $q->set( 'paged', $q->query['paged'] );
            }

            // Define a variable so we know this is the front page resume later on.
            if( ! defined( 'RESUMES_IS_ON_FRONT' ) ) {
                define( 'RESUMES_IS_ON_FRONT', true );
            }

            // Get the actual WP page to avoid errors and let us use is_front_page().
            // This is hacky but works. Awaiting https://core.trac.wordpress.org/ticket/21096.
            global $wp_post_types;

            $resume_page = get_post( front_wpjmr_get_page_id( 'resume' ) );

            $wp_post_types['resume']->ID         = $resume_page->ID;
            $wp_post_types['resume']->post_title = $resume_page->post_title;
            $wp_post_types['resume']->post_name  = $resume_page->post_name;
            $wp_post_types['resume']->post_type  = $resume_page->post_type;
            $wp_post_types['resume']->ancestors  = get_ancestors( $resume_page->ID, $resume_page->post_type );

            // Fix conditional Functions like is_front_page.
            $q->is_singular          = false;
            $q->is_post_type_archive = true;
            $q->is_archive           = true;
            $q->is_page              = true;

            // Remove post type archive name from front page title tag.
            add_filter( 'post_type_archive_title', '__return_empty_string', 5 );
        } elseif ( ! $q->is_post_type_archive( 'resume' ) && ! $q->is_tax( get_object_taxonomies( 'resume' ) ) ) {
            // Only apply to resume categories, the resume post archive, the resume page, and resume taxonomies.
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
        $q->set( 'front_wpjmr_query', 'resume_query' );
        $q->set( 'posts_per_page', $this->get_posts_per_page( $q->get( 'posts_per_page' ), true ) );
        $q->set( 'post_status', array( 'publish' ) );

        // Store reference to this query.
        self::$front_wpjmr_query = $q;
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
            global $front_wpjmr_search_keyword;
            $front_wpjmr_search_keyword = sanitize_text_field( $_GET['search_keywords'] );

            if ( ! empty( $front_wpjmr_search_keyword ) && strlen( $front_wpjmr_search_keyword ) >= apply_filters( 'resume_manager_get_resumes_keyword_length_threshold', 2 ) ) {
                $q->set( 's' , $front_wpjmr_search_keyword );
                add_filter( 'posts_search', 'front_get_resume_keyword_search' );
            }
        } elseif ( ! empty( $_GET['s'] ) ) {
            global $front_wpjmr_search_keyword;
            $front_wpjmr_search_keyword = sanitize_text_field( $_GET['s'] );

            if ( ! empty( $front_wpjmr_search_keyword ) && strlen( $front_wpjmr_search_keyword ) >= apply_filters( 'resume_manager_get_resumes_keyword_length_threshold', 2 ) ) {
                add_filter( 'posts_search', 'front_get_resume_keyword_search' );
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
        return array_filter( apply_filters( 'front_resumes_query_meta_query', $meta_query, $this ) );
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
            $operator   = 'all' === get_option( 'job_manager_resume_category_filter_type', 'all' ) && sizeof( $categories ) > 1 ? 'AND' : 'IN';
            $tax_query[] = array(
                'taxonomy'         => 'resume_category',
                'field'            => $field,
                'terms'            => array_values( $categories ),
                'include_children' => $operator !== 'AND' ,
                'operator'         => $operator
            );
        }

        return array_filter( apply_filters( 'front_resumes_query_tax_query', $tax_query, $this ) );
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

        return array_filter( apply_filters( 'front_resumes_query_date_query', $date_query, $this ) );
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
            $per_page = get_option( 'resume_manager_per_page' );
        }

        return absint( apply_filters( 'front_resumes_query_posts_per_page', $per_page ) );
    }

    /**
     * Return a meta query for filtering by location.
     *
     * @return array
     */
    private function search_location_filter_meta_query() {
        if ( ! empty( $_GET['search_location'] ) ) {
            $location_meta_keys = array( 'geolocation_formatted_address', '_candidate_location', 'geolocation_state_long' );
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
     * Returns an array of arguments for ordering resumes based on the selected values.
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
                    $orderby_value = apply_filters( 'front_resumes_default_catalog_orderby', 'date' );
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

        return apply_filters( 'front_resumes_get_catalog_ordering_args', $args );
    }

    /**
     * Get the main query which job queries ran against.
     *
     * @return array
     */
    public static function get_main_query() {
        return self::$front_wpjmr_query;
    }

    /**
     * Get the tax query which was used by the main query.
     *
     * @return array
     */
    public static function get_main_tax_query() {
        $tax_query = isset( self::$front_wpjmr_query->tax_query, self::$front_wpjmr_query->tax_query->queries ) ? self::$front_wpjmr_query->tax_query->queries : array();

        return $tax_query;
    }

    /**
     * Get the meta query which was used by the main query.
     *
     * @return array
     */
    public static function get_main_meta_query() {
        $args       = isset( self::$front_wpjmr_query->query_vars ) ? self::$front_wpjmr_query->query_vars : array();
        $meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

        return $meta_query;
    }

    /**
     * Get the date query which was used by the main query.
     *
     * @return array
     */
    public static function get_main_date_query() {
        $date_query = isset( self::$front_wpjmr_query->date_query, self::$front_wpjmr_query->date_query->queries ) ? self::$front_wpjmr_query->date_query->queries : array();

        return $date_query;
    }

    /**
     * Based on WP_Query::parse_search
     */
    public static function get_main_search_query_sql() {
        global $wpdb;

        $args         = isset( self::$front_wpjmr_query->query_vars ) ? self::$front_wpjmr_query->query_vars : array();
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
            $taxonomies     = front_wpjmr_get_all_taxonomies();

            if ( ! empty( $taxonomies ) ) {
                foreach ( $taxonomies as $tax ) {
                    $taxonomy = $tax['taxonomy'];
                    $filter_terms = ! empty( $_GET[ 'filter_' . $taxonomy ] ) ? explode( ',', front_clean( wp_unslash( $_GET[ 'filter_' . $taxonomy ] ) ) ) : array(); // WPCS: sanitization ok, input var ok, CSRF ok.

                    if ( empty( $filter_terms ) || ! taxonomy_exists( $taxonomy ) ) {
                        continue;
                    }

                    $query_type                                     = ! empty( $_GET[ 'query_type_' . $taxonomy ] ) && in_array( $_GET[ 'query_type_' . $taxonomy ], array( 'and', 'or' ), true ) ? front_clean( wp_unslash( $_GET[ 'query_type_' . $taxonomy ] ) ) : ''; // WPCS: sanitization ok, input var ok, CSRF ok.
                    self::$_chosen_taxonomies[ $taxonomy ]['terms'] = array_map( 'sanitize_title', $filter_terms ); // Ensures correct encoding.
                    self::$_chosen_taxonomies[ $taxonomy ]['query_type'] = $query_type ? $query_type : apply_filters( 'front_wpjmc_layered_nav_default_query_type', 'and' );
                }
            }
        }
        return self::$_chosen_taxonomies;
    }
}

$front_wpjmr_query = new Front_WPJMR_Query();

if ( ! function_exists( 'front_get_wpjmr_resume_listing_style' ) ) {
    function front_get_wpjmr_resume_listing_style() {
        $style = get_option( 'resume_manager_resumes_listing_style' ) ? get_option( 'resume_manager_resumes_listing_style' ) : 'grid';
        return apply_filters( 'front_get_wpjmr_resume_listing_style', $style );
    }
}

if ( ! function_exists( 'front_get_wpjmr_resume_listing_layout' ) ) {
    function front_get_wpjmr_resume_listing_layout() {
        $layout = get_option( 'resume_manager_resumes_listing_sidebar' ) && is_active_sidebar( 'sidebar-resume' )  ? get_option( 'resume_manager_resumes_listing_sidebar' ) : 'fullwidth';
        return apply_filters( 'front_get_wpjmr_resume_listing_layout', $layout );
    }
}

if ( ! function_exists( 'front_the_candidate_photo' ) ) {
    function front_the_candidate_photo( $size = 'thumbnail', $class = 'img-fluid', $default = null, $post = null, $echo =true ) {
        $logo = get_the_candidate_photo( $post );

        if ( $logo ) {

            if ( $size !== 'full' ) {
                $logo = job_manager_get_resized_image( $logo, $size );
            }

            $candidate_photo = '<img class="' . esc_attr( $class ) . '" src="' . $logo . '" alt="Photo" />';

        } elseif ( $default ) {
            $candidate_photo = '<img class="' . esc_attr( $class ) . '" src="' . $default . '" alt="Photo" />';
        } elseif ( apply_filters( 'front_enable_candidate_photo_default_text_placeholder', true ) ) {
            $title = get_the_title( $post );
            if( ! empty ( $title ) ) {
                $split = explode(" ", $title);
                $first_name = $split[0];
                $last_name = $split[count($split)-1];
            } else {
                $first_name = $title;
                $last_name = $title;
            }

            ob_start();
            ?>
            <span class="btn-icon__inner">
                <?php echo substr( $first_name, 0 , 1 ) . ( $first_name !== $last_name ? substr( $last_name, 0 , 1 ) : '' ); ?>
            </span>
            <?php
            $candidate_photo = ob_get_clean();
        } else
            $candidate_photo = '<img class="' . esc_attr( $class ) . '" src="' . apply_filters( 'resume_manager_default_candidate_photo', RESUME_MANAGER_PLUGIN_URL . '/assets/images/candidate.png' ) . '" alt="Logo" />';

        if( $echo ) {
            echo wp_kses_post( $candidate_photo );
        } else {
            return $candidate_photo;
        }
    }
}

if ( ! function_exists( 'front_wpjmr_resume_catalog_ordering' ) ) {
    function front_wpjmr_resume_catalog_ordering() {
        if ( ! front_wpjmr_get_loop_prop( 'is_paginated' ) || 0 >= front_wpjmr_get_loop_prop( 'total', 0 ) ) {
            return;
        }

        $catalog_orderby_options = apply_filters( 'front_resumes_catalog_orderby', array(
            'featured'   => esc_html__( 'Featured', 'front' ),
            'date'       => esc_html__( 'New Resume', 'front' ),
            'menu_order' => esc_html__( 'Menu Order', 'front' ),
            'title-asc'  => esc_html__( 'Name: Ascending', 'front' ),
            'title-desc' => esc_html__( 'Name: Descending', 'front' ),
        ) );

        $default_orderby = front_wpjmr_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'front_resumes_default_catalog_orderby', 'date' );
        $orderby         = isset( $_GET['orderby'] ) ? front_clean( wp_unslash( $_GET['orderby'] ) ) : $default_orderby; // WPCS: sanitization ok, input var ok, CSRF ok.

        if ( front_wpjmr_get_loop_prop( 'is_search' ) ) {
            $catalog_orderby_options = array_merge( array( 'relevance' => esc_html__( 'Relevance', 'front' ) ), $catalog_orderby_options );

            unset( $catalog_orderby_options['menu_order'] );
        }

        if ( ! array_key_exists( $orderby, $catalog_orderby_options ) ) {
            $orderby = current( array_keys( $catalog_orderby_options ) );
        }

        $current_page_query_args = Front_WPJMR::get_current_page_query_args();

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

if ( ! function_exists( 'front_resume_header_search_form' ) ) {
    /**
     * Display Resume/Candidate Header Search block
     */
    function front_resume_header_search_form( $args = array() ) {

        $defaults =  apply_filters( 'front_job_header_search_form_default_args', array(
            'keywords_title_text'       => esc_html__( 'what', 'front' ),
            'keywords_subtitle_text'    => esc_html__( 'candidate name, position or keywords', 'front' ),
            'keywords_placeholder_text' => esc_html__( 'Keyword or name', 'front' ),
            'location_title_text'       => esc_html__( 'where', 'front' ),
            'location_subtitle_text'    => esc_html__( 'city, state, or zip code', 'front' ),
            'location_placeholder_text' => esc_html__( 'City, state, or zip', 'front' ),
            'category_title_text'       => esc_html__( 'which', 'front' ),
            'category_subtitle_text'    => esc_html__( 'department, industry, or specialism', 'front' ),
            'category_placeholder_text' => esc_html__( 'All Category', 'front' ),
            'search_button_text'        => esc_html__( 'Find Candidate', 'front' ),
        ) );

        $args = wp_parse_args( $args, $defaults );

        extract( $args );

        $current_page_url = Front_WPJMR::get_current_page_url();
        $current_page_query_args = Front_WPJMR::get_current_page_query_args();

        ?>
        <div class="resume-filters bg-light">
            <div class="container space-1">
                <!-- Search Jobs Form -->
                <form class="resume_filters" action="<?php echo esc_attr( $current_page_url ); ?>">
                    <?php do_action( 'resume_manager_resume_header_search_block_start' ); ?>
                    <div class="search_resumes row mb-2">
                        <?php do_action( 'resume_manager_resume_header_search_block_search_resumes_start' ); ?>

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

                        <?php do_action( 'resume_manager_resume_header_search_block_search_resumes_end' ); ?>
                    </div>
                    <?php do_action( 'resume_manager_resume_header_search_block_end' ); ?>
                    <!-- End Checkbox -->
                </form>
                <!-- End Search Jobs Form -->
            </div>
        </div>
        <?php
    }
}

// if ( ! function_exists( 'front_submit_resume_form_login_url' ) ) {
//     function front_submit_resume_form_login_url( $login_page_url ) {

//         if ( ! empty( front_get_register_login_form_page() ) ) {
//             $login_page_url = get_permalink( front_get_register_login_form_page() ) . '#front-login-tab-content';
//         }

//         return $login_page_url;
//     }
// }

// add_filter( 'submit_resume_form_login_url', 'front_submit_resume_form_login_url' );
