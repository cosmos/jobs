<?php
/**
 * Server-side rendering of the `fgb/portfolio` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/portfolio` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_portfolio_block' ) ) {
    function frontgb_render_portfolio_block( $attributes ) {
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
                        'terms'    => $attributes['portfolio_tags'],
                        'operator' => 'IN',
                    ) 
                ) :  array()
            )
        );

        $containerclass = 'u-cubeportfolio';

        $containerclass .=' ' . $attributes['className'] . 'portfolio-block ' . $attributes['layoutMode'];

        if ($attributes['enableContainer'] === true) { 
          $containerclass .=  ' container';
        }
        if ($attributes['layoutMode'] === 'modern') { 
          $containerclass .=  ' u-cubeportfolio--reveal-v1';
        }
        if ($attributes['design'] === 'style-1' ) { 
          $containerclass .=  ' space-top-2 space-top-md-3 space-bottom-2';
        }elseif ($attributes['design'] !== 'style-1' ) {
            $containerclass .=  ' space-2 space-bottom-md-3';
        }

        $containerclass .= ' portfolio-block';

        $ulid = '';
        if ($attributes['design'] === 'style-1' ) { 
            $ulid .= ' filterControls';
        }elseif ($attributes['design'] !== 'style-1' ) {
            $ulid .= ' cubeFilter';
        }

        $ulclass = 'list-inline cbp-l-filters-alignRight';
        if ($attributes['design'] === 'style-1' ) { 
            $ulclass .= ' text-center';
        }elseif ($attributes['design'] === 'style-2' ) {
            $ulclass .= ' d-flex';
        }else {
            $ulclass .= ' d-sm-flex';
        }

        $firstliclass = 'list-inline-item cbp-filter-item cbp-filter-item-active u-cubeportfolio__item';
        if ($attributes['design'] !== 'style-1' ) { 
            $firstliclass .= ' mr-auto';
        }

        if ( ! empty( $attributes['showAllText'] ) ) {
            $firstlicontent = $attributes['showAllText'];
        } else {
            $attributes['design'] === 'style-1' ? $firstlicontent = 'All' : $firstlicontent = 'Show All';
        }

        $gap = '';
        
        if ( ( $attributes['design'] === 'style-1' )  && ( $attributes['layoutMode'] === 'modern') ) { 
          $gap .=  '0';
        }
        if ( ( $attributes['design'] === 'style-1' )  && ( $attributes['layoutMode'] !== 'modern') ) { 
          $gap .=  '15';
        }
        if ( ( ( $attributes['design'] === 'style-2' ) || ( $attributes['design'] === 'style-3' ) ) && ( $attributes['layoutMode'] === 'modern') ) { 
          $gap .=  '0';
        }

        if ( ( ( $attributes['design'] === 'style-2' ) || ( $attributes['design'] === 'style-3' ) ) && ( $attributes['layoutMode'] !== 'modern') ) { 
          $gap .=  '16';
        }

        $selector = '';
        if ( ( $attributes['design'] === 'style-1' )  && ( $attributes['layoutMode'] === 'modern') ) { 
           $selector .=  ' #cubeLoadMore';
        }
        if ( ( $attributes['design'] !== 'style-1' ) && ( ( $attributes['layoutMode'] === 'masonry') || ( $attributes['layoutMode'] === 'modern') ) ) { 
            $selector .=  ' #cubeLoadMore' ;
        }

        $action = '';
        if ( ( $attributes['design'] === 'style-1' )  && ( $attributes['layoutMode'] === 'modern') ) { 
          $action .=  'click';
        }
        if ( ( $attributes['design'] === 'style-2' )  && ( ( $attributes['layoutMode'] === 'masonry') || ( $attributes['layoutMode'] === 'modern') ) ){ 
          $action .=  'click';
        }
        if ( ( $attributes['design'] === 'style-3' ) && ( $attributes['layoutMode'] === 'masonry') ) { 
          $action .=  'auto';
        }

        if ( ( $attributes['design'] === 'style-3' ) && ( $attributes['layoutMode'] === 'modern') ) { 
          $action =  'click';
        }


        $itemsAmount = '';
        if ( ( $attributes['design'] === 'style-1' )  && ( $attributes['layoutMode'] === 'modern') ) { 
          $itemsAmount .=  '2';
        }
        if ( ( $attributes['design'] === 'style-2' )  && ( $attributes['layoutMode'] === 'masonry') ) { 
          $itemsAmount .=  '4';
        }
        if ( ( $attributes['design'] === 'style-2' ) && ( $attributes['layoutMode'] === 'modern') ) { 
          $itemsAmount .=  '2';
        }

        if ( ( $attributes['design'] === 'style-3' ) && ( ( $attributes['layoutMode'] === 'masonry') || ( $attributes['layoutMode'] === 'modern') ) ) { 
          $itemsAmount =  '2';
        }

        $animation =  $attributes['layoutMode'] === 'modern' ? 'zoom' : 'quicksand' ;

        $dataClass =  'cbp portfolio cbp-caption-active cbp-ready ' . ( $attributes['layoutMode'] === 'modern' ? 'cbp-caption-zoom' : '' ) ;
        

        $queries_args1 = array(
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
                'cols'      => 2,
            ),
            array(
                'width'    => 300,
                'cols'      => 1,
            ),
        );

        $queries_args2 = array(
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

        $query = ( $attributes['design'] === 'style-2' ) ? $queries_args1 : $queries_args2;

        $singlecat = '';

        $terms = get_terms( array(
            'taxonomy' => 'jetpack-portfolio-type',
            'hide_empty' => false,
        ) );

        if(!empty($terms)&& is_array($terms) ) {
            foreach ( $terms as $term ) {
                if(!empty($term)) {
                    $singlecat .=  '<li class= "list-inline-item cbp-filter-item u-cubeportfolio__item" data-filter=".jetpack-portfolio-type-'. $term->slug . '">' . esc_html( $term->name ) . '</li>';
                }
            }
        }

        $posts_markup = '';
        $props = array( 'attributes' => array() );

        $index = 0;
        foreach ( $recent_posts as $post ) {
            $post_id = $post['ID'];

            // Title.
            $Title = get_the_title( $post_id );

            $img_sz_name = 'full';
            if( function_exists( 'front_get_image_size' ) ) {
                if ( $attributes['design'] == 'style-3') {
                    $img_index_arr = array( 1, 2, 1, 4, 2, 5, 2, 2, 2, 1, 3, 4, 1, 3, 5, 4, 4, 1, 5, 3, 1, 4, 3, 3 );
                    $i = $index%24;
                    $img_index = $img_index_arr[ $i ];
                    /**
                     * Image Size: 500x700-crop * 6
                     * Image Size: 480x320-crop * 5
                     * Image Size: 380x250-crop * 6
                     * Image Size: 450x450-crop * 4
                     * Image Size: 380x360-crop * 3
                     */
                    $img_sz_name = front_get_image_size( 'portfolio_profile_thumbnail_' . $img_index , 'full' );
                } elseif ( $attributes['design'] == 'style-2') {
                    $img_index_arr = array( 1, 1, 2, 1, 1, 1, 1, 1 );
                    $i = $index%8;
                    $img_index = $img_index_arr[ $i ];
                    /**
                     * Image Size: 380x360-crop * 7
                     * Image Size: 380x740-crop * 1
                     */
                    $img_sz_name = front_get_image_size( 'portfolio_agency_thumbnail_' . $img_index , 'full' );
                } elseif ( $attributes['design'] == 'style-1') {
                    $img_index_arr = array( 1, 1, 2, 1, 1, 1, 1 );
                    $i = $index%7;
                    $img_index = $img_index_arr[ $i ];
                    /**
                     * Image Size: 380x360-crop * 6
                     * Image Size: 380x740-crop * 1
                     */
                    if ( $attributes['enableSameImageSize'] == true ) {
                        $img_size = 'portfolio_classic_thumbnail';
                    } else {
                        $img_size = 'portfolio_corporate_startup_thumbnail_' . $img_index;
                    }

                    $img_sz_name = front_get_image_size( $img_size , 'full' );
                }
            }
            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $img_sz_name );

            $fancybox_featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );

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
            $category_class = 'cbp-item';

            if ( $attributes['layoutMode'] != 'modern' && $attributes['layoutMode'] != 'classic' ) {
                $category_class .= ' rounded';
            }

            if( is_array ($post_terms) ) {
                foreach ( $post_terms as $post_term ) {
                    $category_class .= " jetpack-portfolio-type-" . $post_term->slug ;
                }
            }

            if ( $attributes['layoutMode'] == 'classic' ) {
                $content_class = 'dark';
            } else {
               $content_class = 'light'; 
            }

            if ( $attributes['layoutMode'] == 'grid' || $attributes['layoutMode'] == 'masonry' ) {
                $content_class .= ' px-3'; 
            }

            $post_content = '';
            if ( $attributes['enablePostContent'] == true && ! empty( get_the_excerpt( $post_id ) ) ) {
                $post_content = '<p class="portfolio-post-content small mb-0 mt-1 text-' . esc_attr( $content_class ) . '">' . get_the_excerpt( $post_id ) . '</p>';
            }

            $post_markup = '<div class="' . esc_attr( $category_class ) .'">';
            if ( $attributes['design'] !== 'style-3') {
                $post_markup .= '<a class="cbp-caption" href="' . esc_url( $Link ) . '">';
                    if ( $attributes['layoutMode'] === 'classic') {
                        $post_markup .= $image;
                        $post_markup .= '<div class="py-3">';
                            $post_markup .= '<h4 class="h6 text-dark mb-0">' . esc_html( $Title ) .'</h4>';
                            if ( $attributes['enableAuthor'] == true ) {
                                $post_markup .= '<p class="mb-0">' . esc_html( $Author ) .'</p>';
                            }
                            $post_markup .= $post_content;
                        $post_markup .= '</div>';
                    }
                    if ( $attributes['layoutMode']  === 'grid' || $attributes['layoutMode'] === 'masonry' ) { 
                        $post_markup .= '<div class="cbp-caption-defaultWrap">';
                        $post_markup .= $image;
                        $post_markup .= '</div>';
                        $post_markup .= '<div class="cbp-caption-activeWrap bg-primary">';
                        $post_markup .= '<div class="cbp-l-caption-alignCenter">';
                        $post_markup .= '<div class="cbp-l-caption-body">';
                        $post_markup .= '<h4 class="h6 text-white mb-0">' . esc_html( $Title ) .'</h4>';
                        if ( $attributes['enableAuthor'] == true ) {
                            $post_markup .= '<p class="small text-white-70 mb-0">' . esc_html( $Author ) .'</p>';
                        }
                        $post_markup .= $post_content;
                        $post_markup .= '</div>';
                        $post_markup .= '</div>';               
                        $post_markup .= '</div>';  
                    }
                    if ( $attributes['layoutMode'] === 'modern') {
                                    
                        $post_markup .= '<div class="cbp-caption-defaultWrap">';
                        $post_markup .=  $image;
                        $post_markup .=  '</div>';
                        $post_markup .=  '<div class="cbp-caption-activeWrap">';
                        $post_markup .=  '<div class="cbp-l-caption-alignLeft">';
                        $post_markup .=  '<div class="cbp-l-caption-body">';
                        $post_markup .=  '<h4 class="h6 text-white mb-0">' . esc_html( $Title ) .'</h4>';
                        if ( $attributes['enableAuthor'] == true ) {
                            $post_markup .=  '<p class="small text-white-70 mb-0">' . esc_html( $Author ) .'</p>';
                        }
                        $post_markup .= $post_content;
                        $post_markup .=  '</div>';
                        $post_markup .=  '</div>';
                        $post_markup .=  '</div>';
                    }      
                $post_markup .=     '</a>';
            }
            if ( $attributes['design'] === 'style-3') {
                    $post_markup .= '<a class="cbp-lightbox u-media-viewer" href="' . esc_url( $attributes['fancyboxImageOrginalSize'] == true ? $fancybox_featured_image[0] : $featured_image[0] ) . '" data-title="' . esc_attr( $Title ) . '' . esc_attr( $Author ) .'">';
                    $post_markup .=  $image;
                    $post_markup .=  '<span class="u-media-viewer__container">';
                    $post_markup .=  '<span class="u-media-viewer__icon">';
                    $post_markup .=  '<span class="fas fa-plus u-media-viewer__icon-inner">';
                    $post_markup .=  '</span>';
                    $post_markup .=  '</span>';
                    $post_markup .=  '</span>';
                    $post_markup .=  '</a>';                               
            }
            $post_markup .=     '</div>';

            $posts_markup .= $post_markup . "\n";                  

            $index++;
        }


        $block_content = '<div class="' . esc_attr( $containerclass ) .'">';
        if ( ( $attributes['design'] === 'style-1' ) && ( $attributes['displaySectionHeader'] === true ) ) {
            $block_content  .= '<div class="w-md-80 w-lg-50 text-center mx-md-auto mb-4">';
            $block_content  .= '<h2 class="text-primary">' . ( isset( $attributes['Title'] ) ? wp_kses_post( $attributes['Title'] ) : (__('Our <span class="font-weight-semi-bold">branding</span> works', FRONTGB_I18N)) ) . '</h2>';
            $block_content  .= '</div>';
        }

        if( $attributes['displayHeaderFilter'] ) {
            $block_content  .=  '<ul id="filterControls" class="' . esc_attr( $ulclass ) . '">';
            $block_content  .= '<li class="' . esc_attr( $firstliclass ) . '" data-filter="*">' . esc_html( $firstlicontent ) .'</li>';
            $block_content  .=  wp_kses_post( $singlecat );
            $block_content  .= '</ul>';
        }

        $block_content  .=  '<div class="' . esc_attr( $dataClass ) . '" 
                                data-controls="#filterControls" 
                                data-animation="' . esc_attr( $animation ) . '" 
                                data-x-gap="' . esc_attr( $gap ) . '" 
                                data-y-gap="' . esc_attr( $gap ) . '" 
                                data-load-more-selector="' . esc_attr( $selector ) .'" 
                                data-load-more-action="' . esc_attr( $action ) . '" 
                                data-load-items-amount="' . esc_attr( $itemsAmount ) . '" 
                                data-media-queries="' . htmlspecialchars( json_encode( $query ), ENT_QUOTES, 'UTF-8' ) . '">';                              
        $block_content  .=   wp_kses_post( $posts_markup );
        $block_content  .=  '</div>';
        $block_content  .=  '</div>';

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


