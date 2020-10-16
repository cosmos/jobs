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
?>
<div id="comments" class="<?php echo comments_open() ? 'comments-area' : 'comments-area comments-closed'; ?> container<?php echo esc_attr( ( ( wp_count_posts()->publish > 1 ) && apply_filters( 'front_single_related_posts_enabled', true ) ) ? " space-2 space-md-3" : "" ) ?>">
    <div class="w-lg-60 mx-auto">
        <header class="row justify-content-between align-items-center <?php echo esc_attr( $discussion->responses > 0 ? 'comments-title-wrap' : 'comments-title-wrap no-responses' ); ?>">
            <div class="col-12">
                <h2 class="comments-title h5 mb-4">
                <?php
                if ( comments_open() ) {
                    if ( have_comments() ) {
                        printf(
                            esc_html( _nx( '%1$s Comment', '%1$s Comments', get_comments_number(), 'comments title', 'front' ) ),
                            number_format_i18n( get_comments_number() ),
                            get_the_title()
                        );
                    } else {
                        esc_html_e( 'Post a comment', 'front' );
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
                </h2><!-- .comments-title -->
            </div>
        </header><!-- /.comments-title-wrap -->
        <?php
        if ( have_comments() ) :

            // Show comment form at top if showing newest comments at the top.
            if ( comments_open() ) {
                //front_comment_form( 'desc' );
            }

            ?>
            <div class="list-unstyled comment-list">
                <?php
                wp_list_comments(
                    array(
                        'walker'      => new Front_Walker_Comment(),
                        'avatar_size' => front_get_avatar_size(),
                        'short_ping'  => true,
                        'style'       => 'div',
                    )
                );
                ?>
            </div><!-- .comment-list -->
            <?php

            // Show comment navigation
            if ( have_comments() ) :
                $comments_text = esc_html__( 'Comments', 'front' );
                the_comments_navigation(
                    array(
                        'prev_text' => sprintf( '<span class="nav-prev-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span>', esc_html__( 'Previous', 'front' ), esc_html__( 'Comments', 'front' ) ),
                        'next_text' => sprintf( '<span class="nav-next-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span>', esc_html__( 'Next', 'front' ), esc_html__( 'Comments', 'front' ) ),
                    )
                );
            endif;

            // Show comment form at bottom if showing newest comments at the bottom.
            if ( comments_open() && 'asc' === strtolower( get_option( 'comment_order', 'asc' ) ) ) :
                ?>
                <div class="comment-form-flex d-flex flex-column border-top pt-6">
                    <span class="screen-reader-text"><?php esc_html_e( 'Leave a comment', 'front' ); ?></span>
                    <?php front_comment_form( 'asc' ); ?>
                    <h2 class="h5 mb-0 order-first d-none" aria-hidden="true"><?php esc_html_e( 'Post a comment', 'front' ); ?></h2>
                </div>
                <?php
            endif;

            // If comments are closed and there are comments, let's leave a little note, shall we?
            if ( ! comments_open() ) :
                ?>
                <p class="no-comments">
                    <?php esc_html_e( 'Comments are closed.', 'front' ); ?>
                </p>
                <?php
            endif;

        else :

            // Show comment form.
            front_comment_form( true );

        endif; // if have_comments();
        ?>
    </div>
</div>