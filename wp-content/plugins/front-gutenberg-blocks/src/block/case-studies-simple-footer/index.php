<?php
/**
 * Server-side rendering of the `fgb/case-studies-simple-footer` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/case-studies-simple-footer` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest portfolio added.
 */
if ( ! function_exists( 'frontgb_render_case_studies_simple_footer_block' ) ) {
    function frontgb_render_case_studies_simple_footer_block( $attributes ) {
        $recent_posts = wp_get_recent_posts(
            array(
                'post_type'   => 'jetpack-portfolio', 
                'numberposts' => 2,
                'post_status' => 'publish',
                'order'       => ! empty( $attributes['order'] ) ? $attributes['order'] : '',
                'orderby'     => ! empty( $attributes['orderBy'] ) ? $attributes['orderBy'] : '',
                'include'     => ( ! empty( $attributes['posts'] ) && is_array($attributes['posts']) ) ? array_column($attributes['posts'], 'id') : '',
            )
        );

        $posts_markup = '';
        $props = array( 'attributes' => array() );

        foreach ( $recent_posts as $index => $post ) {
            $post_id = $post['ID'];

            // Portfolio Title
            $portfolio_title = get_the_title( $post_id );

            // Portfolio Featured Image
            $portfolio_image = get_the_post_thumbnail_url( $post_id, 'full' );

            // Portfolio Link
            $portfolio_link = get_permalink( $post_id );

            // Portfolio Order
            $portfolio_order = ' order-' . ( $index == 0 ? '1' : '3' );

            // Portfolio Overlay
            $portfolio_overlay = $index == 0 ? ' gradient-overlay-half-primary-v2' : ' gradient-overlay-half-primary-v1' ;

            // Portfolio Arrow
            $portfolio_arrow = ' fa-arrow-' . ( $index == 0 ? 'left' : 'right' ) . ' u-paging-modern__arrow-icon-' . ( $index == 0 ? 'prev' : 'next' );

            // Portfolio Title Align 
            $portfolio_text_align = $index == 0 ? ' text-right' : '';

            // Portfolio Content Align 
            $portfolio_content_align = $index == 0 ? ' text-right' : '';

            // Portfolio Arrow Content 
            $portfolio_arrow_content = '<span class="fas' . esc_attr( $portfolio_arrow ) . ' text-warning"></span>';

            $post_markup  = '<a class="col-sm-5' . esc_attr( $portfolio_order ) . ' u-paging-modern' . esc_attr( $portfolio_overlay ) . ' bg-img-hero space-1 space-sm-3' . esc_attr( $portfolio_text_align ) . '" href="' . esc_url( $portfolio_link ) . '" style="background-image: url(' . esc_url( $portfolio_image ) . ')">';
            $post_markup .= '<div class="px-7">';
            $post_markup .= '<span class="text-warning">' . esc_html( $index == 0 ? $attributes['prevText'] : $attributes['nextText'] ) . '</span>';
            $post_markup .= '<div class="d-flex justify-content-between align-items-center">';
            if ( $index == 0 ) {
                $post_markup .= wp_kses_post( $portfolio_arrow_content );
            }
            $post_markup .= '<h2 class="text-white font-weight-semi-bold mb-0">' . esc_html( $portfolio_title ) . '</h2>';
            if ( $index != 0 ) {
                $post_markup .= wp_kses_post( $portfolio_arrow_content );
            }
            $post_markup .= '</div>';
            $post_markup .= '</div>';
            $post_markup .= '</a>';

            $posts_markup .= $post_markup;                  
        }

        // Portfolio Arrow Content 
        $portfolio_additional_class = ! empty( $attributes['className'] ) ? $attributes['className'] . ' ' : '';

        $block_content  = '<nav class="' . esc_attr( $portfolio_additional_class ) . 'clearfix">';
        $block_content .= '<div class="row no-gutters">';
        $block_content .= wp_kses_post( $posts_markup );
        $block_content .= '<a class="col-sm-2 order-2 u-paging-modern-view-all space-1 space-sm-3" href="' . get_post_type_archive_link( 'jetpack-portfolio' ) . '">';
        $block_content .= '<span class="fas fa-th u-paging-modern-view-all__icon"></span>';
        $block_content .= esc_html( $attributes['viewAllText'] );
        $block_content .= '</a>';
        $block_content .= '</div>';
        $block_content .= '</nav>';

        if ( ! post_type_exists( 'jetpack-portfolio' ) ) {
            $block_alert = esc_html__( 'Portfolio post type is not available', FRONTGB_I18N );
        } else {
            $block_alert = esc_html__( 'Portfolio projects is empty', FRONTGB_I18N );
        }

        return ( 
            ( post_type_exists( 'jetpack-portfolio' ) && ! empty( $recent_posts ) ) 
            ? 
            $block_content 
            : 
            '<div class="container space-2">
                <p class="text-danger text-center font-size-2 mb-0">'
                . esc_html( $block_alert ) . 
                '</p>
            </div>'
        );
    }
}


if ( ! function_exists( 'frontgb_register_case_studies_simple_footer_block' ) ) {
    /**
     * Registers the `fgb/case-studies-simple-footer` block on server.
     */
    function frontgb_register_case_studies_simple_footer_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/case-studies-simple-footer',
            array(
                'attributes' => array(
                    'order' => array(
                        'type' => 'string',
                        'default' => 'desc',
                    ),
                    'orderBy' => array(
                        'type' => 'string',
                        'default' => 'date',
                    ),
                    'viewAllText' => array(
                        'type' => 'string',
                        'default' => 'View All',
                    ),
                    'prevText' => array(
                        'type' => 'string',
                        'default' => 'Prev',
                    ),
                    'nextText' => array(
                        'type' => 'string',
                        'default' => 'Next',
                    ),
                    'posts'=> array(
                        'type' => 'array',
                        'items' => array(
                          'type' => 'object'
                        ),
                        'default' => [],
                    ),
                    'className' => array(
                        'type' => 'string',
                    ),
                ),
                
                'render_callback' => 'frontgb_render_case_studies_simple_footer_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_case_studies_simple_footer_block' );
}