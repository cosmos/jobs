<?php
/**
 * Creates a resume location search widget
 *
 * @class       Front_WPJMR_Widget_Resume_Location_Search
 * @version     1.0.0
 * @package     Widgets
 * @category    Class
 * @author      MadrasThemes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if( class_exists( 'WP_Widget' ) ) :
    /**
     * Front resume search widget class
     *
     * @since 1.0.0
     */
    class Front_WPJMR_Widget_Resume_Location_Search extends WP_Widget {

        public function __construct() {
            $widget_ops = array( 'description' => esc_html__( 'Add resume location search widgets to your sidebar.', 'front-extensions' ) );
            parent::__construct( 'front_wpjmr_location_search', esc_html__( 'Front Resume Location Search', 'front-extensions' ), $widget_ops );
        }

        public function widget($args, $instance) {

            $instance['title'] = apply_filters( 'front_wpjmr_location_search_widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

            echo wp_kses_post( $args['before_widget'] );

            if ( ! empty($instance['title']) ) {
                echo wp_kses_post( $args['before_title'] . $instance['title'] . $args['after_title'] );
            }

            $link = $this->get_current_page_url();
            $query_vars = Front_WPJMR::get_current_page_query_args();
            $value = isset( $_GET['search_location'] ) ? front_clean( wp_unslash( $_GET['search_location'] ) ) : '';
            ?>
            <form method="get" class="front-wpjmr-location-search" action="<?php echo esc_url( $link ); ?>">
                <div class="js-focus-state">
                    <div class="input-group">
                        <input type="text" name="search_location" id="<?php echo esc_attr( $args['widget_id'] ); ?>-location-field" class="form-control" placeholder="<?php echo esc_html__( 'City, state, or zip', 'front-extensions' ); ?>" aria-label="<?php echo esc_html__( 'Locations', 'front-extensions' ); ?>" aria-describedby="locationInputAddon-<?php echo esc_attr( $args['widget_id'] ); ?>" value="<?php echo esc_attr( $value ); ?>" />
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text">
                                <span class="fas fa-map-marker-alt" id="locationInputAddon-<?php echo esc_attr( $args['widget_id'] ); ?>"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <?php 
                    if( ! array_key_exists( 'search_keywords', $query_vars ) ) {
                        echo '<input type="hidden" name="search_keywords" value=""/>';
                    }

                    foreach( $query_vars as $key => $value ) {
                        if( $key !== 'search_location' ) {
                            echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '"/>';
                        }
                    }

                    if( ! array_key_exists( 'post_type', $query_vars ) ) {
                        echo '<input type="hidden" name="post_type" value="resume"/>';
                    }
                ?>
            </form>
            <?php

            echo wp_kses_post( $args['after_widget'] );
        }

        public function update( $new_instance, $old_instance ) {
            $instance = array();
            if ( ! empty( $new_instance['title'] ) ) {
                $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
            }
            return $instance;
        }

        public function form( $instance ) {
            global $wp_registered_sidebars;

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
         * Get current page URL.
         *
         * @return string
         * @since  3.3.0
         */
        protected function get_current_page_url() {
            if ( defined( 'RESUMES_IS_ON_FRONT' ) ) {
                $link = home_url( '/' );
            } elseif( front_is_resume_taxonomy() ) {
                $queried_object = get_queried_object();
                $link = get_term_link( $queried_object->slug, $queried_object->taxonomy );
            } else {
                $link = get_permalink( front_wpjmr_get_page_id( 'resume' ) );
            }

            return $link;
        }
    }
endif;