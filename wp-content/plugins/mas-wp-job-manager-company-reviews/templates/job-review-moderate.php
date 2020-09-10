<?php
/**
 * Shortcode Review Moderation Dashboard [review_dashboard].
 * 
 * @since 1.0.0
 * @version 1.0.0
 * 
 * @vars object $reviews       WP_Comment object.
 * @vars int    $max_num_pages Max num pages.
 */
?>

<div id="job-manager-review-moderate-board">

    <p><?php _e( 'Moderate your reviews below.', 'mas-wp-job-manager-company-reviews' ); ?></p>

    <?php mas_wpjmcr_print_dashboard_notices(); // Display notices. ?>

    <table class="job-manager-reviews">

        <thead>
            <tr>
                <th class="" style="width: 50%;"><?php _e( 'Review', 'mas-wp-job-manager-company-reviews' ); ?></th>
                <th class="" style="width: 15%;"><?php _e( 'Author', 'mas-wp-job-manager-company-reviews' ); ?></th>
                <th class="" style="width: 20%;"><?php _e( 'Ratings', 'mas-wp-job-manager-company-reviews' ); ?></th>
                <th class="" style="width: 25%;"><?php _e( 'Actions', 'mas-wp-job-manager-company-reviews' ); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php if ( ! $reviews ) : ?>
                <tr>
                    <td colspan="6"><?php _e( 'There are currently no reviews found for any of your listings.', 'mas-wp-job-manager-company-reviews' ); ?></td>
                </tr>
            <?php else : ?>
                <?php foreach ( $reviews as $review ) : ?>

                    <?php
                    // Vars:
                    $actions = mas_wpjmcr_dashboard_actions( true ); // Get active actions.
                    $title = ! empty( $review->post_title ) ? $review->post_title : esc_html__( '(no title)', 'mas-wp-job-manager-company-reviews' );
                    $content = get_comment_text( $review->comment_ID );

                    // Get status and unset unneeded actions.
                    $status = '';
                    if ( '0' == $review->comment_approved ) {
                        $status = esc_html__( 'Unapproved', 'mas-wp-job-manager-company-reviews' );
                        unset( $actions['unapprove'] );
                    } elseif ( '1' == $review->comment_approved ) {
                        $status = esc_html__( 'Approved', 'mas-wp-job-manager-company-reviews' );
                        unset( $actions['approve'] );
                    } elseif ( 'spam' == $review->comment_approved ) {
                        $status = esc_html__( 'Spam', 'mas-wp-job-manager-company-reviews' );
                        unset( $actions[ $approve ] );
                        unset( $actions['spam'] );
                    } elseif ( 'trash' == $review->comment_approved ) {
                        $status = esc_html__( 'Deleted', 'mas-wp-job-manager-company-reviews' );
                        unset( $actions['trash'] );
                    }
                    ?>

                    <tr class="wp-job-manger-reviews-status-<?php echo $review->comment_approved; ?>">

                        <td>
                            <div class="review-content">
                                <?php echo wp_kses_post( $content ); ?>
                            </div><!-- .review-content -->

                            <div class='review-content-listing'>
                                <strong><?php echo sprintf( esc_html__( 'On listing %s', 'mas-wp-job-manager-company-reviews' ), '<a href="' . get_permalink( $review->comment_post_ID ) . '">' . $title . '</a>' ); ?></strong>
                            </div><!-- .review-content-listing -->
                        </td>

                        <td>
                            <?php echo $review->comment_author; ?>
                        </td>

                        <td>
                            <div class="mas-wpjmcr-list-reviews">
                                <?php echo mas_wpjmcr_review_get_stars( $review->comment_ID ); ?>
                            </div><!-- .mas-wpjmcr-list-reviews -->
                        </td>

                        <td>
                            <div class="review-action-status">
                                <strong><?php echo $status; ?></strong>
                            </div><!-- .review-action-status -->

                            <div class="job-dashboard-actions">

                                <?php foreach( $actions as $action => $label ) : ?>
                                    <div>

                                        <a class="review-action review-action-<?php echo esc_attr( $action ); ?>" href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'c' => $review->comment_ID, 'action' => $action ) ), 'moderate_comment', 'moderate_nonce' ) ); ?>">
                                            <?php echo mas_wpjmcr_get_svg( $action ); ?>&nbsp;<?php echo esc_html( $label ); ?>
                                        </a><!-- .review-action -->

                                    </div>
                                <?php endforeach; ?>

                            </div><!-- .job-dashboard-actions -->

                        </td>
                    </tr>
                <?php endforeach; // End $reviews as $review. ?>

            <?php endif; // End $reviews exists. ?>
        </tbody>

    </table><!-- .job-manager-reviews -->

    <?php get_job_manager_template( 'pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>

</div><!-- .job-manager-review-moderate-board -->