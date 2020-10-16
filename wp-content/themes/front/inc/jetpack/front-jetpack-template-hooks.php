<?php
/**
 * Template Hooks used in JetPack
 */

/**
* Portfolio
*/
add_action( 'pre_get_posts', 'front_portfolio_set_posts_per_page', 20 );

add_action( 'front_before_portfolio', 'front_portfolio_hero',            10 );

add_action( 'front_loop_portfolio_before', 'front_loop_portfolio_wrap_start', 10 );
add_action( 'front_loop_portfolio', 'front_portfolio_content', 10);
add_action( 'front_loop_portfolio_after', 'front_loop_portfolio_wrap_end', 10 );
add_action( 'front_after_portfolio', 'front_portfolio_contact', 10 );
add_action( 'front_after_portfolio', 'front_portfolio_static_content', 20 );

/**
 * Single Portfolio
 */
add_action( 'front_portfolio_single_post', 'front_jetpack_sharing_filters', 5 );
add_action( 'front_portfolio_single_post', 'front_single_portfolio_content', 10 );
add_action( 'front_portfolio_single_post', 'front_portfolio_related_works', 20 );

/**
 * Single Post
 */
add_action( 'front_single_post_before', 'front_jetpack_sharing_filters', 5 );