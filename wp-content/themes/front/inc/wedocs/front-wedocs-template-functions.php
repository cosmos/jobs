<?php

/**
 * Template tags used in Front WeDocs
 */

if ( ! function_exists( 'front_wedocs_single_docs_remove_hooks' ) ) :

function front_wedocs_single_docs_remove_hooks() {
    // remove main actions
    remove_action( 'wedocs_before_main_content', 'wedocs_template_wrapper_start', 10 );
    remove_action( 'wedocs_after_main_content', 'wedocs_template_wrapper_end', 10 );
}

endif;

if ( ! function_exists( 'front_wedocs_docs_search_form' ) ) :

function front_wedocs_docs_search_form() {
    ?>
    <div class="gradient-half-primary-v1">
        <div class="bg-img-hero-center" style="background-image: url( <?php echo esc_attr( get_template_directory_uri() ); ?>/assets/svg/components/bg-elements-10.svg );">
            <div class="container space-1">
                <div class="w-lg-80 mx-lg-auto">
                    <!-- Input -->
                    <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="wedocs-search-form input-group input-group-borderless">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="askQuestions">
                                <span class="fas fa-search"></span>
                            </span>
                        </div>
                        <input type="hidden" name="post_type" value="docs" />
                        <input name="s" type="search" class="form-control" placeholder="<?php echo esc_attr__( 'Documentation Search &hellip;', 'front' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" aria-label="<?php echo esc_attr__( 'Documentation Search &hellip;', 'front' ); ?>" aria-describedby="askQuestions">
                    </form>
                    <!-- End Input -->
                </div>
            </div>
        </div>
    </div>
    <?php
}

endif;

if ( ! function_exists( 'front_wedocs_docs_entry_header' ) ) : 

function front_wedocs_docs_entry_header() {
    ?>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title h2 font-weight-medium" itemprop="headline">', '</h1>' ); ?>
        <?php the_excerpt(); ?>
        <?php front_wedocs_docs_entry_meta(); ?>
    </header>
    <?php
}

endif;

if ( ! function_exists( 'front_wedocs_docs_entry_meta' ) ) :

function front_wedocs_docs_entry_meta() {
    ?>
    <div class="media mb-5">
        <div class="u-sm-avatar u-avatar--bordered rounded-circle mr-2">
            <img class="img-fluid rounded-circle" src="<?php echo esc_url( get_avatar_url( get_the_author_meta( 'ID' ) ) ); ?>" alt="Image Description">
        </div>

        <div class="media-body">
            <div class="wedocs-article-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                <small class="d-block">
                    <?php echo wp_kses_post( sprintf( '<span class="text-muted">%s</span> %s', esc_html__( 'Written by', 'front' ), get_the_author() ) ); ?>
                </small>
                <meta itemprop="name" content="<?php echo get_the_author(); ?>" />
                <meta itemprop="url" content="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" />
            </div>
            <meta itemprop="datePublished" content="<?php echo get_the_time( 'c' ); ?>"/>
            <time class="d-block text-secondary" itemprop="dateModified" datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><small><?php printf( esc_html__( 'Updated on %s', 'front' ), get_the_modified_date() ); ?></small></time>
        </div>
    </div>
    <?php
}

endif;

if ( ! function_exists( 'front_wedocs_docs_entry_content' ) ) : 

function front_wedocs_docs_entry_content() {
    global $post;
    ?>
    <div class="entry-content" itemprop="articleBody">
        <?php
            the_content( sprintf(
                /* translators: %s: Name of current post. */
                wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'front' ), array( 'span' => array( 'class' => array() ) ) ),
                the_title( '<span class="screen-reader-text">"', '"</span>', false )
            ) );
            
            front_wedocs_child_pages();

            front_wedocs_tags_list();
        ?>
    </div>
    <?php
}

endif;

if ( ! function_exists( 'front_wedocs_tags_list' ) ) :
/**
 * List tags in single docs
 */
function front_wedocs_tags_list( $post = null ) {
    
    if ( is_null( $post ) ) {
        global $post;
    }

    $tags_list = str_replace( 'rel="tag"', 'rel="tag" class="link-muted ml-1"', wedocs_get_the_doc_tags( $post->ID, '', '<span class="tags-separator text-muted">,</span> ' ) );

    if ( $tags_list ) {
        printf( '<span class="d-block font-size-1 tags-links"><span class="text-dark">%1$s </span>%2$s</span>',
            _x( 'Tags:', 'Used before tag names.', 'front' ),
            $tags_list
        );
    }
}

endif;

if ( ! function_exists( 'front_wedocs_child_pages' ) ) : 
/**
 * List all child pages for this topic
 */
function front_wedocs_child_pages( $post = null ) {

    if ( is_null( $post ) ) {
        global $post;
    }

    $child_pages_args = apply_filters( 'front_wedocs_child_pages_args', array(
        'title_li'  => '',
        'order'     => 'menu_order',
        'child_of'  => $post->ID,
        'echo'      => false,
        'post_type' => $post->post_type,
        'walker'    => new WeDocs_Page_Walker,
    ) );

    $children = wp_list_pages( $child_pages_args );

    if ( $children ) : ?>
        <div class="article-child mb-4">
            <ul class="list-unstyled">
            <?php echo wp_kses_post( $children ); ?>
            </ul>
        </div><?php
    endif;
}
endif;

if ( ! function_exists( 'front_wedocs_docs_entry_feedback' ) ) :

