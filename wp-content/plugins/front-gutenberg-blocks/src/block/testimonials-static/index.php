<?php
/**
 * Server-side rendering of the `fgb/testimonial-static` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/testimonial-static` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_testimonial_static_block' ) ) {
    function frontgb_render_testimonial_static_block( $attributes ) {
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

            // echo '<pre>' . print_r($ratings) . '</pre>';

            $columnClass = $attributes['shadow'] ? 'col-lg-' .  ( intval( 12/$attributes['lgColumns'] ) ) : 'col-lg-' .  ( intval( 12/$attributes['lgColumns'] ) ) . ' px-lg-2';

            if ( $attributes['shadow'] ) {
                $columnClass .= ' mb-5';
            }

            if ( $attributes['shadow'] == false && ( $attributes['postsToShow'] != $attributes['lgColumns'] ) ) {
                $columnClass .= ' mb-5';
            }

            $cardClass = '';

            if ($attributes['shadow']) {
                $cardClass = 'card border-0 shadow-soft h-100 p-0 mt-0 mw-100';
            } else if ( $attributes['primary_bg'] ) {
                $cardClass = ($index + 3)%2 == 0 ? 'card border-0 bg-primary text-white shadow-primary-lg h-100 p-0 mt-0 mw-100' : 'card bg-transparent border-0 h-100 p-0 mt-0 mw-100 shadow-none';
            } else {
                $cardClass = 'card bg-transparent border-0 h-100 p-0 mt-0 mw-100 shadow-none';
            }

            $cardAuthorClass =  $attributes['shadow'] ? 'h6 mb-0' : 'h6 mb-1';

            $cardAuthorpPositionClass = $attributes['primary_bg'] && $attributes['shadow'] == false && ( ($index + 3)%2 == 0 ) ? 'd-block text-light' : 'd-block text-secondary';

            $default_color = '';

            switch ( $attributes['design'] ) {
                case 'style-3':
                    $default_color = 'gradient-half-primary-v1';
                break;

                case 'style-4':
                    $default_color = 'gradient-half-info-v1';
                break;

                case 'style-5':
                    $default_color = 'bg-light';
                break;

                case 'style-8':
                    $default_color = 'gradient-half-primary-v1';
                break;
            }
            
            /**
             * This is the default style-v1.
             */
            $post_markup  = '<div class="' . esc_attr( $columnClass ) . '">';
            $post_markup .= '<div class="' . esc_attr( $cardClass ) . '">';
            $post_markup .= '<div class="card-body p-5">';
            if ( $attributes['displayStarRatings'] && $ratings != '' ) {
                $post_markup .= '<ul class="list-inline text-warning testimonial-carousel-star-ratings">';
                for ($i = 1; $i <= $ratings; $i++) {
                    $post_markup .= '<li class="list-inline-item mx-0"><span class="fas fa-star"></span></li>';
                }
                $post_markup .= '</ul>';
            }
            if ($attributes['displayExcerpt']) {
                $post_markup .= '<div class="mb-auto">';
                $post_markup .= '<p class="mb-0' . ( $attributes['shadow'] ? esc_attr( ' text-dark' ) : '' ) . ( ($index + 3)%2 == 0 && $attributes['primary_bg'] && $attributes['shadow'] === false ? esc_attr( ' text-white' ) : '' ) . '">';
                $post_markup .= wp_kses_post( $content );
                $post_markup .= '</p>';
                $post_markup .= '</div>';
            }
            $post_markup .= '</div>';
            $post_markup .= '<div class="card-footer border-0 bg-transparent pt-0 px-5 pb-5">';
            $post_markup .= '<div class="media">';
            if ($attributes['displayAuthorImage']) {
                $post_markup .= '<div class="u-avatar mr-3">';
                $post_markup .= '<img class="img-fluid rounded-circle" src="' . esc_url( $featured_image ) . '" alt="' . esc_attr( get_the_title( $post_id ) ) . '">';
                $post_markup .= '</div>';
            }
            $post_markup .= '<div class="media-body">';
            if ($attributes['displayAuthor']) {
                $post_markup .= '<h4 class="' . esc_attr( $cardAuthorClass ) . '">';
                $post_markup .= esc_html( $Author );
                $post_markup .= '</h4>';
            }
            if ($attributes['displayAuthorPosition']) {
                $post_markup .= '<small class="' . esc_attr( $cardAuthorpPositionClass ) . '">';
                $post_markup .= esc_html( $excerpt );
                $post_markup .= '</small>';
            }
            $post_markup .= '</div>';
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
                'default_color' => $default_color,
                'index' => $index,
            );

            $post_markup = apply_filters( 'frontgb/designs_testimonial_static_save', $post_markup, $attributes['design'], $props );
            $posts_markup .= $post_markup . "\n";
        }

        $before_output = apply_filters( 'frontgb/testimonial_static_save_output_before', '', $attributes['design'], $props );
        $after_output = apply_filters( 'frontgb/testimonial_static_save_output_after', '', $attributes['design'], $props );

        $rowClass = $attributes['design'] == 'style-1' ? 'row' : '';

        if ( $attributes['shadow'] == false ) {
            $rowClass .= ' mx-lg-n2';
        }

        $wrapperClass = $attributes['enableBorderTop'] ? 'testimonial-static style-1 border-top' : 'testimonial-static style-1';

        $containerClass = $attributes['design'] == 'style-1' ? 'space-top-lg-3' : '';

        if ( $attributes['enablecontainer'] ) {
            $containerClass .= ' container';
        }

        if ( $attributes['design'] == 'style-1' ) {
            if ( $attributes['shadow'] == false ) {
                $containerClass .= ' space-2';
            }

            if ( $attributes['shadow'] == true ) {
                $containerClass .= ' space-top-2';
            }
        }

        $headerClass = $attributes['design'] == 'style-1' ? 'w-lg-50 mb-9' : '';

        $titleClass = $attributes['design'] == 'style-1' ? 'font-weight-medium' : '';

        if ( $attributes['shadow'] == true ) {
            $headerClass .= ' w-md-80';
            $titleClass  .= ' h1'; 
        }

        $defaultRichTitle = ( $attributes['primary_bg'] == true && $attributes['shadow'] == false) ? (__('Loved by business and individuals across the globe.', FRONTGB_I18N)) : (__('Front workflow is loved by users worldwide', FRONTGB_I18N));

        $sectionRichTitle  = '<div class="' . esc_attr( $headerClass ) . '">';
        $sectionRichTitle .= '<h2 class="' . esc_attr( $titleClass ) . '">' . esc_html( ! empty( $attributes['sectionTitle'] ) ? $attributes['sectionTitle'] : $defaultRichTitle ) . '</h2>';
        $sectionRichTitle .= '</div>';

        $block_content = sprintf(
            $attributes['design'] == 'style-1' ? 
            '<div class="' . esc_attr( $wrapperClass ) . '">' . '<div class="' . esc_attr( $containerClass ) . '">' . wp_kses_post( $attributes['enableSectionTitle'] == true ? $sectionRichTitle : '' ) . '<div class="' . esc_attr( $rowClass ) . '">%s%s%s</div></div></div>' 
            : 
            ( $attributes['design'] == 'style-7' ? 
                '<div class="testimonial-static style-7">' . wp_kses_post( $attributes['enableSectionTitle'] == true ? '<div class="mb-4">' . '<h4 class="h5">' . esc_html( ! empty( $attributes['sectionTitle'] ) ? $attributes['sectionTitle'] : (__('What people are saying', FRONTGB_I18N)) ) . '</h4>' . '</div>' : '' ) . '%s%s%s</div>'
            :
            '%s%s%s' ),
            $before_output,
            $posts_markup,
            $after_output
        );

        if ( ! post_type_exists( 'jetpack-testimonial' ) ) {
            $block_alert = esc_html__( 'Testimonial post type is not available', FRONTGB_I18N );
        } else {
            $block_alert = esc_html__( 'Testimonials is empty', FRONTGB_I18N );
        }

        return ( 
            ( post_type_exists( 'jetpack-testimonial' ) && ! empty( $recent_posts ) ) 
            ? 
            '<div class="testimonial-static-jetpack' . esc_attr( ! empty( $attributes['className'] ) ? ' ' . $attributes['className'] : '' ) . '">' . $block_content . '</div>'
            : 
            '<div class="container space-2">
                <p class="text-danger text-center font-size-2 mb-0">'
                . esc_html( $block_alert ) . 
                '</p>
            </div>'
        );
    }
}

