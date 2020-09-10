<?php
/**
 * Server-side rendering of the `fgb/blog-posts` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the `fgb/blog-posts` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_hero_posts_block' ) ) {
    function frontgb_render_hero_posts_block( $attributes ) {
        $recent_posts = wp_get_recent_posts(
            array(
                'numberposts' => ! empty( $attributes['postsToShow'] ) ? $attributes['postsToShow'] : '',
                'post_status' => 'publish',
                'order' => ! empty( $attributes['order'] ) ? $attributes['order'] : '',
                'orderby' => ! empty( $attributes['orderBy'] ) ? $attributes['orderBy'] : '',
                'category' => ! empty( $attributes['categories'] ) ? $attributes['categories'] : '',
                'include'     => ( ! empty( $attributes['posts'] ) && is_array($attributes['posts']) ) ? array_column($attributes['posts'], 'id') : '',
            )
        );

		$posts_markup = '';
		$props = array( 'attributes' => array() );

        foreach ( $recent_posts as $post ) {
            $post_id = $post['ID'];

            // Title.
            $post_title = get_the_title( $post_id );

            // Post Content
            $post_content = wp_strip_all_tags( wp_trim_words(get_the_excerpt( $post_id, $post ), 50, '...' ), true );

            // Featured image.
            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'large' );

            // Read more link.
            $read_more = get_the_permalink( $post_id );

            /**
             * This is the default basic style.
             */
            $post_markup  = '<div class="js-slide ' . esc_attr( isset($attributes['overlayBgColor']) ? $attributes['overlayBgColor'] : 'gradient-overlay-half-primary-v1' ) .  ' bg-img-hero space-3 min-height-lg-100vh" style="background-image: url(' . esc_attr( ($attributes['displayFeaturedImage']) == true ? $featured_image[0] : '' ) . ')">';
            $post_markup .= '<div class="container d-lg-flex align-items-lg-center">';
            $post_markup .= '<article class="js-scroll-effect position-relative w-lg-60 text-center mx-lg-auto" data-scroll-effect="smoothFadeToBottom" data-scroll-effect-speed="500">';
            $post_markup .= '<div class="mb-4">';
            if ($attributes['displayPostTitle']) {
                $post_markup .= '<h2 class="h1 text-white font-weight-semi-bold mb-3" data-scs-animation-in="fadeInUp">' . esc_html( $post_title ) . '</h2>';
            } 
            if ($attributes['displayPostContent']) {
                $post_markup .= '<p class="text-white-70 mb-7" data-scs-animation-in="fadeInUp">' . esc_html( $post_content ) . '</p>';
            } 
            $post_markup .= '</div>';
            if ($attributes['displayPostLink']) {
                $post_markup .= '<a class="btn text-primary btn-white btn-pill btn-wide transition-3d-hover" href=' . esc_url( $read_more ) . '>' . esc_html__( 'Read More', FRONTGB_I18N ) . '</a>';
            } 
            $post_markup .= '</article>';
            $post_markup .= '</div>';
            $post_markup .= '</div>';
            

            // Let others change the saved markup.
            $props = array(
				'post_id' => $post_id,
                'attributes' => $attributes,
            );

            $post_markup = apply_filters( 'frontgb/designs_blog-posts_save', $post_markup, $attributes, $props );
            $posts_markup .= $post_markup;
        }


            $block_content  = '<div class="js-slick-carousel u-slick u-slick--equal-height" data-fade="true" data-infinite="true" data-autoplay="true" data-speed="10000" data-pagi-classes="text-center u-slick__pagination u-slick__pagination--white position-absolute right-0 bottom-0 left-0 mb-4 mb-0">';
            $block_content .= $posts_markup;
            $block_content .= '</div>';
            

        return $block_content;
    }
}

