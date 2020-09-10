<?php
/**
 * Layered nav widget
 *
 * @package Widgets
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Widget campany name class.
 */
class Front_WPJM_Widget_Company_Name extends WP_Widget {

    /**
     * Constructor.
     */
    public function __construct() {
        $widget_ops = array( 'description' => esc_html__( 'Add company name filter widgets to your sidebar.', 'front-extensions' ) );
        parent::__construct( 'front_wpjm_company_name', esc_html__( 'Front Filter Job by Company Name', 'front-extensions' ), $widget_ops );
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
        $company_names = array();

        // Hide Expired jobs
        if ( 0 === intval( get_option( 'job_manager_hide_expired', get_option( 'job_manager_hide_expired_content', 1 ) ) ) ) {
            $post_status = array( 'publish', 'expired' );
        } else {
            $post_status = array( 'publish' );
        }

        $query_args['post_type']    = 'job_listing';
        $query_args['post_status']  = $post_status;
        $query_args['numberposts']  = -1;

        $jobs = get_posts( $query_args );

        foreach( $jobs as $key => $job ) {
            $name = get_post_meta( $job->ID, '_company_name', true );
            $sanitize_name = sanitize_title( $name );
            if( ! array_key_exists( $sanitize_name, $company_names ) ) {
                $company_names[$sanitize_name] = array(
                    'name' => $name,
                    'count'=> 0,
                );
            }
        }

        $query_args['tax_query']    = Front_WPJM_Query::get_main_tax_query();
        $query_args['meta_query']   = Front_WPJM_Query::get_main_meta_query();
        $query_args['date_query']   = Front_WPJM_Query::get_main_date_query();

        if( array_key_exists( 'company_name_filter', $query_args['meta_query'] ) ) {
            unset( $query_args['meta_query']['company_name_filter'] );
        }

        $search = Front_WPJM_Query::get_main_search_query_sql();

        if( ! $search ) {
            $jobs = get_posts( $query_args );
            foreach( $jobs as $key => $job ) {
                $name = get_post_meta( $job->ID, '_company_name', true );
                $sanitize_name = sanitize_title( $name );
                if( array_key_exists( $sanitize_name, $company_names ) ) {
                    $company_names[$sanitize_name]['count'] = $company_names[$sanitize_name]['count'] + 1;
                }
            }
        }

        ob_start();

        echo wp_kses_post( $args['before_widget'] );

        if ( ! empty($instance['title']) ) {
            echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
        }

        $found = $this->layered_nav_list( $company_names );

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
     * @param  array  $company_names.
     *
     */
    protected function layered_nav_list( $company_names ) {
        // List display.
        echo '<div class="front-wpjm-widget-layered-nav-list company-name">';

        $widget_uniqid  = "company_name-{uniqid()}";
        $found          = false;
        $i              = 0;
        $show_hide_limit = apply_filters( "front_wpjm_layered_nav_show_hide_limit_company_name", 4 );

        foreach ( $company_names as $sanitize_name => $company_name ) {
            $filter_name    = 'company_name';
            $current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', front_clean( wp_unslash( $_GET[ $filter_name ] ) ) ) : array();
            $option_is_set  = in_array( $company_name['name'], $current_filter, true );
            $count          = isset( $company_name['count'] ) ? $company_name['count'] : 0;

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

            if ( ! in_array( $company_name['name'], $current_filter, true ) ) {
                $current_filter[] = $company_name['name'];
            }

            $link = remove_query_arg( $filter_name, Front_WPJM::get_current_page_url() );

            // Add current filters to URL.
            foreach ( $current_filter as $key => $value ) {
                // Exclude self so filter can be unset on click.
                if ( $option_is_set && $value === $company_name['name'] ) {
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
                $company_html = '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="' . esc_attr( $company_uniqid ) . '" ' . esc_attr( $option_is_set ? 'checked' : '' ) . '><a for="' . esc_attr( $company_uniqid ) . '" class="custom-control-label d-inline-block text-secondary" rel="nofollow" href="' . esc_url( $link ) . '">'  . esc_html( $company_name['name'] ) . '</a></div>' . $count_html;
            } else {
                $link      = false;
                $company_html = '<span>' . esc_html( $company_name['name'] ) . '</span>';
            }

            if ( $i == $show_hide_limit ) :
                echo '<div class="collapse" id="' . esc_attr( $widget_uniqid ) . '">';
            endif;

            echo '<div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-2 front-wpjm-widget-layered-nav-list__item front-wpjm-layered-nav-company-name">';
            echo apply_filters( 'front_wpjm_layered_nav_company_html', $company_html, $company_name['count'], $link, $count );
            echo '</div>';

            if ( $i >= $show_hide_limit && $i == ( count( $company_names ) - 1 ) ) :
                echo '</div><a class="link link-collapse small font-size-1 collapsed" data-toggle="collapse" href="#' . esc_attr( $widget_uniqid ) . '" role="button" aria-expanded="false" aria-controls="' . esc_attr( $widget_uniqid ) . '"><span class="link-collapse__default">' . esc_html__( 'View more', 'front-extensions' ) . '</span><span class="link-collapse__active">' . esc_html__( 'View less', 'front-extensions' ) . '</span><span class="link__icon ml-1"><span class="link__icon-inner">+</span></span></a>';
            endif;
            $i++;
        }

        echo '</div>';

        return $found;
    }
}
