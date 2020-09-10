<?php
/**
 * Server-side rendering of the `fgb/jobs-content` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the `fgb/jobs-content` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_jobs_content_block' ) ) {
    function frontgb_render_jobs_content_block( $attributes ) {

        if ( function_exists( 'front_is_wp_job_manager_activated' ) && ! front_is_wp_job_manager_activated() ) {
            return '<p class="text-danger text-center font-size-2">' . __( 'WP Job Manager is not activated', FRONTGB_I18N ) . '</p>';
        }

        extract( $attributes );

        add_filter( 'front_job_search_filters_multi_select', '__return_false' );

        $shortcode_atts['featured'] = ! empty( $shortcode_atts['featured'] ) ? $shortcode_atts['featured'] : null;

        return front_do_shortcode( 'jobs', $shortcode_atts );
    }
}

if ( ! function_exists( 'front_modify_job_manager_get_listings_result' ) ) {
    function front_modify_job_manager_get_listings_result( $result, $jobs ) {
        front_pr( $result );
        $result['showing'] = sprintf( _n( '%d Open Position.', '%d Open Positions.', $jobs->found_posts, FRONTGB_I18N ), $jobs->found_posts );
        front_pr( $result );

        return $result;
    }
}

if ( ! function_exists( 'frontgb_register_jobs_content_block' ) ) {
    /**
     * Registers the `fgb/jobs-content` block on server.
     */
    function frontgb_register_jobs_content_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/jobs-content',
            array(
                'attributes' => array(
                    'shortcode_atts'=> array(
                        'type'      => 'object',
                        'default'   => array(
                            'per_page'      => 9,
                            'orderby'       => 'date',
                            'order'         => 'DESC',
                            'view'          => 'grid',
                            'columns'       => 3,
                            'show_more'     => true,
                            'show_filters'  => false,
                        ),
                    ),
                    'job_category'  => array(
                        'type'      => 'boolean',
                        'default'   => get_option( 'job_manager_enable_categories' ),
                    ),
                    'job_type'      => array(
                        'type'      => 'boolean',
                        'default'   => get_option( 'job_manager_enable_types' ),
                    ),
                ),
                'render_callback' => 'frontgb_render_jobs_content_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_jobs_content_block' );
}
