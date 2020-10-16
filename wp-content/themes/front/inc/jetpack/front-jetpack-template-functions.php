<?php
/**
 * Template functions used in JetPack
 */

/**
* Portfolio
*/
if ( ! function_exists( 'front_portfolio_hero' ) ) {
    function front_portfolio_hero() {
        $enable_portfolio_hero = apply_filters( 'front_portfolio_enable_hero', true );

        $hero_title = apply_filters( 'front_portfolio_hero_title', sprintf( esc_html__( 'Portfolio %s card %s', 'front' ), '<span class="font-weight-semi-bold">', '</span>' ) );

        $hero_subtitle = apply_filters( 'front_portfolio_hero_subtitle', esc_html__( 'Your portfolio should tell your story.', 'front' ) );

        if ( $enable_portfolio_hero == true ) {
            ?><!-- Hero Section -->
            <div id="SVGwave1BottomSMShape" class="svg-preloader position-relative bg-light overflow-hidden portfolio__hero">
                <div class="container space-top-2 space-bottom-3 space-top-md-5 space-top-lg-4 portfolio__hero-caption">
                    <div class="w-md-80 w-lg-60 text-center mx-auto">
                        <h1 class="display-4 font-size-md-down-5 text-primary portfolio__hero-title"><?php echo wp_kses_post( $hero_title ); ?></h1>
                        <p class="lead portfolio__hero-subtitle"><?php echo esc_html ( $hero_subtitle ); ?></p>
                    </div>
                </div>

                <!-- SVG Background -->
                <figure class="position-absolute right-0 bottom-0 left-0">
                    <img class="js-svg-injector" src="<?php echo get_template_directory_uri() . '/assets/svg/components/wave-1-bottom-sm.svg'; ?>" alt="Image Description"
                    data-parent="#SVGwave1BottomSMShape">
                </figure>
                <!-- End SVG Background Section -->
            </div>
            <!-- End Hero Section -->
            <?php
        }
    }
}

if ( ! function_exists( 'front_loop_portfolio_wrap_start' ) ) {

    function front_loop_portfolio_wrap_start() { 

        $portfolio_layout   = front_get_portfolio_layout();
        $portfolio_view     = front_get_portfolio_view();
        $enable_portfolio_hero = apply_filters( 'front_portfolio_enable_hero', true );

        extract( front_portfolio_get_cbp_class_and_atts( $portfolio_view ) );

        $container_class = '';
        switch ( $portfolio_layout ) {
            case 'boxed':
                $container_class = ' container';
            break;
            case 'fullwidth':
                $container_class = ' container-fluid px-sm-5';
            break;
        }

        $portfolio_cats = array();        

        while ( have_posts() ) : 
            the_post(); 

            $portfolio_types = get_the_terms( get_the_ID(), 'jetpack-portfolio-type' );

            if ( ! $portfolio_types || is_wp_error( $portfolio_types ) ) {
                $portfolio_types = array();
            }

            $portfolio_types = array_values( $portfolio_types );

            foreach ( array_keys( $portfolio_types ) as $key ) {
               _make_cat_compat( $portfolio_types[ $key ] );           
            }

            foreach ( $portfolio_types as $portfolio_type ) {
                $portfolio_cats[ $portfolio_type->slug] = $portfolio_type->name;
            }

        endwhile; ?>


        <div class="space-2 space-bottom-md-3<?php echo esc_attr( $enable_portfolio_hero == false ? ' space-top-md-5' : '' ); echo esc_attr( $container_class ); ?>">
            <div class="<?php echo esc_attr( $cbp_class ); ?>">
                <?php front_portfolio_cbp_filters( $portfolio_cats ); ?>
                <div<?php echo front_get_attributes( $cbp_atts ); ?>><?php
    }
}

if ( ! function_exists( 'front_portfolio_cbp_filters' ) ) {
    function front_portfolio_cbp_filters( $items ) {
        $enable_portfolio_filters = apply_filters( 'front_portfolio_enable_filters', true );

        if ( $enable_portfolio_filters == true ) {
            ?><ul id="filterControls" class="list-inline cbp-l-filters-alignRight text-center">
                <li class="list-inline-item cbp-filter-item cbp-filter-item-active u-cubeportfolio__item" data-filter="*"><?php echo esc_html__( 'All', 'front' ); ?></li>
            <?php foreach ( $items as $key => $item ) : ?>
                <li class= "list-inline-item cbp-filter-item u-cubeportfolio__item" data-filter=".jetpack-portfolio-type-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $item ); ?></li>
                <?php endforeach; ?>
            </ul><?php
        }
    }
}

