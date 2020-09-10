<?php
/**
 * Server-side rendering of the `fgb/news-blog` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/news-blog` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */


if ( ! function_exists( 'frontgb_render_news_blog_posts_block' ) ) {
    function frontgb_render_news_blog_posts_block( $attributes ) {
        
        $query_args = array(
            'numberposts' => ! empty( $attributes['postsToShow'] ) ? $attributes['postsToShow'] : '',
            'post_status' => 'publish',
            'order' => ! empty( $attributes['order'] ) ? $attributes['order'] : '',
            'orderby' => ! empty( $attributes['orderBy'] ) ? $attributes['orderBy'] : '',
            'category' => ( ! empty( $attributes['categories'] ) && empty( $attributes['posts'] ) ) ? $attributes['categories'] : '',
            'include'     => ( ! empty( $attributes['posts'] ) && is_array($attributes['posts']) ) ? array_column($attributes['posts'], 'id') : '',
        );

        $recent_posts = wp_get_recent_posts( $query_args );

        $posts_markup = '';
        $props = array( 'attributes' => array() );

        foreach ( $recent_posts as $index => $post ) {
            $post_id = $post['ID'];

            $post_format = get_post_format($post_id);

            $title_word_trim = '';

            if ($attributes['design'] == 'style-1') {
                $title_word_trim = strlen(get_the_title( $post_id ));
            } 
            else if ($attributes['design'] == 'style-5') {
                $title_word_trim = 4;
            } 
            else if ($attributes['design'] == 'style-4') {
                $title_word_trim = 10;
            } 
            else {
                $title_word_trim = 8;
            }

            // Title.
            $post_title= wp_trim_words( get_the_title( $post_id ), $title_word_trim, '...' ) . ( $attributes['design'] == 'style-1' ? '. ' : '' );

            // Category.
            $category = wp_strip_all_tags( get_the_category_list( esc_html__( ', ', FRONTGB_I18N ), '', $post_id ), true);

            $test = array(80, 76);

            $image_size = 'full';

            if ( function_exists( 'front_get_image_size' ) ) {
                if ( $attributes['design'] == 'style-1' ) {
                    $image_size = front_get_image_size( 'blog_classic_agency_thumbnail', 'full' );
                }

                if ( $attributes['design'] == 'style-5' ) {
                    $image_size = front_get_image_size( 'blog_agency_thumbnail_4', 'full' );
                }

                if ( $attributes['design'] == 'style-7' ) {
                    $image_size = front_get_image_size( 'blog_crypto_demo_thumbnail', 'full' );
                }
            }

            // Featured image.
            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $image_size );

            $word_trim = '';

            if ($attributes['design'] == 'style-1') {
                $word_trim = 50;
            }
            elseif ($attributes['design'] == 'style-5') {
                $word_trim = 10;
            } 
            else {
                $word_trim = 15;
            }

            // Post Content
            $post_content = wp_strip_all_tags( wp_trim_words(get_the_excerpt( $post_id, $post ), $word_trim, '...' ), true );

            // Post Excerpt.
            $post_excerpt = get_post_field( 'post_excerpt', $post_id );

            //Author name
            $author_name = get_the_author_meta( 'display_name', $post['post_author'] );

            //Author id
            $post_author_id = get_post_field( 'post_author', $post_id );

            //Author image
            $author_image = get_avatar_url( $post_author_id );

            //Author link
            $author_link = get_author_posts_url( $post_author_id );

            // Read more link.
            $read_more = get_the_permalink( $post_id );

            // Posted date.
            $post_date = get_the_date('F j, Y',$post_id);

            // Posted date ago.
            $post_time_ago = human_time_diff( get_the_time('U', $post_id), current_time( 'timestamp' ) ) . ' ago';
            
            /**
             * This is the default style.
             */
            $post_markup = '';
            if ( $attributes['design'] === 'style-1' && $index % 2 === 0 ) {
                $post_markup  = '<a class="js-slide bg-img-hero transition-3d-hover rounded-pseudo my-4 slick-slide ' . esc_attr( ! empty( $attributes['overlayBgColor'] ) ? $attributes['overlayBgColor'] : '' ) . '" href=' . esc_url($read_more) . ' style="background-image: url(' . esc_url($featured_image[0]) . ')">';
                $post_markup .= '<article class="align-self-end w-100 text-center p-6">';
                if ($attributes['displayPostTitle']) {
                    $post_markup .= '<h3 class="h4 text-white">' . esc_html($post_title) . '</h3>';
                }
                $post_markup .= '<div class="mt-4">';
                if ($attributes['displayPostAuthor']) {
                    $post_markup .= '<strong class="d-block text-white-70 mb-2">' . esc_html($author_name) . '</strong>';
                }
                if ($attributes['displayPostAuthorImage']) {
                    $post_markup .= '<div class="u-avatar mx-auto">';
                    $post_markup .= '<img class="img-fluid rounded-circle" src=' . esc_url($author_image) . ' alt="' . esc_attr( $author_name ) . '"/>';
                    $post_markup .= '</div>';
                }
                $post_markup .= '</div>';
                $post_markup .= '</article>';
                $post_markup .= '</a>';
            }

            if ( $attributes['design'] === 'style-1' && $index % 2 === 1 ) {
                $post_markup  = '<div class="js-slide position-relative bg-white shadow-sm transition-3d-hover rounded my-4">';
                $post_markup .= '<article class="align-self-end w-100 text-center p-6">';
                if ($attributes['displayPostContent']) {
                    $post_markup .= '<h3 class="h6 font-weight-normal">" ' . esc_html( $post_title ) . esc_html( $post_excerpt ) . ' "</h3>';
                }
                $post_markup .= '<div class="my-4">';
                if ($attributes['displayPostAuthor']) {
                    $post_markup .= '<strong class="d-block mb-2">' . esc_html($author_name) . '</strong>';
                }
                if ($attributes['displayPostAuthorImage']) {
                    $post_markup .= '<div class="u-avatar mx-auto">';
                    $post_markup .= '<img class="img-fluid rounded-circle" src=' . esc_url($author_image) . ' alt="' . esc_attr( $author_name ) . '"/>';
                    $post_markup .= '</div>';
                }
                $post_markup .= '</div>';
                $post_markup .= '<a class="btn btn-sm btn-soft-primary btn-wide transition-3d-hover" href=' . esc_url(  $read_more ) . ' tabindex="0">' . esc_html(__('Read More', FRONTGB_I18N)) . '</a>';
                $post_markup .= '</article>';
                $post_markup .= '</div>';
            }

            // Let others change the saved markup.
            $props = array(
                'index' => $index,
                'post_id' => $post_id,
                'attributes' => $attributes,
                'category' => $category,
                'featured_image' => $featured_image[0],
                'author_name' => $author_name,
                'author_image' => $author_image,
                'author_link' => $author_link,
                'post_title' => $post_title,
                'post_content' => $post_content,
                'read_more' => $read_more,
                'post_date' => $post_date,
                'post_time_ago' => $post_time_ago,
                'post_format' => $post_format,
                'featured_image_width' => $featured_image[1],
                'featured_image_height' => $featured_image[2],
            );

            $post_markup = apply_filters( 'frontgb/designs_blog-posts_save', $post_markup, $attributes['design'], $props );
            $posts_markup .= $post_markup;
        }

        $carousel_args = array(
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
            array(
                'breakpoint'    => 554,
                'settings'      => array(
                    'slidesToShow'      => 1,
                )
            ),
        );

        $carousel_args1 = array(
            array(
                'breakpoint'    => 1200,
                'settings'      => array(
                    'slidesToShow'      => 3,
                )
            ),
            array(
                'breakpoint'    => 992,
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

        $carousel_args2 = array(
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

        $carousel_args3 = array(
            array(
                'breakpoint'    => 992,
                'settings'      => array(
                    'slidesToShow'      => 1,
                )
            ),
            array(
                'breakpoint'    => 768,
                'settings'      => array(
                    'slidesToShow'      => 1,
                )
            ),
            array(
                'breakpoint'    => 554,
                'settings'      => array(
                    'slidesToShow'      => 1,
                )
            ),
        );

        $cube_args = array(
            array(
                'width'    => 1500,
                'cols'      => 4,
            ),
            array(
                'width'    => 1100,
                'cols'      => 4,
            ),
            array(
                'width'    => 800,
                'cols'      => 3,
            ),
            array(
                'width'    => 480,
                'cols'      => 2,
            ),
            array(
                'width'    => 300,
                'cols'      => 1,
            ),
        );

        $cube_args1 = array(
            array(
                'width'    => 1500,
                'cols'      => 3,
            ),
            array(
                'width'    => 1100,
                'cols'      => 3,
            ),
            array(
                'width'    => 800,
                'cols'      => 3,
            ),
            array(
                'width'    => 480,
                'cols'      => 1,
            ),
        );

        $defaultPretitleBg = '';
        $defaultSectionBg = '';

        if ( $attributes['design'] === 'style-1' || $attributes['design'] === 'style-4' ) {
            $defaultSectionBg = 'gradient-half-primary-v2';
        }

        if ( $attributes['design'] === 'style-2' || $attributes['design'] === 'style-6' ) {
            $defaultSectionBg = 'bg-light';
        }

        if ( $attributes['design'] === 'style-5' ) {
            $defaultSectionBg = 'bg-primary';
        }

        if ( $attributes['design'] === 'style-4' ) {
            $defaultPretitleBg = 'btn-soft-primary';
        }
        else {
            $defaultPretitleBg = 'btn-soft-success';
        }

        switch ($attributes['design']) {
            case 'style-1':
                $block_content  = '<div class="news-blog-section style-1 ' . esc_attr( isset( $attributes['SectionBgColor'] ) ? $attributes['SectionBgColor'] : $defaultSectionBg ) . esc_attr( ! empty( $attributes['className'] ) ? ( ' ' . $attributes['className'] ) : '' ) . '" ' . ( ! empty($attributes['SectionCustomBgColor']) ? 'style="background-color:' .  esc_attr( ! empty($attributes['SectionCustomBgColor']) ? $attributes['SectionCustomBgColor'] : '' ) . '"' : '' ) . '>';
                $block_content .= '<div class="' . esc_attr(  $attributes['enableContainer'] ? 'container ' : '' ) . 'space-2 space-md-3 px-lg-7">';
                if ($attributes['displaySectionHeader']) {
                    $block_content .= '<div class="w-md-80 w-lg-50 text-center mx-md-auto mb-9">';
                    if ($attributes['displaySectionPretitle']) {
                        $block_content .= '<span class="btn btn-xs btn-pill mb-2 ' . esc_attr( isset( $attributes['preTitleBgColor'] ) ? $attributes['preTitleBgColor'] : $defaultPretitleBg ) . '" ' . ( ! empty($attributes['preTitleCustomBgColor'] ) ? 'style="background-color:' . $attributes['preTitleCustomBgColor'] : '' ) . '>' . wp_kses_post( ! empty ( $attributes['preTitle'] ) ? $attributes['preTitle'] : esc_html(__('News & Blog', FRONTGB_I18N)) ) . '</span>';
                    }
                    if ($attributes['displaySectionTitle']) {
                        $block_content .= '<h2>' . wp_kses_post( ! empty ( $attributes['title'] ) ? $attributes['title'] : esc_html(__('Read our latest news', FRONTGB_I18N)) ) . '</h2>';
                    }
                    if ($attributes['displaySectionDesc']) {
                        $block_content .= '<p>' . wp_kses_post( ! empty ( $attributes['desc'] ) ? $attributes['desc'] : esc_html(__("Our duty towards you is to share our experience we're reaching in our work path with you.", FRONTGB_I18N)) ) . '</p>';
                    }
                    $block_content .= '</div>';
                }
                $block_content .= '<div class="js-slick-carousel u-slick u-slick--equal-height u-slick--gutters-3" data-slides-show="3" data-slides-scroll="1" data-arrows-classes="d-none d-lg-inline-block u-slick__arrow u-slick__arrow--offset u-slick__arrow-centered--y rounded-circle" data-arrow-left-classes="fas fa-arrow-left u-slick__arrow-inner u-slick__arrow-inner--left" data-arrow-right-classes="fas fa-arrow-right u-slick__arrow-inner u-slick__arrow-inner--right" data-pagi-classes="text-center u-slick__pagination mt-7 mb-0" data-responsive="' . htmlspecialchars( json_encode( $carousel_args ), ENT_QUOTES, 'UTF-8' ) . '">';
                $block_content .= wp_kses_post($posts_markup);
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '</div>';
            break;

            case 'style-2':
                $block_content = '<div class="news-blog-section style-2 ' . esc_attr( isset( $attributes['SectionBgColor'] ) ? $attributes['SectionBgColor'] : $defaultSectionBg ) . esc_attr( ! empty( $attributes['className'] ) ? ( ' ' . $attributes['className'] ) : '' ) . '" ' . ( ! empty($attributes['SectionCustomBgColor']) ? 'style="' . ( ! empty($attributes['SectionCustomBgColor']) ? 'background-color: ' . $attributes['SectionCustomBgColor'] : '' ) . '"' : '' ) . '>';
                $block_content .= '<div class="space-2 space-md-3' . ( $attributes['enableContainer'] ? ' container' : '' ) . '">';
                    if ($attributes['displaySectionHeader']) {
                        $block_content .= '<div class="w-md-80 w-lg-50 text-center mx-md-auto mb-9">';
                        if ($attributes['displaySectionPretitle']) {
                            $block_content .= '<span class="btn btn-xs btn-pill mb-2 ' . esc_attr( isset( $attributes['preTitleBgColor'] ) ? $attributes['preTitleBgColor'] : $defaultPretitleBg ) . '" style="' .  ( ! empty($attributes['preTitleCustomBgColor']) ? 'background-color: ' . $attributes['preTitleCustomBgColor'] : '' ) . '">' . wp_kses_post( ! empty ( $attributes['preTitle'] ) ? $attributes['preTitle'] : esc_html(__('News', FRONTGB_I18N)) ) . '</span>';
                        }
                        if ($attributes['displaySectionTitle']) {
                            $block_content .= '<h2 class="text-primary">' . wp_kses_post( ! empty ( $attributes['title'] ) ? $attributes['title'] : (__('Read our <span class="font-weight-semi-bold">news & blogs</span>', FRONTGB_I18N)) ) . '</h2>';
                        }
                        if ($attributes['displaySectionDesc']) {
                            $block_content .= '<p>' . wp_kses_post( ! empty ( $attributes['desc'] ) ? $attributes['desc'] : esc_html(__("Our duty towards you is to share our experience we're reaching in our work path with you.", FRONTGB_I18N)) ) . '</p>';
                        }
                        $block_content .= '</div>';
                    }
                $block_content .= '<div class="js-slick-carousel u-slick u-slick--equal-height u-slick--gutters-2" data-slides-show="4" data-slides-scroll="1" data-pagi-classes="text-center u-slick__pagination mt-7 mb-0" data-responsive="' . htmlspecialchars( json_encode( $carousel_args1 ), ENT_QUOTES, 'UTF-8' ) . '">';
                $block_content .= wp_kses_post($posts_markup);
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '</div>';
            break;

            case 'style-3':
                $block_content  = '<div class="news-blog-section style-3 space-top-3' . ( $attributes['enableContainer'] ? ' container' : '' ) . esc_attr( ! empty( $attributes['className'] ) ? ( ' ' . $attributes['className'] ) : '' ) . '">';
                $block_content .= '<div class="' . ( $attributes['enableMaxWidth'] ? ' w-lg-65 ' : '' ) . 'mx-lg-auto">';
                $block_content .= '<div class="d-block d-md-flex flex-wrap mx-md-n3">';
                $block_content .= wp_kses_post($posts_markup);
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '</div>';
            break;

            case 'style-4':
                $block_content   = '<div class="news-blog-section style-4 ' . esc_attr( isset( $attributes['SectionBgColor'] ) ? $attributes['SectionBgColor'] : $defaultSectionBg ) . esc_attr( ! empty( $attributes['className'] ) ? ( ' ' . $attributes['className'] ) : '' ) . '" ' . ( ! empty($attributes['SectionCustomBgColor']) ? 'style="' .  ( ! empty($attributes['SectionCustomBgColor']) ? 'background-color: ' . $attributes['SectionCustomBgColor'] : '' ) . '"' : '' ) . '>';
                $block_content  .= '<div class="' . esc_attr( $attributes['enableContainer'] ? 'container ' : '' ) . 'space-2 space-md-3 u-cubeportfolio">';
                if ($attributes['displaySectionHeader']) {
                    $block_content .= '<div class="w-md-80 w-lg-50 text-center mx-md-auto mb-9">';
                    if ($attributes['displaySectionPretitle']) {
                        $block_content .= '<span class="btn btn-xs btn-pill mb-2 ' . esc_attr( isset( $attributes['preTitleBgColor'] ) ? $attributes['preTitleBgColor'] : $defaultPretitleBg ) . '" ' .  ( ! empty( $attributes['preTitleCustomBgColor'] ) ? ( 'style="background-color:' .  $attributes['preTitleCustomBgColor'] . '"' ) : '' ) . '>' . wp_kses_post( ! empty ( $attributes['preTitle'] ) ? $attributes['preTitle'] : esc_html(__('News', FRONTGB_I18N)) ) . '</span>';
                    }
                    if ($attributes['displaySectionTitle']) {
                        $block_content .= '<h2 class="h3 font-weight-normal">' . wp_kses_post( ! empty ( $attributes['title'] ) ? $attributes['title'] : esc_html(__('Read our latest news', FRONTGB_I18N)) ) . '</h2>';
                    }
                    $block_content .= '</div>';
                }
                $block_content .= '<div class="cbp mb-7 cbp-caption-active cbp-caption-overlayBottomAlong cbp-ready" data-layout="' . esc_attr( $attributes['layoutMode'] ) . '" data-animation="quicksand" data-x-gap="16" data-y-gap="16" data-load-more-selector="#cubeLoadMore" data-load-more-action="click" data-load-items-amount="4" data-media-queries="' . htmlspecialchars( json_encode( $cube_args ), ENT_QUOTES, 'UTF-8' ) . '">';
                $block_content .= wp_kses_post($posts_markup);
                $block_content .= '</div>';
                if ($attributes['displayReadMoreButton']) {
                    $block_content .= '<div id="cubeLoadMore" class="text-center">';
                    $block_content .= '<a href="#" class="cbp-l-loadMore-link link" rel="nofollow">';
                    $block_content .= '<span class="cbp-l-loadMore-defaultText">';
                    $block_content .= (__('Load More', FRONTGB_I18N));
                    $block_content .= '<span class="link__icon ml-1">';
                    $block_content .= '<span class="link__icon-inner">+</span>';
                    $block_content .= '</span>';
                    $block_content .= '</span>';
                    $block_content .= '<span class="cbp-l-loadMore-loadingText">' . (__('Loading...', FRONTGB_I18N)) . '</span>';
                    $block_content .= '<span class="cbp-l-loadMore-noMoreLoading">' . (__('No more works', FRONTGB_I18N)) . '</span>';
                    $block_content .= '</a>';
                    $block_content .= '</div>';
                }
                $block_content .= '</div>';
                $block_content .= '</div>';
            break;

            case 'style-5':
                $block_content  = '<div class="news-blog-section style-5 ' . esc_attr( isset( $attributes['SectionBgColor'] ) ? $attributes['SectionBgColor'] : $defaultSectionBg ) . esc_attr( ! empty( $attributes['className'] ) ? ( ' ' . $attributes['className'] ) : '' ) . '" ' . ( ! empty($attributes['SectionCustomBgColor']) ? 'style="background-color: ' .  ( ! empty($attributes['SectionCustomBgColor']) ? $attributes['SectionCustomBgColor'] : '' ) . '"' : '' ) . '>';
                $block_content .= '<div class="space-1' . ( $attributes['enableContainer'] ? ' container' : '' ) . '">';
                $block_content .= '<div class="js-slick-carousel u-slick u-slick--gutters-3" data-slides-show="3" data-slides-scroll="1" data-autoplay="true" data-infinite="true" data-center-mode="true" data-speed="' . apply_filters( 'frontgb_news_block_5_slick_data_speed',  esc_attr( "5000" ) ) . '" data-responsive="' . htmlspecialchars( json_encode( $carousel_args2 ), ENT_QUOTES, 'UTF-8' ) . '">';
                $block_content .= wp_kses_post($posts_markup);
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '</div>';
            break;

            case 'style-6':
                $block_content   = '<div class="news-blog-section style-6 ' . esc_attr( isset( $attributes['SectionBgColor'] ) ? $attributes['SectionBgColor'] : $defaultSectionBg ) . esc_attr( ! empty( $attributes['className'] ) ? ( ' ' . $attributes['className'] ) : '' ) . '"' . ( ! empty($attributes['SectionCustomBgColor']) ? 'style="background-color:' .  ( ! empty($attributes['SectionCustomBgColor']) ? $attributes['SectionCustomBgColor'] : '' ) . '"' : '' ) . '>';
                $block_content  .= '<div class="' . ( $attributes['enableContainer'] ? 'container ' : '' ) . 'u-cubeportfolio space-2 space-md-3">';
                $block_content  .= '<div class="cbp mb-7 cbp-caption-active cbp-caption-overlayBottomAlong cbp-ready" data-layout="' . esc_attr( $attributes['layoutMode'] ) . '" data-animation="quicksand" data-x-gap="30" data-y-gap="30" data-load-more-selector="#cubeLoadMore" data-load-more-action="auto" data-load-items-amount="3" data-media-queries="' . htmlspecialchars( json_encode( $cube_args1 ), ENT_QUOTES, 'UTF-8' ) . '">';
                $block_content .= wp_kses_post($posts_markup);
                $block_content .= '</div>';
                $block_content .= '<div id="cubeLoadMore" class="text-center">';
                $block_content .= '<a href="#" class="cbp-l-loadMore-link link cbp-l-loadMore-loading" rel="nofollow">';
                $block_content .= '<span class="cbp-l-loadMore-defaultText">';
                $block_content .= 'Load More';
                $block_content .= '<span class="link__icon ml-1">';
                $block_content .= '<span class="link__icon-inner">+</span>';
                $block_content .= '</span>';
                $block_content .= '</span>';
                $block_content .= '<span class="cbp-l-loadMore-loadingText">Loading...</span>';
                $block_content .= '<span class="cbp-l-loadMore-noMoreLoading">No more works</span>';
                $block_content .= '</a>';
                $block_content .= '</div>';
                $block_content .= '</div>';
                $block_content .= '</div>';
            break;

            case 'style-7':
                $block_content  = '<div class="news-blog-section style-7 ' . ( $attributes['enableContainer'] ? 'container ' : '' ) . esc_attr( ! empty( $attributes['className'] ) ? ( $attributes['className'] . ' ' ) : '' ) . 'space-2 space-md-3">';
                if ($attributes['displaySectionHeader']) {
                    $block_content .= '<div class="w-md-80 w-lg-50 text-center mx-md-auto mb-9">';
                    if ($attributes['displaySectionTitle']) {
                        $block_content .= '<h2 class="text-primary font-weight-semi-bold">' . wp_kses_post( ! empty ( $attributes['title'] ) ? $attributes['title'] : esc_html(__('Bitcoin news', FRONTGB_I18N)) ) . '</h2>';
                    }
                    if ($attributes['displaySectionDesc']) {
                        $block_content .= '<p>' . wp_kses_post( ! empty ( $attributes['desc'] ) ? $attributes['desc'] : esc_html(__("Our duty towards you is to share our experience we're reaching in our work path with you.", FRONTGB_I18N)) ) . '</p>';
                    } 
                    $block_content .= '</div>';
                }
                $block_content .= '<div class="js-slick-carousel u-slick u-slick--equal-height" data-slides-show="2" data-slides-scroll="1" data-pagi-classes="text-center u-slick__pagination mt-7 mb-0" data-responsive="' . htmlspecialchars( json_encode( $carousel_args3 ), ENT_QUOTES, 'UTF-8' ) . '">';
                $block_content .= wp_kses_post($posts_markup);
                $block_content .= '</div>';
                $block_content .= '</div>';
            break;
        }

        return $block_content;
    }
}


if ( ! function_exists( 'frontgb_register_news_blog_posts_block' ) ) {
    /**
     * Registers the `fgb/news-blog` block on server.
     */
    function frontgb_register_news_blog_posts_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/news-blog',
            array(
                'attributes' => array(
                    'className' => array(
                        'type' => 'string',
                    ),
                    'order' => array(
                        'type' => 'string',
                        'default' => 'desc',
                    ),
                    'orderBy' => array(
                        'type' => 'string',
                        'default' => 'date',
                    ),
                    'categories' => array(
                        'type' => 'string',
                    ),
                    'postsToShow' => array(
                        'type' => 'number',
                        'default' => 9,
                    ),
                    'mdColumns' => array(
                        'type' => 'number',
                        'default' => 2,
                    ),
                    'displaySectionHeader' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displaySectionPretitle' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displaySectionTitle' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displaySectionDesc' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayPostTitle' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayPostContent' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayFeaturedImage' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayPostAuthor' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayPostAuthorImage' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayDate' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayCategory' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayIcon' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayReadMoreButton' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'enableContainer' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'enableMaxWidth' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'enableHighlight' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'design' => array(
                        'type' => 'string',
                        'default' => 'style-1',
                    ),
                    'layoutMode' => array(
                        'type' => 'string',
                        'default' => 'mosaic',
                    ),
                    'preTitle' => array(
                        'type' => 'string',
                    ),
                    'title' => array(
                        'type' => 'string',
                    ),
                    'desc' => array(
                        'type' => 'string',
                    ),
                    'SectionBgColor' => array(
                        'type' => 'string',
                    ),
                    'SectionCustomBgColor' => array(
                        'type' => 'string',
                    ),
                    'preTitleBgColor' => array(
                        'type' => 'string',
                    ),
                    'preTitleCustomBgColor' => array(
                        'type' => 'string',
                    ),
                    'overlayBgColor' => array(
                        'type' => 'string',
                        'default' => 'gradient-overlay-half-dark-v1',
                    ),
                    'backgroundType' => array(
                        'type' => 'string',
                    ),
                    'icon0' => array(
                        'type' => 'string',
                    ),
                    'icon1' => array(
                        'type' => 'string',
                    ),
                    'icon2' => array(
                        'type' => 'string',
                    ),
                    'posts'=> array(
                        'type' => 'array',
                        'items' => array(
                          'type' => 'object'
                        ),
                        'default' => [],
                    ),
                ),
                'render_callback' => 'frontgb_render_news_blog_posts_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_news_blog_posts_block' );
}

if ( ! function_exists( 'frontgb_news_blog_posts_rest_fields' ) ) {
    /**
     * Add more data in the REST API that we'll use in the blog post.
     *
     * @since 1.7
     */
    function frontgb_news_blog_posts_rest_fields() {

        // Featured image urls.
        register_rest_field( 'post', 'featured_image_url',
            array(
                'get_callback' => 'frontgb_news_blog_featured_image_url',
                'update_callback' => null,
                'schema'          => array(
                    'description' => __( 'Featured Image', FRONTGB_I18N ),
                    'type' => 'string',
                ),
            )
        );

        // Post content.
        register_rest_field( 'post', 'post_content',
            array(
                'get_callback' => 'frontgb_news_blog_post_excerpt',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'Post excerpt for FrontGB', FRONTGB_I18N ),
                    'type' => 'string',
                ),
            )
        );

        //Category name.
        register_rest_field( 'post', 'category',
            array(
                'get_callback' => 'frontgb_news_blog_category_list',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'Category', FRONTGB_I18N ),
                    'type' => 'string',
                ),
            )
        );

        //Category link.
        register_rest_field( 'post', 'category_link',
            array(
                'get_callback' => 'frontgb_news_blog_category_link',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'Category', FRONTGB_I18N ),
                    'type' => 'object',
                ),
            )
        );

        // Author name.
        register_rest_field( 'post', 'author_info',
            array(
                'get_callback' => 'frontgb_author_info',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'Author information', FRONTGB_I18N ),
                    'type' => 'array',
                ),
            )
        );

        // Post date.
        register_rest_field( 'post', 'date_info',
            array(
                'get_callback' => 'frontgb_news_blog_post_date',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'Post Date', FRONTGB_I18N ),
                    'type' => 'array',
                ),
            )
        );

        // Post time ago.
        register_rest_field( 'post', 'time_ago_info',
            array(
                'get_callback' => 'frontgb_news_blog_time_info',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'Post Time Ago', FRONTGB_I18N ),
                    'type' => 'array',
                ),
            )
        );
    }
    add_action( 'init', 'frontgb_news_blog_posts_rest_fields' );
}

