<?php
/**
 * Register Plugin Shortcodes.
 *
 * @since 1.0.0
 *
 * @package MAS Company Reviews For WP Job Manager
 * @category Core
 * @author Madras Themes
 */
 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Class WPJMCR_Shortcodes
 * Handle all reviews.
 *
 * @since 1.0.0
 */
class MAS_WPJMCR_Shortcodes {

    /**
     * Construct.
     * Initialize this class including hooks.
     *
     * @since 1.0.0
     */
    public function __construct() {

        // Shortcode [mas_wpjmcr_review_stars].
        add_shortcode( 'mas_wpjmcr_review_stars', array( $this, 'shortcode_review_stars' ) );

        // Shortcode [mas_wpjmcr_review_average].
        add_shortcode( 'mas_wpjmcr_review_average', array( $this, 'shortcode_review_average' ) );

        // Shortcode [mas_wpjmcr_review_count].
        add_shortcode( 'mas_wpjmcr_review_count', array( $this, 'shortcode_review_count' ) );

        // Shortcode Review Moderation Dashboard [mas_wpjmcr_review_dashboard].
        add_shortcode( 'mas_wpjmcr_review_dashboard', array( $this, 'shortcode_review_dashboard' ) );

        // On review moderate action.
        if ( is_user_logged_in() && isset( $_GET['c'], $_GET['action'], $_GET['moderate_nonce'] ) && $_GET['c'] && $_GET['action'] && $_GET['moderate_nonce'] ) {
            add_action( 'init', array( $this, 'moderate_comment_action' ) ); // Need to be in init hook.
        }
    }


    /**
     * Shortcode [mas_wpjmcr_review_stars].
     *
     * A shortcode for the review stars..
     *
     * @since 1.0.0
     *
     * @param array $atts Attributes given in the shortcode.
     * @return string Shortcode output.
     */
    public function shortcode_review_stars( $atts = array() ) {
        extract( shortcode_atts( array(
            'post_id' => get_the_ID(),
        ), $atts ) );

        if ( ! $post_id ) {
            return;
        }

        return '<span class="review-stars">' . mas_wpjmcr_reviews_get_stars( $post_id ) . '</span>';
    }


    /**
     * Shortcode [mas_wpjmcr_review_average].
     *
     * A shortcode for the review average.
     *
     * @since 1.0.0
     *
     * @param array $atts Attributes given in the shortcode.
     * @return string Shortcode output.
     */
    public function shortcode_review_average( $atts = array() ) {
        extract( shortcode_atts( array(
            'post_id' => get_the_ID(),
        ), $atts ) );

        if ( ! $post_id ) {
            return;
        }

        return '<span class="review-average">' . mas_wpjmcr_get_reviews_average( $post_id ) . '</span>';
    }


    /**
     * Shortcode [mas_wpjmcr_review_count].
     *
     * A shortcode for the review count.
     *
     * @since 1.0.0
     *
     * @param array $atts Attributes given in the shortcode.
     * @return string Shortcode output.
     */
    public function shortcode_review_count( $atts = array() ) {
        extract( shortcode_atts( array(
            'post_id' => get_the_ID(),
        ), $atts ) );

        if ( ! $post_id ) {
            return;
        }

        return '<span class="review-count">' . mas_wpjmcr_get_reviews_count( $post_id ) . '</span>';
    }

    /**
     * Review Dashboard.
     * Shortcode [mas_wpjmcr_review_dashboard].
     * Shortcode to display the review moderate in the dashboard.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function shortcode_review_dashboard() {

        $can_moderate = get_option( 'mas_wpjmcr_listing_authors_can_moderate', '0' );

        if ( ! $can_moderate ) {
            return wpautop( esc_html__( 'Review moderation has not been enabled.', 'mas-wp-job-manager-company-reviews' ) );
        }

        if ( ! is_user_logged_in() ) {
            return wpautop( esc_html__( 'Please log in to moderate reviews.', 'mas-wp-job-manager-company-reviews' ) );
        }

        // Get all user listings.
        $all_listings = new WP_Query( $this->mas_wpjmcr_listings_for_current_user() );

        // User listings:
        $listings = array();
        $listing_ids = $all_listings->have_posts() ? $all_listings->get_posts() : array();
        $listing_ids = apply_filters( 'mas_wpjmcr_current_user_listing_ids', $listing_ids );

        // Comment per page.
        $per_page = 10;

        // Comments query.
        $args = array(
            'post__in'              => $listing_ids ? $listing_ids : array( -1 ),
            'post_author'           => get_current_user_id(),
            'post_type'             => 'company',
            'author__not_in'        => array( get_current_user_id() ),
            'status'                => 'all',
            'include_unapproved'    => true,
            'number'                => $per_page,
            'offset'                => get_query_var( 'paged' ) > 1 ? ( ( get_query_var( 'paged' ) * $per_page ) - $per_page ) : 0,
        );
        $reviews = get_comments( apply_filters( 'mas_wpjmcr_moderate_review_comments_args', $args ) );

        // Get total comments count.
        $comment_query = new WP_Comment_Query();
        $comment_count = $comment_query->query( array(
            'count'                 => true, // Only return the total number of comment.
            'post_author'           => get_current_user_id(),
            'post_type'             => 'company',
            'status'                => 'all',
            'include_unapproved'    => true,
        ) );

        ob_start();
        get_job_manager_template( 'job-review-moderate.php', array(
            'reviews'               => $reviews,
            'max_num_pages'         => round( $comment_count / $per_page ),
        ), '', plugin_dir_path( mas_wpjmcr()->file ) . 'templates/' );
        return ob_get_clean();
    }

    /**
     * Filter Listing Query for current user.
     * 
     * @since 1.0.0
     *
     * @param array $query_args WP Query Listing Args.
     * @param  array $args Args for get_companys().
     * @return array
     */
    public function mas_wpjmcr_listings_for_current_user( $query_args = array() ) {
        $query_args['post_type']      = 'company';
        $query_args['author']         = get_current_user_id();
        $query_args['disable_cache']  = time(); // disables WPJM cache.
        $query_args['posts_per_page'] = -1;
        $query_args['fields']         = 'ids';
        return apply_filters( 'mas_wpjmcr_listings_args_for_current_user', $query_args );
    }