if ( ! function_exists( 'front_portfolio_get_cbp_class_and_atts' ) ) {
    function front_portfolio_get_cbp_class_and_atts( $view = '' ) {
        $cbp_atts = array(
            'class'              => 'cbp',
            'data-layout'        => 'grid',
            'data-controls'      => '#filterControls',
            'data-animation'     => 'quicksand',
            'data-x-gap'         => '32',
            'data-y-gap'         => '32',
            'data-media-queries' => '[{"width": 1500, "cols": 4}, {"width": 1100, "cols": 4}, {"width": 800, "cols": 3}, {"width": 480, "cols": 2}, {"width": 300, "cols": 1} ]'
        );
        $cbp_class = 'u-cubeportfolio';

        switch ( $view ) {
            case 'classic':
                $cbp_class .= '';
            break;
            case 'grid':
                $cbp_class .= ' space-bottom-2';
            break;
            case 'modern':
                $cbp_class .= ' u-cubeportfolio--reveal-v1';
                $cbp_atts['data-caption-animation']  = 'zoom';
                $cbp_atts['data-x-gap']              = '0';
                $cbp_atts['data-y-gap']              = '0';
                $cbp_atts['data-load-more-selector'] = '#cubeLoadMore';
                $cbp_atts['data-load-more-action']   = 'click';
                $cbp_atts['data-load-items-amount']  = '2';
            break;
            case 'masonry':
                $cbp_class .= '';
                $cbp_atts['data-layout']            = 'grid';
                $cbp_atts['data-controls']          = "#filterControls";
                $cbp_atts['data-animation']         = 'quicksand';
                $cbp_atts['data-x-gap']             = '32';
                $cbp_atts['data-y-gap']             = '32';
                $cbp_atts['data-load-more-selector']= '#cubeLoadMore';
                $cbp_atts['data-load-more-action']  = 'auto';
                $cbp_atts['data-load-items-amount'] = '2';
            break;
        }

        return array( 'cbp_atts' => $cbp_atts, 'cbp_class' => $cbp_class );
    }
}

if ( ! function_exists( 'front_portfolio_content' ) ) {
    function front_portfolio_content( $portfolio_view = '' ) {
        $portfolio_view = ! empty( $portfolio_view ) ? $portfolio_view : front_get_portfolio_view();

        switch ( $portfolio_view ) {
            case 'classic':
                front_portfolio_classic_content();
            break;
            case 'grid':
                front_portfolio_grid_content();
            break;
            case 'masonry':
                front_portfolio_masonry_content();
            break;
            case 'modern':
                front_portfolio_modern_content();
            break;
        }
    }
}

if ( ! function_exists( 'front_portfolio_post_excerpt' ) ) {
    function front_portfolio_post_excerpt() {
        global $post;
        $post_excerpt = get_post_meta( $post->ID, '_description', true );

        if( empty( $post_excerpt ) ) {
            $post_excerpt = $post->post_excerpt;
        }

        if( empty( $post_excerpt ) ) {
            $post_excerpt = get_the_excerpt();
        }

        $portfolio_view = front_get_portfolio_view();
        if ( $portfolio_view == 'classic' ) {
            $content_class = 'dark';
        } else {
           $content_class = 'light'; 
        }

        if ( $portfolio_view == 'grid' || $portfolio_view == 'masonry' ) {
            $content_class .= ' px-3'; 
        }

        if ( apply_filters( 'front_portfolio_post_excerpt_enable', true ) && ! empty( $post_excerpt ) ) {
            ?><div class="portfolio-post-content small mb-0 mt-1 text-<?php echo esc_attr( $content_class ); ?>"><?php echo wp_kses_post( $post_excerpt ); ?></div><?php
        }
    }
}

if ( ! function_exists( 'front_portfolio_classic_content' ) ) {
    function front_portfolio_classic_content() {
        /**
         * Image Size: 380x360-crop
         */
        $img_sz_name = front_get_image_size( 'portfolio_classic_thumbnail', 'post-thumbnail' );
        the_post_thumbnail( $img_sz_name ); 
        $enable_portfolio_author = apply_filters( 'front_portfolio_enable_author', true ); ?>
        <div class="py-3">
            <h4 class="h6 text-dark mb-0"><?php the_title(); ?></h4>
            <?php if ( $enable_portfolio_author == true ): ?>
                <p class="small mb-0"><?php echo sprintf( esc_html__( 'by %s', 'front' ), front_loop_portfolio_author() ); ?></p>                
            <?php endif; 
            front_portfolio_post_excerpt(); ?>
        </div><?php
    }
}

