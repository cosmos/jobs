<?php
/**
 * Layered nav widget
 *
 * @package Widgets
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Widget campany id class.
 */
class Front_WPJM_Widget_Company_ID extends WP_Widget {

    /**
     * Constructor.
     */
    public function __construct() {
        $widget_ops = array( 'description' => esc_html__( 'Add company filter widgets to your sidebar.', 'front-extensions' ) );
        parent::__construct( 'front_wpjm_company_id', esc_html__( 'Front Filter Job by Company', 'front-extensions' ), $widget_ops );
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

        $taxonomy_array = front_wpjm_get_all_taxonomies();
        $title = isset( $instance['title'] ) ? $instance['title'] : '';

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
        if ( ! ( is_post_type_archive( 'job_listing' ) || is_page( front_wpjm_get_page_id( 'jobs' ) ) ) && ! front_is_job_listing_taxonomy() ) {
            return;
        }

        $title  = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Filter by', 'front-extensions' );
        $company_ids = array();

        $companies = get_posts( array( 'post_type' => 'company', 'post_status' => 'publish', 'numberposts' => -1 ) );

        foreach( $companies as $key => $company ) {
            $id = $company->ID;
            $name = $company->post_title;
            if( ! array_key_exists( $id, $company_ids ) ) {
                $company_ids[$id] = array(
                    'name' => $name,
                    'count'=> 0,
                );
            }
        }

        // Hide Expired jobs
        if ( 0 === intval( get_option( 'job_manager_hide_expired', get_option( 'job_manager_hide_expired_content', 1 ) ) ) ) {
            $post_status = array( 'publish', 'expired' );
        } else {
            $post_status = array( 'publish' );
        }

        $query_args['post_type']    = 'job_listing';
        $query_args['post_status']  = $post_status;
        $query_args['numberposts']  = -1;

        $query_args['tax_query']    = Front_WPJM_Query::get_main_tax_query();
        $query_args['meta_query']   = Front_WPJM_Query::get_main_meta_query();
        $query_args['date_query']   = Front_WPJM_Query::get_main_date_query();

        if( array_key_exists( 'company_id_filter', $query_args['meta_query'] ) ) {
            unset( $query_args['meta_query']['company_id_filter'] );
        }

        $search = Front_WPJM_Query::get_main_search_query_sql();

        if( ! $search ) {
            $jobs = get_posts( $query_args );
            foreach( $jobs as $job ) {
                $id = get_post_meta( $job->ID, '_company_id', true );
                if( ( ! empty( $id ) ) && array_key_exists( $id, $company_ids ) ) {
                    $company_ids[$id]['count'] = $company_ids[$id]['count'] + 1;
                }
            }
        }

        ob_start();

        echo wp_kses_post( $args['before_widget'] );

        if ( ! empty($instance['title']) ) {
            echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
        }

        $found = $this->layered_nav_list( $company_ids );

        echo wp_kses_post( $args['after_widget'] );

        if ( ! $found ) {
            ob_end_clean();
        } else {
            echo ob_get_clean(); // @codingStandardsIgnoreLine
        }
    }

    /**
     * Show list based layered nav.
     *
     * @param  array  $company_ids.
     *
     */
    protected function layered_nav_list( $company_ids ) {

        // List display.
        echo '<div class="front-wpjm-widget-layered-nav-list company-id">';

        $widget_uniqid  = 'company_id-' . uniqid();
        $found          = false;
        $i              = 0;
        $show_hide_limit = apply_filters( "front_wpjm_layered_nav_show_hide_limit_company_name", 4 );

        foreach ( $company_ids as $company_id => $company ) {
            $filter_name    = 'company_id';
            $current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', front_clean( wp_unslash( $_GET[ $filter_name ] ) ) ) : array();
            $option_is_set  = in_array( $company_id, $current_filter );
            $count          = isset( $company['count'] ) ? $company['count'] : 0;

            // Only show options with count > 0.
            if ( 0 < $count ) {
                $found = true;
            } elseif ( 0 === $count && ! $option_is_set ) {
                if ( $i <= $show_hide_limit ) $show_hide_limit++;
                if ( $i >= $show_hide_limit && $i == ( count( $company_ids ) - 1 ) ) :
                    echo '</div><a class="link link-collapse small font-size-1 collapsed" data-toggle="collapse" href="#' . esc_attr( $widget_uniqid ) . '" role="button" aria-expanded="false" aria-controls="' . esc_attr( $widget_uniqid ) . '"><span class="link-collapse__default">' . esc_html__( 'View more', 'front-extensions' ) . '</span><span class="link-collapse__active">' . esc_html__( 'View less', 'front-extensions' ) . '</span><span class="link__icon ml-1"><span class="link__icon-inner">+</span></span></a>';
                endif;
                $i++;
                continue;
            }

            // WPCS: input var ok, CSRF ok.
            // $current_filter = array_map( 'sanitize_title', $current_filter );

            if ( ! in_array( $company_id, $current_filter ) ) {
                $current_filter[] = $company_id;
            }

            $link = remove_query_arg( $filter_name, Front_WPJM::get_current_page_url() );

            // Add current filters to URL.
            foreach ( $current_filter as $key => $value ) {
                // Exclude self so filter can be unset on click.
                if ( $option_is_set && $value == $company_id ) {
                    unset( $current_filter[ $key ] );
                }
            }

            if ( ! empty( $current_filter ) ) {
                asort( $current_filter );
                $link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );
                $link = str_replace( '%2C', ',', $link );
            }

            $count_html = apply_filters( 'front_wpjm_layered_nav_count', '<small class="count">' . absint( $count ) . '</small>', $count );

            if ( $count > 0 || $option_is_set ) {
                $company_uniqid = $key . '-' . uniqid();
                $link      = esc_url( apply_filters( 'front_wpjm_layered_nav_link', $link, $key ) );
                $company_html = '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="' . esc_attr( $company_uniqid ) . '" ' . esc_attr( $option_is_set ? 'checked' : '' ) . '><a class="custom-control-label d-inline-block text-secondary" rel="nofollow" href="' . esc_url( $link ) . '">'  . esc_html( $company['name'] ) . '</a></div>' . $count_html;
            } else {
                $link      = false;
                $company_html = '<span>' . esc_html( $company['name'] ) . '</span>';
            }

            if ( $i == $show_hide_limit ) :
                echo '<div class="collapse" id="' . esc_attr( $widget_uniqid ) . '">';
            endif;

            echo '<div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-2 front-wpjm-widget-layered-nav-list__item front-wpjm-layered-nav-company-name">';
            echo apply_filters( 'front_wpjm_layered_nav_company_html', $company_html, $company['count'], $link, $count );
            echo '</div>';

            if ( $i >= $show_hide_limit && $i == ( count( $company_ids ) - 1 ) ) :
                echo '</div><a class="link link-collapse small font-size-1 collapsed" data-toggle="collapse" href="#' . esc_attr( $widget_uniqid ) . '" role="button" aria-expanded="false" aria-controls="' . esc_attr( $widget_uniqid ) . '"><span class="link-collapse__default">' . esc_html__( 'View more', 'front-extensions' ) . '</span><span class="link-collapse__active">' . esc_html__( 'View less', 'front-extensions' ) . '</span><span class="link__icon ml-1"><span class="link__icon-inner">+</span></span></a>';
            endif;
            $i++;
        }

        echo '</div>';

        return $found;
    }
}
