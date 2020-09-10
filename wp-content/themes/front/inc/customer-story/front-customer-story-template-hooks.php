<?php
/**
 * Template Hooks used in Customer Story
 */

// add_filter( 'front_display_header_args', 'front_customer_story_header_args' );

add_action( 'front_customer_story_single_post_before', 'front_single_customer_story_title', 10 );

add_action( 'front_customer_story_single_post', 'front_single_customer_story_content_wrap_open', 10 );
add_action( 'front_customer_story_single_post', 'front_single_customer_story_sticky_content', 20 );
add_action( 'front_customer_story_single_post', 'front_single_customer_story_content', 30 );
add_action( 'front_customer_story_single_post', 'front_single_customer_story_content_wrap_close', 40 );

add_action( 'front_single_after_customer_story', 'front_single_customer_story_after_static_content', 10 );