if ( ! function_exists( 'front_portfolio_grid_content' ) ) {
    function front_portfolio_grid_content() { 
        $enable_portfolio_author = apply_filters( 'front_portfolio_enable_author', true );
        ?>
        <div class="cbp-caption-defaultWrap">
            <?php
                /**
                 * Image Size: 380x360-crop
                 */
                $img_sz_name = front_get_image_size( 'portfolio_grid_thumbnail', 'post-thumbnail' );
                the_post_thumbnail( $img_sz_name );
            ?>
        </div>
        <div class="cbp-caption-activeWrap bg-primary">
            <div class="cbp-l-caption-alignCenter">
                <div class="cbp-l-caption-body">
                    <h4 class="h6 text-white mb-0"><?php the_title();?></h4>
                    <?php if ( $enable_portfolio_author == true ): ?>
                        <p class="small text-white-70 mb-0"><?php echo sprintf( esc_html__( 'by %s', 'front' ), front_loop_portfolio_author() ); ?></p>
                    <?php endif; 
                    front_portfolio_post_excerpt();
                    ?>
                </div>
            </div>
        </div><?php
    }
}

if ( ! function_exists( 'front_portfolio_masonry_content' ) ) {
    function front_portfolio_masonry_content() { 
        $enable_portfolio_author = apply_filters( 'front_portfolio_enable_author', true );

        ?>
        <div class="cbp-caption-defaultWrap">
            <?php
                global $front_loop_portfolio_index;
                $img_index_arr = array( 1, 2, 2, 1, 2, 2, 1, 1, 2, 1, 1, 2 );
                $i = $front_loop_portfolio_index%12;
                $img_index     = $img_index_arr[ $i ];
                /**
                 * Image Size: 380x360-crop * 6
                 * Image Size: 380x270-crop * 6
                 */
                $img_sz_name = front_get_image_size( 'portfolio_masonry_thumbnail_' . $img_index, 'full' );
                the_post_thumbnail( $img_sz_name );
            ?>
        </div>
        <div class="cbp-caption-activeWrap bg-primary">
            <div class="cbp-l-caption-alignCenter">
                <div class="cbp-l-caption-body">
                    <h4 class="h6 text-white mb-0"><?php the_title();?></h4>
                    <?php if ( $enable_portfolio_author == true ): ?>
                        <p class="small text-white-70 mb-0"><?php echo sprintf( esc_html__( 'by %s', 'front' ), front_loop_portfolio_author() ); ?></p>
                    <?php endif; 
                    front_portfolio_post_excerpt(); ?>
                </div>
            </div>
        </div><?php
    }
}

if ( ! function_exists( 'front_portfolio_modern_content' ) ) {
    function front_portfolio_modern_content() { 
        $enable_portfolio_author = apply_filters( 'front_portfolio_enable_author', true );
        ?>
        <div class="cbp-caption-defaultWrap">
            <?php
                global $front_loop_portfolio_index;
                $img_index_arr = array( 1, 2, 2, 1, 2, 2, 1, 1, 2, 1, 1, 2 );
                $i = $front_loop_portfolio_index%12;
                $img_index     = $img_index_arr[ $i ];
                /**
                 * Image Size: 380x360-crop * 6
                 * Image Size: 380x270-crop * 6
                 */
                $img_sz_name = front_get_image_size( 'portfolio_modern_thumbnail_' . $img_index, 'full' );
                the_post_thumbnail( $img_sz_name );
            ?>
        </div>
        <div class="cbp-caption-activeWrap">
            <div class="cbp-l-caption-alignLeft">
                <div class="cbp-l-caption-body">
                    <h4 class="h6 text-white mb-0"><?php the_title();?></h4>
                    <?php if ( $enable_portfolio_author == true ): ?>
                        <p class="small text-white-70 mb-0"><?php echo sprintf( esc_html__( 'by %s', 'front' ), front_loop_portfolio_author() ); ?></p>                        
                    <?php endif; 
                    front_portfolio_post_excerpt(); ?>
                </div>
            </div>
        </div><?php
    }
}

if ( ! function_exists( 'front_loop_portfolio_author' ) ) {
    function front_loop_portfolio_author() {
        global $post;
        $portfolio_author = get_post_meta( $post->ID, 'portfolio_byline', true );

        if ( empty( $portfolio_author ) ) {
            $portfolio_author = get_the_author();
        }

        return $portfolio_author;
    }
}
            

if ( ! function_exists( 'front_loop_portfolio_wrap_end' ) ) {
    function front_loop_portfolio_wrap_end() { ?>
                </div>
            </div>
            <?php front_portfolio_pagination(); ?>
        </div><?php
    }
}

if ( ! function_exists( 'front_portfolio_static_content' ) ) {
    /**
     * Display the static content in footer
     */
    function front_portfolio_static_content() {
        if( apply_filters( 'portfolio_enable_static_content_block', true )) {
            $static_content_id = apply_filters( 'front_portfolio_static_block_id', '' );

            if( front_is_mas_static_content_activated() && ! empty( $static_content_id ) ) {
                echo do_shortcode( '[mas_static_content id=' . $static_content_id . ' class="contact-static-content"]' );
            }
        }
    }
}