    /**
     * Moderate comment action.
     * Triggered if a user clicked on a moderate action link on moderate dashboard shortcode.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function moderate_comment_action() {

        // Bail if nonce is not verified
        if ( ! wp_verify_nonce( $_GET['moderate_nonce'], 'moderate_comment' ) ) {
            return false;
        }

        // Get comment.
        $comment = get_comment( absint( $_GET['c'] ) );
        if ( ! $comment ) {
            return false;
        }

        // Get active actions.
        $actions = mas_wpjmcr_dashboard_actions( true );
        if ( ! array_key_exists( $_GET['action'], $actions ) ) {
            return false;
        }

        // Get listing.
        $post = get_post( $comment->comment_post_ID );

        // Bail if user is not the listing author.
        if ( get_current_user_id() != $post->post_author ) {
            return false;
        }

        // Hook.
        do_action( 'mas_wpjmcr_process_dashboard_comment_action', $_GET['action'], $comment, $post );

        // Report to admin.
        if ( 'report' === $_GET['action'] ) {
            $current_user = wp_get_current_user();

            // Notification to admin.
            $args = array(
                'to'       => get_bloginfo( 'admin_email' ),
                'reply_to' => $current_user->user_email,
                'message'  => sprintf( esc_html__( '%1$s requested a review moderation for Review #%2$s for %3$s', 'mas-wp-job-manager-company-reviews' ), "{$current_user->display_name} ({$current_user->user_email})", $comment->comment_ID, $post->post_title ) . '<br/><br/>' . get_edit_comment_link( $comment ),
            );
            $sent = mas_wpjmcr_send_mail( $args );

            // Notification to user.
            if ( $sent ) {
                $args = array(
                    'to'       => $current_user->user_email,
                    'reply_to' => get_bloginfo( 'admin_email' ),
                    'message'  => sprintf( esc_html__( 'Your review moderation request for %1$s was sent successfully.', 'mas-wp-job-manager-company-reviews' ), "{$post->post_title} (Review #{$comment->comment_ID})" ),
                );
                mas_wpjmcr_send_mail( $args );

                // Notice.
                mas_wpjmcr_set_dashboard_notices( sprintf( esc_html__( 'Review #%1$d for %2$s reported to site admin.', 'mas-wp-job-manager-company-reviews' ), $comment->comment_ID, $post->post_title ) );
            }

        } else { // Other Actions.

            // Action.
            $comment_approved = 0;
            if ( 'approve' === $_GET['action'] ) {
                $comment_approved = 1;
            } elseif ( 'unapprove' === $_GET['action'] ) {
                $comment_approved = 0;
            } elseif ( 'spam' === $_GET['action'] ) {
                $comment_approved = 'spam';
            } elseif ( 'trash' === $_GET['action'] ) {
                $comment_approved = 'trash';
            }

            // Update comments.
            $comment_args = array(
                'comment_ID'       => $comment->comment_ID,
                'comment_approved' => $comment_approved,
            );
            $updated = wp_update_comment( $comment_args );

            // Add updated notice.
            if ( $updated ) {
                mas_wpjmcr_set_dashboard_notices( sprintf( esc_html__( 'Review #%1$d for %2$s updated.', 'mas-wp-job-manager-company-reviews' ), $comment->comment_ID, $post->post_title ) );
            }

        }

        // Redirect user back.
        wp_safe_redirect( esc_url( remove_query_arg( array( 'action', 'c', 'moderate_nonce' ) ) ) );
        exit;
    }

}
