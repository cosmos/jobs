<?php
/**
 * Server-side rendering of the `fgb/more-projects` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/more-projects` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_case_studies_modern_block' ) ) {
    function frontgb_render_case_studies_modern_block( $attributes ) {
        $recent_posts = wp_get_recent_posts(
            array(
                'post_type'   => 'jetpack-portfolio', 
                'numberposts' => ! empty( $attributes['postsToShow'] ) ? $attributes['postsToShow'] : '',
                'post_status' => 'publish',
                'order' => ! empty( $attributes['order'] ) ? $attributes['order'] : '',
                'orderby' => ! empty( $attributes['orderBy'] ) ? $attributes['orderBy'] : '',
                'include'     => ( ! empty( $attributes['posts'] ) && is_array($attributes['posts']) ) ? array_column($attributes['posts'], 'id') : '',
                'tax_query' => ( ! empty( $attributes['portfolio_tags'] ) && is_array($attributes['portfolio_tags']) ) ? array(
                    array(
                        'taxonomy' => 'jetpack-portfolio-tag',
                        'field'    => 'slug',
                        'terms'    =>  $attributes['portfolio_tags'],
                        'operator' => 'IN',
                    )
                ) : []
            )
        );

        $containerclass = 'space-2 space-md-3';

        $containerclass .=' ' . $attributes['className'];

            if ($attributes['enableContainer'] === true) { 
              $containerclass .=  ' container';
            }
            
        $posts_markup = '';
        $props = array( 'attributes' => array() );

        foreach ( $recent_posts as $index => $post ) {
            $post_id = $post['ID'];

            // Title.
                $Title = get_the_title( $post_id );

            // Featured Image.
                /**
                 * Image Size: 500x280-crop
                 */
                $img_sz_name = 'full';
                if( function_exists( 'front_get_image_size' ) ) {
                    $img_sz_name = front_get_image_size( 'portfolio_browse_projects_thumbnail', 'full' );
                }
                $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $img_sz_name );

            // Author.
                $Author = get_post_meta( $post_id, 'portfolio_byline', true );

                if ( empty( $Author ) ) {
                    $Author = get_the_author();
                }

            // Link.
                $Link = get_permalink( $post_id );

            // Image
               $image ='<img src=' . esc_url($featured_image[0]) . ' alt="Image Description"/>';

                $post_terms = get_the_terms( $post_id, 'jetpack-portfolio-type' );
                $types = '';

                if( is_array ($post_terms) ) {
                    $types = implode(', ', wp_list_pluck( $post_terms, 'name') );
                }

                $post_markup = '<div class="col-md-6' . esc_attr( ( $index % 2  == 0  ) ? " mb-7 mb-lg-0" : '' ) . '">';
                $post_markup .= '<a class="card border-0 shadow-sm transition-3d-hover" href="' . esc_url( $Link ) . '">';
                $post_markup .= '<div class="card-body p-0">';
                $post_markup .= $image;
                $post_markup .= '<div class="text-center p-5">';
                $post_markup .= '<h4 class="h5 text-dark mb-0">' . esc_html( $Title ) .'</h4>';
                $post_markup .= '<p class="mb-0">' . esc_html( $types ) .'</p>';
                $post_markup .= '</div>';
                $post_markup .= '</div>';
                $post_markup .= '</a>';
                $post_markup .= '</div>';

                $posts_markup .= $post_markup . "\n";                  
        }


        $block_content  = '<div class="gradient-half-primary-v2">';
        $block_content .= '<div class="' . esc_attr( $containerclass ) .'">';
        $block_content .= '<div class="row justify-content-md-between align-items-center mb-7">';
        $block_content .= '<div class="col-lg-5 mb-7 mb-lg-0">';
        if ( $attributes['displaySectionHeader'] === true  ) {
            $block_content  .= '<h2 class="font-weight-normal mb-0">' . wp_kses_post ( $attributes ['Title'] ) . '</h2>';
            $block_content  .= '</div>';
        }
        $block_content  .=  '<div class ="col-lg-6 text-lg-right mt-lg-auto">';
        $block_content  .= '<span>' . wp_kses_post ( $attributes['SubTitle'] ) . '</span>';
        $block_content  .=  '</div>';
        $block_content  .=  '</div>';
        $block_content  .=  '<div class="row">';                      
        $block_content  .=   wp_kses_post( $posts_markup );
        $block_content  .=  '</div>';
        $block_content  .=  '</div>';
        $block_content  .=  '</div>';

        if ( function_exists( 'front_is_jetpack_activated' ) && ! front_is_jetpack_activated() ) {
            $block_alert = 'Jetpack is not activated';
        } else if ( ! post_type_exists( 'jetpack-portfolio' ) ) {
            $block_alert = 'Portfolio is not enabled in Jetpack';
        } else {
            $block_alert = 'Portfolio projects is empty';
        }

        if ( ! post_type_exists( 'jetpack-portfolio' ) ) {
            $block_alert = esc_html__( 'Portfolio post type is not available', FRONTGB_I18N );
        } else {
            $block_alert = esc_html__( 'Portfolio projects is empty', FRONTGB_I18N );
        }

        return ( 
            ( post_type_exists( 'jetpack-portfolio' ) && ! empty( $recent_posts ) ) 
            ? 
            $block_content 
            : 
            '<div class="container space-2">
                <p class="text-danger text-center font-size-2 mb-0">'
                . esc_html( $block_alert ) . 
                '</p>
            </div>'
        );
    }
}


