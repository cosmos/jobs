<?php
/**
 * Layered nav widget
 *
 * @package Widgets
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Widget layered nav class.
 */
class Front_WPJMR_Widget_Layered_Nav extends WP_Widget {

    /**
     * Constructor.
     */
    public function __construct() {
        $widget_ops = array( 'description' => esc_html__( 'Add resume filter widgets to your sidebar.', 'front-extensions' ) );
        parent::__construct( 'front_wpjmr_layered_nav', esc_html__( 'Front Filter Resume by Taxonomy', 'front-extensions' ), $widget_ops );
    }

    /**
     * Updates a particular instance of a widget.
     *
     * @see WP_Widget->update
     *
     * @param array $new_instance New Instance.
     * @param array $old_instance Old Instance.
     *
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        if ( ! empty( $new_instance['title'] ) ) {
            $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
        }
        if ( ! empty( $new_instance['taxonomy'] ) ) {
            $instance['taxonomy'] = $new_instance['taxonomy'];
        }
        if ( ! empty( $new_instance['query_type'] ) ) {
            $instance['query_type'] = $new_instance['query_type'];
        }
        return $instance;
    }

    /**
     * Outputs the settings update form.
     *
     * @see WP_Widget->form
     *
     * @param array $instance Instance.
     */
    public function form( $instance ) {
        global $wp_registered_sidebars;

        $taxonomy_array = front_wpjmr_get_all_taxonomies();
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $taxonomy = isset( $instance['taxonomy'] ) ? $instance['taxonomy'] : '';
        $query_type = isset( $instance['query_type'] ) ? $instance['query_type'] : 'and';

        // If no sidebars exists.
        if ( !$wp_registered_sidebars ) {
            echo '<p>'. esc_html__('No sidebars are available.', 'front-extensions' ) .'</p>';
            return;
        }
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title:', 'front-extensions' ) ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>"><?php esc_html_e( 'Taxonomy:', 'front-extensions' ); ?></label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'taxonomy' ) ); ?>">
                <option value=""><?php esc_html_e( '&mdash; Select &mdash;', 'front-extensions' ); ?></option>
                <?php foreach ( $taxonomy_array as $tax ) : ?>
                    <option value="<?php echo esc_attr( $tax['taxonomy'] ); ?>" <?php selected( $taxonomy, $tax['taxonomy'] ); ?>>
                        <?php echo esc_html( $tax['name'] ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'query_type' ) ); ?>"><?php esc_html_e( 'Query type:', 'front-extensions' ); ?></label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'query_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'query_type' ) ); ?>">
                <option value="and" <?php selected( $query_type, 'and' ); ?>><?php echo esc_html__( 'AND', 'front-extensions' ); ?></option>
                <option value="or" <?php selected( $query_type, 'or' ); ?>><?php echo esc_html__( 'OR', 'front-extensions' ); ?></option>
            </select>
        </p>
        <?php
    }

    /**
     * Output widget.
     *
     * @see WP_Widget
     *
     * @param array $args Arguments.
     * @param array $instance Instance.
     */
    public function widget( $args, $instance ) {
        if ( ! ( is_post_type_archive( 'resume' ) || is_page( front_wpjmr_get_page_id( 'resume' ) ) ) && ! front_is_resume_taxonomy() ) {
            return;
        }

        $_chosen_taxonomies = Front_WPJMR_Query::get_layered_nav_chosen_taxonomies();
        $title              = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Filter by', 'front-extensions' );
        $taxonomy           = isset( $instance['taxonomy'] ) ? $instance['taxonomy'] : '';
        $query_type         = isset( $instance['query_type'] ) ? $instance['query_type'] : 'and';

        if ( ! taxonomy_exists( $taxonomy ) ) {
            return;
        }

        $get_terms_args = apply_filters( 'front_wpjmr_layered_nav_terms_args', array( 'hide_empty' => '1' ) );

        $terms = get_terms( $taxonomy, $get_terms_args );

        if ( 0 === count( $terms ) ) {
            return;
        }

        ob_start();

        echo wp_kses_post( $args['before_widget'] );

        if ( ! empty($instance['title']) ) {
            echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
        }

        $found = $this->layered_nav_list( $terms, $taxonomy, $query_type );

        echo wp_kses_post( $args['after_widget'] );

        // Force found when option is selected - do not force found on taxonomy taxonomies.
        if ( ! is_tax() && is_array( $_chosen_taxonomies ) && array_key_exists( $taxonomy, $_chosen_taxonomies ) ) {
            $found = true;
        }

        if ( ! $found ) {
            ob_end_clean();
        } else {
            echo ob_get_clean(); // @codingStandardsIgnoreLine
        }
    }

    /**
     * Return the currently viewed taxonomy name.
     *
     * @return string
     */
    protected function get_current_taxonomy() {
        return is_tax() ? get_queried_object()->taxonomy : '';
    }

    /**
     * Return the currently viewed term ID.
     *
     * @return int
     */
    protected function get_current_term_id() {
        return absint( is_tax() ? get_queried_object()->term_id : 0 );
    }

    /**
     * Return the currently viewed term slug.
     *
     * @return int
     */
    protected function get_current_term_slug() {
        return absint( is_tax() ? get_queried_object()->slug : 0 );
    }

    /**
     * Count resumes within certain terms, taking the main WP query into consideration.
     *
     * This query allows counts to be generated based on the viewed resumes, not all resumes.
     *
     * @param  array  $term_ids Term IDs.
     * @param  string $taxonomy Taxonomy.
     * @param  string $query_type Query Type.
     * @return array
     */
    protected function get_filtered_term_resume_counts( $term_ids, $taxonomy, $query_type ) {
        global $wpdb;

        $tax_query  = Front_WPJMR_Query::get_main_tax_query();
        $meta_query = Front_WPJMR_Query::get_main_meta_query();
        $date_query = Front_WPJMR_Query::get_main_date_query();

        if ( 'or' === $query_type ) {
            foreach ( $tax_query as $key => $query ) {
                if ( is_array( $query ) && $taxonomy === $query['taxonomy'] ) {
                    unset( $tax_query[ $key ] );
                }
            }
        }

        $meta_query     = new WP_Meta_Query( $meta_query );
        $date_query     = new WP_Date_Query( $date_query );
        $tax_query      = new WP_Tax_Query( $tax_query );
        $meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
        $date_query_sql = $date_query->get_sql( $wpdb->posts, 'ID' );
        $tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

        if ( 0 === intval( get_option( 'resume_manager_hide_expired', get_option( 'resume_manager_hide_expired_content', 1 ) ) ) ) {
            $post_status = array( 'publish', 'expired' );
        } else {
            $post_status = array( 'publish' );
        }

        // Generate query.
        $query           = array();
        $query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
        $query['from']   = "FROM {$wpdb->posts}";
        $query['join']   = "
            INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
            INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
            INNER JOIN {$wpdb->terms} AS terms USING( term_id )
            " . $tax_query_sql['join'] . $meta_query_sql['join'];

        $query['where'] = "
            WHERE {$wpdb->posts}.post_type IN ( 'resume' )
            AND {$wpdb->posts}.post_status IN ('" . implode( "','", $post_status ) . "') "
            . $tax_query_sql['where'] . $meta_query_sql['where'] . $date_query_sql .
            'AND terms.term_id IN (' . implode( ',', array_map( 'absint', $term_ids ) ) . ')';

        $search = Front_WPJMR_Query::get_main_search_query_sql();
        if ( $search ) {
            $query['where'] .= ' AND ' . $search;
        }

        $query['group_by'] = 'GROUP BY terms.term_id';
        $query             = apply_filters( 'front_wpjmr_get_filtered_term_resume_counts_query', $query );
        $query             = implode( ' ', $query );

        // We have a query - let's see if cached results of this query already exist.
        $query_hash    = md5( $query );

        // Maybe store a transient of the count values.
        $cache = apply_filters( 'front_wpjmr_layered_nav_count_maybe_cache', true );
        if ( true === $cache ) {
            $cached_counts = (array) get_transient( 'front_wpjmr_layered_nav_counts_' . $taxonomy );
        } else {
            $cached_counts = array();
        }

        if ( ! isset( $cached_counts[ $query_hash ] ) ) {
            $results                      = $wpdb->get_results( $query, ARRAY_A ); // @codingStandardsIgnoreLine
            $counts                       = array_map( 'absint', wp_list_pluck( $results, 'term_count', 'term_count_id' ) );
            $cached_counts[ $query_hash ] = $counts;
            if ( true === $cache ) {
                set_transient( 'front_wpjmr_layered_nav_counts_' . $taxonomy, $cached_counts, DAY_IN_SECONDS );
            }
        }

        return array_map( 'absint', (array) $cached_counts[ $query_hash ] );
    }

    /**
     * Show list based layered nav.
     *
     * @param  array  $terms Terms.
     * @param  string $taxonomy Taxonomy.
     * @param  string $query_type Query Type.
     * @return bool   Will nav display?
     */
    protected function layered_nav_list( $terms, $taxonomy, $query_type ) {
        // List display.
        echo '<div class="front-wpjmr-widget-layered-nav-list tax-' . esc_attr( $taxonomy ) . '">';

        $term_counts        = $this->get_filtered_term_resume_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
        $_chosen_taxonomies = Front_WPJMR_Query::get_layered_nav_chosen_taxonomies();
        $found              = false;
        $tax_uniqid         = $taxonomy . '-' . uniqid();
        $i                  = 0;

        foreach ( $terms as $term ) {
            $current_values = isset( $_chosen_taxonomies[ $taxonomy ]['terms'] ) ? $_chosen_taxonomies[ $taxonomy ]['terms'] : array();
            $option_is_set  = in_array( $term->slug, $current_values, true );
            $count          = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;

            // Skip the term for the current archive.
            if ( $this->get_current_term_id() === $term->term_id ) {
                continue;
            }

            // Only show options with count > 0.
            if ( 0 < $count ) {
                $found = true;
            } elseif ( 0 === $count && ! $option_is_set ) {
                continue;
            }

            $filter_name    = 'filter_' . sanitize_title( $taxonomy );
            $current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', front_clean( wp_unslash( $_GET[ $filter_name ] ) ) ) : array(); // WPCS: input var ok, CSRF ok.
            $current_filter = array_map( 'sanitize_title', $current_filter );

            if ( ! in_array( $term->slug, $current_filter, true ) ) {
                $current_filter[] = $term->slug;
            }

            $link = remove_query_arg( $filter_name, Front_WPJMR::get_current_page_url() );

            // Add current filters to URL.
            foreach ( $current_filter as $key => $value ) {
                // Exclude query arg for current term archive term.
                if ( $value === $this->get_current_term_slug() ) {
                    unset( $current_filter[ $key ] );
                }

                // Exclude self so filter can be unset on click.
                if ( $option_is_set && $value === $term->slug ) {
                    unset( $current_filter[ $key ] );
                }
            }

            if ( ! empty( $current_filter ) ) {
                asort( $current_filter );
                $link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );

                // Add Query type Arg to URL.
                if ( 'or' === $query_type && ! ( 1 === count( $current_filter ) && $option_is_set ) ) {
                    $link = add_query_arg( 'query_type_' . sanitize_title( $taxonomy ), 'or', $link );
                }
                $link = str_replace( '%2C', ',', $link );
            }

            $show_hide_limit = apply_filters( "front_wpjmr_layered_nav_show_hide_limit_{$taxonomy}", 4 );

            $count_html = apply_filters( 'front_wpjmr_layered_nav_count', '<small class="count">' . absint( $count ) . '</small>', $count, $term );

            if ( $count > 0 || $option_is_set ) {
                $term_uniqid = $term->slug . '-' . uniqid();
                $link      = esc_url( apply_filters( 'front_wpjmr_layered_nav_link', $link, $term, $taxonomy ) );
                $term_html = '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="' . esc_attr( $term_uniqid ) . '" ' . esc_attr( $option_is_set ? 'checked' : '' ) . '><a class="custom-control-label d-inline-block text-secondary" rel="nofollow" href="' . esc_url( $link ) . '">'  . esc_html( $term->name ) . '</a></div>' . $count_html;
            } else {
                $link      = false;
                $term_html = '<span>' . esc_html( $term->name ) . '</span>';
            }

            if ( $i == $show_hide_limit ) :
                echo '<div class="collapse" id="' . esc_attr( $tax_uniqid ) . '">';
            endif;

            echo '<div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-2 front-wpjmr-widget-layered-nav-list__item front-wpjmr-layered-nav-term">';
            echo apply_filters( 'front_wpjmr_layered_nav_term_html', $term_html, $term, $link, $count );
            echo '</div>';

            if ( $i >= $show_hide_limit && $i == ( count( $terms ) - 1 ) ) :
                echo '</div><a class="link link-collapse small font-size-1 collapsed" data-toggle="collapse" href="#' . esc_attr( $tax_uniqid ) . '" role="button" aria-expanded="false" aria-controls="' . esc_attr( $tax_uniqid ) . '"><span class="link-collapse__default">' . esc_html__( 'View more', 'front-extensions' ) . '</span><span class="link-collapse__active">' . esc_html__( 'View less', 'front-extensions' ) . '</span><span class="link__icon ml-1"><span class="link__icon-inner">+</span></span></a>';
            endif;
            $i++;
        }

        echo '</div>';

        return $found;
    }
}