if ( ! function_exists( 'frontgb_register_hero_posts_block' ) ) {
    /**
     * Registers the `fgb/blog-posts` block on server.
     */
    function frontgb_register_hero_posts_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/hero-post-1',
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
                    'overlayBgColor' => array(
                        'type' => 'string',
                    ),
                    'categories' => array(
                        'type' => 'string',
                    ),
                    'postsToShow' => array(
                        'type' => 'number',
                        'default' => 6,
                    ),
                    'columns' => array(
                        'type' => 'number',
                        'default' => 2,
                    ),
                    'displayPostTitle' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayPostContent' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayPostLink' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayFeaturedImage' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'icon' => array(
                        'type' => 'number',
                        'default' => 3,
                    ),
                    'enableMargin' => array(
                        'type' => 'boolean',
                        'default' => false,
                    ),
                    'enableTransparent' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'enableCircle' => array(
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
                'render_callback' => 'frontgb_render_hero_posts_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_hero_posts_block' );
}

if ( ! function_exists( 'frontgb_hero_posts_rest_fields' ) ) {
    /**
     * Add more data in the REST API that we'll use in the blog post.
     *
     * @since 1.7
     */
    function frontgb_hero_posts_rest_fields() {

        // Featured image urls.
        register_rest_field( 'post', 'featured_image_urls',
            array(
                'get_callback' => 'frontgb_hero_post_featured_image_urls',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'Different sized featured images', FRONTGB_I18N ),
                    'type' => 'array',
                ),
            )
        );

        // Excerpt.
        register_rest_field( 'post', 'post_excerpt_frontgb',
            array(
                'get_callback' => 'frontgb_post_excerpt',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'Post excerpt for FrontGB', FRONTGB_I18N ),
                    'type' => 'string',
                ),
            )
        );

        // Category links.
        register_rest_field( 'post', 'category_list',
            array(
                'get_callback' => 'frontgb_category_list',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'Category list links', FRONTGB_I18N ),
                    'type' => 'string',
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

        // Number of comments.
        register_rest_field( 'post', 'comments_num',
            array(
                'get_callback' => 'frontgb_commments_number',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'Number of comments', FRONTGB_I18N ),
                    'type' => 'number',
                ),
            )
        );
    }
    add_action( 'rest_api_init', 'frontgb_hero_posts_rest_fields' );
}

if ( ! function_exists( 'frontgb_hero_post_featured_image_urls' ) ) {
    /**
     * Get the different featured image sizes that the blog will use.
     *
     * @since 1.7
     */
    function frontgb_hero_post_featured_image_urls( $object, $field_name, $request ) {
        return wp_get_attachment_image_src( $object['featured_media'], 'full', false );
    }
}

if ( ! function_exists( 'frontgb_author_info' ) ) {
    /**
     * Get the author name and link.
     *
     * @since 1.7
     */
    function frontgb_author_info( $object ) {
        return array(
            'name' => get_the_author_meta( 'display_name', $object['author'] ),
            'url' => get_author_posts_url( $object['author'] ),
        );
    }
}

if ( ! function_exists( 'frontgb_commments_number' ) ) {
    /**
     * Get the number of comments.
     *
     * @since 1.7
     */
    function frontgb_commments_number( $object ) {
        $num = get_comments_number( $object['id'] );
        return sprintf( _n( '%d comment', '%d comments', $num, FRONTGB_I18N ), $num );
    }
}

if ( ! function_exists( 'frontgb_category_list' ) ) {
    /**
     * Get the category links.
     *
     * @since 1.7
     */
    function frontgb_category_list( $object ) {
        return get_the_category_list( esc_html__( ', ', FRONTGB_I18N ), '', $object['id'] );
    }
}

if ( ! function_exists( 'frontgb_post_excerpt' ) ) {
    /**
     * Get the post excerpt.
     *
     * @since 1.7
     */
    function frontgb_post_excerpt( $object ) {
        return frontgb_get_excerpt( $object['id'] );
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
            return apply_filters( 'the_excerpt', wp_trim_words( $post['post_content'], 55 ) );
        }

        $post_content = apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
        return apply_filters( 'the_excerpt', wp_trim_words( $post_content, 55 ) );
    }
}