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
if ( ! function_exists( 'frontgb_render_hero_posts_subblock' ) ) {
    function frontgb_render_hero_posts_subblock( $attributes ) {
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

            //Author id
            $post_author_id = get_post_field( 'post_author', $post_id );

            //Author image
            $author_image = get_avatar_url( $post_author_id );

            //Author link
            $author_link = get_author_posts_url( $post_author_id );

            //Author name
            $author_name = get_the_author_meta( 'display_name', $post['post_author'] );

            /**
             * This is the default basic style.
             */

            $post_markup  = '<div class="w-lg-50">';
            $post_markup  .= '<div class="media align-items-center mb-4">';
            if ($attributes['displayAuthorImage']) {
                $post_markup .= '<div class="u-sm-avatar mr-3">';
                $post_markup .= '<img class="img-fluid rounded-circle" src=' . esc_url( $author_image ) . '  alt="Image Description"/>';
                $post_markup .= '</div>';
            }
            if ($attributes['displayAuthorName']) {
                $post_markup .= '<h4 class="d-inline-block mb-0">';
                $post_markup .= '<a class="d-block h6 mb-0" href=' . esc_html( $author_link ) . '>' . esc_html( $author_name ) . '</a>';
                $post_markup .= '</h4>';
                $post_markup .= '</div>';
            }
            $post_markup .= '<div class="mb-4">';
            if ($attributes['displayPostTitle']) {
                $post_markup .= '<h1 class="text-primary display-4 font-size-md-down-5 font-weight-semi-bold">' . esc_html( $post_title ) . '</h1>';
            }
            if ($attributes['displayPostContent']) {
                $post_markup .= '<p class="lead">' . esc_html( $post_content ) . '</p>';
            }
            $post_markup .= '</div>';
            if ($attributes['displayPostLink']) {
                $post_markup .='<a class="btn btn-primary btn-wide transition-3d-hover" href=' . esc_url( $read_more ) . '>';
                 $post_markup .=esc_html(__('Read More', FRONTGB_I18N));
                $post_markup .='<span class="fas fa-angle-right ml-2">';
                $post_markup .='</span>';
                $post_markup .='</a>';
            }
            $post_markup .= '</div>';
            $post_markup .=  '<figure class="d-none d-lg-block w-75 position-absolute bottom-0 left-0 z-index-n1">';
            $post_markup .= '<img class="js-svg-injector" src="' . front_get_assets_url() . 'svg/components/wave-3-bottom.svg" alt="Image Description"
                                data-parent="#SVGwaveBottom3Shape">';
            $post_markup .= '</figure>';

            // Let others change the saved markup.
            $props = array(
				'post_id' => $post_id,
                'attributes' => $attributes,
            );

            $post_markup = apply_filters( 'frontgb/designs_blog-posts_save', $post_markup, $attributes, $props );
            $posts_markup .= $post_markup;
        }

            $block_content = $posts_markup;
           
            

        return $block_content;
    }
}

if ( ! function_exists( 'frontgb_register_hero_posts_subblock' ) ) {
    /**
     * Registers the `fgb/hero-post-subblock` block on server.
     */
    function frontgb_register_hero_posts_subblock() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/hero-post-subblock-1',
            array(
                'attributes' => array(
                    'className' => array(
                        'type' => 'string',
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
                    'displayAuthorImage' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayAuthorName' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'icon' => array(
                        'type' => 'number',
                        'default' => 3,
                    ),
                    'posts'=> array(
                        'type' => 'array',
                        'items' => array(
                          'type' => 'object'
                        ),
                        'default' => [],
                    ),
                     'postsToShow' => array(
                        'type' => 'string',
                        'default' => 1,
                    ),
                ),
                'render_callback' => 'frontgb_render_hero_posts_subblock',
            )
        );
    }
    add_action( 'init', 'frontgb_register_hero_posts_subblock' );
}

if ( ! function_exists( 'frontgb_hero_posts_rest_fields' ) ) {
    /**
     * Add more data in the REST API that we'll use in the blog post.
     *
     * @since 1.7
     */
    function frontgb_hero_posts_subblock_rest_fields() {

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
    add_action( 'rest_api_init', 'frontgb_hero_posts_subblock_rest_fields' );
}

if ( ! function_exists( 'frontgb_hero_post_subblock_featured_image_urls' ) ) {
    /**
     * Get the different featured image sizes that the blog will use.
     *
     * @since 1.7
     */
    function frontgb_hero_post_subblock_featured_image_urls( $object, $field_name, $request ) {
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