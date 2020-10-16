<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Front
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) {
    return;
}

$discussion = front_get_discussion_data();

$user_comment_order = front_wpjmr_user_comment_order();
?>
<div id="comments" class="<?php echo comments_open() ? 'comments-area' : 'comments-area comments-closed'; ?>">
    <div class="review-heaader d-sm-flex justify-content-sm-between align-items-sm-center border-bottom pb-5 mb-5">
        <div class="d-flex align-items-center mb-2 mb-sm-0">
            <h4 class="comments-title h5 mb-0">
                <?php
                if ( comments_open() ) {
                    if ( have_comments() ) {
                        echo sprintf( _n( 'Review', 'Reviews', intval( $discussion->responses ), 'front' ), intval( $discussion->responses ) );
                    } else {
                        esc_html_e( 'Be a First Reviewer', 'front' );
                    }
                } else {
                    if ( '1' == $discussion->responses ) {
                        /* translators: %s: post title */
                        printf( _x( 'One reply on &ldquo;%s&rdquo;', 'comments title', 'front' ), get_the_title() );
                    } else {
                        printf(
                            /* translators: 1: number of comments, 2: post title */
                            _nx(
                                '%1$s reply on &ldquo;%2$s&rdquo;',
                                '%1$s replies on &ldquo;%2$s&rdquo;',
                                $discussion->responses,
                                'comments title',
                                'front'
                            ),
                            number_format_i18n( $discussion->responses ),
                            get_the_title()
                        );
                    }
                }
                ?>
            </h4><!-- .comments-title -->
            <?php if( front_is_mas_wp_job_manager_company_review_activated() && ( $review_average = mas_wpjmcr_get_reviews_average() ) ) : ?>
                <div class="reviews-average text-warning ml-3">
                    <small class="fas fa-star"></small>
                    <span class="font-weight-semi-bold align-middle">
                        <?php echo esc_html( $review_average ); ?>
                    </span>
                    <span class="text-muted align-middle">
                        (<?php echo sprintf( _n( '%s review', '%s reviews', intval( mas_wpjmcr_get_reviews_count() ), 'front' ), intval( mas_wpjmcr_get_reviews_count() ) ); ?>)
                    </span>
                </div><!-- .reviews-average -->
            <?php endif; ?>
        </div>
        <form method="POST">
            <select name="uco" class="js-select selectpicker dropdown-select" onchange="this.form.submit();" data-width="fit" data-style="btn-soft-secondary btn-xs">
                <option value="desc" <?php selected( "desc", $user_comment_order ); ?>><?php esc_html_e( 'Newest First', 'front' ); ?></option>
                <option value="asc" <?php selected( "asc", $user_comment_order ); ?>><?php esc_html_e( 'Oldest First', 'front' ); ?></option>
            </select>
        </form>
    </div><!-- /.comments-title-wrap -->
    <?php if( front_is_mas_wp_job_manager_company_review_activated() && ( $stars = mas_wpjmcr_get_catetgory_average_reviews_db() ) ) : ?>
        <div class="border-bottom pb-5">
            <div class="row">
                <?php
                    $i = 1;
                    foreach ( $stars as $label => $star) {
                        ?>
                        <div class="col-sm-4<?php echo esc_attr( $i !== count( $stars ) ? ' mb-3 mb-sm-0' : '' ) ?>">
                            <div class="text-warning">
                                <small class="fas fa-star"></small>
                                <span class="font-weight-semi-bold align-middle">
                                    <?php echo number_format( $star, 1, '.', ''); ?>
                                </span>
                            </div>
                            <h5 class="small text-secondary mb-0"><?php echo esc_html( $label ); ?></h5>
                        </div>
                        <?php
                        $i++;
                    }
                ?>
            </div>
        </div>
    <?php endif; ?>
    <?php
    if ( have_comments() ) :
        ?>
        <div class="list-unstyled comment-list">
            <?php
            wp_list_comments(
                array(
                    'walker'      => new Front_WPJMCR_Walker_Comment(),
                    'avatar_size' => front_get_avatar_size(),
                    'short_ping'  => true,
                    'style'       => 'div',
                )
            );
            ?>
        </div><!-- .comment-list -->
        <?php

        // Show comment navigation
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
            $comments_text = esc_html__( 'Comments', 'front' );
            the_comments_navigation(
                array(
                    'prev_text' => sprintf( '<span class="nav-prev-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span>', esc_html__( 'Previous', 'front' ), esc_html__( 'Comments', 'front' ) ),
                    'next_text' => sprintf( '<span class="nav-next-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span>', esc_html__( 'Next', 'front' ), esc_html__( 'Comments', 'front' ) ),
                )
            );
        endif;
    endif;

    if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?><p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'front' ); ?></p><?php
    endif;

    $comment_form_args = apply_filters( 'front_wpjmrc_comment_form_args', array(
        'title_reply'          => esc_html__( 'Leave a review', 'front' ),
        'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'front' ),
        'title_reply_before'   => '<h4 class="comment-reply-title h5 mb-3 d-flex align-items-center">',
        'title_reply_after'    => '</h4>',
        'cancel_reply_before'  => '<small class="small ml-auto text-secondary">',
        'cancel_reply_after'   => '</small>',
        'comment_notes_before' => '',
        'comment_notes_after'  => '',
        'fields'               => array(
            'author' => '<div class="comment-form-author js-form-message mb-6">' . '<label class="form-label" for="author">' . esc_html__( 'Name', 'front' ) . ' <span class="required">*</span></label> ' .
                        '<input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></div>',
            'email'  => '<div class="comment-form-email js-form-message mb-6"><label class="form-label" for="email">' . esc_html__( 'Email', 'front' ) . ' <span class="required">*</span></label> ' .
                        '<input id="email" class="form-control" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></div>',
            'url'    => '<div class="comment-form-url js-form-message mb-6"><label class="form-label" for="url">' . esc_html__( 'Website', 'front' ) . ' <span class="required">*</span></label> ' .
                        '<input id="url" class="form-control" name="url" type="url" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" size="30" aria-required="true" /></div>',
        ),
        'label_submit'  => esc_html__( 'Submit Review', 'front' ),
        'logged_in_as'  => '',
        'comment_field' => '<div class="comment-form-comment js-form-message mb-6"><label class="form-label" for="comment">' . esc_html__( 'Your Review', 'front' ) . '</label><textarea id="comment" class="form-control" name="comment" rows="8" aria-required="true"></textarea></div>'
    ) );

    // Show comment form.
    comment_form( $comment_form_args );
    ?>
</div>