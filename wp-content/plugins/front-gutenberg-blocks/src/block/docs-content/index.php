<?php
/**
 * Server-side rendering of the `fgb/docs-content` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the `fgb/docs-content` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_docs_content_block' ) ) {
    function frontgb_render_docs_content_block( $attributes ) {

        if ( function_exists( 'front_is_wedocs_activated' ) && ! front_is_wedocs_activated() ) {
            return '<p class="text-danger text-center font-size-2">' . __( 'WeDocs is not activated', FRONTGB_I18N ) . '</p>';
        }

        $defaults = array(
            'col'     => '2',
            'include' => 'any',
            'exclude' => '',
            'items'   => 10,
            'more'    => __( 'View Details', FRONTGB_I18N )
        );

        $args = wp_parse_args( $attributes['shortcode_atts'], $defaults );

        extract( $args );

        $docs = array();

        $parent_args     = array(
            'post_type'   => 'docs',
            'parent'      => 0,
            'sort_column' => 'menu_order'
        );

        if ( 'any' != $args['include'] ) {
            $parent_args['include'] = $args['include'];
        }

        if ( !empty( $args['exclude'] ) ) {
            $parent_args['exclude'] = $args['exclude'];
        }

        $parent_docs = get_pages( $parent_args );

        // arrange the docs
        if ( $parent_docs ) {
            foreach ($parent_docs as $root) {
                $sections = get_children( array(
                    'post_parent'    => $root->ID,
                    'post_type'      => 'docs',
                    'post_status'    => 'publish',
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                    'posts_per_page' => (int) $args['items'],
                ) );

                $docs[] = array(
                    'doc'      => $root,
                    'sections' => $sections
                );
            }
        }

        ob_start(); 
            ?><div class="row mx-gutters-2"><?php
                foreach( $docs as $key => $main_doc ) :
                    $total_sections = 0;
                    $author_ids     = array();
                    $more_than_6    = 0;
                    $author_names   = array();
                    if ( $main_doc['sections'] ) :
                        foreach ( $main_doc['sections'] as $section ) :
                            $total_sections++;

                            if ( array_key_exists( $section->post_author, $author_ids ) ) {
                                continue;
                            }

                            $author_name = get_the_author_meta( 'display_name', $section->post_author );
                            $author_names[ $section->post_author ] = $author_name;
                            
                            $author_ids[ $section->post_author ] = array(
                                'id'           => $section->post_author,
                                'display_name' => $author_name,
                                'gravatar'     => get_avatar_url( $section->post_author )
                            );
                        endforeach;
                    endif; ?>

                    <div class="col-12 col-lg-6 px-2 mb-3">
                        <a class="card card-frame mw-100 p-0 mt-0 h-100" href="<?php echo get_permalink( $main_doc['doc']->ID ); ?>">
                            <div class="card-body p-4">
                                <!-- Icon Block -->
                                <div class="media">
                                    
                                    <?php front_wedocs_entry_thumbnail( $main_doc['doc'] ); ?>
                                    
                                    <div class="media-body">
                                        <h2 class="h5"><?php echo wp_kses_post( $main_doc['doc']->post_title ); ?></h2>
                                        <p class="font-size-1"><?php echo wp_kses_post( $main_doc['doc']->post_excerpt ); ?></p>

                                        <div class="media">
                                            <?php if ( count( $author_ids ) ) : ?>
                                            <!-- Contributors List -->
                                            <ul class="list-inline mr-2 mb-0">
                                                <?php $i = 0; foreach ( $author_ids as $author ) : ?>
                                                <li class="list-inline-item mr-0<?php if ( $i++ > 0 ) : ?> ml-n3<?php endif; ?>">
                                                    <div class="u-sm-avatar u-sm-avatar--bordered rounded-circle">
                                                        <img class="img-fluid rounded-circle" src="<?php echo esc_url( $author['gravatar']); ?>" alt="<?php echo esc_attr( $author['display_name'] ); ?>">
                                                    </div>
                                                </li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <!-- End Contributors List -->
                                            <?php endif; ?>

                                            <div class="media-body">

                                                <!-- Article Authors -->
                                                <?php if ( $total_sections ) : ?>
                                                <small class="d-block text-dark"><?php printf( _n( '%s section in this topic', '%s sections in this topic', $total_sections, FRONTGB_I18N ), number_format_i18n( $total_sections ) ); ?></small>
                                                <?php endif; ?>
                                                <?php if ( $author_names ) : ?>
                                                <small class="d-block text-dark">
                                                    <?php 
                                                        $author_names = front_natural_language_join( $author_names, '<span class="text-muted">' . esc_html__( 'and', FRONTGB_I18N ) . '</span>' );
                                                        printf( '<span class="text-muted">%s</span> %s', esc_html__( 'Written by', FRONTGB_I18N ), $author_names ); 
                                                    ?>
                                                </small>
                                                <?php endif; ?>
                                                <!-- End Article Authors -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Icon Block -->
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php

        return ob_get_clean();
    }
}

if ( ! function_exists( 'frontgb_register_docs_content_block' ) ) {
    /**
     * Registers the `fgb/docs-content` block on server.
     */
    function frontgb_register_docs_content_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/docs-content',
            array(
                'attributes' => array(
                    'shortcode_atts'=> array(
                        'type'      => 'object',
                        'default'   => array(
                            'items' => 10,
                        ),
                    ),
                ),
                'render_callback' => 'frontgb_render_docs_content_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_docs_content_block' );
}
