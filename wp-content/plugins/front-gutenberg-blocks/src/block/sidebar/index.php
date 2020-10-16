<?php
/**
 * Server-side rendering of the `fgb/sidebar` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/sidebar` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_sidebar_block' ) ) {
    function frontgb_render_sidebar_block( $attributes ) {
        ob_start();
        if( ! empty( $attributes['sidebarName'] ) && is_active_sidebar( $attributes['sidebarName'] ) ) {
            ?>
            <div class="<?php if( ! empty( $attributes['className'] ) ) { echo esc_attr( $attributes['className'] ); } ?>">
                <div class="navbar-expand-lg navbar-expand-lg-collapse-block">
                    <button class="btn btn-block btn-gray d-lg-none collapsed" type="button" data-toggle="collapse" data-target="#sidebar-nav" aria-controls="sidebar-nav" aria-expanded="false" aria-label="<?php echo esc_attr__( 'Toggle navigation', FRONTGB_I18N ); ?>">
                        <span class="d-flex justify-content-between align-items-center">
                            <span><?php echo esc_html__( 'View all categories', FRONTGB_I18N ); ?></span>
                            <span class="fas fa-angle-right"></span>
                        </span>
                    </button>
                    <div id="sidebar-nav" class="navbar-collapse collapse">
                        <?php dynamic_sidebar( $attributes['sidebarName'] ); ?>
                    </div>
                </div>
            </div>
            <?php
        } else {
            echo esc_html__( 'Sidebar not available', FRONTGB_I18N );
        }
        return ob_get_clean();
    }
}

if ( ! function_exists( 'frontgb_register_sidebar_block' ) ) {
    /**
     * Registers the `fgb/sidebar` block on server.
     */
    function frontgb_register_sidebar_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/sidebar',
            array(
                'attributes'      => array(
                    'sidebarName' => array(
                        'type' => 'string',
                    ),
                    'className'     => array(
                        'type'      => 'string',
                    ),
                ),
                'render_callback' => 'frontgb_render_sidebar_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_sidebar_block' );
}