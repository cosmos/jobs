<?php
/**
 * Server-side rendering of the `fgb/testimonial-carousel` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/testimonial-carousel` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_testimonial_carousel_block' ) ) {
    function frontgb_render_testimonial_carousel_block( $attributes ) {
        $recent_posts = wp_get_recent_posts(
            array(
                'post_type'   => 'jetpack-testimonial', 
                'numberposts' => ! empty( $attributes['postsToShow'] ) ? $attributes['postsToShow'] : '',
                'post_status' => 'publish',
                'order'       => ! empty( $attributes['order'] ) ? $attributes['order'] : '',
                'orderby'     => ! empty( $attributes['orderBy'] ) ? $attributes['orderBy'] : '',
                'include'     => ( ! empty( $attributes['posts'] ) && is_array($attributes['posts']) ) ? array_column($attributes['posts'], 'id') : '',
            )
        );

        $posts_markup = '';
        $posts_pagination = '';
        $props = array( 'attributes' => array() );

        foreach ( $recent_posts as $index => $post ) {
            $post_id = $post['ID'];

            // Author.
            $Author = get_the_title( $post_id );

            // Excerpt.
            $excerpt = get_post_field( 'post_excerpt', $post_id );

            // Content.
            $content = wp_strip_all_tags( get_post_field( 'post_content', $post_id ), true );

            // Default Image.
            $default_user_img = frontgb_get_assets_url() . 'img/profile/default-gravatar.png';

            $post_featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ) );

            // Featured Image.
            $featured_image = ( ! empty($post_featured_image[0]) ? $post_featured_image[0] : $default_user_img );

            //Star Rating.
            $ratings =  get_post_meta( $post_id, '_rating', true );

            /**
             * This is the default style-v1.
             */

            $post_markup = '<div class="js-slide card mb-1 p-0">';
            $post_markup .= '<div class="card-body p-5">';
            if ($attributes['displayExcerpt']) {
            $post_markup .= '<div class="mb-auto">';
            $post_markup .= ' <p class="mb-0">';
            $post_markup .= esc_html( $content );
            $post_markup .= '</p>';
            $post_markup .= '</div>';
            }
            $post_markup .= '</div>';
            $post_markup .= '<div class="card-footer border-0 pt-0 px-5 pb-5">';
            $post_markup .= '<div class="media">';
            if ($attributes['displayAuthorImage']) {
            $post_markup .= '<div class="u-avatar mr-3">';
            $post_markup .= '<img class="img-fluid rounded-circle" src="' . esc_url( $featured_image ) . '" alt="' . esc_attr( get_the_title( $post_id ) ) . '">';
            $post_markup .= '</div>';
            }
            $post_markup .= '<div class="media-body">';
            if ($attributes['displayAuthor']) {
            $post_markup .= '<div class="media-body">';
            $post_markup .= '<h4 class="h6 mb-1">';
            $post_markup .= esc_html( $Author );
            $post_markup .= '</h4>';
            if ( $attributes['displayStarRatings'] && $ratings != '' ) {
                $post_markup .= '<ul class="list-inline text-warning testimonial-carousel-star-ratings">';
                for ($i = 1; $i <= $ratings; $i++) {
                    $post_markup .= '<li class="list-inline-item mx-0"><span class="fas fa-star"></span></li>';
                }
                $post_markup .= '</ul>';
            }
            $post_markup .= '</div>';
            }
            $post_markup .= '</div>';
            $post_markup .= '</div>';
            $post_markup .= '</div>';
            $post_markup .= '</div>';

            // Let others change the saved markup.
            $props = array(
                'post_id' => $post_id,
                'attributes' => $attributes,
                'featured_image' => $featured_image,
                'author' => $Author,
                'content' => $content,
                'excerpt' => $excerpt,
                'post_id' => $post_id,
            );

            $post_markup = apply_filters( 'frontgb/designs_testimonial_carousel_save', $post_markup, $attributes['design'], $props );
            $posts_markup .= $post_markup . "\n";
        }

        foreach ( $recent_posts as $index => $post ) {
            $post_id = $post['ID'];

            // Author.
            $Author = get_the_title( $post_id );

            // Excerpt.
            $excerpt = get_post_field( 'post_excerpt', $post_id );

            // Default image.
            $default_user_img = frontgb_get_assets_url() . 'img/profile/default-gravatar.png';

            // Featured image.
            $post_featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ) );

            $featured_image = ( ! empty($post_featured_image[0]) ? $post_featured_image[0] : $default_user_img );

            /**
             * This is the default style-v1.
             */

            $post_pagination1 = '<div class="js-slide">';
            if ( $attributes['displayAuthorImage'] ) { 
                $post_pagination1 .= '<div class="u-avatar mx-auto">';
                $post_pagination1 .= '<img class="img-fluid rounded-circle" src=' . esc_url( $featured_image ) . ' alt="' . esc_attr( get_the_title( $post_id ) ) . '">';
                $post_pagination1 .= '</div>';
            }
            $post_pagination1 .= '</div>';

            $post_pagination2  = '<div class="js-slide rounded-pill p-2">';
            $post_pagination2 .= '<div class="media align-items-center">';
            if ( $attributes['displayAuthorImage'] ) {
                $post_pagination2 .= '<div class="u-avatar mr-3">';
                $post_pagination2 .= '<img class="img-fluid rounded-circle" src=' . esc_url( $featured_image ) . ' alt="' . esc_attr( get_the_title( $post_id ) ) . '">';
                $post_pagination2 .= '</div>';
            }
            if ( $attributes['displayAuthor'] || $attributes['displayAuthorPosition'] ) {
            $post_pagination2 .= '<div class="media-body">';
                if ( $attributes['displayAuthor'] ) {
                    $post_pagination2 .= '<h4 class="h6 u-slick--pagination-interactive__title mb-0">' . esc_html( $Author ) . '</h4>';
                }
                if ( $attributes['displayAuthorPosition'] ) {
                    $post_pagination2 .= '<p class="small u-slick--pagination-interactive__text mb-0">' . esc_html( $excerpt ) . '</p>';
                }
            }
            $post_pagination2 .= '</div>';
            $post_pagination2 .= '</div>';
            $post_pagination2 .= '</div>';

            if ( $attributes['design'] === 'style-4' || $attributes['design'] === 'style-5' ) {
                $posts_pagination .= $post_pagination1;
            }

            if ( $attributes['design'] === 'style-7' ) {
                $posts_pagination .= $post_pagination2;
            }
        }

        $carousel_args1 = array(
            array(
                'breakpoint'    => 992,
                'settings'      => array(
                    'slidesToShow'      => 2,
                )
            ),
            array(
                'breakpoint'    => 768,
                'settings'      => array(
                    'slidesToShow'      => 1,
                )
            ),
        );

        $carousel_args2 = array(
            array(
                'breakpoint'    => 1200,
                'settings'      => array(
                    'slidesToShow'      => 2,
                )
            ),
            array(
                'breakpoint'    => 768,
                'settings'      => array(
                    'slidesToShow'      => 2,
                )
            ),
            array(
                'breakpoint'    => 554,
                'settings'      => array(
                    'slidesToShow'      => 1,
                )
            ),
        );

        $default_color = '';

        if ( $attributes['design'] === 'style-1' || $attributes['design'] === 'style-6' || $attributes['design'] === 'style-8'  ) {
            $default_color = 'bg-light';
        }

        if ( $attributes['design'] === 'style-2' ) {
            $default_color = 'bg-primary';
        }

        if ( $attributes['design'] === 'style-5' || $attributes['design'] === 'style-7' ) {
            $default_color = 'gradient-half-primary-v1';
        }

        $block_content = '';

        switch ( $attributes['design'] ) {
            case 'style-1':
                $styles = ( ! empty($attributes['bg_cusomColor']) ? ( 'background-color:' . $attributes['bg_cusomColor'] ) : '' ) ;

                $block_content  = '<div class="testimonial-carousel style-1 ' . esc_attr( isset($attributes['bg_color']) ? $attributes['bg_color'] : $default_color ) . '" style="' . esc_attr( $styles ) . '">' ;
                $block_content .= '<div class="space-2' . ( $attributes['enablecontainer'] ? esc_attr( ' container' ) : '' ) . '">';
                if ( $attributes['displaySectionHeader'] ) {
                    $block_content .= '<div class="w-md-80 w-lg-50 text-center mx-md-auto mb-9">';
                    if ( $attributes['displaySectionSvg'] ) {
                        $block_content .= '<figure id="icon4" class="ie-height-72 max-width-10 mx-auto mb-3">';
                        $block_content .= '<img class="js-svg-injector" src="' . esc_url( $attributes['svgImg'] ) . '" alt="' . (__('SVG', FRONTGB_I18N)) . '" data-parent="#icon4"/>';
                        $block_content .= '</figure>';
                    }
                    if ( $attributes['displaySectionTitle'] ) {
                        $block_content .= '<h2 class="font-weight-medium">' . ( ! empty($attributes['sectionTitle']) ? $attributes['sectionTitle'] : (__('Review from our experts', FRONTGB_I18N)) ) . '</h2>';
                    }
                    $block_content .= '</div>';
                }
                $block_content .= '<div class="js-slick-carousel u-slick u-slick--equal-height u-slick--gutters-3" data-slides-show="3" data-autoplay="true" data-speed="' . apply_filters( 'frontgb_testimonial_carousel_block_1_slick_data_speed', esc_attr( "5000" ) ) . '" data-infinite="false" data-center-mode="true" data-pagi-classes="d-lg-none text-center u-slick__pagination mt-7 mb-0" data-responsive="' . htmlspecialchars( json_encode( $carousel_args1 ), ENT_QUOTES, 'UTF-8' ) . '">';
                $block_content .= wp_kses_post( $posts_markup );
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '</div>'; 
            break;

            case 'style-2':
                $background = '';

                if ( ! empty ($attributes['bg_image1']) ) {
                    $background = 'background-image: url(' . $attributes['bg_image1'] . ')';
                } 
                else if ( ( empty ($attributes['bg_image1']) && $attributes['align'] == 'right' ) ) {
                    $background = 'background-image: url(' . frontgb_get_assets_url() . 'img/1920x800/img11.jpg)';
                } 
                else if ( ( empty ($attributes['bg_image1']) && $attributes['align'] == 'left' ) ) {
                    $background = 'background-image: url(' . frontgb_get_assets_url() . 'img/1920x800/img12.jpg)';
                }

                $cardclass = '';

                if ( $attributes['align'] === 'right' ) {
                    $cardclass = 'card border-0 text-white shadow-primary-lg p-0 ';
                    $cardclass .= ( isset($attributes['bg_color']) ? $attributes['bg_color'] : $default_color );
                }

                if ( $attributes['align'] === 'left' ) {
                    $cardclass = 'card shadow-sm p-0 border-0 '; 
                    $cardclass .= '';
                }

                $slickParent = '';

                if ($attributes['align'] === 'right') {
                    $slickParent= '<div class="js-slick-carousel u-slick" data-pagi-classes="text-right u-slick__pagination u-slick__pagination--white mt-2 mb-0">' . $posts_markup . '</div>';
                }

                if ($attributes['align'] === 'left') {
                    $slickParent= '<div class="js-slick-carousel u-slick" data-pagi-classes="text-right u-slick__pagination mt-2 mb-0">' . $posts_markup . '</div>';
                }

                $styles = '';

                if ( ! empty($attributes['bg_cusomColor']) ) {
                    $styles = 'background-color:' . $attributes['bg_cusomColor'];
                }

                $block_content = '<div class="' . esc_attr( $attributes['align'] == 'left' ? 'clearfix px-3 px-md-5' : '' ) . '">';
                $block_content .= '<div class="testimonial-carousel style-2 ' . esc_attr( $attributes['align'] == 'right' ? 'bg-img-hero-bottom' : 'bg-img-hero' ) . '" style="' . esc_attr( $background ) . '">';
                $block_content .= '<div class="' . esc_attr( $attributes['enablecontainer'] ? 'container' : '' ) . '">';
                $block_content .= '<div class="' . esc_attr( $attributes['align'] == 'right' ? 'row justify-content-md-end' : 'row' ) . '">';
                $block_content .= '<div class="' . esc_attr( $attributes['align'] == 'right' ? 'col-md-6 col-lg-5 col-xl-4 space-top-3 mb-n9' : 'col-md-6 col-lg-5 col-xl-4 space-2' ) . '">';
                $block_content .= '<div class="' . esc_attr( $cardclass ) . '" style="' . esc_attr( $styles ) . '">';
                $block_content .= '<div class="card-body p-7">';
                $block_content .= wp_kses_post( $slickParent );
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '</div>';
            break;

            case 'style-3':
                $block_content  = '<div class="position-lg-absolute right-lg-0 bottom-lg-0 left-lg-0 w-80 w-lg-100 mx-auto p-md-7">';
                $block_content .= '<div class="js-slick-carousel u-slick" data-adaptive-height="true" data-autoplay="false" data-speed="' . apply_filters( 'frontgb_testimonial_carousel_block_3_slick_data_speed', esc_attr( "5000" ) ) . '" data-vertical="true" data-vertical-swiping="true">';
                $block_content .= wp_kses_post( $posts_markup );
                $block_content .= '</div>';
                $block_content .= '</div>'; 
            break;

            case 'style-4':
                $containerclass = 'space-2 space-md-3 testimonial-carousel style-4';

                if ( $attributes['enablecontainer'] ) {
                    $containerclass .= ' container';
                }

                $block_content = '<div class="' . esc_attr( $containerclass ) . '">';
                if ( $attributes['displayQuote'] ) {
                    $block_content .= '<figure class="text-center mb-5 mx-auto">';
                    $block_content .= '<img class="js-svg-injector" src="' . esc_url( $attributes['svg_quote2'] ) . '" alt="' . (__('SVG', FRONTGB_I18N)) . '"/>';
                    $block_content .= '</figure>';
                }
                $block_content .= '<div id="testimonialsNavMain" class="js-slick-carousel u-slick u-slick--transform-off mb-4" data-infinite="false" data-autoplay="true" data-speed="' . apply_filters( 'frontgb_testimonial_carousel_block_4_slick_data_speed', esc_attr( "5000" ) ) . '" data-fade="true" data-nav-for="#testimonialsNavPagination">';
                $block_content .= wp_kses_post( $posts_markup );
                $block_content .= '</div>';
                $block_content .= '<div id="testimonialsNavPagination" class="js-slick-carousel u-slick u-slick--pagination-modern u-slick--transform-off mx-auto" data-infinite="false" data-autoplay="true" data-speed="' . apply_filters( 'frontgb_testimonial_carousel_block_4_slick_data_speed', esc_attr( "5000" ) ) . '" data-focus-on-select="true" data-center-mode="true" data-slides-show="3" data-is-thumbs="true" data-nav-for="#testimonialsNavMain">';
                $block_content .= wp_kses_post( $posts_pagination );
                $block_content .= '</div>';
                $block_content .= '</div>';
            break;

            case 'style-5':
                $styles = '';

                if ( ! empty($attributes['bg_cusomColor']) ) {
                    $styles = 'background-color:' . $attributes['bg_cusomColor'];
                }

                $block_content = '<div class="testimonial-carousel style-5 ' . esc_attr( isset($attributes['bg_color']) ? $attributes['bg_color'] : $default_color ) . '" style="' . esc_attr( $styles ) . '">' ;
                if ( $attributes['displayQuote'] ) {
                    $block_content .= '<figure class="text-center mb-5 mx-auto">';
                    $block_content .= '<img class="js-svg-injector" src="' . esc_url( $attributes['svg_quote1'] ) . '" alt="' . (__('SVG', FRONTGB_I18N)) . '"/>';
                    $block_content .= '</figure>';
                }
                $block_content .= '<div id="testimonialsNavMainExample1" class="js-slick-carousel u-slick mb-4" data-infinite="false" data-autoplay="true" data-speed="' . apply_filters( 'frontgb_testimonial_carousel_block_5_slick_data_speed', esc_attr( "5000" ) ) . '" data-fade="true" data-nav-for="#testimonialsNavPaginationExample1">';
                $block_content .= wp_kses_post( $posts_markup );
                $block_content .= '</div>';
                $block_content .= '<div id="testimonialsNavPaginationExample1" class="js-slick-carousel u-slick u-slick--transform-off u-slick--pagination-modern mx-auto" data-infinite="false" data-autoplay="true" data-speed="' . apply_filters( 'frontgb_testimonial_carousel_block_5_slick_data_speed', esc_attr( "5000" ) ) . '" data-center-mode="true" data-slides-show="3" data-is-thumbs="true" data-focus-on-select="true" data-nav-for="#testimonialsNavMainExample1">';
                $block_content .= wp_kses_post( $posts_pagination );
                $block_content .= '</div>';
                $block_content .= '</div>'; 
            break;

            case 'style-6':
                $styles = '';

                if ( ! empty($attributes['bg_cusomColor']) ) {
                    $styles = 'background-color:' . $attributes['bg_cusomColor'];
                }

                $block_content  = '<div class="testimonial-carousel style-6 ' . esc_attr( isset($attributes['bg_color']) ? $attributes['bg_color'] : $default_color ) . '" style="' . esc_attr( $styles ) . '">' ;
                $block_content .= '<div class="' . esc_attr( $attributes['enablecontainer'] ? 'container ' : '' ) . 'space-2 space-md-3">';
                if ( $attributes['displaySectionHeader'] ) {
                    $block_content .= '<div class="w-md-80 w-lg-50 text-center mx-md-auto mb-9">';
                    if ( $attributes['displaySectionPreTitle'] ) {
                        $block_content .= '<span class="btn btn-xs btn-soft-primary btn-pill mb-2">' . esc_html( ! empty ( $attributes['sectionPreTitle'] ) ? $attributes['sectionPreTitle'] : (__('Testimonials', FRONTGB_I18N)) ) . '</span>';
                    }
                    if ( $attributes['displaySectionTitle'] ) {
                        $block_content .= '<h2 class="h3 font-weight-normal">' . ( ! empty ( $attributes['sectionTitle'] ) ? $attributes['sectionTitle'] : (__('100+ companies are using Front', FRONTGB_I18N)) ) . '</h2>';
                    }
                    $block_content .= '</div>';
                }
                $block_content .= '<div class="js-slick-carousel u-slick u-slick-zoom u-slick--gutters-3" data-slides-show="3" data-center-mode="true" data-autoplay="true" data-speed="' . apply_filters( 'frontgb_testimonial_carousel_block_6_slick_data_speed', esc_attr( "5000" ) ) . '" data-pagi-classes="text-center u-slick__pagination mt-7 mb-0"  data-responsive="' . htmlspecialchars( json_encode( $carousel_args1 ), ENT_QUOTES, 'UTF-8' ) . '">';
                $block_content .= wp_kses_post( $posts_markup );
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '</div>';
            break;

            case 'style-7':
                $styles = '';

                if ( ! empty($attributes['bg_cusomColor']) ) {
                    $styles = 'background-color:' . $attributes['bg_cusomColor'];
                }

                $block_content  = '<div id="SVGbgElements5" class="testimonial-carousel style-7 position-relative ' . esc_attr( isset($attributes['bg_color']) ? $attributes['bg_color'] : $default_color ) . '" style="' . esc_attr( $styles ) . '">' ;
                $block_content .= '<div class="' . ( $attributes['enablecontainer'] ? esc_attr( 'container ' ) : '') . 'position-relative z-index-2 space-2 space-md-3">';
                $block_content .= '<div class="text-center mb-4">';
                if ( $attributes['displayQuote'] ) {
                    $block_content .= '<figure class="mx-auto mb-2">';
                    $block_content .= '<img class="js-svg-injector" src="' . esc_url( $attributes['svg_quote3'] ) . '" alt="' . (__('SVG', FRONTGB_I18N)) . '"/>';
                    $block_content .= '</figure>';
                }
                if ( $attributes['displaySectionTitle'] ) {
                    $block_content .= '<h2 class="text-white font-weight-medium">' . ( ! empty ( $attributes['sectionTitle'] ) ? $attributes['sectionTitle'] : (__('Satisfied customers on Front', FRONTGB_I18N)) )  . '</h2>';
                }
                $block_content .= '</div>';
                $block_content .= '<div id="testimonialsNavMainExample2" class="js-slick-carousel u-slick text-center w-lg-75 mx-lg-auto mb-7" data-adaptive-height="true" data-infinite="true" data-fade="true" data-nav-for="#testimonialsNavPaginationExample3">';
                $block_content .= wp_kses_post( $posts_markup );
                $block_content .= '</div>';
                $block_content .= '<div id="testimonialsNavPaginationExample3" class="js-slick-carousel u-slick u-slick--gutters-3 u-slick--pagination-interactive" data-infinite="true" data-slides-show="3" data-center-mode="true" data-focus-on-select="true" data-nav-for="#testimonialsNavMainExample2" data-responsive="' . htmlspecialchars( json_encode( $carousel_args2 ), ENT_QUOTES, 'UTF-8' ) . '">';
                $block_content .= wp_kses_post( $posts_pagination );
                $block_content .= '</div>';
                $block_content .= '</div>';
                if ( $attributes['displayBgSvg1'] ) {
                    $block_content .= '<figure class="position-absolute top-0 right-0 w-100 h-100">';
                    $block_content .= '<img class="js-svg-injector" src="' . esc_url( $attributes['svg_bg1'] ) . '" alt="' . (__('SVG', FRONTGB_I18N)) . '"/>';
                    $block_content .= '</figure>';
                }
                $block_content .= '</div>';
            break;

            case 'style-8':
                $styles = '';

                if ( ! empty($attributes['bg_cusomColor']) ) {
                    $styles = 'background-color:' . $attributes['bg_cusomColor'];
                }

                $block_content = '<div id="SVGdoubleEllipseTopRight" class="testimonial-carousel style-8 position-relative ' . esc_attr( isset($attributes['bg_color']) ? $attributes['bg_color'] : $default_color ) . '" style="' . esc_attr( $styles ) . '">' ;
                $block_content .= '<div class="' . esc_attr( $attributes['enablecontainer'] ? 'container ' : '' ) . 'space-2 position-relative z-index-2">';
                $block_content .= '<div class="row">';
                $block_content .= '<div class="col-lg-4 mb-7 mb-lg-0">';
                $block_content .= '<div class="pr-lg-4">';
                if ( $attributes['displayQuationBg'] ) {
                $block_content .= '<figure class="mb-3">';
                $block_content .= '<img class="js-svg-injector" src="' . esc_url( $attributes['quation_bg'] ) . '" alt="' . (__('SVG', FRONTGB_I18N)) . '"/>';
                $block_content .= '</figure>';
                }
                if ( $attributes['displaySectionTitle'] ) {
                    $block_content .= '<h2 class="font-weight-normal mb-4">' . ( ! empty ( $attributes['sectionTitle'] ) ? $attributes['sectionTitle'] : (__('What Front users say about us.', FRONTGB_I18N)) )  . '</h2>';  
                }
                $block_content .= '<div class="d-flex align-items-center">';
                if ( $attributes['displayStarRatings'] ) {
                    $block_content .= '<ul class="list-inline mr-3 mb-0">';
                    $block_content .= '<li class="list-inline-item text-warning testimonial-carousel-star-ratings-8">';
                        for ($i = 1; $i <= $attributes['starRatings']; $i++) {
                            $block_content .= '<span class="fas fa-star"></span>';
                        }
                    $block_content .= '</li>';
                    $block_content .= '</ul>';
                }
                if ( $attributes['displayReviewlabel'] && ! empty ( $attributes['reviewLabel'] ) ) {
                    $block_content .= '<span class="text-secondary">' . ( ! empty ( $attributes['reviewLabel'] ) ? $attributes['reviewLabel'] : '' )  . '</span>';
                }
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '<div class="col-lg-8">';
                $block_content .= '<div class="js-slick-carousel u-slick u-slick--gutters-3" data-slides-show="2" data-autoplay="true" data-speed="' . apply_filters( 'frontgb_testimonial_carousel_block_8_slick_data_speed', esc_attr( "5000" ) ) . '" data-infinite="false" data-center-mode="true" data-responsive="' . htmlspecialchars( json_encode( $carousel_args1 ), ENT_QUOTES, 'UTF-8' ) . '">';
                $block_content .= wp_kses_post( $posts_markup );
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '</div>';
                if ( $attributes['displayBgSvg2'] ) { 
                    $block_content .= '<div class="position-absolute top-0 right-0 w-75 w-md-60 w-lg-35">';
                    $block_content .= '<figure class="ie-double-ellipse-top-right">';
                    $block_content .= '<img class="js-svg-injector" src="' . esc_url( $attributes['svg_bg2'] ) . '" alt="' . (__('SVG', FRONTGB_I18N)) . '"/>';
                    $block_content .= '</figure>';
                    $block_content .= '</div>';
                }
                $block_content .= '</div>';
            break;

            case 'style-9':
                $block_content  = '<div class="' . esc_attr( $attributes['enablecontainer'] ? 'container ' : '' ) . 'space-2 space-lg-3">';
                $block_content .= '<div class="w-md-80 w-lg-60 mx-md-auto">';
                if ( $attributes['displayQuote'] ) {
                    $block_content .= '<figure class="mx-auto text-center mb-5">';
                    $block_content .= '<img class="js-svg-injector" src="' . esc_url( $attributes['quote_style_9'] ) . '" alt="' . (__('SVG', FRONTGB_I18N)) . '"/>';
                    $block_content .= '</figure>';
                }
                $block_content .= '<div class="js-slick-carousel u-slick " data-fade="true" data-autoplay="true" data-autoplay-speed="' . apply_filters( 'frontgb_testimonial_carousel_block_9_slick_data_speed', esc_attr( "7000" ) ) . '" data-pagi-classes="text-center u-slick__pagination mt-7 mb-0">';
                $block_content .= wp_kses_post( $posts_markup );
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '</div>';
            break;
        }

        if ( ! post_type_exists( 'jetpack-testimonial' ) ) {
            $block_alert = esc_html__( 'Testimonial post type is not available', FRONTGB_I18N );
        } else {
            $block_alert = esc_html__( 'Testimonials is empty', FRONTGB_I18N );
        }

        return ( 
            ( post_type_exists( 'jetpack-testimonial' ) && ! empty( $recent_posts ) ) 
            ? 
            '<div class="testimonial-carousel-jetpack' . esc_attr( ! empty($attributes['className']) ? ' ' . $attributes['className'] : ''  ) . '">' . $block_content . '</div>'
            : 
            '<div class="container space-2">
                <p class="text-danger text-center font-size-2 mb-0">'
                . esc_html( $block_alert ) . 
                '</p>
            </div>'
        );        
    }
}