if ( ! function_exists( 'frontgb_register_testimonial_static_block' ) ) {
    /**
     * Registers the `fgb/testimonial-static` block on server.
     */
    function frontgb_register_testimonial_static_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/testimonial-static',
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
                        'default' => 3,
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
                    'displayAuthorLocation' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayQuote' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayBgQuote' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayBgRound' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayStarRatings' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'enableSectionTitle' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'enablecontainer' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'enableseparator' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'shadow' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'primary_bg' => array(
                        'type' => 'boolean',
                        'default' => false,
                    ),
                    'enableBorderTop' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'design' => array(
                        'type' => 'string',
                        'default' => 'style-1',
                    ),
                    'quotationMark' => array(
                        'type' => 'string',
                        'default' => front_get_assets_url() . 'svg/illustrations/testimonial-static-default-quote.svg', 
                    ),
                    'quotationMark1' => array(
                        'type' => 'string',
                        'default' => front_get_assets_url() . 'svg/illustrations/testimonial-static-quote-2.svg', 
                    ),
                    'Authorcolor' => array(
                        'type' => 'string',
                        'default' => '',
                    ),
                    'Excerptcolor' => array(
                        'type' => 'string',
                        'default' => '',
                    ),
                    'AuthorPositioncolor' => array(
                        'type' => 'string',
                        'default' => '',
                    ),
                    'AuthorLocationcolor' => array(
                        'type' => 'string',
                        'default' => '',
                    ),
                    'quoteColor' => array(
                        'type' => 'string',
                        'default' => '#bdc5d1',
                    ),
                    'quoteColor1' => array(
                        'type' => 'string',
                        'default' => '#ffc107',
                    ),
                    'quotationSize' => array(
                        'type' => 'number',
                        'default' => 40,
                    ),
                    'quotationSize1' => array(
                        'type' => 'number',
                        'default' => 48,
                    ),
                    'svg_bg1' => array(
                        'type' => 'string',
                        'default' => front_get_assets_url() . 'svg/components/bg-quote.svg',
                    ),
                    'svg_bg2' => array(
                        'type' => 'string',
                        'default' => front_get_assets_url() . 'svg/components/irregular-shape-2-right.svg',
                    ),
                    'quote_style_5' => array(
                        'type' => 'string',
                        'default' => front_get_assets_url() . 'svg/illustrations/quote-style-5.svg',
                    ),
                    'quote_style_7' => array(
                        'type' => 'string',
                        'default' => front_get_assets_url() . 'svg/illustrations/testimonial-static-7.svg', 
                    ),
                    'bg_seperator' => array(
                        'type' => 'string',
                        'default' => '',
                    ),
                    'bg_gradientcolor1' => array(
                        'type' => 'string',
                    ),
                    'bg_image1' => array(
                        'type' => 'string',
                    ),
                    'posts'=> array(
                        'type' => 'array',
                        'items' => array(
                          'type' => 'object'
                        ),
                        'default' => [],
                    ),
                    'custom_bgcolor1' => array(
                        'type' => 'string',
                    ),
                    'lgColumns' => array(
                        'type' => 'number',
                        'default' => 3,
                    ),
                    'sectionTitle' => array(
                        'type' => 'string',
                        'default' => '',
                    ),
                    'align' => array(
                        'type' => 'string',
                        'default' => 'full',
                    ),
                ),
                'render_callback' => 'frontgb_render_testimonial_static_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_testimonial_static_block' );
}


