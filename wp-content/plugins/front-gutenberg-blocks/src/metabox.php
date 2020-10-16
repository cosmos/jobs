<?php

if ( ! function_exists( 'frontgb_register_meta_fields' ) ) {
    function frontgb_register_meta_fields() {
        add_post_type_support( 'docs', 'custom-fields' );
        register_meta( 'post', '_featured', array(
            'object_subtype' => 'docs',
            'show_in_rest' => true,
            'type' => 'boolean',
            'single' => true,
            // 'sanitize_callback' => 'sanitize_text_field',
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            }
        ) );

        register_meta( 'post', '_front_options', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'string',
            'single' => true,
            // 'sanitize_callback' => 'sanitize_text_field',
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );

        add_post_type_support( 'jetpack-testimonial', 'custom-fields' );
        register_meta( 'post', '_rating', array(
            'object_subtype' => 'jetpack-testimonial',
            'show_in_rest' => true,
            'type' => 'number',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            }
        ) );
        register_meta( 'post', '_author_position', array(
            'object_subtype' => 'jetpack-testimonial',
            'show_in_rest' => true,
            'type' => 'string',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            }
        ) );

        add_post_type_support( 'customer_story', 'custom-fields' );
        register_meta( 'post', '_featured_logo', array(
            'object_subtype' => 'customer_story',
            'show_in_rest' => true,
            'type' => 'string',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            }
        ) );
        register_meta( 'post', '_additional_information_count', array(
            'object_subtype' => 'customer_story',
            'show_in_rest' => true,
            'type' => 'number',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            }
        ) );
        register_meta( 'post', '_key_features_count', array(
            'object_subtype' => 'customer_story',
            'show_in_rest' => true,
            'type' => 'number',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            }
        ) );
        register_meta( 'post', '_custom_static_content_id', array(
            'object_subtype' => 'customer_story',
            'show_in_rest' => true,
            'type' => 'number',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            }
        ) );
        register_meta( 'post', '_additional_information', array(
            'object_subtype' => 'customer_story',
            'show_in_rest' => true,
            'type' => 'string',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            }
        ) );
        register_meta( 'post', '_key_features', array(
            'object_subtype' => 'customer_story',
            'show_in_rest' => true,
            'type' => 'string',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            }
        ) );

        add_post_type_support( 'jetpack-portfolio', 'custom-fields' );
        register_meta( 'post', '_description', array(
            'object_subtype' => 'jetpack-portfolio',
            'show_in_rest' => true,
            'type' => 'string',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            }
        ) );
        register_meta( 'post', '_attributes', array(
            'object_subtype' => 'jetpack-portfolio',
            'show_in_rest' => true,
            'type' => 'string',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            }
        ) );
    }
    add_action('init', 'frontgb_register_meta_fields');
}