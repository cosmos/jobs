<?php
/**
 * Submit New Review.
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
 * Submit New Review.
 * Handles review submission and saving data.
 *
 * @since 1.0.0
 */
class MAS_WPJMCR_Submit {

    /**
     * Constructor Class.
     *
     * @since 1.0.0
     */
    public function __construct() {

        // Before saving comment to database.
        add_filter( 'pre_comment_approved', array( $this, 'pre_save_review' ), 10, 2 );

        // Allow blank comment content (set in settings).
        add_action( 'init', array( $this, 'allow_blank_comment' ) );

        // Save review as comment meta.
        add_action( 'comment_post', array( $this, 'save_comment_review' ), 10, 3 );
    }


    /**
     * Initial check of invalid review before saving to database.
     *
     * We use "pre_comment_approved" filter because it's the last hook,
     * before saving the comment to database.
     *
     * @since 1.0.0
     * @link https://developer.wordpress.org/reference/hooks/pre_comment_approved/
     *
     * @param bool|string $approved    Comment auto approved.
     * @param array       $commentdata Comment data.
     * @return bool|string
     */
    public function pre_save_review( $approved, $commentdata ) {
        $post = get_post( $commentdata['comment_post_ID'] );

        // Check post type.
        if ( 'company' !== $post->post_type ) {
            return $approved;
        }

        // Only top level comments is review.
        if ( 0 !== intval( $commentdata['comment_parent'] ) ) {
            return $approved;
        }

        // Post author cannot submit review.
        if ( ! get_option( 'mas_wpjmcr_allow_owner', '0' ) && absint( $post->post_author ) === absint( get_current_user_id() ) ) {
            return $approved;
        }

        // Get categories.
        $review_categories = mas_wpjmcr_get_categories();

        // Loop category, bail if a category not set. Each comment require user to fill all rating categories.
        foreach ( $review_categories as $category_slug => $review_category ) {
            if ( ! isset( $_POST[ 'star-rating-' . $category_slug ] ) || empty( $_POST[ 'star-rating-' . $category_slug ] ) ) {
                wp_die( esc_html__( '<strong>ERROR:</strong> Please select a rating for all categories.', 'mas-wp-job-manager-company-reviews' ) );
                $approved = false; // No really needed.
            }
        }

        // Return.
        return $approved;
    }

    /**
     * Allow blank comment content by adding default text.
     * 
     * @since 1.0.0
     */
    public function allow_blank_comment(){
        if ( get_option( 'mas_wpjmcr_allow_blank_comment' ) && isset( $_POST['star-rating-0'] ) && isset( $_POST['comment'] ) && empty( $_POST['comment'] ) ) {
            $_POST['comment'] = '<!-- no content -->';
        }
    }

    /**
     * Save the ratings as comment meta in the database.
     *
     * @since 1.0.0
     * @link https://developer.wordpress.org/reference/hooks/comment_post/
     *
     * @param int        $comment_id       ID of the current comment.
     * @param int|string $comment_approved Value is 1 if comment approved.
     * @param array      $commentdata      Comment data.
     * @return void
     */
    public function save_comment_review( $comment_id, $comment_approved, $commentdata ) {
        $post = get_post( $commentdata['comment_post_ID'] ); // Get post data.

        // Check post type.
        if ( 'company' !== $post->post_type ) {
            return;
        }
        // Bail if not top level comment.
        if ( 0 !== intval( $commentdata['comment_parent'] ) ) {
            return;
        }

        $title = isset( $_POST['mas-wpjmcr-title'] ) ? sanitize_text_field( $_POST['mas-wpjmcr-title'] ) : '';
        // Save submitted title.
        update_comment_meta( $comment_id, 'mas-wpjmcr-title', $title );

        // Upload Gallery.
        mas_wpjmcr_handle_uploads( $post->ID, $comment_id );

        // Vars.
        $categories = mas_wpjmcr_get_categories();
        $stars = array();
        $review_total = 0;

        // Loop each categories.
        foreach ( $categories as $index => $category ) {
            if ( isset ( $_POST['star-rating-' . $index ] ) ) {

                // Single cat review value.
                $value = sanitize_text_field( $_POST['star-rating-' . $index ] );

                // Stars.
                $stars[ $category ] = $value;

                // Add in total average.
                $review_total += $value;

            } else {
                return; // Bail if no review submitted.
            }
        }

        // Save submitted ratings.
        update_comment_meta( $comment_id, 'review_stars', $stars );

        // Save review average:
        $review_average = $review_total / count( $stars );
        update_comment_meta( $comment_id, 'review_average', $review_average );

        // Action hook.
        do_action( 'mas_wpjmcr_review_updated', $comment_id, $comment_approved );
    }

}