if ( ! function_exists( 'frontgb_register_testimonial_carousel_block' ) ) {
    /**
     * Registers the `fgb/testimonial-carousel` block on server.
     */
    function frontgb_register_testimonial_carousel_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/testimonial-carousel',
            array(
                'attributes' => array(
                    'className' => array(
                        'type' => 'string',
                        'default' => '',
                    ),
                    'order' => array(
                        'type' => 'string',
                        'default' => 'asc',
                    ),
                    'orderBy' => array(
                        'type' => 'string',
                        'default' => 'title',
                    ),
                    'postsToShow' => array(
                        'type' => 'number',
                        'default' => 4,
                    ),
                    'displayAuthorImage' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayAuthor' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayExcerpt' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayAuthorPosition' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayQuote' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayStarRatings' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayBg' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayBgSvg1' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayBgSvg2' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayQuationBg' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayReviewlabel' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displaySectionTitle' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displaySectionPreTitle' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'enablecontainer' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'design' => array(
                        'type' => 'string',
                        'default' => 'style-1',
                    ),
                    'svg_quote1' => array(
                        'type' => 'string',
                        'default' => front_get_assets_url() . 'svg/illustrations/quote1.svg',
                    ),
                    'svg_quote2' => array(
                        'type' => 'string',
                        'default' => front_get_assets_url() . 'svg/illustrations/quote2.svg',
                    ),
                    'svg_quote3' => array(
                        'type' => 'string',
                        'default' => front_get_assets_url() . 'svg/illustrations/quote3.svg',
                    ),
                    'svg_bg1' => array(
                        'type' => 'string',
                        'default' => front_get_assets_url() . 'svg/components/bg-elements-5.svg',
                    ),
                    'svg_bg2' => array(
                        'type' => 'string',
                        'default' => front_get_assets_url() . 'svg/components/double-ellipse-top-right.svg',
                    ),
                    'quation_bg' => array(
                        'type' => 'string',
                        'default' => front_get_assets_url() . 'svg/components/background-quote.svg',
                    ),
                    'quote_style_9' => array(
                        'type' => 'string',
                        'default' => front_get_assets_url() . 'svg/illustrations/testimonial-static-default-quote.svg', 
                    ),
                    'bg_image1' => array(
                        'type' => 'string',
                    ),
                    'starRatings' => array(
                        'type' => 'number',
                        'default' => 5,
                    ),
                    'bg_color' => array(
                        'type' => 'string',
                    ),
                    'bg_cusomColor' => array(
                        'type' => 'string',
                    ),
                    'align' => array(
                        'type' => 'string',
                        'default' => 'right',
                    ),
                    'primary_bg' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'shadow' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'reviewLabel' => array(
                        'type' => 'string',
                        'default' => 'Review',
                    ),
                    'svgImg' => array(
                        'type' => 'string',
                        'default' => front_get_assets_url() . 'svg/icons/icon-4.svg',
                    ),
                    'sectionTitle' => array(
                        'type' => 'string',
                    ),
                    'sectionPreTitle' => array(
                        'type' => 'string',
                        'default' => 'Testimonials',
                    ),
                    'displaySectionHeader' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displaySectionSvg' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'posts'=> array(
                        'type' => 'array',
                        'items' => array(
                          'type' => 'object'
                        ),
                        'default' => [],
                    ),
                ),
                'render_callback' => 'frontgb_render_testimonial_carousel_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_testimonial_carousel_block' );
}


if ( ! function_exists( 'frontgb_testimonial_carousel_rest_fields' ) ) {
    /**
     * Add more data in the REST API that we'll use in the testimonial post.
     *
     * @since 1.7
     */
    function frontgb_testimonial_carousel_rest_fields() {

        // Featured image urls.
        register_rest_field( 'jetpack-testimonial', 'featured_image_urls',
            array(
                'get_callback' => 'frontgb_testimonial_carousel_featured_image_urls',
                'update_callback' => null,
                'schema'          => null,
            )
        );
    }
    add_action( 'init', 'frontgb_testimonial_carousel_rest_fields' );
}

if ( ! function_exists( 'frontgb_testimonial_carousel_featured_image_urls' ) ) {
    /**
     * Get the different featured image sizes that the testimonial will use.
     *
     * @since 1.7
     */
    function frontgb_testimonial_carousel_featured_image_urls( $object, $field_name, $request ) {
        $image = wp_get_attachment_image_src( $object['featured_media'], 'full', false );
        return array(
            'full' => is_array( $image ) ? $image : '',
        );
    }
}
