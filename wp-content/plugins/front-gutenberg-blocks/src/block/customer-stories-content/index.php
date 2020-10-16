<?php
/**
 * Server-side rendering of the `fgb/customer-stories-content` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/customer-stories-content` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_customer_stories_content_block' ) ) {
    function frontgb_render_customer_stories_content_block( $attributes ) {

        if ( ! class_exists( 'Front' ) ) {
            return '<p class="text-danger text-center font-size-2">' . __( 'Front is not activated', FRONTGB_I18N ) . '</p>';
        }

        if ( ! post_type_exists( 'customer_story' ) ) {
            return '<p class="text-danger text-center font-size-2">' . esc_html__( '"customer_story" post type is not available', FRONTGB_I18N ) . '</p>';
        }

        $default_args = array(
            'post_type'         => 'customer_story',
            'orderby'           => 'date',
            'order'             => 'DESC',
            'per_page'          => 3,
            'include'     => ( ! empty( $attributes['posts'] ) && is_array($attributes['posts']) ) ? array_column($attributes['posts'], 'id') : '',
        );

        $args = wp_parse_args( $attributes['shortcode_atts'], $default_args );

        $args['posts_per_page'] = $args['per_page'];

        $posts = get_posts( apply_filters( 'frontgb_render_customer_stories_content_block_args', $args, $attributes ) );

        $content = '';

        if( $posts ) {
            ob_start();
            global $post;

            $classes = empty( $attributes['className'] ) ? 'row' : $attributes['className'] . ' row';
            ?><div class="<?php echo esc_attr( $classes ); ?>">
                <?php foreach ( $posts as $post ) : setup_postdata( $post ); ?>
                    <div class="col-sm-6 col-md-4 mb-5">
                        <div class="card border-0 shadow-soft h-100">
                            <?php if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'full', array( 'class' => 'card-img-top' ) );
                            } ?>
                            <div class="card-body p-5">
                                <div class="max-width-15 w-100 mb-3">
                                    <?php
                                        $clean_featured_logo_arr = get_post_meta( $post->ID, '_featured_logo', true );
                                        $featured_logo_arr = json_decode( stripslashes( $clean_featured_logo_arr ), true );
                                        if( ! empty( $featured_logo_arr['id'] ) ) {
                                            echo wp_get_attachment_image( $featured_logo_arr['id'], 'full', '', array( 'class' => 'img-fluid' ) );
                                        }
                                    ?>
                                </div>
                                <p class="mb-0 post-excerpt"><?php
                                    if ( ! empty( get_the_excerpt() ) ) {
                                        echo get_the_excerpt();
                                    } else{
                                        echo get_the_content();
                                    }
                                ?></p>
                            </div>
                            <div class="card-footer bg-light border-0 py-4 px-5">
                                <a href="<?php the_permalink(); ?>"><?php echo apply_filters( 'frontgb_render_customer_stories_content_block_read_story_text', sprintf( '%s %s', __( 'Read Story', FRONTGB_I18N ), '<small class="fas fa-arrow-right ml-1"></small>' ) ) ?></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div><?php
            wp_reset_postdata();
            $content = ob_get_clean();
        } else {
            $content = '<p class="text-danger text-center font-size-2">' . esc_html__( 'Customer Stories is empty', FRONTGB_I18N ) . '</p>';
        }

        return apply_filters( 'frontgb_render_customer_stories_content_block_content', $content, $posts, $attributes );
    }
}

if ( ! function_exists( 'frontgb_register_customer_stories_content_block' ) ) {
    /**
     * Registers the `fgb/customer-stories-content` block on server.
     */
    function frontgb_register_customer_stories_content_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/customer-stories-content',
            array(
                'attributes'      => array(
                    'shortcode_atts'=> array(
                        'type'      => 'object',
                        'default'   => array(
                            'per_page'      => 9,
                            'orderby'       => 'date',
                            'order'         => 'DESC',
                        ),
                    ),
                    'posts'       => array(
                        'type'      => 'array',
                        'items'     => array(
                            'type'          => 'object'
                        ),
                        'default'   => [],
                    ),
                    'className'     => array(
                        'type'      => 'string',
                    )
                ),
                'render_callback' => 'frontgb_render_customer_stories_content_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_customer_stories_content_block' );
}