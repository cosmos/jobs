<?php
/**
 * Server-side rendering of the `fgb/docs-posts-list` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/docs-posts-list` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_docs_posts_list_block' ) ) {
    function frontgb_render_docs_posts_list_block( $attributes ) {
        $args = array(
            'post_type'         => 'docs',
            'orderby'           => 'date',
            'order'             => 'DESC',
            'posts_per_page'    => $attributes['limit']
        );

        switch ( $attributes['type'] ) {
            case 'featured':
                $args['meta_query'] = array(
                    array(
                        'key' => '_featured',
                        'value' => true,
                    )
                );
                break;

            case 'helpful':
                $args['meta_key'] = 'positive';
                $args['orderby']  = array(
                    'meta_value_num' => 'DESC',
                    'ID'             => 'ASC',
                );
                break;

            case 'popular':
                $args['orderby'] = 'comment_count';
                break;

            default:
                break;
        }

        $posts = get_posts( apply_filters( 'frontgb_render_docs_posts_list_block_args', $args, $attributes ) );

        $content = '';

        if( $posts ) {
            ob_start();
            global $post;
            ?><ul class="list-unstyled">
                <?php foreach ( $posts as $post ) : setup_postdata( $post ); ?>
                    <li class="pt-3">
                        <a class="link-muted" href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>
                    </li>
                <?php endforeach; ?>
                <?php if( $attributes['enableActionButton'] && ! empty( $attributes['actionButtonLink'] ) && ! empty( $attributes['actionButtontext'] ) ) : ?>
                    <li class="pt-3">
                        <a href="<?php echo esc_url( $attributes['actionButtonLink'] ); ?>"><?php echo esc_html( $attributes['actionButtontext'] ); ?></a>
                    </li>
                <?php endif; ?>
            </ul><?php
            wp_reset_postdata();
            $content = ob_get_clean();
        }

        return apply_filters( 'frontgb_render_docs_posts_list_block_content', $content, $posts, $attributes );
    }
}

if ( ! function_exists( 'frontgb_register_docs_posts_list_block' ) ) {
    /**
     * Registers the `fgb/docs-posts-list` block on server.
     */
    function frontgb_register_docs_posts_list_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/docs-posts-list',
            array(
                'attributes'      => array(
                    'limit' => array(
                        'type'      => 'number',
                        'default'   => 4
                    ),
                    'type' => array(
                        'type'      => 'string',
                        'default'   => 'recent'
                    ),
                    'enableActionButton' => array(
                        'type'      => 'boolean',
                        'default'   => true
                    ),
                    'actionButtontext' => array(
                        'type'      => 'string',
                        'default'   => esc_html__( 'See all', FRONTGB_I18N )
                    ),
                    'actionButtonLink' => array(
                        'type'      => 'string',
                        'default'   => '#'
                    )
                ),
                'render_callback' => 'frontgb_render_docs_posts_list_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_docs_posts_list_block' );
}