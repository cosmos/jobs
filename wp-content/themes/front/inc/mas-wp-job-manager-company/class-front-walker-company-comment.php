<?php
/**
 * Custom company comment walker for this theme
 *
 * @package Front
 * @since 1.0.0
 */

/**
 * This class outputs custom comment walker for HTML5 friendly WordPress comment and threaded replies.
 *
 * @since 1.0.0
 */
class Front_WPJMCR_Walker_Comment extends Walker_Comment {

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

                <div class="comment-content mb-4">
                    <?php 
                        if( front_is_mas_wp_job_manager_company_review_activated() ) {
                            do_action( 'front_wpjmcr_walker_comment_before_title' );
                            $review_title = get_comment_meta( get_comment_ID(), 'mas-wpjmcr-title', true );
                            if( !empty( $review_title ) ) {
                                ?><h4 class="h6 text-body"><?php echo esc_html( $review_title ); ?></h4><?php
                            }
                        }
                        comment_text();
                        if( front_is_mas_wp_job_manager_company_review_activated() ) {
                            $gallery = get_comment_meta( get_comment_ID(), 'mas-wpjmcr-gallery', false );
                            if ( $gallery ) {
                                $count = count( $gallery );
                                ?>
                                <div class="row mx-gutters-2 mb-6">
                                    <?php
                                    $columns = 3;
                                    for( $i = 0; $i < $count; $i++ ) {
                                        if( $i <= $columns ) {
                                            ?>
                                            <div class="col-5 col-sm-3<?php echo esc_attr( $i!==0 && $i!==$columns ) ? ' d-none d-sm-inline-block' : '' ?>">
                                            <?php
                                        }
                                        ?><a class="js-fancybox u-media-viewer" href="javascript:;" data-src="<?php echo wp_get_attachment_image_url( $gallery[$i], 'full' ); ?>" data-fancybox="fancyboxGallery6" data-caption="<?php echo basename ( get_attached_file( $gallery[$i] ) ); ?>" data-speed="700" data-is-infinite="true"><?php
                                        echo wp_get_attachment_image( $gallery[$i], 'thumbnail', 'false', array( "class" => esc_attr( $i > $columns  ? 'js-fancybox d-none' : 'img-fluid rounded w-100' ) ) );
                                        if( $i <= $columns ) {
                                            if( $i < $columns || $count <= $columns + 1 ) {
                                                ?>
                                                <span class="u-media-viewer__container">
                                                    <span class="u-media-viewer__icon">
                                                        <span class="fas fa-plus u-media-viewer__icon-inner"></span>
                                                    </span>
                                                </span>
                                                <?php
                                            } elseif( $i === $columns ) {
                                                ?>
                                                <span class="u-media-viewer__container">
                                                    <span class="d-none d-sm-inline-block u-media-viewer__icon u-media-viewer__icon--active">
                                                        <span class="u-media-viewer__icon-inner font-weight-medium">+<?php echo esc_html( $count-1-$columns ) ?></span>
                                                    </span>
                                                    <span class="d-sm-none u-media-viewer__icon u-media-viewer__icon--active">
                                                        <span class="u-media-viewer__icon-inner font-weight-medium">+<?php echo esc_html( $count+1-$columns ) ?></span>
                                                    </span>
                                                </span>
                                                <?php
                                            }
                                        }
                                        ?></a><?php
                                        if( $i < $columns || $i === $count-1 ) {
                                            ?>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                        }
                    ?>
                </div><!-- .comment-content -->
                
                <div class="media">
                    <?php if ( 0 != $args['avatar_size'] ) : ?>
                        <div class="u-avatar mr-3">
                            <?php echo get_avatar( $comment, $args['avatar_size'], '', '', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
                        </div>
                    <?php endif; ?>
                    <div class="media-body">
                        <h4 class="d-inline-block mb-1 h6">
                            <?php if ( ! empty( $comment_author_url ) ) : ?>
                                <a class="d-block mb-0" href="#">
                            <?php endif; ?>
                                <?php echo get_comment_author( $comment ); ?>
                            <?php if ( ! empty( $comment_author_url ) ) : ?>
                                </a>
                            <?php endif; ?>
                        </h4>
                        <div class="small mb-3">
                            <?php if( front_is_mas_wp_job_manager_company_review_activated() ) : ?>
                                <?php
                                    // Get reviews: Array/list of ratings with slug and rating.
                                    $review_average = mas_wpjmcr_sanitize_number( get_comment_meta( get_comment_ID(), 'review_average', true ) );
                                    if ( $review_average ) {
                                        ?>
                                        <span class='text-warning mr-2'>
                                            <?php for ( $i = 0; $i < mas_wpjmcr_get_max_stars(); $i++ ) : ?>
                                                <span class="<?php echo esc_attr( $i < $review_average ? 'fas' : 'far' ); ?> fa-star"></span>
                                            <?php endfor; ?>
                                        </span>
                                        <span class="font-weight-semi-bold mr-2">
                                            <?php echo number_format( $review_average, 1, '.', ''); ?>
                                        </span>
                                        <?php
                                    }
                                ?>
                            <?php endif; ?>
                            <span class="text-muted mr-2">
                                <?php
                                    /* translators: 1: comment date, 2: comment time */
                                    $comment_timestamp = sprintf( __( '%1$s at %2$s', 'front' ), get_comment_date( '', $comment ), get_comment_time() );
                                ?>
                                <time datetime="<?php comment_time( 'c' ); ?>" title="<?php echo esc_attr( $comment_timestamp ); ?>">
                                    <?php echo wp_kses_post( $comment_timestamp ); ?>
                                </time>
                            </span>
                            <?php if ( '0' == $comment->comment_approved ) : ?>
                            <span class="d-block text-muted comment-awaiting-moderation mr-2"><?php esc_html_e( 'Your comment is awaiting moderation.', 'front' ); ?></span>
                            <?php endif; ?>
                            <?php
                                comment_reply_link(
                                    array_merge(
                                        $args,
                                        array(
                                            'add_below' => 'div-comment',
                                            'depth'     => $depth,
                                            'max_depth' => $args['max_depth'],
                                            'before'    => '<span class="comment-reply text-secondary"><span class="far fa-comments mr-1"></span>',
                                            'after'     => '</span>',
                                        )
                                    )
                                );
                            ?>
                        </div>
                    </div>
                </div>                
            </article><!-- .comment-body -->
        <?php
    }
}