if ( ! function_exists( 'front_portfolio_contact' ) ) {
    function front_portfolio_contact() {

        if ( apply_filters( 'front_portfolio_enable_contact', true ) ) :

            $section_title = apply_filters( 'front_portfolio_contact_section_title', sprintf( esc_html__( 'You wish us %s to talk about %s your project %s?', 'front' ), '<br/>', '<span class="font-weight-semi-bold">', '</span>' ) );
            $contact_email = apply_filters( 'front_portfolio_contact_email', 'support@htmlstream.com' );
            $contact_phone = apply_filters( 'front_portfolio_contact_phone', '+1 (062) 109-9222' );
            $sm_menu_id    = apply_filters( 'front_portfolio_contact_sm_menu_id', '' );

            ?>
            <!-- Contact Us Section -->
            <div id="SVGwave1BottomSMShapeID2" class="svg-preloader">
                <div class="gradient-half-primary-v1">
                    <div class="container space-top-2 space-bottom-3 space-top-md-3 space-bottom-md-4">
                        <div class="row justify-content-md-between align-items-md-start">
                            <div class="col-md-6 mb-7 mb-md-0">
                                <h2 class="text-white mb-5"><?php echo wp_kses_post( $section_title ); ?></h2>
                                <?php if ( ! empty ( $contact_email ) ) : ?>
                                <a class="h4 text-light" href="mailto:<?php echo esc_url( $contact_email ); ?>"><?php echo esc_html( $contact_email ); ?></a>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mt-md-auto text-md-right">

                                <?php 

                                    if ( ! empty( $sm_menu_id ) ) {
                                        wp_nav_menu( array( 
                                            'menu'         => $sm_menu_id,
                                            'menu_class'   => 'list-inline',
                                            'container'    => false,
                                            'icon_class'   => array( 'btn-icon__inner' ),
                                            'item_class'   => array( 'list-inline-item' ),
                                            'anchor_class' => array( 'btn', 'btn-sm', 'btn-icon', 'btn-soft-light', 'btn-bg-transparent' ),
                                            'depth'        => 1,
                                            'walker'       => new Front_Walker_Social_Media(),
                                        ) ); 
                                    }
                                ?>

                                <?php if ( ! empty ( $contact_phone ) ) : ?>
                                <span class="h4 text-white-70"><?php echo esc_html( $contact_phone ); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SVG Background -->
                <figure class="position-absolute right-0 bottom-0 left-0 z-index-2">
                    <img class="js-svg-injector" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/svg/components/wave-1-bottom-sm.svg" alt="Image Description"
                    data-parent="#SVGwave1BottomSMShapeID2">
                </figure>
                <!-- End SVG Background -->
            </div>
            <!-- End Contact Us Section -->
        <?php 

        endif;
    }
}

if ( ! function_exists( 'front_portfolio_pagination' ) ) {
    /**
     * Output the pagination.
     */
    function front_portfolio_pagination() {

        $args = array(
            'total'   => $GLOBALS['wp_query']->max_num_pages,
            'current' => max( 1, $GLOBALS['wp_query']->get( 'paged', 1 ) ),
            'format'  => '',
            'base'    => esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) )
        );

        extract( $args );

        if ( $total <= 1 ) {
            return;
        }

        ?>
        <nav class="front-portfolio-pagination space-top-2 jcc" aria-label="<?php echo esc_html__( 'Portfolio Navigation', 'front' ); ?>">
            <?php
                echo paginate_links( apply_filters( 'front_portfolio_pagination_args', array( // WPCS: XSS ok.
                    'base'         => $base,
                    'format'       => $format,
                    'add_args'     => false,
                    'current'      => max( 1, $current ),
                    'total'        => $total,
                    'prev_text'    => '&larr;',
                    'next_text'    => '&rarr;',
                    'type'         => 'list',
                    'end_size'     => 3,
                    'mid_size'     => 3,
                ) ) );
            ?>
        </nav>
        <?php
    }
}

