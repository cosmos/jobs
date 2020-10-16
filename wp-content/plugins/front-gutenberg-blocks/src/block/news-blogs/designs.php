<?php
/**
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'frontgb_blog_posts_designs' ) ) {

    /**
     * Render the design markup.
     *
     * @since 1.7
     */
    function frontgb_blog_posts_designs( $markup, $design, $props ) {
        $attributes = $props['attributes'];

        if ( $design == 'style-2' ) {
            $markup  = '<div class="js-slide card border-0 mb-3 slick-slide p-0 mt-0">';
            $markup .= '<div class="card-body p-5">';
            if ($attributes['displayDate']) {
                $markup .= '<small class="d-block text-muted mb-2">' . esc_html( $props['post_date'] ) . '</small>';
            }
            if ($attributes['displayPostTitle']) {
                $markup .= '<h2 class="h5">';
                $markup .= '<a href="'. esc_url(  $props['read_more'] ) . '" tabindex="0">' . esc_html( $props['post_title'] ) . '</a>';
                $markup .= '</h2>';
            }
            if ($attributes['displayPostContent']) {
                $markup .= '<p class="mb-0">' . esc_html( $props['post_content'] ) . '</p>';
            }
            $markup .= '</div>';
            $markup .= '<div class="card-footer pb-5 px-0 mx-5">';
            $markup .= '<div class="media align-items-center">';
            if ($attributes['displayPostAuthorImage']) {
                $markup .= '<div class="u-sm-avatar mr-3">';
                $markup .= '<img class="img-fluid rounded-circle" src=' . esc_url($props['author_image']) . ' alt="' . esc_attr( $props['author_name'] ) . '"/>';
                $markup .= '</div>';
            }
            if ($attributes['displayPostAuthor']) {
                $markup .= '<div class="media-body">';
                $markup .= '<h4 class="small mb-0"><a href="' . esc_url($props['author_link']) . '" tabindex="0">' .  esc_html( $props['author_name'] ) . '</a></h4>';
                $markup .= '</div>';
            }
            $markup .= '</div>';
            $markup .= '</div>';
            $markup .= '</div>';
            return $markup;
        }

        if ( $design == 'style-3' ) { 

            if ( $attributes['design'] === 'style-3' ) {
                $defaultSectionBg = 'bg-primary';
            }

            $articleClass = 'card border-0 transition-3d-hover p-0 px-md-3 mt-0' . ( ( $attributes['postsToShow'] != $attributes['mdColumns'] ) ? ' mb-5' : '' ) . ' shadow-none bg-transparent col-md-' . ( intval(12/$attributes['mdColumns']) );

            $postbg = isset( $attributes['SectionBgColor'] ) ? $attributes['SectionBgColor'] : $defaultSectionBg;

            $cardBodyClass = 'card-body p-6 rounded ' . ( ( ( $props['index'] % 2 ) == 0 && $attributes['enableHighlight'] ) ? esc_attr( $postbg ) . ' text-white shadow-primary-lg' : 'shadow-sm' );

            $cardBodyStyle = '';

            if ( ! empty($attributes['SectionCustomBgColor']) && ( $props['index'] % 2 ) == 0 && $attributes['enableHighlight'] ) {
                $cardBodyStyle .= 'background-color: ' . $attributes['SectionCustomBgColor'];
            }

            $iconClass = 'btn btn-lg btn-icon rounded-circle mb-9 ' . ( ( ( $props['index'] % 2 ) == 0 && $attributes['enableHighlight'] ) ? 'btn-soft-light' : 'btn-soft-primary' );

            $categoryClass = 'd-block text-uppercase mb-1 ' . ( ( ( $props['index'] % 2 ) == 0 && $attributes['enableHighlight'] ) ? 'text-white-70' : 'text-primary' );

            $titleClass = 'h5 mb-3' . ( ( ( $props['index'] % 2 ) == 0  && $attributes['enableHighlight'] ) ? ' text-white' : '' );

            $readMoreClass = 'btn btn-sm btn-pill transition-3d-hover ' . ( ( ( $props['index'] % 2 ) == 0 && $attributes['enableHighlight'] ) ? 'btn-soft-white' : 'btn-soft-primary' );


            $markup  = '<article class="' . esc_attr( $articleClass ) . '">';
            $markup .= '<div class="' . esc_attr( $cardBodyClass ) . '" style="' . esc_attr($cardBodyStyle) . '">';
            if ($attributes['displayIcon']) {
                $markup .= '<span class="' . esc_attr($iconClass) . '">';
                $markup .= '<span class="' . esc_attr( ! empty( $attributes['icon0'] ) ? $attributes['icon0'] : ( ( $props['index'] % 2 ) == 0 ? 'fab fa-audible' : 'far fa-file-archive' ) ) . ' font-size-5 btn-icon__inner btn-icon__inner-bottom-minus"></span>';
                $markup .= '</span>';
            }
            if ($attributes['displayCategory']) {
                $markup .= '<small class="' . esc_attr( $categoryClass ) . '">' . esc_html( $props['category'] ) . '</small>';
            }
            if ($attributes['displayPostTitle']) {
                $markup .= '<h3 class="' . esc_attr( $titleClass ) . '">' . esc_html( $props['post_title'] ) . '</h3>';
            }
            if ($attributes['displayReadMoreButton']) {
                $markup .= '<a class="' . esc_attr( $readMoreClass ) . '" href="' . esc_url( $props['read_more'] ) . '">' . esc_html(__('Read Now', FRONTGB_I18N)) . '</a>';
            }
            $markup .= '</div>';
            $markup .= '</article>';
            return $markup;
        }

        if ( $design == 'style-4' ) { 

            $articleClass = ( ( empty ( $props['featured_image'] ) ) ? 'card bg-primary text-white border-0 p-0 mt-0' : 'bg-white rounded-bottom' ) . ' mb-3';

            $smallClass = ( ( empty ( $props['featured_image'] ) ) ? 'text-white-70' : 'd-block text-secondary' ) . ' mb-1';

            $titleClass = ( $props['index'] == 0 ? 'h5' : 'h6' ) . ' mb-0' . ( ( empty ( $props['featured_image'] ) ) ? ' text-white' : '' );

            $markup  = '<div class="cbp-item">';
            $markup .= '<article class="' . esc_attr( $articleClass ) . '">';
            if ( ! empty ( $props['featured_image'] ) ) {
                $markup .= '<img class="card-img-top" src="' . esc_url( $props['featured_image'] ) . '" alt="' . (__('Img', FRONTGB_I18N)) . '"/>';
            }
            $markup .= '<div class="card-body p-5">';
            $markup .= '<small class="' . esc_attr( $smallClass ) . '">' . esc_html( $props['post_date'] ) . '</small>';
            $markup .= '<h3 class="' . esc_attr( $titleClass ) . '">';
            $markup .= '<a href="' . esc_url( $props['read_more'] ) . '">' . esc_html( $props['post_title'] ) . '</a>';
            $markup .= '</h3>';
            $markup .= '</div>';
            $markup .= '</article>';
            $markup .= '</div>';
            return $markup;
        }

        if ( $design == 'style-5' ) { 
            $markup   = '<div class="js-slide">';
            $markup  .= '<div class="u-blog-thumb-minimal">';
            $markup  .= '<a class="media" href="' . esc_url( $props['read_more'] ) . '" tabindex="-1">';
            if ( $attributes['displayFeaturedImage'] && ! empty( $props['featured_image'] ) ) {
                $markup  .= '<span class="d-flex u-blog-thumb-minimal__img-wrapper mr-3">';
                $markup  .= '<span class="u-blog-thumb-minimal__img-wrapper">';
                $markup  .= '<img class="img-fluid u-blog-thumb-minimal__img h-auto news_blog_v5_thumbnail" src="' . esc_url( $props['featured_image'] ) . '" alt="' . (__('Image', FRONTGB_I18N)) . '"/>';
                $markup  .= '</span>';
                $markup  .= '</span>';
            }
            $markup  .= '<span class="media-body">';
            if ( $attributes['displayPostTitle'] ) {
                $markup  .= '<span class="d-block h6 text-white mb-1 overflow-hidden">' . esc_html( $props['post_title'] ) . '</span>';
            }
            if ( $attributes['displayPostContent'] ) {
                $markup  .= '<small class="d-block text-white-70 overflow-hidden">' . esc_html( $props['post_content'] ) . '</small>';
            }
            $markup  .= '</span>';
            $markup  .= '</a>';
            $markup  .= '</div>';
            $markup  .= '</div>';
            return $markup;
        }

        if ( $design == 'style-6' ) { 

            $authorInfoClass = 'list-inline small mb-1 ' . ( ( empty ( $props['featured_image'] ) ) ? 'text-white-70' : 'text-muted' );

            $author_info  = '<ul class="' . esc_attr( $authorInfoClass ) . '">';
            $author_info .= '<li class="list-inline-item mr-0">' .  esc_html( $props['author_name'] ) . '</li>';
            $author_info .= '<li class="list-inline-item mx-2">–</li>';
            $author_info .= '<li class="list-inline-item">' . esc_html( $props['post_time_ago'] ) . '</li>';
            $author_info .= '</ul>';

            $articleClass1 = '';
            $cardBodyClass1 = '';

            if ( $props['post_format'] == 'quote' ) {
               $articleClass1 = 'bg-primary text-center';
               $cardBodyClass1 = 'py-9 px-7';
            }

            if ( empty ( $props['featured_image'] ) ) {
                if ( $props['post_format'] != 'quote' ) {
                    $articleClass1 = 'bg-dark';
                }

                if ( $props['featured_image_width'] > $props['featured_image_height'] ) {
                    $cardBodyClass1 = 'p-0';
                }               
            }

            $articleClass = 'card border-0 p-0 m-0 ' . $articleClass1;

            $cardBodyClass = 'card-body ' . $cardBodyClass1 . ( ( empty ( $props['featured_image'] ) ) || ( $props['featured_image_width'] < $props['featured_image_height'] ) ? 'p-5' : '' );

            $categories_list = array();

            $categories = get_the_category( $props['post_id'] );


            if (! empty($categories) ) {
                foreach ($categories as $cat) {
                    $categories_list[] = get_term_link( $cat );
                }
            }

            $categorySep = '';

            $categorySep = explode(",", $props['category']);

            $singlecat = '';

            foreach ($categorySep as $i => $catname) {
                $btnClass = '';

                if ( ! empty( $props['featured_image'] ) ) {
                    if ( ( $i + 1 ) % 5 === 1 ) {
                        $btnClass = 'btn-soft-danger';
                    } 

                    if ( ( $i + 1 ) % 5 === 2 ) {
                        $btnClass = 'btn-soft-success';
                    } 

                    if ( ( $i + 1 ) % 5 === 3 ) {
                        $btnClass = 'btn-soft-warning';
                    } 

                    if ( ( $i + 1 ) % 5 === 4 ) {
                        $btnClass = 'btn-soft-info';
                    }

                    if ( ( $i + 1 ) % 5 === 0 ) {
                        $btnClass = 'btn-soft-dark';
                    }
                } else {
                    $btnClass = 'btn-soft-white';
                }

                $singlecat .= '<li class="list-inline-item g-mb-10">';
                $singlecat .= '<a class="btn btn-xs ' . esc_attr( $btnClass ) . ' btn-pill m-1" href="' . esc_url( $categories_list[$i] ) . '">' . esc_html( $catname ) . '</a>';
                $singlecat .= '</li>';
            }
                
            $markup  = '<div class="cbp-item">';
            $markup .= '<div class="cbp-caption">';
            $markup .= '<article class="' . esc_attr( $articleClass ) . '">';
            if ( ! empty( $props['featured_image'] ) && ( $props['post_format'] != 'quote' ) && ( $props['featured_image_width'] < $props['featured_image_height'] ) ) {
                $markup .= '<img class="card-img-top" src="' . esc_url( $props['featured_image'] ) . '" alt="' . (__('Img', FRONTGB_I18N)) . '"/>';
            }
            if ( $props['post_format'] == 'quote' ) {
                $markup .= '<a class="' . esc_attr( $cardBodyClass ) . '" href="' . esc_url( $props['read_more'] ) . '">';
                $markup .= '<figure class="mx-auto mb-3">';
                $markup .= '<img class="js-svg-injector" src=' . front_get_assets_url() . 'svg/components/quote-news-blog.svg alt="Svg"/>';
                $markup .= '</figure>';
                $markup .= '<h3 class="h4 text-white mb-4">' . esc_html( $props['post_title'] ) . '</h3>';
                $markup .= '<small class="d-block text-white-70 mb-1">' .  esc_html( $props['author_name'] ) . '</small>';
                $markup .= '</a>';
            }
            if ( $props['post_format'] != 'quote' ) {
            $markup .= '<div class="' . esc_attr( $cardBodyClass ) . '">';
            if ( ! empty( $props['featured_image'] ) && ( $props['featured_image_width'] > $props['featured_image_height'] ) ) {
                $markup .= '<div class="row align-items-stretch no-gutters">';
                $markup .= '<div class="col-md-6">';
                $markup .= '<div class="p-5">';
                $markup .= wp_kses_post($author_info);
                $markup .= '<div class="mb-4">';
                $markup .= '<h2 class="h5 mb-3">';
                $markup .= '<a href="' . esc_url( $props['read_more'] ) . '">' . esc_html( $props['post_title'] ) . '</a>';
                $markup .= '</h2>';
                $markup .= '<p>' . esc_html( $props['post_content'] ) . '</p>';
                $markup .= '</div>';
                $markup .= '<ul class="list-inline mb-0">';
                $markup .= wp_kses_post( $singlecat );
                $markup .= '</ul>';
                $markup .= '</div>';
                $markup .= '</div>';
                $markup .= '<div class="col-md-6 bg-img-hero min-height-300 rounded" style="background-image: url(' . esc_url( $props['featured_image'] ) . ')"></div>';
                $markup .= '</div>';
            }
            if ( empty( $props['featured_image'] ) ) {
                $markup .= wp_kses_post($author_info);
                $markup .= '<div class="mb-4">';
                $markup .= '<h3 class="h5 text-white mb-0">';
                $markup .= '<a href="' . esc_url( $props['read_more'] ) . '">' . esc_html( $props['post_title'] ) . '</a>';
                $markup .= '</h3>';
                $markup .= '</div>';
                $markup .= '<ul class="list-inline mb-0">';
                $markup .= wp_kses_post( $singlecat );
                $markup .= '</ul>';
            } else if ( $props['featured_image_width'] < $props['featured_image_height'] ) {
                $markup .= wp_kses_post($author_info);        
                $markup .= '<div class="mb-4">';
                $markup .= '<h3 class="h5 mb-0">';
                $markup .= '<a href="' . esc_url( $props['read_more'] ) . '">' . esc_html( $props['post_title'] ) . '</a>';
                $markup .= '</h3>';
                $markup .= '</div>';    
                $markup .= '<ul class="list-inline mb-0">';
                $markup .= wp_kses_post( $singlecat );
                $markup .= '</ul>';
            }
            $markup .= '</div>';
            }
            $markup .= '</article>';
            $markup .= '</div>';
            $markup .= '</div>';
            return $markup;
        }

        if ( $design == 'style-7' ) { 
            $markup   = '<div class="js-slide">';
            $markup  .= '<article class="row w-100">';
            if ( $attributes['displayFeaturedImage'] && ! empty( $props['featured_image'] ) ) {
                $markup  .= '<div class="col-sm-5">';
                $markup  .= '<div class="d-none d-sm-block h-100 rounded bg-img-hero" style="background-image: url(' . $props['featured_image'] . ')"></div>';
                $markup  .= '<img class="img-fluid d-block d-sm-none w-100 rounded" alt="" src=' . $props['featured_image'] . ' alt="' . (__('Img', FRONTGB_I18N)) . '/>';
                $markup  .= '</div>';
            }
            $markup  .= '<div class="col-sm-' . ( empty( $props['featured_image'] ) ? '12' : '7' ) . '">';
            $markup  .= '<div class="pt-4 pr-4 pb-4">';
            if ($attributes['displayDate']) {
                $markup  .= '<small class="d-block text-muted mb-3">' . esc_html( $props['post_date'] ) . '</small>';
            }
            if ( $attributes['displayPostTitle'] || $attributes['displayPostContent'] ) {
                $markup  .= '<div class="mb-7">';
                if ($attributes['displayPostTitle']) {
                    $markup  .= '<h3 class="h5">';
                    $markup  .= '<a href="' . esc_url( $props['read_more'] ) . '">' . esc_html( $props['post_title'] ) . '</a>';
                    $markup  .= '</h3>';
                }
                if ($attributes['displayPostContent']) {
                    $markup  .= '<p>' . esc_html( $props['post_content'] ) . '</p>';
                }
                $markup  .= '</div>';
            }
            if ($attributes['displayPostAuthor']) {
                $markup  .= '<small class="d-block text-secondary">' . (__('by ', FRONTGB_I18N)) . '<a class="text-dark font-weight-semi-bold" href="' . esc_url($props['author_link']) . '" tabindex="0">' .  esc_html( $props['author_name'] ) . '</a></small>';
            }
            $markup  .= '</div>';
            $markup  .= '</div>';
            $markup  .= '</article>';
            $markup  .= '</div>';
            return $markup;
        }

        return $markup;
    }
    add_filter( 'frontgb/designs_blog-posts_save', 'frontgb_blog_posts_designs', 10, 3 );
}