function front_wedocs_docs_entry_feedback() {
    if ( wedocs_get_option( 'helpful', 'wedocs_settings', 'on' ) == 'on' ):
        wedocs_get_template_part( 'content', 'feedback' );
    endif;
}

endif;

if ( ! function_exists( 'front_wedocs_related_articles' ) ) : 

function front_wedocs_related_articles() {
    global $post;

    $orig_post = $post;

    $related_articles_number = apply_filters( 'front_wedocs_related_articles_number', 5 );

    $tags       = wp_get_post_tags( $post->ID );
    $categories = get_the_category( $post->ID );
    
    if ( $tags ) {
        $tag_ids = array();
        foreach( $tags as $tag ) {
            $tag_ids[] = $tag->term_id;
        }

        $related_articles_query_args = apply_filters( 'front_wedocs_related_articles_query_args', array(
            'tag__in'             => $tag_ids,
            'post__not_in'        => array( $post->ID ),
            'posts_per_page'      => $related_articles_number, // Number of related posts that will be shown.
            'ignore_sticky_posts' => 1,
            'post_type'           => $post->post_type,
        ), 'tags', $tag_ids );
    } elseif ( $categories ) {
        $category_ids = array();

        foreach( $categories as $category ) {
            $category_ids[] = $category->term_id;
        }
    

        $related_articles_query_args = apply_filters( 'front_wedocs_related_articles_query_args', array(
            'category__in'        => $category_ids,
            'post__not_in'        => array( $post->ID ),
            'posts_per_page'      => $related_articles_number, // Number of related posts that will be shown.
            'ignore_sticky_posts' => 1,
            'post_type'           => $post->post_type,
        ), 'categories', $category_ids );
    } else {

        $related_articles_query_args = apply_filters( 'front_wedocs_related_articles_query_args', array(
            'post__not_in'        => array( $post->ID ),
            'posts_per_page'      => $related_articles_number, // Number of related posts that will be shown.
            'ignore_sticky_posts' => 1,
            'post_type'           => $post->post_type,
        ) );

        if ( $post->post_parent ) {
            $related_articles_query_args['post_parent'] = $post->post_parent;
        } else {
            $related_articles_query_args['post_parent'] = $post->ID;
        }
    }

    $related_articles_query = new wp_query( $related_articles_query_args );

    if( $related_articles_query->have_posts() ) {
        ?><div class="mb-4">
            <h3 class="h5 font-weight-medium"><?php echo esc_html__( 'Related Articles', 'front' ); ?></h3>
        </div>
        <ul class="list-unstyled"><?php
        while( $related_articles_query->have_posts() ): $related_articles_query->the_post();  ?>
            <li class="pb-3">
                <a href="<?php echo esc_url( get_the_permalink() ); ?>" rel="bookmark" class="link-muted"><?php the_title(); ?></a>
            </li>
        <?php endwhile; ?>
        </ul><?php
    }

    $post = $orig_post;
    wp_reset_postdata(); 
}

endif;

if ( ! function_exists( 'front_wedocs_entry_thumbnail' ) ) :
/**
 * Displays featured image of the docs
 */
function front_wedocs_entry_thumbnail( $post = null ) {

    if ( is_null( $post ) ) {
        global $post;
    }

    $post_thumbnail_id = get_post_thumbnail_id( $post );

    if ( $post_thumbnail_id ) {

        $metadata = wp_get_attachment_metadata( $post_thumbnail_id );

        if ( $metadata['sizes']['post-thumbnail']['mime-type'] === 'image/svg+xml' ) :

        ?><figure id="icon-<?php echo esc_attr( $post_thumbnail_id );?>" class="svg-preloader ie-height-56 w-100 max-width-8 mr-4">
            <img class="js-svg-injector" src="<?php echo esc_url( get_the_post_thumbnail_url( $post ) ); ?>" alt="<?php echo esc_attr__( 'post thumbnail', 'front' ); ?>" data-parent="#icon-<?php echo esc_attr( $post_thumbnail_id );?>">
        </figure><?php

        else: 

        ?><figure class="ie-height-56 w-100 max-width-8 mr-4">
            <img src="<?php echo esc_url( get_the_post_thumbnail_url( $post ) ); ?>" alt="<?php echo esc_attr__( 'post thumbnail', 'front' ); ?>" >
        </figure><?php

        endif;

    } else {

        ?><figure id="icon-placeholder-<?php echo esc_attr( $post->ID );?>" class="svg-preloader ie-height-56 w-100 max-width-8 mr-4">
            <img class="js-svg-injector" src="<?php echo esc_url( get_template_directory_uri() . '/assets/svg/icons/icon-2.svg' ); ?>" alt="<?php echo esc_attr__( 'post thumbnail', 'front' ); ?>" data-parent="#icon-placeholder-<?php echo esc_attr( $post->ID );?>">
        </figure><?php

    }
}

endif;

if ( ! function_exists( 'front_wedocs_container_start' ) ):
/**
 * Wraps container on Docs Home Page
 */
function front_wedocs_container_start() {
    ?><div class="container">
        <div class="border-bottom space-bottom-2">
            <div class="w-lg-80 mx-lg-auto"><?php
}
endif;

if ( ! function_exists( 'front_wedocs_container_end' ) ):
/**
 * Closes container
 */
function front_wedocs_container_end() {
    ?></div></div></div><?php
}
endif;