if ( ! function_exists( 'front_single_portfolio_content' ) ) {
    function front_single_portfolio_content() {
        global $post;
        $content = get_post_meta( $post->ID, '_description', true );

        if( empty( $content ) ) {
            $content = $post->post_excerpt;
        }

        $attributes_json = get_post_meta( $post->ID, '_attributes', true );
        $attributes = json_decode( $attributes_json );
        $last_key = '';

        if( ! empty( $attributes ) && is_array( $attributes ) ) {
            $attributes = array_filter( $attributes );
            end( $attributes );
            $last_key = key( $attributes );
            reset( $attributes );
        }

        ?>
        <div class="container space-2 space-top-md-4 space-bottom-md-3">
            <div class="row">
                <div class="col-lg-7 mb-7 mb-lg-0">
                   <?php front_portfolio_image_gallery(); ?>
                   <hr class="my-5">
                   <?php the_content(); ?>
                </div>
                <div id="stickyBlockStartPoint" class="col-lg-5">
                    <div class="js-sticky-block pl-lg-4"
                       data-parent="#stickyBlockStartPoint"
                       data-sticky-view="lg"
                       data-start-point="#stickyBlockStartPoint"
                       data-end-point="#stickyBlockEndPoint"
                       data-offset-top="80"
                       data-offset-bottom="130"
                    >
                        <div class="mb-6">
                            <h1 class="h4 text-primary font-weight-semi-bold"><?php the_title(); ?></h1>
                            <?php echo wp_kses_post( $content ); ?>
                        </div>
                        <?php if( ! empty( $attributes ) && is_array( $attributes ) ) : ?>
                            <hr class="my-5">
                            <ul class="list-unstyled mb-0">
                                <?php foreach ( $attributes as $key => $attribute ) : ?>
                                    <?php if( isset( $attribute->label ) && ! empty( $attribute->label ) ) : ?>
                                        <li class="media<?php if( $last_key !== $key ) { echo esc_attr( ' mb-1' ); } ?>">
                                            <div class="d-flex w-40 w-sm-30">
                                                <h3 class="h6"><?php echo esc_html( $attribute->label ); ?></h3>
                                            </div>
                                            <div class="media-body">
                                                <small class="text-muted">
                                                    <?php echo wp_kses_post( isset( $attribute->value ) ? $attribute->value : '' ); ?>
                                                </small>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <?php front_single_portfolio_share(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="stickyBlockEndPoint"></div>
        <hr class="my-0">
    <?php
    }
}

if( ! function_exists( 'front_single_portfolio_share' ) ) {
    function front_single_portfolio_share() {
        if ( function_exists( 'sharing_display' ) && apply_filters( 'front_single_portfolio_share_enable', true ) ) {
            global $post;
            $show = false;
            $options = get_option( 'sharing-options' );

            if ( is_singular() && in_array( get_post_type(), $options['global']['show'], true ) ) {
                $show = true;
            }
            $switched_status = get_post_meta( $post->ID, 'sharing_disabled', false );
            if ( ! empty( $switched_status ) ) {
                $show = false;
            }

            if( $show ) {
                sharing_display( '', true );
            }
        }
    }
}

if ( ! function_exists( 'front_portfolio_image_gallery' ) ) {
    function front_portfolio_image_gallery( $view = '' ) {
        global $post;

        $portfolio_image_gallery = explode( ',', get_post_meta( $post->ID, '_portfolio_image_gallery', true ) );
        $attachments             = array_filter( $portfolio_image_gallery );

        if ( empty( $attachments ) ) {
            $post_thumbnail_id       = get_post_thumbnail_id( $post->ID );
            array_unshift( $attachments, $post_thumbnail_id );
        }

        $gallery_view            = ! empty( $view ) ? $view : get_post_meta( $post->ID, '_portfolio_image_gallery_view', true );

        $cbp_atts = apply_filters( 'front_portfolio_image_gallery_cbp_atts', array(
            'data-layout'        =>   'grid',
            'data-animation'     =>   'quicksand',
            'data-x-gap'         =>   '32',
            'data-y-gap'         =>   '32',
            'data-media-queries' =>  '[ { "width": 300, "cols": 1 } ]'

        ) );

        switch ( $gallery_view ) {
            case 'grid': 
            case 'masonry':
                $cbp_atts['data-media-queries'] =  '[ { "width": 300, "cols": 2 } ]';
            break;
        }

        if ( ! empty( $attachments ) ) : ?>
            <div class="cbp" <?php echo front_get_attributes( $cbp_atts ); ?>><?php 
                $index = 0;
                foreach ( $attachments as $attachment_id ) :
                    if( $gallery_view == 'masonry' ) {
                        $img_index_arr = array( 4, 1, 4, 4, 4, 2, 3 );
                        $i = $index%7;
                        $img_index = $img_index_arr[ $i ];
                        /**
                         * Image Size: 600x400-crop * 1
                         * Image Size: 400x600-crop * 1
                         * Image Size: 600x435-crop * 1
                         * Image Size: 600x600-crop * 4
                         */
                        $img_sz_name = front_get_image_size( 'portfolio_single_masonry_thumbnail_' . $img_index , 'full' );
                    } else {
                        $img_sz_name = front_get_image_size( 'portfolio_single_' . $gallery_view . '_thumbnail' , 'full' );
                    }

                    $attachment = wp_get_attachment_image( $attachment_id, $img_sz_name, '', array( 'class' => 'rounded' ) );

                    if ( empty( $attachment ) ) {
                        continue;
                    }

                    ?>

                    <div class="cbp-item">
                        <div class="cbp-caption"><?php printf( $attachment ); ?></div>
                    </div>

                    <?php
                    $index++;
                endforeach; 
                ?>
            </div>
        <?php endif; 

    }
}


if ( ! function_exists( 'front_portfolio_related_works' ) ) {
    function front_portfolio_related_works() {

        if ( apply_filters( 'front_portfolio_enable_related_works', true ) ) :

            $pretitle = apply_filters( 'front_portfolio_related_works_pretitle', esc_html__( 'Portfolio', 'front' ) );
            $title    = apply_filters( 'front_portfolio_related_works_title', 
                sprintf( esc_html__( 'Our %s Branding %s works', 'front' ), '<strong class="font-weight-semi-bold">', '</strong>' ) );
            $subtitle = apply_filters( 'front_portfolio_related_works_subtitle', esc_html__( 'Experience a level of our quality in both design & customization works.', 'front' ) ) ;   

            $view = apply_filters( 'front_portfolio_related_works_view', 'grid' );

            $related_works = new WP_Query( apply_filters( 'front_portfolio_related_works_default_args', array( 
                'post_type'      => 'jetpack-portfolio', 
                'posts_per_page' => 8,
                'post__not_in'   => array( get_the_ID() ), 
                'orderby'        => 'rand',
            ) ) );

            extract( front_portfolio_get_cbp_class_and_atts( $view ) );
            ?>

            <div class="container space-top-2 space-top-md-3 space-bottom-1">
                <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-9">
                    <?php if ( apply_filters( 'front_portfolio_related_works_pretitle_enable', true ) ): ?>
                        <span class="btn btn-xs <?php echo apply_filters( 'front_portfolio_related_works_pretitle_color', esc_attr( 'btn-soft-success' ) ); ?> btn-pill mb-2"><?php echo esc_html( $pretitle ); ?></span>
                    <?php endif ?>

                    <h2 class="text-primary"><?php echo wp_kses_post( $title ); ?></h2>

                    <p><?php echo esc_html( $subtitle ); ?></p>
                </div>
                <div class="u-cubeportfolio">
                    <div class="cbp"
                        data-layout="grid"
                        data-controls="#filterControls"
                        data-animation="quicksand"
                        data-x-gap="32"
                        data-y-gap="32"
                        data-media-queries='[
                            {"width": 1500, "cols": 4},
                            {"width": 1100, "cols": 4},
                            {"width": 800, "cols": 3},
                            {"width": 480, "cols": 2},
                            {"width": 300, "cols": 1}
                            ]'>

                    <?php while ( $related_works->have_posts() ) : $related_works->the_post(); ?>
                            <div id="portfolio-<?php the_ID(); ?>" <?php post_class( 'cbp-item' ); ?>>
                                    <a class="cbp-caption" href="<?php echo esc_url( get_permalink() ); ?>">
                                        <?php front_portfolio_content( 'grid' ); ?>
                                    </a>
                            </div><?php
                        endwhile;
                    ?></div>
                </div>
            </div><?php
        endif;
    }
}

