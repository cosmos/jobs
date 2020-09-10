<?php
/**
 * Post Types
 *
 * Registers post types and taxonomies.
 *
 * @package Front_Extensions/Classes
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Post types Class.
 */
class Front_Extensions_Post_Types {

    /**
     * Hook in methods.
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'register_post_types' ), 5 );
        add_filter( 'rest_api_allowed_post_types', array( __CLASS__, 'rest_api_allowed_post_types' ) );
        add_action( 'front_extensions_after_register_post_type', array( __CLASS__, 'maybe_flush_rewrite_rules' ) );
        add_action( 'front_extensions_flush_rewrite_rules', array( __CLASS__, 'flush_rewrite_rules' ) );
        add_filter( 'gutenberg_can_edit_post_type', array( __CLASS__, 'gutenberg_can_edit_post_type' ), 10, 2 );
    }

    /**
     * Register core post types.
     */
    public static function register_post_types() {

        if ( ! is_blog_installed() ) {
            return;
        }

        do_action( 'front_extensions_register_post_type' );

        if( apply_filters( 'front_extensions_enable_customer_story_post_type', true ) ) {
            register_post_type(
                'customer_story',
                apply_filters(
                    'front_extensions_register_post_type_customer_story',
                    array(
                        'labels'              => array(
                            'name'                  => esc_html__( 'Customer Stories', 'front-extensions' ),
                            'singular_name'         => esc_html__( 'Customer Story', 'front-extensions' ),
                            'all_items'             => esc_html__( 'All Customer Stories', 'front-extensions' ),
                            'menu_name'             => esc_html_x( 'Customer Stories', 'Admin menu name', 'front-extensions' ),
                            'add_new'               => esc_html__( 'Add New', 'front-extensions' ),
                            'add_new_item'          => esc_html__( 'Add new customer story', 'front-extensions' ),
                            'edit'                  => esc_html__( 'Edit', 'front-extensions' ),
                            'edit_item'             => esc_html__( 'Edit customer story', 'front-extensions' ),
                            'new_item'              => esc_html__( 'New customer story', 'front-extensions' ),
                            'view_item'             => esc_html__( 'View customer story', 'front-extensions' ),
                            'view_items'            => esc_html__( 'View customer stories', 'front-extensions' ),
                            'search_items'          => esc_html__( 'Search customer stories', 'front-extensions' ),
                            'not_found'             => esc_html__( 'No customer stories found', 'front-extensions' ),
                            'not_found_in_trash'    => esc_html__( 'No customer stories found in trash', 'front-extensions' ),
                            'parent'                => esc_html__( 'Parent customer story', 'front-extensions' ),
                            'featured_image'        => esc_html__( 'Customer Story image', 'front-extensions' ),
                            'set_featured_image'    => esc_html__( 'Set customer story image', 'front-extensions' ),
                            'remove_featured_image' => esc_html__( 'Remove customer story image', 'front-extensions' ),
                            'use_featured_image'    => esc_html__( 'Use as customer story image', 'front-extensions' ),
                            'insert_into_item'      => esc_html__( 'Insert into customer story', 'front-extensions' ),
                            'uploaded_to_this_item' => esc_html__( 'Uploaded to this customer story', 'front-extensions' ),
                            'filter_items_list'     => esc_html__( 'Filter customer stories', 'front-extensions' ),
                            'items_list_navigation' => esc_html__( 'Customer Stories navigation', 'front-extensions' ),
                            'items_list'            => esc_html__( 'Customer Stories list', 'front-extensions' ),
                        ),
                        'description'         => esc_html__( 'This is where you can add new customer stories to your site.', 'front-extensions' ),
                        'public'              => true,
                        'show_ui'             => true,
                        'map_meta_cap'        => true,
                        'publicly_queryable'  => true,
                        'exclude_from_search' => true,
                        'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
                        'rewrite'             => array(
                            'slug'                  => 'customer-story',
                            'with_front'            => false,
                            'feeds'                 => true,
                            'pages'                 => true,
                        ),
                        'query_var'           => true,
                        'supports'            => array( 'title', 'editor', 'thumbnail', 'author', 'revisions', 'excerpt' ),
                        'has_archive'         => false,
                        'show_in_nav_menus'   => true,
                        'show_in_menu'        => true,
                        'show_in_rest'        => true,
                        'menu_icon'           => 'dashicons-admin-post',
                    )
                )
            );

            if( apply_filters( 'front_extensions_enable_customer_story_cat_taxonomy', false ) ) {
                // Register Custom Taxonomy
                $labels = array(
                    'name'                       => esc_html_x( 'Categories', 'Taxonomy General Name', 'front-extensions' ),
                    'singular_name'              => esc_html_x( 'Category', 'Taxonomy Singular Name', 'front-extensions' ),
                    'menu_name'                  => esc_html__( 'Categories', 'front-extensions' ),
                    'all_items'                  => esc_html__( 'All Items', 'front-extensions' ),
                    'parent_item'                => esc_html__( 'Parent Item', 'front-extensions' ),
                    'parent_item_colon'          => esc_html__( 'Parent Item:', 'front-extensions' ),
                    'new_item_name'              => esc_html__( 'New Item Name', 'front-extensions' ),
                    'add_new_item'               => esc_html__( 'Add New Item', 'front-extensions' ),
                    'edit_item'                  => esc_html__( 'Edit Item', 'front-extensions' ),
                    'update_item'                => esc_html__( 'Update Item', 'front-extensions' ),
                    'view_item'                  => esc_html__( 'View Item', 'front-extensions' ),
                    'separate_items_with_commas' => esc_html__( 'Separate items with commas', 'front-extensions' ),
                    'add_or_remove_items'        => esc_html__( 'Add or remove items', 'front-extensions' ),
                    'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'front-extensions' ),
                    'popular_items'              => esc_html__( 'Popular Items', 'front-extensions' ),
                    'search_items'               => esc_html__( 'Search Items', 'front-extensions' ),
                    'not_found'                  => esc_html__( 'Not Found', 'front-extensions' ),
                    'no_terms'                   => esc_html__( 'No items', 'front-extensions' ),
                    'items_list'                 => esc_html__( 'Items list', 'front-extensions' ),
                    'items_list_navigation'      => esc_html__( 'Items list navigation', 'front-extensions' ),
                );

                $args = apply_filters( 'front_extensions_register_taxonomy_customer_story_cat', array(
                    'labels'                     => $labels,
                    'hierarchical'               => false,
                    'public'                     => true,
                    'show_ui'                    => true,
                    'show_admin_column'          => true,
                    'show_in_nav_menus'          => true,
                    'show_tagcloud'              => true,
                ) );
                register_taxonomy( 'customer_story_cat', array( 'customer_story' ), $args );
            }
        }

        do_action( 'front_extensions_after_register_post_type' );
    }

    /**
     * Flush rules if the event is queued.
     */
    public static function maybe_flush_rewrite_rules() {
        self::flush_rewrite_rules();
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
        return in_array( $post_type, array( 'customer_story' ) ) ? false : $can_edit;
    }

    /**
     * Added video for Jetpack related posts.
     *
     * @param  array $post_types Post types.
     * @return array
     */
    public static function rest_api_allowed_post_types( $post_types ) {
        $post_types[] = 'customer_story';

        return $post_types;
    }
}

Front_Extensions_Post_Types::init();
