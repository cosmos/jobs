<?php
/**
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'frontgb_testimonial_carousel_designs' ) ) {

    /**
     * Render the designs markup.
     *
     * @since 1.7
     */
    function frontgb_testimonial_carousel_designs( $markup, $design, $props ) {
        $attributes = $props['attributes'];

        if ( $design == 'style-2' ) {

            $markup = '<div class="js-slide">';
            if ( $attributes['displayQuote'] ){ 
                $markup .= '<figure class="mb-4">';
                $markup .= '<img class="js-svg-injector" src="' . esc_url( $attributes['align'] == 'right' ? $attributes['svg_quote1'] : $attributes['svg_quote2'] ) . '" alt="SVG"/>';
                $markup .= '</figure>';
            } 
            if ( $attributes['displayExcerpt'] ) {
                $markup .= '<blockquote class="h6 font-weight-normal text-lh-md mb-4">';
                $markup .= esc_html( $props['content'] );
                $markup .= '</blockquote>';
            }
            $markup .= '<div class="media">';
            if ( $attributes['displayAuthorImage'] ) {
                $markup .= '<div class="u-avatar mr-3">';
                $markup .= '<img class="img-fluid rounded-circle" src=' . esc_url( $props['featured_image'] ) . ' alt="' . esc_attr( get_the_title( $props['post_id'] ) ) . '"/>';
                $markup .= '</div>';
            }
            if ( $attributes['displayAuthor'] || $attributes['displayAuthorPosition'] ) {
                $markup .= '<div class="media-body">';
                if ( $attributes['displayAuthor'] ) {
                    $markup .= '<h4 class="h6 mb-0">' . esc_html( $props['author'] ) . '</h4>';
                }
                if ( $attributes['displayAuthorPosition'] ) {
                    $markup .= '<p class="' . esc_attr( $attributes['align'] == 'right' ? 'small text-white-70' : 'small' ) . '">';
                    $markup .= esc_html( $props['excerpt'] );
                    $markup .= '</p>';
                }
                $markup .= '</div>';
            }
            $markup .= "</div>";
            $markup .= "</div>";

            return $markup;
        }

        if ( $design == 'style-3' ) {

            $default_color = 'bg-primary';

            $cardclass = 'card border-0 text-white rounded-bottom-left-pill rounded-right-pill p-0 '; 
            $cardclass .= ( isset($attributes['bg_color']) ? $attributes['bg_color'] : $default_color );

            $styles = '';

            if ( ! empty($attributes['bg_cusomColor']) ) {
                $styles = 'background-color:' . $attributes['bg_cusomColor'];
            }

            $markup  = '<div class="js-slide py-1">';
            $markup .= '<div class="card border-0 rounded-top-left-pill rounded-right-pill mb-1 shadow-none p-0">';
            $markup .= '<div class="card-body py-3 px-4">';
            $markup .= '<div class="media align-items-center">';
            if ( $attributes['displayAuthorImage'] ) { 
                $markup .= '<div class="u-avatar mr-3">';
                $markup .= '<img class="img-fluid rounded-circle" src=' . esc_url( $props['featured_image'] ) . ' alt="' . esc_attr( get_the_title( $props['post_id'] ) ) . '"/>';
                $markup .= '</div>';
            }
            if ( $attributes['displayAuthor'] || $attributes['displayAuthorPosition'] ) {
            $markup .= '<div class="media-body">';
                if ( $attributes['displayAuthor'] ) {
                    $markup .= '<h2 class="h6 mb-0">' . esc_html( $props['author'] ) . '</h2>';
                }
                if ( $attributes['displayAuthorPosition'] ) {
                    $markup .= '<p class="small mb-0">' . esc_html( $props['excerpt'] ) . '</p>'; 
                }
            $markup .= '</div>';
            }
            $markup .= '</div>';
            $markup .= '</div>';
            $markup .= '</div>';
            $markup .= '<div class="' . esc_attr( $cardclass ) . '" style="' . esc_attr( $styles ) . '">' ;
            $markup .= '<div class="card-body p-4">';
            $markup .= '<div class="media">';
            if ( $attributes['displayQuote'] ) {
                $markup .= '<figure class="mr-3">';
                $markup .= '<img class="js-svg-injector" src="' . esc_url( $attributes['svg_quote3'] ) . '" alt="SVG"/>';
                $markup .= '</figure>';
            }
            if ( $attributes['displayExcerpt'] ) {
                $markup .= '<div class="media-body">';
                $markup .= '<blockquote class="mb-0">' . esc_html( $props['content'] ) . '</blockquote>';
                $markup .= '</div>';
            }
            $markup .= '</div>';
            $markup .= '</div>';
            $markup .= '</div>';
            $markup .= '</div>';

            return $markup;
        }


        if ( $design == 'style-4' ) {

            $markup  = '<div class="js-slide">';
            $markup .= '<div class="w-md-80 w-lg-60 text-center mx-auto">';
            if ( $attributes['displayExcerpt'] ) { 
                $markup .= '<blockquote class="h3 mb-5">' . esc_html( $props['content'] ) . '</blockquote>';
            }
            if ( $attributes['displayAuthor'] || $attributes['displayAuthorPosition'] ) {
                $markup .= '<h4 class="h6 text-muted">';
                if ( $attributes['displayAuthor'] ) { 
                    $markup .= esc_html( $props['author'] );
                }
                if ( $attributes['displayAuthor'] && $attributes['displayAuthorPosition'] && $props['author'] && $props['excerpt'] ) {
                    $markup .= ', ';
                }
                if ( $attributes['displayAuthorPosition'] ) {
                   $markup .= esc_html( $props['excerpt'] );
                }
                $markup .= '</h4>';
            }
            $markup .= '</div>';
            $markup .= '</div>';

            return $markup;
        }

        if ( $design == 'style-5' ) {

            $markup   = '<div class="js-slide">';
            $markup  .= '<div class="w-md-80 w-lg-60 text-center mx-auto">';
            if ( $attributes['displayExcerpt'] ) { 
                $markup .= '<blockquote class="h5 text-white font-weight-normal mb-4">' . esc_html( $props['content'] ) . '</blockquote>';
            }
            if ( $attributes['displayAuthor'] || $attributes['displayAuthorPosition'] ) {
                $markup .= '<h4 class="h6 text-white-70">';
                if ( $attributes['displayAuthor'] ) { 
                    $markup .= esc_html( $props['author'] );
                }
                if ( $attributes['displayAuthor'] && $attributes['displayAuthorPosition'] && $props['author'] && $props['excerpt'] ) {
                    $markup .= ', ';
                }
                if ( $attributes['displayAuthorPosition'] ) {
                   $markup .= esc_html( $props['excerpt'] );
                }
                $markup .= '</h4>';
            }
            $markup .= '</div>';
            $markup .= '</div>';

            return $markup;
        }

        if ( $design == 'style-6' ) {

            $markup  = '<div class="js-slide my-4">';
            $markup .= '<div class="u-slick-zoom__slide text-center">';
            $markup .= '<div class="card border-0 shadow-sm p-0 m-0">';
            if ( $attributes['displayExcerpt'] ) { 
                $markup .= '<div class="card-body p-7">';
                $markup .= '<p class="mb-0">' . esc_html( $props['content'] ) . '</p>';
                $markup .= '</div>';
            }
            $markup .= '</div>';
            if ( $attributes['displayAuthorImage'] ) {
            $markup .= '<div class="position-relative z-index-2 mt-n5 mb-3">';
            $markup .= '<div class="u-avatar mx-auto">';
            $markup .= '<img class="img-fluid rounded-circle" src=' . esc_url( $props['featured_image'] ) . ' alt="' . esc_attr( get_the_title( $props['post_id'] ) ) . '"/>';
            $markup .= '</div>';
            $markup .= '</div>';
            }
            if ( $attributes['displayAuthor'] ) {
                $markup .= '<h4 class="h6 mb-0">' . esc_html( $props['author'] ) . '</h4>';
            }
            if ( $attributes['displayAuthorPosition'] ) {
                $markup .= '<p class="small">' . esc_html( $props['excerpt'] ) . '</p>';
            }
            $markup .= '</div>';
            $markup .= '</div>';

            return $markup;
        }

        if ( $design == 'style-7' ) {

            $markup = '<div class="js-slide">';
            if ( $attributes['displayExcerpt'] ) {
                $markup .= '<blockquote class="lead text-white-70 text-lh-md">' . esc_html( $props['content'] ) . '</blockquote>';
            }
            $markup .= '</div>';

            return $markup;
        }

        if ( $design == 'style-8' ) {

            $markup = '<div class="js-slide my-4">';
            if ( $attributes['displayExcerpt'] ) {
            $markup .= '<div class="card border-0 shadow-sm mb-4 p-0 m-0">';
            $markup .= '<div class="card-body p-6">';
            $markup .= '<p>' . esc_html( $props['content'] ) . '</p>';
            $markup .= '</div>';
            $markup .= '</div>';
            }
            $markup .= '<div class="media ml-6">';
            if ( $attributes['displayAuthorImage'] ) {
            $markup .= '<div class="u-avatar mr-3">';
            $markup .= '<img class="img-fluid rounded-circle" src=' . esc_url( $props['featured_image'] ) . ' alt="' . esc_attr( get_the_title( $props['post_id'] ) ) . '"/>';
            $markup .= '</div>';
            }
            if ( $attributes['displayAuthor'] || $attributes['displayAuthorPosition'] ) {
            $markup .= '<div class="media-body">';
                if ( $attributes['displayAuthor'] ) { 
                    $markup .= '<h4 class="h6 mb-0">' . esc_html( $props['author'] ) . '</h4>';
                }
                if ( $attributes['displayAuthorPosition'] ) {
                    $markup .= '<p class="small">' . esc_html( $props['excerpt'] ) . '</p>';
                }
            $markup .= '</div>';
            }
            $markup .= '</div>';
            $markup .= '</div>';

            return $markup;
        }

         if ( $design == 'style-9' ) {

            $markup  = '<div class="js-slide">';
            if ( $attributes['displayAuthorPosition'] ) {
                $markup .= '<div class="text-center mb-5">';
                $markup .= '<blockquote class="h4 text-lh-md">' . esc_html( $props['content'] ) . '</blockquote>';
                $markup .= '</div>';
            }
            $markup .= '<div class="d-flex justify-content-center align-items-center w-lg-50 mx-auto">';
            if ( $attributes['displayAuthorImage'] ) {
                $markup .= '<div class="u-avatar">';
                $markup .= '<img class="img-fluid rounded-circle" src=' . esc_url( $props['featured_image'] ) . ' alt="' . esc_attr( get_the_title( $props['post_id'] ) ) . '"/>';
                $markup .= '</div>';
            }
            if ( $attributes['displayAuthor'] || $attributes['displayAuthorPosition'] ) {
                $markup .= '<div class="ml-3">';
                if ( $attributes['displayAuthor'] ) {
                    $markup .= '<h4 class="h6 mb-0">' . esc_html( $props['author'] ) . '</h4>';
                }
                if ( $attributes['displayAuthorPosition'] ) {
                    $markup .= '<small class="text-muted">' . esc_html( $props['excerpt'] ) . '</small>';
                }
                $markup .= '</div>';
            }
            $markup .= '</div>';
            $markup .= '</div>';


            return $markup;
        }

        return $markup;
    }
    add_filter( 'frontgb/designs_testimonial_carousel_save', 'frontgb_testimonial_carousel_designs', 10, 3 );
}