if ( ! function_exists( 'front_jetpack_sharing_filters' ) ) {
    function front_jetpack_sharing_filters() {
        
        if ( apply_filters( 'front_enable_front_jetpack_sharing', true ) ) {
            $options = get_option( 'sharing-options' );
        
            if ( isset( $options['global']['button_style'] ) && 'icon' == $options['global']['button_style'] ) {
                add_filter( 'jetpack_sharing_display_classes', 'front_jetpack_sharing_display_classes', 10, 4 );
                add_filter( 'jetpack_sharing_headline_html', 'front_jetpack_sharing_headline_html', 10, 3 );
                add_filter( 'jetpack_sharing_display_markup', 'front_jetpack_sharing_display_markup', 10, 2 );
            }
        }
    }
}

if ( ! function_exists( 'front_jetpack_sharing_headline_html' ) ) {
    function front_jetpack_sharing_headline_html( $heading_html, $sharing_label, $action ) {
        if ( is_singular( 'post' ) ) {
            return false;
        } else {
            return '<div class="d-flex w-40 w-sm-30"><h4 class="h6 m-0">%s</h4></div>';    
        }
    }
}

if ( ! function_exists( 'front_jetpack_sharing_display_classes' ) ) {
    function front_jetpack_sharing_display_classes( $klasses, $sharing_source, $id, $args ) {

        if ( 'icon' == $sharing_source->button_style ) {
            if ( ( $key = array_search( 'sd-button', $klasses ) ) !== false ) {
                unset( $klasses[$key] );
            }
            $klasses[] = 'btn';
            
            if ( ! is_singular( 'post' ) ) {
                $klasses[] = 'btn-sm';
            }
            
            $klasses[] = 'btn-icon';
            $klasses[] = 'btn-soft-secondary';
            $klasses[] = 'btn-bg-transparent';
        }

        return $klasses;
    }
}

