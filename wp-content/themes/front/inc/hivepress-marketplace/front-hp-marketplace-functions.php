<?php
/**
 * Functions related to HP Marketplace
 */

if ( ! function_exists( 'front_hp_listing_add_post_type_support' ) ) {
    function front_hp_listing_add_post_type_support() {
        add_post_type_support( 'hp_listing', array( 'excerpt', 'custom-fields' ) );
    }
}

if ( ! function_exists( 'front_hp_listing_use_block_editor_for_post_type_args' ) ) {
    /**
     * Disable gutenberg editor support to an already registered post type.
     * https://github.com/WordPress/gutenberg/issues/7595
     */
    function front_hp_listing_use_block_editor_for_post_type_args( $can_edit, $post_type ){
        if ( 'hp_listing' === $post_type ) {
            $can_edit = false;
        }

        return $can_edit;
    }
}

if ( ! function_exists( 'front_hp_listing_post_type_args' ) ) {
    /**
     * Add REST API support to an already registered post type.
     */
    function front_hp_listing_post_type_args( $args, $post_type ) {
        if ( 'hp_listing' === $post_type ) {
            $args['show_in_rest'] = true;
        }

        return $args;
    }
}

if ( ! function_exists( 'front_hp_listing_taxonomy_args' ) ) {
    /**
     * Add REST API support to an already registered taxonomy.
     */
    function front_hp_listing_taxonomy_args( $args, $taxonomy ) {
        if ( 'hp_listing_category' === $taxonomy ) {
            $args['show_in_rest'] = true;
        }

        return $args;
    }
}

if ( ! function_exists( 'front_hp_is_listing_archive' ) ) {
    /**
     * Returns if a page is listing home or not
     */
    function front_hp_is_listing_archive() {
        return is_post_type_archive( 'hp_listing' );
    }
}

if ( ! function_exists( 'front_hp_is_listing_search' ) ) {
    /**
     * Returns if a page is listing search or not
     */
    function front_hp_is_listing_search() {
        return ( is_search() && get_post_type() == 'hp_listing' );
    }
}

if ( ! function_exists( 'front_hp_is_listing_taxonomy' ) ) {
    /**
     * Returns if a page is listing taxonomy or not
     */
    function front_hp_is_listing_taxonomy() {
        return is_tax( get_object_taxonomies( 'hp_listing' ) );
    }
}

if ( ! function_exists( 'front_hp_is_listing_single' ) ) {
    /**
     * Returns if a page is listing single or not
     */
    function front_hp_is_listing_single() {
        return ( is_single() && get_post_type() == 'hp_listing' );
    }
}

if ( ! function_exists( 'front_hp_listing_pre_get_posts' ) ) {
    function front_hp_listing_pre_get_posts( $query ) {
        if ( is_admin() || ! $query->is_main_query() ) {
            return;
        }

        if ( front_hp_is_listing_archive() ) {
            $meta_query = array();
            $varication = isset( $_GET['varication'] ) ? front_clean( wp_unslash( $_GET['varication'] ) ) : '';
            if( $varication == 'verified' ) {
                $meta_query = array(
                    array(
                        'key' => 'hp_verified',
                        'value' => '1',
                        'compare' => '==',
                    ),
                );
                $query->set( 'meta_query', $meta_query );
            } elseif( $varication == 'unverified' ) {
                $meta_query = array(
                    'relation' => 'OR',
                    array(
                        'key' => 'hp_verified',
                        'compare' => 'NOT EXISTS' // doesn't work
                    ),
                    array(
                        'key' => 'hp_verified',
                        'value' => '1',
                        'compare' => '!=',
                    ),
                );
                $query->set( 'meta_query', $meta_query );
            }

            $listings_attributes = isset( $_GET['hp_listings_attributes'] ) ? explode( ',', front_clean( wp_unslash( $_GET['hp_listings_attributes'] ) ) ) : array();

            if( ! empty( $listings_attributes ) ) {
                $listings_attributes_filters = array();
                foreach( $listings_attributes as $value ) {
                    $listings_attributes_filters[] = array(
                        'key' => 'hp_' . $value,
                        'value' => '1',
                        'compare' => '==',
                    );
                } 
                $meta_query = array_merge( $meta_query, $listings_attributes_filters );
                $query->set( 'meta_query', $meta_query );
            }

            return;
        }
    }
}
