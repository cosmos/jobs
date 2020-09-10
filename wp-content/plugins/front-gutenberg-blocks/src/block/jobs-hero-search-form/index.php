<?php
/**
 * Server-side rendering of the `fgb/jobs-hero-search-form` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the `fgb/jobs-hero-search-form` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_jobs_search_form_block' ) ) {
    function frontgb_render_jobs_search_form_block( $attributes ) {

        if ( function_exists( 'front_is_wp_job_manager_activated' ) && ! front_is_wp_job_manager_activated() ) {
            return '<p class="text-danger text-center font-size-2">' . __( 'WP Job Manager is not activated', FRONTGB_I18N ) . '</p>';
        }

        $attributes['current_page_url'] = function_exists( 'front_wpjm_get_page_id' ) ?  get_permalink( front_wpjm_get_page_id( 'jobs' ) ) : '';
        $attributes['background_color'] = 'bg-none';
        $attributes['enable_container'] = false;
        extract( $attributes );

        ob_start();
        ?>
        <div class="card border-0 mw-100 p-0 mt-0">
            <div class="card-body p-7">
                <?php front_job_header_search_form( $attributes ); ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

if ( ! function_exists( 'frontgb_register_jobs_hero_search_form_block' ) ) {
    /**
     * Registers the `fgb/jobs-hero-search-form` block on server.
     */
    function frontgb_register_jobs_hero_search_form_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/jobs-hero-search-form',
            array(
                'attributes' => array(
                    'keywords_title_text' => array(
                        'type'    => 'string',
                        'default' =>  __( 'what', FRONTGB_I18N ),
                    ),
                    'keywords_subtitle_text' => array(
                        'type'    => 'string',
                        'default' =>  __(  "job title, keywords, or company", FRONTGB_I18N ),
                    ),
                    'keywords_placeholder_text' => array(
                        'type'    => 'string',
                        'default' =>  __(  "Keyword or title", FRONTGB_I18N ),
                    ),
                    'location_title_text' => array(
                        'type'    => 'string',
                        'default' =>  __( 'where', FRONTGB_I18N ),
                    ),
                    'location_subtitle_text' => array(
                        'type'    => 'string',
                        'default' =>  __(  "city, state, or zip code", FRONTGB_I18N ),
                    ),
                    'location_placeholder_text' => array(
                        'type'    => 'string',
                        'default' =>  __(  "City, state, or zip", FRONTGB_I18N ),
                    ),
                    'search_button_text' => array(
                        'type'    => 'string',
                        'default' =>  __( "Find Jobs", FRONTGB_I18N ),
                    ),
                ),
                'render_callback' => 'frontgb_render_jobs_search_form_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_jobs_hero_search_form_block' );
}