if ( ! function_exists( 'front_jetpack_sharing_display_markup' ) ) {
    function front_jetpack_sharing_display_markup( $sharing_content, $enabled ) {

        if ( is_singular( 'post' ) ) {
            if ( front_single_post_style() === 'classic' ) {
                $sharing_content = '<hr class="my-7">' . $sharing_content;    
            }
        } else {
            $sharing_content = '<hr class="my-5">' . $sharing_content;
        }
        
        $sharing_content = str_replace( 'class="robots-nocontent', 'class="media align-items-center robots-nocontent', $sharing_content );
        $sharing_content = str_replace( 'class="sd-content"', 'class="media-body"', $sharing_content );
        
        if ( is_singular( 'post' ) ) {
            $sharing_content = str_replace( '<ul>', '<ul class="list-inline text-center mb-0">', $sharing_content );
        } else {
            $sharing_content = str_replace( '<ul>', '<ul class="list-inline mb-0">', $sharing_content );    
        }
        
        $sharing_content = str_replace( '<li class="share-', '<li class="list-inline-item list-inline-item-', $sharing_content );
        $sharing_content = str_replace( '<span></span>', '<span class="btn-icon__inner"></span>', $sharing_content );

        if ( is_singular( 'post' ) ) {
            $sharing_content = str_replace( '<li><a href="#" class="sharing-anchor sd-button share-more"><span>', '<li class="list-inline-item"><a href="#" class="btn btn-icon btn-soft-secondary btn-bg-transparent sharing-anchor share-more"><span class="fas fa-ellipsis-h btn-icon__inner"></span><span class="sr-only">', $sharing_content );    
        } else {
            $sharing_content = str_replace( '<li><a href="#" class="sharing-anchor sd-button share-more"><span>', '<li class="list-inline-item"><a href="#" class="btn btn-sm btn-icon btn-soft-secondary btn-bg-transparent sharing-anchor share-more"><span class="fas fa-ellipsis-h btn-icon__inner"></span><span class="sr-only">', $sharing_content );
        }

        return $sharing_content;
    }
}

if ( ! function_exists( 'front_portfolio_section' ) ) {
    function front_portfolio_section( $args = array() ) {
        $defaults = apply_filters( 'front_portfolio_section_args', array(
            'section_title'     => '',
            'action_link'       => '#',
            'action_text'       => '',
            'columns'           => 2,
            'post_atts'         => array(),
            'el_class'          => '',
        ) );

        $args = wp_parse_args( $args, $defaults );
        extract( $args );

        $query_args = array(
            'post_status'    => 'publish',
            'post_type'      => 'jetpack-portfolio', 
            'posts_per_page' => isset( $post_atts['posts_per_page'] ) ? absint( $post_atts['posts_per_page'] ): 2,
            'orderby'        => isset( $post_atts['orderby'] ) ?  $post_atts['orderby'] : 'date',
            'order'          => isset( $post_atts['order'] ) ?  $post_atts['order'] : 'DESC',
        );
        
        if( isset( $post_atts['category'] ) && ! empty( $post_atts['category'] ) ) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'jetpack-portfolio-type',
                    'field'    => 'term_id',
                    'terms'    => explode( ",", $post_atts['category'] )
                )
            );
        }

        if( isset( $post_atts['ids'] ) && ! empty( $post_atts['ids'] ) ) {
            $query_args['post__in'] = explode( ",", $post_atts['ids'] );
        }

        $posts_query = new WP_Query( $query_args );
        if ( $posts_query->have_posts() ) :
            do_action( 'front_portfolio_section_before_content' ); ?>
            <div class="gradient-half-primary-v2">                
                <div class="container space-2 space-md-3">
                    <div class="row">
                        <?php $i = 1; ?>
                        <?php while ( $posts_query->have_posts() ) : $posts_query->the_post();
                            switch ( $columns ) {
                               case 1:
                                   $addl_class = '12';
                                   break;
                               
                               case 2:
                                   $addl_class = '6';
                                   break;

                               case 3:
                                   $addl_class = '4';
                                   break;

                               case 4:
                                   $addl_class = '3';
                                   break;

                               default:
                                   $addl_class = '6';
                                   break;
                            }
                            $addl_class .= $i % 2 ? ' mb-7 mb-lg-0' : ''; ?>
                            <div class="col-md-<?php echo esc_attr( $addl_class ); ?>">
                                <a class="card border-0 shadow-sm transition-3d-hover" href="<?php echo esc_url( get_permalink() ); ?>">
                                    <div class="card-body p-0">
                                        <?php the_post_thumbnail('large', array(
                                            'class' => 'card-img-top'
                                        )); ?>
                                        <div class="text-center p-5">
                                            <h4 class="h5 text-dark mb-0"><?php the_title();?></h4>
                                            <?php add_filter( 'term_links-jetpack-portfolio-type', 'front_portfolio_type_strip_tags' ); ?>
                                            <p class="mb-0"><?php echo get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '', ', ' ); ?></p>
                                            <?php remove_filter( 'term_links-jetpack-portfolio-type', 'front_portfolio_type_strip_tags' ); ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php $i++; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
            <?php do_action( 'front_portfolio_section_after_content' );
        endif;
        wp_reset_postdata();
    }
}