if ( ! function_exists( 'frontgb_news_blog_featured_image_url' ) ) {
    /**
     * Get the different featured image sizes that the blog will use.
     *
     * @since 1.7
     */
    function frontgb_news_blog_featured_image_url( $object, $field_name, $request ) {
        return wp_get_attachment_image_src( $object['featured_media'], 'full', false );
    }
}

if ( ! function_exists( 'frontgb_news_blog_post_excerpt' ) ) {
    /**
     * Get the post excerpt.
     *
     * @since 1.7
     */
    function frontgb_news_blog_post_excerpt( $object ) {
        return wp_strip_all_tags(frontgb_get_excerpt( $object['id'] ), true );
    }
}

if ( ! function_exists( 'frontgb_get_excerpt' ) ) {
    /**
     * Get the excerpt.
     *
     * @since 1.7
     */
    function frontgb_get_excerpt( $post_id, $post = null ) {

        $excerpt = apply_filters( 'the_excerpt', get_post_field( 'post_excerpt', $post_id, 'display' ) );
        if ( ! empty( $excerpt ) ) {
            return $excerpt;
        }

        if ( ! empty( $post['post_content'] ) ) {
            return apply_filters( 'the_excerpt', $post['post_content'] );
        }

        $post_content = apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
        return apply_filters( 'the_excerpt', $post_content );
    }
}