if ( ! function_exists( 'frontgb_register_case_studies_modern_block' ) ) {
    /**
     * Registers the `fgb/case_studies_modern` block on server.
     */
    function frontgb_register_case_studies_modern_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/more-projects',
            array(
                'attributes' => array(
                    'className' => array(
                        'type' => 'string',
                        'default' => '',
                    ),
                    'postsToShow' => array(
                        'type' => 'number',
                        'default' => 2,
                    ),
                    'Title' => array(
                        'type' => 'string',
                        'default'=> 'Browse<br>more <span class="text-primary font-weight-semi-bold">projects</span>'
                    ),
                    'order' => array(
                        'type' => 'string',
                        'default' => 'desc',
                    ),
                    'orderBy' => array(
                        'type' => 'string',
                        'default' => 'date',
                    ),
                    'displaySectionHeader' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'enableContainer' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'SubTitle' => array(
                        'type' => 'string',
                        'default' => '<a href="#"><span>See all projects<span class="fas fa-arrow-right small ml-2"></span></span></a>',
                    ),
                    'layoutMode' => array(
                        'type' => 'string',
                        'default' => 'grid',
                    ),
                    'posts'=> array(
                        'type' => 'array',
                        'items' => array(
                          'type' => 'object'
                        ),
                        'default' => [],
                    ),
                    'portfolio_tags'=> array(
                        'type' => 'array',
                        'items' => array(
                          'type' => 'string'
                        ),
                        'default' => [],
                    ),
                ),
                
                'render_callback' => 'frontgb_render_case_studies_modern_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_case_studies_modern_block' );
}

if ( ! function_exists( 'frontgb_case_studies_modern_rest_fields' ) ) {
    /**
     * Add more data in the REST API that we'll use in the blog post.
     *
     * @since 1.7
     */
    function frontgb_case_studies_modern_rest_fields() {

        // Featured image urls.
        register_rest_field( 'jetpack-portfolio', 'featured_image_url',
            array(
                'get_callback' => 'frontgb_portfolio_featured_image_urls',
                'update_callback' => null,
                'schema'          => null,
            )
        );

        // Author name.
        register_rest_field( 'jetpack-portfolio', 'author_info',
            array(
                'get_callback' => 'frontgb_portfolio_author_info',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'Author information', FRONTGB_I18N ),
                    'type' => 'array',
                ),
            )
        );

        //Category name.
        register_rest_field( 'jetpack-portfolio', 'category',
            array(
                'get_callback' => 'frontgb_portfolio_category_list',
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'Category', FRONTGB_I18N ),
                    'type' => 'string',
                ),
            )
        );

    }
    add_action( 'init', 'frontgb_case_studies_modern_rest_fields' );
}

if ( ! function_exists( 'frontgb_case_studies_modern_featured_image_urls' ) ) {
    /**
     * Get the different featured image sizes that the blog will use.
     *
     * @since 1.7
     */
    function frontgb_case_studies_modern_featured_image_urls( $object, $field_name, $request ) {
        $image = wp_get_attachment_image_src( $object['featured_media'], 'full', false );
        return array(
            'full' => is_array( $image ) ? $image : '',
        );
    }
}

if ( ! function_exists( 'frontgb_case_studies_modern_author_info' ) ) {
    /**
     * Get the author name and image.
     *
     * @since 1.7
     */
    function frontgb_case_studies_modern_author_info( $post ) {

        $portfolio_author = get_post_meta( $post['id'], 'portfolio_byline', true );

        if ( empty( $portfolio_author ) ) {
            $portfolio_author = get_the_author();
        }

        return $portfolio_author;
    }
}

if ( ! function_exists( 'frontgb_portfolio_category_list' ) ) {
    /**
     * Get the category.
     *
     * @since 1.7
     */
    function frontgb_portfolio_category_list( $items ) {
        $portfolio_type = get_the_terms( get_the_ID(), 'jetpack-portfolio-type' );
        if( is_array( $portfolio_type ) ) return implode(', ', wp_list_pluck( $portfolio_type, 'name'));
        return;
    }
}