if ( ! function_exists( 'front_portfolio_type_strip_tags' ) ) {
    function front_portfolio_type_strip_tags( $links ) {
        foreach ( $links as $key => $link ) {
            $links[$key] = wp_strip_all_tags( $link );
        }
        return $links;
    }
}


if ( ! function_exists( 'front_testimonial_14_section' ) ) {
    function front_testimonial_14_section( $args = array() ) {
        $defaults = apply_filters( 'front_testimonial_14_section_args', array(
            'display_author'       =>true,
            'display_description'  =>true,
            'display_position'     =>true,
            'display_author_image' =>true,
            'author_color'       =>'',
            'description_color'  =>'',
            'position_color'    =>'',
            'bg_color'          =>'',
            'border_radius'     => '',
            'columns'           => 3,
            'post_atts'         => array(),
            'el_class'          => '',
        ) );

        $args = wp_parse_args( $args, $defaults );
        extract( $args );

        $query_args = array(
            'post_status'    => 'publish',
            'post_type'      => 'jetpack-testimonial', 
            'posts_per_page' => isset( $post_atts['posts_per_page'] ) ? absint( $post_atts['posts_per_page'] ): 2,
            'orderby'        => isset( $post_atts['orderby'] ) ?  $post_atts['orderby'] : 'date',
            'order'          => isset( $post_atts['order'] ) ?  $post_atts['order'] : 'DESC',
        );

        if( isset( $post_atts['ids'] ) && ! empty( $post_atts['ids'] ) ) {
            $query_args['post__in'] = explode( ",", $post_atts['ids'] );
        }

        $posts_query = new WP_Query( $query_args );
        if ( $posts_query->have_posts() ) : ?>
            <div class="container space-2">
                <div class="row">
                    <?php while ( $posts_query->have_posts() ) : $posts_query->the_post();
                        $style = '';
                        if ( $columns == '1' ) {
                            $style= 'max-width: 100%; ';
                        }
                        $style .= 'border-radius:' . $border_radius . 'px;' . 'background-color:' . $bg_color . ';';
                        $style1 = 'color:' . $author_color . ';' ;
                        $style2 = 'color:' . $description_color . ';' ;
                        $style3 = 'color:' . $position_color . ';' ;
                        ?>
                        <div class="col-lg-<?php echo esc_attr( intval( 12/$columns ) ); ?> mb-5">
                            <div class="card border-0 shadow-soft h-100" style="<?php echo esc_attr( $style );?>">
                                <div class="card-body p-5">
                                    <div class="mb-auto">
                                        <?php if ( ( isset( $display_description ) && ! empty( $display_description ) ) ) {?>
                                            <?php echo str_replace( '<p>', '<p class="mb-0' . ( isset( $description_color ) && ! empty( $description_color ) ? '' : esc_attr( ' text-dark' ) ) . '" style="' . esc_attr( $style2 ) . '">', get_the_content() ); ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="card-footer border-0 bg-transparent pt-0 px-5 pb-5">
                                    <div class="media">
                                        <div class="u-avatar mr-3">
                                            <?php if ( ( isset( $display_author_image ) && ! empty( $display_author_image ) ) ) {
                                            the_post_thumbnail('large', array(
                                            'class' => 'img-fluid rounded-circle'
                                        )); }?>
                                        </div>
                                        <div class="media-body">
                                            <?php if ( ( isset( $display_author ) && ! empty( $display_author ) ) ) {?>
                                                <h4 class="h6 mb-0" style="<?php echo esc_attr( $style1 );?>"><?php echo the_title(); ?></h4>
                                            <?php } ?>
                                            <?php if ( ( isset( $display_position ) && ! empty( $display_position ) ) ) {?>
                                            <small class="d-block<?php echo isset( $position_color ) && ! empty( $position_color ) ? '' : esc_attr( ' text-secondary' );?>" style="<?php echo esc_attr( $style3 );?>">Business Manager</small>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif;
        wp_reset_postdata();
    }
}