<?php
/**
 * Functions used when JetPack is activated
 */
/**
 * Checks if Portfolio Module is activated
 *
 */
function front_jp_is_portfolio_activated() {
    if ( class_exists( 'Jetpack' ) &&  class_exists( 'Jetpack_Portfolio' ) ) {
        $setting = Jetpack_Options::get_option_and_ensure_autoload( Jetpack_Portfolio::OPTION_NAME, '0' );    
    } else {
        return false;
    }
    
    return ( ! empty( $setting ) );
}

/**
 * Checks if Testimonial Module is activated
 *
 */
function front_jp_is_testimonial_activated() {
    if ( class_exists( 'Jetpack' ) && class_exists( 'Jetpack_Testimonial' ) ) {
        $setting = Jetpack_Options::get_option_and_ensure_autoload( Jetpack_Testimonial::OPTION_NAME, '0' );    
    } else {
        return false;
    }
    
    return ( ! empty( $setting ) );
}

/**
 * Checks if a page is a JetPack Portfolio page
 *
 */
function front_is_jetpack_portfolio() {
    return front_jp_is_portfolio_activated() && ( is_post_type_archive( Jetpack_Portfolio::CUSTOM_POST_TYPE ) || is_singular( Jetpack_Portfolio::CUSTOM_POST_TYPE ) );
}

function front_get_portfolio_view() {
    $portfolio_view = apply_filters( 'front_portfolio_view', 'modern' );

    if( is_tax( 'jetpack-portfolio-type' ) ) {
        $term           = get_queried_object();
        $term_id        = $term->term_id;
        $type_portfolio_view  = get_term_meta( $term_id, 'portfolio_view', true );
        if ( ! empty( $type_portfolio_view ) ) {
            $portfolio_view = $type_portfolio_view;
        }
    }

    return $portfolio_view;
}

function front_get_portfolio_layout() {
    $portfolio_layout = apply_filters( 'front_portfolio_layout', 'fullwidth' );

    if( is_tax( 'jetpack-portfolio-type' ) ) {
        $term           = get_queried_object();
        $term_id        = $term->term_id;
        $type_portfolio_layout  = get_term_meta( $term_id, 'portfolio_layout', true );
        if ( ! empty( $type_portfolio_layout ) ) {
            $portfolio_layout = $type_portfolio_layout;
        }
    }

    return $portfolio_layout;
}

function front_portfolio_set_posts_per_page( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( front_jp_is_portfolio_activated() && is_post_type_archive( Jetpack_Portfolio::CUSTOM_POST_TYPE ) ) {
        $query->set( 'posts_per_page', apply_filters( 'front_portfolio_posts_per_page', 16 ) );
        return;
    }
}

function front_get_jetpack_page_views( $post_id ) {
    if ( function_exists( 'stats_get_csv' ) ) {
        $args = array( 'days' => -1, 'limit' => -1, 'post_id' => $post_id );
        $result = stats_get_csv( 'postviews', $args );
        $views = $result[0]['views'];
    } else {
        $views = 0;
    }

    return apply_filters( 'front_get_jetpack_page_views', absint( $views ) );
}