if ( ! function_exists( 'frontgb_register_portfolio_block' ) ) {
    /**
     * Registers the `fgb/portfolio` block on server.
     */
    function frontgb_register_portfolio_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/portfolio',
            array(
                'attributes' => array(
                    'className' => array(
                        'type' => 'string',
                        'default' => '',
                    ),
                    'postsToShow' => array(
                        'type' => 'number',
                        'default' => 7,
                    ),
                    'Title' => array(
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
                    'displaySectionHeader' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'displayHeaderFilter' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'enableContainer' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'design' => array(
                        'type' => 'string',
                        'default' => 'style-1',
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
                    'showAllText' => array(
                        'type' => 'string',
                        'default' => '',
                    ),
                    'fancyboxImageOrginalSize' => array(
                        'type' => 'boolean',
                        'default' => false,
                    ),
                    'enableAuthor' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'enablePostContent' => array(
                        'type' => 'boolean',
                        'default' => false,
                    ),
                    'enableSameImageSize' => array(
                        'type' => 'boolean',
                        'default' => false,
                    ),
                ),
                
                'render_callback' => 'frontgb_render_portfolio_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_portfolio_block' );
}

if ( ! function_exists( 'frontgb_portfolio_rest_fields' ) ) {
    /**
     * Add more data in the REST API that we'll use in the blog post.
     *
     * @since 1.7
     */
    function frontgb_portfolio_rest_fields() {

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

        // Post Content.
        register_rest_field( 'jetpack-portfolio', 'post_content',
            array(
                'get_callback' => 'frontgb_portfolio_post_content',
                'update_callback' => null,
                'schema' =>null,
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
    add_action( 'init', 'frontgb_portfolio_rest_fields' );
}

if ( ! function_exists( 'frontgb_portfolio_featured_image_urls' ) ) {
    /**
     * Get the different featured image sizes that the blog will use.
     *
     * @since 1.7
     */
    function frontgb_portfolio_featured_image_urls( $object, $field_name, $request ) {
        $image = wp_get_attachment_image_src( $object['featured_media'], 'full', false );
        return array(
            'full' => is_array( $image ) ? $image : '',
        );
    }
}

if ( ! function_exists( 'frontgb_portfolio_author_info' ) ) {
    /**
     * Get the author name and image.
     *
     * @since 1.7
     */
    function frontgb_portfolio_author_info( $post ) {

        $portfolio_author = get_post_meta( $post['id'], 'portfolio_byline', true );

        if ( empty( $portfolio_author ) ) {
            $portfolio_author = get_the_author();
        }

        return $portfolio_author;
    }
}

if ( ! function_exists( 'frontgb_portfolio_post_content' ) ) {
    /**
     * Get the post content
     *
     * @since 1.7
     */
    function frontgb_portfolio_post_content( $post ) {

        $portfolio_post_content = '';

        if ( empty( $portfolio_post_content ) ) {
            $portfolio_post_content = get_the_excerpt( $post['id'] );
        }

        return $portfolio_post_content;
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
        if( is_array( $portfolio_type ) ) return implode(', ', wp_list_pluck( $portfolio_type, 'slug'));
        return;
    }
}

if ( ! function_exists( 'frontgb_rest_jetpack_portfolio_query' ) ) {
    function frontgb_rest_jetpack_portfolio_query( $args, $request ) {
        $tax_query = isset( $args['tax_query'] ) ? $args['tax_query'] : array();

        if ( $types = $request->get_param( 'portfolio_types' ) ) {
            $tax_query[] = array(
                'taxonomy' => 'jetpack-portfolio-type',
                'field'    => 'slug',
                'terms'    => $types,
                'operator' => 'IN',
            );
        }

        if ( $tags = $request->get_param( 'portfolio_tags' ) ) {
            $tax_query[] = array(
                'taxonomy' => 'jetpack-portfolio-tag',
                'field'    => 'slug',
                'terms'    => $tags,
                'operator' => 'IN',
            );
        }

        $args['tax_query'] = $tax_query;

        return $args;
    }
}

add_filter( 'rest_jetpack-portfolio_query', 'frontgb_rest_jetpack_portfolio_query', 10, 2 );