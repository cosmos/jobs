<?php
/**
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'frontgb_testimonial_static_designs' ) ) {

    /**
     * Render the designs markup.
     *
     * @since 1.7
     */
    function frontgb_testimonial_static_designs( $markup, $design, $props ) {
        $attributes = $props['attributes'];

        if ( $design == 'style-2' ) {

            $containerClass = $attributes['enablecontainer'] ? 'container ' : '';

            $markup = '<div class="testimonial-static style-2 ' . esc_attr( $containerClass ) . 'space-bottom-2 space-bottom-md-3">';
            if ( $attributes['displayQuote'] ) {
                $markup .= '<figure class="mx-auto text-center mb-3">';
                $markup .= '<img class="js-svg-injector" src="' . esc_url( $attributes['quotationMark'] ) . '" alt="svg"/>';
                $markup .= '</figure>';
            }
            if ( $attributes['displayExcerpt'] ) {
                $markup .= '<div class="w-md-80 w-lg-50 text-center mx-md-auto mb-6">';
                $markup .= '<blockquote class="lead text-secondary font-weight-normal">';
                $markup .= esc_html( $props['content'] );
                $markup .= '</blockquote>';
                $markup .= '</div>';
            }
            $markup .= '<div class="d-flex justify-content-center align-items-center w-lg-50 mx-auto">';
            if ( $attributes['displayAuthorImage'] ) {
                $markup .= '<div class="u-avatar">';
                $markup .= '<img class="img-fluid rounded-circle" src="' . esc_url( $props['featured_image'] ) . '" alt="' . esc_attr( get_the_title( $props['post_id'] ) ) . '"/>';
                $markup .= '</div>';
            }
            $markup .= '<div class="ml-3">';
            if ( $attributes['displayAuthor'] ) {
                $markup .= '<h4 class="h6 mb-0">';
                $markup .= esc_html( $props['author'] );
                $markup .= '</h4>'; 
            } 
            if ( $attributes['displayAuthorPosition'] && $props['excerpt'] ) { 
                $markup .= '<small class="text-muted">';
                $markup .= esc_attr( $props['excerpt'] );
                $markup .= '</small>'; 
            }
            $markup .= '</div>';
            $markup .= '</div>';
            $markup .= '</div>';
            return $markup;
        }

        if ( $design == 'style-3' ) {

            $styles = '';

            if( isset($attributes['custom_bgcolor1']) ) {
                $styles .= 'background-color:' . $attributes['custom_bgcolor1'];
            }

            $containerClass = $attributes['enablecontainer'] ? 'container ' : '';

            $markup  = '<div class="testimonial-static style-3 ' . esc_attr( isset( $attributes['bg_gradientcolor1'] ) ? $attributes['bg_gradientcolor1'] : $props['default_color'] ) . '" style="' . esc_attr( $styles ) . '">';
            $markup .= '<div class="' . esc_attr( $containerClass ) . 'space-2">';
            $markup .=  '<div class="media d-block d-md-flex">';
            if ( $attributes['displayAuthorImage'] ) {
                $markup .= '<div class="u-lg-avatar mr-md-7 mb-7 mb-md-0">';
                    $markup .= '<img class="img-fluid rounded-circle" src="' . esc_url( $props['featured_image'] ) . '" alt="' . esc_attr( get_the_title( $props['post_id'] ) ) . '"/>';
                $markup .= '</div>';
            }
            $markup .= '<div class="media-body">';
            if ( $attributes['displayQuote'] ) {
                $markup .= '<figure class="mb-3">';
                $markup .= '<img class="js-svg-injector" src="' . esc_url( $attributes['quotationMark1'] ) . '" alt="svg"/>';
                $markup .= '</figure>';
            }
            if ( $attributes['displayExcerpt'] ){
                $markup .= '<blockquote class="lead text-white mb-4">';
                $markup .= esc_html( $props['content'] );
                $markup .= '</blockquote>';
            }
            if ( $attributes['displayAuthor'] ) { 
                $markup .= '<h4 class="h5 text-white">';
                $markup .= esc_html( $props['author'] );
                $markup .= '</h4>'; 
            } 
            if ( $attributes['displayAuthorLocation'] && $props['excerpt'] ) { 
                $markup .= '<span class="d-block text-warning pl-3">';
                if ( $props['excerpt'] ) {
                    $markup .= '— ';
                }
                $markup .= esc_html( $props['excerpt'] );
                $markup .= '</span>'; 
            }
            $markup .= '</div>';
            $markup .= '</div>';
            $markup .= '</div>';
            $markup .= '</div>';
            return $markup;
        }

        if ( $design == 'style-4' ) {
            $defaultimage = 'background-image: url(' . frontgb_get_assets_url() . 'img/bg-shapes/bg2.png)';

            $styles = '';

            if( isset($attributes['custom_bgcolor1']) ) {
                $styles .= 'background-color:' . $attributes['custom_bgcolor1'];
            }

            $styles1 =  isset( $attributes['bg_image1'] ) ? 'background-image: url(' . $attributes['bg_image1'] . ')' :  $defaultimage;

            $className = 'testimonial-static style-4 position-relative z-index-2 ' . ( isset( $attributes['bg_gradientcolor1'] ) ? $attributes['bg_gradientcolor1'] : $props['default_color'] );

            $containerClass = $attributes['enablecontainer'] ? 'container ' : '';

            $markup  = '<div id="SVGirregularShape2Right" class="' . esc_attr( $className ) . '" style="' . esc_attr( $styles ) . '">';
            $markup .= '<div class="bg-img-hero-bottom" style="' . $styles1 . '">';
            $markup .= '<div class="' . $containerClass . 'space-top-2 space-top-md-3 space-bottom-4">';
            $markup .= '<div class="text-center">';
            $markup .= '<div class="mb-4">';
            if ( $attributes['displayAuthorImage'] ) {
                $markup .= '<div class="u-avatar mx-auto mb-3">';
                $markup .= '<img class="img-fluid rounded-circle" src="' . esc_url( $props['featured_image'] ) . '" alt="' . esc_attr( get_the_title( $props['post_id'] ) ) . '"/>';
                $markup .= '</div>'; 
            }   
            if ( ( ($attributes['displayAuthor'] && $props['author']) || ($attributes['displayAuthorPosition'] && $props['excerpt']) ) ) {
                $markup .= '<h4 class="h6 text-white">';
                if ( $attributes['displayAuthor'] ) {
                    $markup .=  esc_html( $props['author'] );
                }
                if ( ($attributes['displayAuthor'] && $props['author']) && ($attributes['displayAuthorPosition'] && $props['excerpt']) ) {
                    $markup .=  ', ';
                }
                if ( $attributes['displayAuthorPosition'] ) {
                    $markup .=  esc_html( $props['excerpt'] );
                }
                $markup .= '</h4>';
            }
            $markup .= '</div>';
            if ( $attributes['displayExcerpt'] ) {
                $markup .= '<div class="w-md-80 w-lg-50 text-center mx-md-auto mb-7">';
                $markup .= '<blockquote class="h3 text-white mb-0">'; 
                $markup .= esc_html( $props['content'] );
                $markup .= '</blockquote>'; 
                $markup .= '</div>';
            }
            $markup .= '</div>';
            $markup .= '</div>';
            if (  $attributes['displayBgQuote'] ) {
                $markup .= '<figure class="w-25 position-absolute top-0 right-0 left-0 ml-11">';
                $markup .= '<img class="js-svg-injector" src="' . esc_url( $attributes['svg_bg1'] ) . '" alt="' . (__('Img', FRONTGB_I18N)) . '" data-parent="#SVGirregularShape2Right"/>';
                $markup .= '</figure>';
            }
            if (  $attributes['displayBgRound'] ) {
                $markup .= '<div class="position-absolute top-0 right-0 left-0 z-index-n1">';
                    $markup .= '<figure class="ie-irregular-shape-2-right">';
                    $markup .= '<img class="js-svg-injector" src="' . esc_url( $attributes['svg_bg2'] ) . '" alt="' . (__('Img', FRONTGB_I18N)) . '" data-parent="#SVGirregularShape2Right"/>';
                    $markup .= '</figure>';
                $markup .= '</div>';
            }
            $markup .= '</div>';
            $markup .= '</div>';
            return $markup;
        }

        if ( $design == 'style-5' ) {

            $styles = '';

            if( isset($attributes['custom_bgcolor1']) ) {
                $styles .= 'background-color:' . $attributes['custom_bgcolor1'];
            }

            $containerClass = $attributes['enablecontainer'] ? 'container ' : '';

            $markup  = '<div class="testimonial-static style-5 ' . esc_attr( isset( $attributes['bg_gradientcolor1'] ) ? $attributes['bg_gradientcolor1'] : $props['default_color'] ) . '" style="' . esc_attr( $styles ) . '">';
            $markup .= '<div class="space-2 space-lg-3 ' . $containerClass . '">';
            $markup .= '<div class="w-lg-75 mx-lg-auto">';
            if ( $attributes['displayQuote'] ) {
                $markup .= '<figure class="mx-auto text-center mb-3">';
                $markup .= '<img class="js-svg-injector" src="' . esc_url( $attributes['quote_style_5'] ) . '" alt="' . (__('Img', FRONTGB_I18N)) . '"/>';
                $markup .= '</figure> ';
            }
            if ( $attributes['displayExcerpt'] ) {
                $markup .= '<div class="text-center mb-5">';
                $markup .= '<blockquote class="font-size-3 font-weight-medium">' . esc_html( $props['content'] ) . '</blockquote>';
                $markup .= '</div>';
            }
            if ( $attributes['displayAuthor'] || $attributes['displayAuthorPosition'] ) {
                $markup .= '<div class="w-lg-50 text-center mx-lg-auto">';
                if ( $attributes['displayAuthor'] ) {
                    $markup .= '<h4 class="h5 mb-0">' . esc_html( $props['author'] ) . '</h4>';
                }
                if ( $attributes['displayAuthorPosition'] ) {
                    $markup .= '<small class="text-muted">' . esc_html( $props['excerpt'] ) . '</small>';
                }
                $markup .= '</div>';
            }
            $markup .= '</div>';
            $markup .= '</div>';
            $markup .= '</div>';
            return $markup;
        }

        if ( $design == 'style-6' ) {

            $containerClass = 'testimonial-static style-6 space-bottom-3' . ( $attributes['enablecontainer'] ? ' container' : '' );

            $markup  = '<div class="' . $containerClass . '">';
            if ( $attributes['displayQuote'] ) {
                $markup .= '<figure class="mx-auto text-center mb-3">';
                $markup .= '<img class="js-svg-injector" src="' . esc_url( $attributes['quotationMark'] ) . '" alt="svg"/>';
                $markup .= '</figure>';
            }
            if ( $attributes['displayExcerpt'] ) {
                $markup .= '<div class="w-md-75 text-center mx-md-auto mb-6">';
                $markup .= '<blockquote class="lead font-weight-normal">' . esc_html( $props['content'] ) . '</blockquote>';
                $markup .= '</div>';
            }
            $markup .= '<div class="d-flex justify-content-center align-items-center w-lg-50 mx-auto">';
            if ( $attributes['displayAuthorImage'] ) {
                $markup .= '<div class="u-avatar">';
                $markup .= '<img class="img-fluid rounded-circle" src="' . esc_url( $props['featured_image'] ) . '" alt="' . esc_attr( get_the_title( $props['post_id'] ) ) . '"/>';
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

        if ( $design == 'style-7' ) {

            $markup  = '<div class="media mb-3">';
            if ( $attributes['displayAuthorImage'] ) {
                $markup .= '<div class="u-avatar' . esc_attr( ( $props['index'] % 2 ) == 0 ? ' mr-3' : '' ) . esc_attr( ( $props['index'] % 2 ) == 1 ? ' order-2' : '' ) . '">';
                $markup .= '<img class="img-fluid rounded-circle" src="' . esc_url( $props['featured_image'] ) . '" alt="' . esc_attr( get_the_title( $props['post_id'] ) ) . '"/>';
                $markup .= '</div>';
            }
            $markup .= '<div class="media-body">';
            $markup .= '<div class="card shadow p-3 mb-2' . esc_attr( ( ( $props['index'] % 2 ) == 1 && $attributes['displayAuthorImage'] ) ? ' order-1 mr-3' : '' ) . '">';
            if ( $attributes['displayExcerpt'] ) {
                $markup .= '<p class="font-size-1">' . esc_html( $props['content'] ) . '</p>';
            }
            $markup .= '<div class="media align-items-center">';
                if ( $attributes['displayQuote'] ) {
                    $markup .= '<figure class="mr-3">';
                    $markup .= '<img class="js-svg-injector" src="' . esc_url( $attributes['quote_style_7'] ) . '" alt="svg"/>';
                    $markup .= '</figure>';
                }
                if ( $attributes['displayAuthor'] || $attributes['displayAuthorPosition'] ) {
                    $markup .= '<div class="media-body">';
                        if ( $attributes['displayAuthor'] ) {
                            $markup .= '<h5 class="font-size-1 mb-0">' . esc_html( $props['author'] ) . '</h5>';
                        }
                        if ( $attributes['displayAuthorPosition'] ) {
                            $markup .= '<small class="d-block text-secondary">' . esc_html( $props['excerpt'] ) . '</small>';
                        }
                    $markup .= '</div>';
                }
            $markup .= '</div>';
            $markup .= '</div>';
            $markup .= '</div>';
            $markup .= '</div>';
            return $markup;
        }

        if ( $design == 'style-8' ) {

            $styles = '';

            if( isset($attributes['custom_bgcolor1']) ) {
                $styles .= 'background-color:' . $attributes['custom_bgcolor1'];
            }

            $containerClass = $attributes['enablecontainer'] ? 'container ' : '';

            $markup  = '<div id="SVGwave1BottomSMShape" class="' . esc_attr( $attributes['align'] === 'full' ? 'alignfull' : '' ) . esc_attr( $attributes['align'] === 'wide' ? 'alignwide' : '' ) . ' testimonial-static style-8 ' . esc_attr( isset( $attributes['bg_gradientcolor1'] ) ? $attributes['bg_gradientcolor1'] : $props['default_color'] ) . '" style="' . esc_attr( $styles ) . '">';
            
            $markup .= '<div class="' . $containerClass . 'space-2 space-md-3 position-relative">';
            $markup .= '<div class="text-center">';
                if ( $attributes['displayAuthorImage'] ) {
                    $markup .= '<div class="u-avatar mx-auto mb-4">';
                    $markup .= '<img class="img-fluid rounded-circle" src="' . esc_url( $props['featured_image'] ) . '" alt="' . esc_attr( get_the_title( $props['post_id'] ) ) . '"/>';
                    $markup .= '</div>';
                }
                if ( $attributes['displayExcerpt'] ) {
                    $markup .= '<div class="w-md-80 w-lg-50 text-center mx-md-auto mb-7">';
                    $markup .= '<blockquote class="h4 text-white font-weight-light mb-0">' . esc_html( $props['content'] ) . '</blockquote>';
                    $markup .= '</div>';
                }
                if ( $attributes['displayAuthor'] ) {
                    $markup .= '<h4 class="h5 text-warning mb-0">' . esc_html( $props['author'] ) . '</h4>';
                }
            $markup .= '</div>';
            if (  $attributes['displayBgQuote'] ) {
                $markup .= '<figure class="w-35 position-absolute top-0 right-0 left-0 left-15x">';
                $markup .= '<img class="js-svg-injector" src="' . esc_url( $attributes['svg_bg1'] ) . '" alt="' . (__('Img', FRONTGB_I18N)) . '" data-parent="#SVGwave1BottomSMShape"/>';
                $markup .= '</figure>';
            }
            $markup .= '</div>';
            $markup .= '</div>';
            return $markup;
        }

        if ( $design == 'style-9' ) {

            $containerClass = $attributes['enablecontainer'] ? 'container ' : '';

            $markup = '<div class="bg-img-hero" style="background-image: url(' . frontgb_get_assets_url() . 'img/bg-shapes/bg3.png )">';
            $markup .= '<div class="' . esc_attr( $containerClass ) . 'space-2 space-md-3">';
            $markup .= '<div class="w-md-80 w-lg-60 text-center mx-auto">';
            if ( $attributes['displayExcerpt'] ) {
                $markup .= '<blockquote class="h3 mb-5">' . esc_html( $props['content'] ) . '</blockquote>';
            }
            if ( $attributes['displayAuthor'] || $attributes['displayAuthorPosition'] ) {
                $markup .= '<h4 class="h6 text-muted mb-4">'; 
                $markup .= $attributes['displayAuthor'] ? esc_html( $props['author'] ) : '';
                $markup .= ( $attributes['displayAuthor'] && $attributes['displayAuthorPosition'] ) ? ', ' : '';
                $markup .= $attributes['displayAuthorPosition'] ? esc_html( $props['excerpt'] ) : '';
                $markup .= '</h4>';
            }
            if ( $attributes['displayAuthorImage'] ) {
                $markup .= '<div class="u-avatar mx-auto">';
                $markup .= '<img class="img-fluid rounded-circle" src="' . esc_url( $props['featured_image'] ) . '" alt="' . esc_attr( get_the_title( $props['post_id'] ) ) . '"/>';
                $markup .= '</div>';
            }
            $markup .= '</div>';
            $markup .= '</div>';
            $markup .= '</div>';
            return $markup;
        }

        return $markup;
    }

    add_filter( 'frontgb/designs_testimonial_static_save', 'frontgb_testimonial_static_designs', 10, 3 );
}