<?php
/**
 * Post Types
 *
 * Registers post types and taxonomies.
 *
 * @package Mas_Static_Content/Classes
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Post types Class.
 */
class Mas_Static_Content_Post_Types {

    /**
     * Hook in methods.
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'register_post_types' ), 5 );
        add_filter( 'rest_api_allowed_post_types', array( __CLASS__, 'rest_api_allowed_post_types' ) );
        add_action( 'mas_static_content_after_register_post_type', array( __CLASS__, 'maybe_flush_rewrite_rules' ) );
        add_action( 'mas_static_content_flush_rewrite_rules', array( __CLASS__, 'flush_rewrite_rules' ) );
        add_filter( 'gutenberg_can_edit_post_type', array( __CLASS__, 'gutenberg_can_edit_post_type' ), 10, 2 );
    }

    /**
     * Register core post types.
     */
    public static function register_post_types() {

        if ( ! is_blog_installed() ) {
            return;
        }

        do_action( 'mas_static_content_register_post_type' );

        // If theme support changes, we may need to flush permalinks since some are changed based on this flag.
        if ( update_option( 'current_theme_supports_mas_static_content', current_theme_supports( 'mas-static-content' ) ? 'yes' : 'no' ) ) {
            update_option( 'mas_static_content_queue_flush_rewrite_rules', 'yes' );
        }

        register_post_type(
            'mas_static_content',
            apply_filters(
                'mas_static_content_register_post_type_mas_static_content',
                array(
                    'labels'              => array(
                        'name'                  => esc_html__( 'Static Contents', 'mas-static-content' ),
                        'singular_name'         => esc_html__( 'Static Content', 'mas-static-content' ),
                        'all_items'             => esc_html__( 'All Static Contents', 'mas-static-content' ),
                        'menu_name'             => esc_html_x( 'Static Contents', 'Admin menu name', 'mas-static-content' ),
                        'add_new'               => esc_html__( 'Add New', 'mas-static-content' ),
                        'add_new_item'          => esc_html__( 'Add new static content', 'mas-static-content' ),
                        'edit'                  => esc_html__( 'Edit', 'mas-static-content' ),
                        'edit_item'             => esc_html__( 'Edit static content', 'mas-static-content' ),
                        'new_item'              => esc_html__( 'New static content', 'mas-static-content' ),
                        'view_item'             => esc_html__( 'View static content', 'mas-static-content' ),
                        'view_items'            => esc_html__( 'View static contents', 'mas-static-content' ),
                        'search_items'          => esc_html__( 'Search static contents', 'mas-static-content' ),
                        'not_found'             => esc_html__( 'No static contents found', 'mas-static-content' ),
                        'not_found_in_trash'    => esc_html__( 'No static contents found in trash', 'mas-static-content' ),
                        'parent'                => esc_html__( 'Parent static content', 'mas-static-content' ),
                        'featured_image'        => esc_html__( 'Static Content image', 'mas-static-content' ),
                        'set_featured_image'    => esc_html__( 'Set static content image', 'mas-static-content' ),
                        'remove_featured_image' => esc_html__( 'Remove static content image', 'mas-static-content' ),
                        'use_featured_image'    => esc_html__( 'Use as static content image', 'mas-static-content' ),
                        'insert_into_item'      => esc_html__( 'Insert into static content', 'mas-static-content' ),
                        'uploaded_to_this_item' => esc_html__( 'Uploaded to this static content', 'mas-static-content' ),
                        'filter_items_list'     => esc_html__( 'Filter static contents', 'mas-static-content' ),
                        'items_list_navigation' => esc_html__( 'Static Contents navigation', 'mas-static-content' ),
                        'items_list'            => esc_html__( 'Static Contents list', 'mas-static-content' ),
                    ),
                    'description'         => esc_html__( 'This is where you can add new static contents to your site.', 'mas-static-content' ),
                    'public'              => true,
                    'show_ui'             => true,
                    'map_meta_cap'        => true,
                    'publicly_queryable'  => true,
                    'exclude_from_search' => true,
                    'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
                    'rewrite'             => false,
                    'query_var'           => true,
                    'supports'            => array( 'title', 'editor', 'revisions' ),
                    'has_archive'         => false,
                    'show_in_nav_menus'   => true,
                    'show_in_menu'        => true,
                    'show_in_rest'        => true,
                    'menu_icon'           => 'dashicons-admin-post',
                )
            )
        );

        if( apply_filters( 'mas_static_content_enable_category_taxonomy', true ) ) {
            // Register Custom Taxonomy
            $labels = array(
                'name'                       => esc_html_x( 'Categories', 'Taxonomy General Name', 'mas-static-content' ),
                'singular_name'              => esc_html_x( 'Category', 'Taxonomy Singular Name', 'mas-static-content' ),
                'menu_name'                  => esc_html__( 'Categories', 'mas-static-content' ),
                'all_items'                  => esc_html__( 'All Items', 'mas-static-content' ),
                'parent_item'                => esc_html__( 'Parent Item', 'mas-static-content' ),
                'parent_item_colon'          => esc_html__( 'Parent Item:', 'mas-static-content' ),
                'new_item_name'              => esc_html__( 'New Item Name', 'mas-static-content' ),
                'add_new_item'               => esc_html__( 'Add New Item', 'mas-static-content' ),
                'edit_item'                  => esc_html__( 'Edit Item', 'mas-static-content' ),
                'update_item'                => esc_html__( 'Update Item', 'mas-static-content' ),
                'view_item'                  => esc_html__( 'View Item', 'mas-static-content' ),
                'separate_items_with_commas' => esc_html__( 'Separate items with commas', 'mas-static-content' ),
                'add_or_remove_items'        => esc_html__( 'Add or remove items', 'mas-static-content' ),
                'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'mas-static-content' ),
                'popular_items'              => esc_html__( 'Popular Items', 'mas-static-content' ),
                'search_items'               => esc_html__( 'Search Items', 'mas-static-content' ),
                'not_found'                  => esc_html__( 'Not Found', 'mas-static-content' ),
                'no_terms'                   => esc_html__( 'No items', 'mas-static-content' ),
                'items_list'                 => esc_html__( 'Items list', 'mas-static-content' ),
                'items_list_navigation'      => esc_html__( 'Items list navigation', 'mas-static-content' ),
            );

            $args = apply_filters( 'mas_static_content_register_taxonomy_mas_static_content_cat', array(
                'labels'                     => $labels,
                'hierarchical'               => false,
                'public'                     => true,
                'show_ui'                    => true,
                'show_admin_column'          => true,
                'show_in_nav_menus'          => true,
                'show_tagcloud'              => true,
            ) );
            register_taxonomy( 'mas_static_content_cat', array( 'mas_static_content' ), $args );
        }

        do_action( 'mas_static_content_after_register_post_type' );
    }

    /**
     * Flush rules if the event is queued.
     *
     * @since 3.3.0
     */
    public static function maybe_flush_rewrite_rules() {
        if ( 'yes' === get_option( 'mas_static_content_queue_flush_rewrite_rules' ) ) {
            update_option( 'mas_static_content_queue_flush_rewrite_rules', 'no' );
            self::flush_rewrite_rules();
        }
    }

    /**
     * Flush rewrite rules.
     */
    public static function flush_rewrite_rules() {
        flush_rewrite_rules();
    }

    /**
     * Disable Gutenberg for videos.
     *
     * @param bool   $can_edit Whether the post type can be edited or not.
     * @param string $post_type The post type being checked.
     * @return bool
     */
    public static function gutenberg_can_edit_post_type( $can_edit, $post_type ) {
        return in_array( $post_type, array( 'mas_static_content' ) ) ? false : $can_edit;
    }

    /**
     * Added video for Jetpack related posts.
     *
     * @param  array $post_types Post types.
     * @return array
     */
    public static function rest_api_allowed_post_types( $post_types ) {
        $post_types[] = 'mas_static_content';

        return $post_types;
    }
}

Mas_Static_Content_Post_Types::init();