if ( ! function_exists( 'frontgb_news_blog_category_list' ) ) {
    /**
     * Get the category.
     *
     * @since 1.7
     */
    function frontgb_news_blog_category_list( $object ) {
        return implode(', ', wp_list_pluck(get_the_category( $object['id'] ), 'name'));
    }
}

if ( ! function_exists( 'frontgb_news_blog_category_link' ) ) {
    /**
     * Get the category.
     *
     * @since 1.7
     */
    function frontgb_news_blog_category_link( $object ) {
        $categories = get_the_category( $object['id'] );

        $categories_list = array();

        if (! empty($categories) ) {
            foreach ($categories as $category) {
                $categories_list[] = array(
                    'link' => get_term_link( $category ),
                );
            }
        }

        return wp_list_pluck( $categories_list, 'link');
    }
}

if ( ! function_exists( 'frontgb_news_blog_post_date' ) ) {
    /**
     * Get the post date.
     *
     * @since 1.7
     */
    function frontgb_news_blog_post_date( $object ) {
        return get_the_date('F j, Y', $object['id']);
    }
}

if ( ! function_exists( 'frontgb_author_info' ) ) {
    /**
     * Get the author name and image.
     *
     * @since 1.7
     */
    function frontgb_author_info( $object ) {
        return array(
            'name' => get_the_author_meta( 'display_name', $object['author'] ),
            'url' => get_author_posts_url( $object['author'] ),
            'imageUrl' => get_avatar_url( $object['author'] ),
        );
    }
}

if ( ! function_exists( 'frontgb_news_blog_time_info' ) ) {
    /**
     * Get the post posted time ago.
     *
     * @since 1.7
     */
    function frontgb_news_blog_time_info( $object ) {
        return human_time_diff( get_the_time('U', $object['id']), current_time( 'timestamp' ) ) . ' ago';
    }
}