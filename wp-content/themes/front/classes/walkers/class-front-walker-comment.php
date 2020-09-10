<?php
/**
 * Custom comment walker for this theme
 *
 * @package Front
 * @since 1.0.0
 */

/**
 * This class outputs custom comment walker for HTML5 friendly WordPress comment and threaded replies.
 *
 * @since 1.0.0
 */
class Front_Walker_Comment extends Walker_Comment {

    /**
     * Outputs a comment in the HTML5 format.
     *
     * @see wp_list_comments()
     *
     * @param WP_Comment $comment Comment to display.
     * @param int        $depth   Depth of the current comment.
     * @param array      $args    An array of arguments.
     */
    protected function html5_comment( $comment, $depth, $args ) {
        ?>
        <<?php echo ( 'div' === $args['style'] ) ? 'div' : 'li'; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <?php 
                $comment_author_link = get_comment_author_link( $comment );
                $comment_author_url  = get_comment_author_url( $comment ); ?>
                
                <div class="media mb-2 d-flex align-items-center">
                    <?php if ( 0 != $args['avatar_size'] ) : ?>
                    <div class="u-avatar mr-3">
                        <?php echo get_avatar( $comment, $args['avatar_size'], '', '', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
                    </div>
                    <?php endif; ?>
                    <div class="media-body d-flex justify-content-between flex-wrap">
                        <h4 class="d-inline-block mb-1 h6">
                            <?php if ( ! empty( $comment_author_url ) ) : ?>
                            <a class="d-block mb-0" href="#">
                            <?php endif; ?>
                            <?php echo get_comment_author( $comment ); ?>
                            <?php if ( ! empty( $comment_author_url ) ) : ?>
                            </a>
                            <?php endif; ?>
                        </h4>
                        <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>" class="d-block text-muted">
                            <small>
                                <?php
                                    /* translators: 1: comment date, 2: comment time */
                                    $comment_timestamp = sprintf( __( '%1$s at %2$s', 'front' ), get_comment_date( '', $comment ), get_comment_time() );
                                ?>
                                <time datetime="<?php comment_time( 'c' ); ?>" title="<?php echo esc_attr( $comment_timestamp ); ?>">
                                    <?php echo wp_kses_post( $comment_timestamp ); ?>
                                </time>
                            </small>
                        </a>
                        <?php if ( '0' == $comment->comment_approved ) : ?>
                        <small class="d-block text-muted comment-awaiting-moderation w-100"><?php esc_html_e( 'Your comment is awaiting moderation.', 'front' ); ?></small>
                        <?php endif; ?>
                    </div>
                </div>    

                <div class="comment-content">
                    <?php comment_text(); ?>
                </div><!-- .comment-content -->
            </article><!-- .comment-body -->
            <ul class="list-inline d-flex mb-2">
                <li class="list-inline-item">
                    <?php
                    comment_reply_link(
                        array_merge(
                            $args,
                            array(
                                'add_below' => 'div-comment',
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth'],
                                'before'    => '<div class="comment-reply text-secondary"><span class="far fa-comments mr-1"></span>',
                                'after'     => '</div>',
                            )
                        )
                    );
                    ?>
                </li>
            </ul>
        <?php
    }
}