if ( ! function_exists( 'frontgb_testimonial_static_rest_fields' ) ) {
    /**
     * Add more data in the REST API that we'll use in the testimonial static.
     *
     * @since 1.7
     */
    function frontgb_testimonial_static_rest_fields() {

        // Featured image urls.
        register_rest_field( 'jetpack-testimonial', 'featured_image_url',
            array(
                'get_callback' => 'frontgb_testimonial_static_featured_image_urls',
                'update_callback' => null,
                'schema'          => null,
            )
        );

        // Star Ratings.
        register_rest_field( 'jetpack-testimonial', 'star_ratings',
            array(
                'get_callback' => 'frontgb_testimonial_static_star_ratings',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'Star Ratings', FRONTGB_I18N ),
                    'type' => 'array',
                ),
            )
        );
    }
    add_action( 'init', 'frontgb_testimonial_static_rest_fields' );
}

if ( ! function_exists( 'frontgb_testimonial_static_featured_image_urls' ) ) {
    /**
     * Get the different featured image sizes that the testimonial static will use.
     *
     * @since 1.7
     */
    function frontgb_testimonial_static_featured_image_urls( $object, $field_name, $request ) {
        $image = wp_get_attachment_image_src( $object['featured_media'], 'full', false );
        return array(
            'full' => is_array( $image ) ? $image : '',
        );
    }
}

if ( ! function_exists( 'frontgb_testimonial_static_star_ratings' ) ) {
    /**
     * Get the star ratings that the testimonial static will use.
     *
     * @since 1.7
     */
    function frontgb_testimonial_static_star_ratings( $object, $field_name, $request ) {
        return get_post_meta( $object['id'], '_rating', true );
    }
}
