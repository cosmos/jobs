<?php
/**
 * Server-side rendering of the `fgb/companies-search-form` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the `fgb/companies-search-form` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_companies_search_form_block' ) ) {
    function frontgb_render_companies_search_form_block( $attributes ) {

        if ( function_exists( 'front_is_wp_job_manager_activated' ) && ! front_is_wp_job_manager_activated() ) {
            return '<p class="text-danger text-center font-size-2">' . __( 'WP Job Manager is not activated', FRONTGB_I18N ) . '</p>';
        } elseif ( function_exists( 'front_is_mas_wp_company_manager_activated' ) && ! front_is_mas_wp_company_manager_activated() ) {
            return '<p class="text-danger text-center font-size-2">' . __( 'MAS WP Job Manager Company is not activated', FRONTGB_I18N ) . '</p>';
        }

        $attributes['current_page_url'] = get_permalink( mas_wpjmc_get_page_id( 'companies' ) );
        $attributes['enable_container'] = false;
        $attributes['background_color'] = 'bg-none';
        extract( $attributes );

        ob_start();
        ?><div id="SVGfiles" class="position-relative z-index-2 d-flex flex-column justify-content-center <?php echo ( $attributes['enableBackgroundSVG'] !== false ) ? esc_attr( $background . ' min-height-300') : $background ?>"><?php
            if( $enableContainer ) {
                ?><div class="container space-2"><?php
            }
            if( $enableBlockPretitle || $enableBlockTitle ) {
                ?><div class="mb-7"><?php
                    if( $enableBlockPretitle ) {
                        ?><span class="d-block text-secondary"><?php echo esc_html( $blockPretitle ); ?></span><?php
                    }
                    if( $enableBlockTitle ) {
                        ?><h1 class="text-primary font-weight-semi-bold"><?php echo esc_html( $blockTitle ); ?></h1><?php
                    }
                ?></div><?php
            }
            front_companies_header_search_form( $attributes );
            if( $enableContainer ) {
                ?></div><?php
            }
            if ( $attributes['enableBackgroundSVG'] !== false ) : ?>
            <div class="d-none d-lg-block w-100 position-absolute bottom-0 right-0 max-width-27 z-index-n1">
                <figure class="ie-files">
                    <img class="js-svg-injector" src="<?php echo get_template_directory_uri() . '/assets/svg/illustrations/files.svg'; ?>" alt="Image Description"
               data-parent="#SVGfiles">
                </figure>
            </div>
            <?php endif;
        ?></div><?php
        return ob_get_clean();
    }
}

if ( ! function_exists( 'frontgb_register_companies_search_form_block' ) ) {
    /**
     * Registers the `fgb/companies-search-form` block on server.
     */
    function frontgb_register_companies_search_form_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/companies-search-form',
            array(
                'attributes' => array(
                    'enableContainer' => array(
                        'type'    => 'boolean',
                        'default' => true,
                    ),
                    'enableBlockPretitle' => array(
                        'type'    => 'boolean',
                        'default' => true,
                    ),
                    'enableBlockTitle' => array(
                        'type'    => 'boolean',
                        'default' => true,
                    ),
                    'enableBackgroundSVG' => array(
                        'type'    => 'boolean',
                        'default' => true,
                    ),
                    'blockPretitle' => array(
                        'type'    => 'string',
                        'default' =>  __( 'Get access to millions of company reviews', FRONTGB_I18N ),
                    ),
                    'blockTitle' => array(
                        'type'    => 'string',
                        'default' =>  __( 'Find great places to work', FRONTGB_I18N ),
                    ),
                    'background' => array(
                        'type'    => 'string',
                        'default' =>  'bg-light',
                    ),
                    'keywords_title_text' => array(
                        'type'    => 'string',
                        'default' =>  __( 'Company name or job title', FRONTGB_I18N ),
                    ),
                    'keywords_placeholder_text' => array(
                        'type'    => 'string',
                        'default' =>  __(  "Company or title", FRONTGB_I18N ),
                    ),
                    'location_title_text' => array(
                        'type'    => 'string',
                        'default' =>  __( 'City, state, or zip', FRONTGB_I18N ),
                    ),
                    'location_placeholder_text' => array(
                        'type'    => 'string',
                        'default' =>  __(  "City, state, or zip", FRONTGB_I18N ),
                    ),
                    'search_button_text' => array(
                        'type'    => 'string',
                        'default' =>  __( "Search", FRONTGB_I18N ),
                    ),
                ),
                'render_callback' => 'frontgb_render_companies_search_form_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_companies_search_form_block' );
}
