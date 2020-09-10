<?php
/**
 * Template used to display post content in Blog List
 *
 * @package front
 */

$article_class = 'article card border-0 shadow-sm mb-3';

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $article_class ); ?>>
    
    <?php do_action( 'front_blog_grid_loop_post_before' ); ?>

    <div class="card-body p-5">
        <?php 
            front_posted_on( '<small class="article__date d-block text-muted mb-2">', '</small>', 'text-muted' );
            the_title( sprintf( '<h2 class="article__title h5"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), front_sticky_indicator() . '</a></h2>' );
            the_excerpt();
        ?>
    </div>

    <div class="card-footer pb-5 px-0 mx-5">
        <div class="media align-items-center">
            <div class="u-sm-avatar mr-3">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 100, '', '', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
            </div>
            <div class="media-body">
                <?php 
                    printf(
                        '<h4 class="article__author small mb-0"><a href="%1$s" class="text-dark font-weight-semi-bold" rel="author">%2$s</a></h4>',
                        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                        esc_html( get_the_author() )
                    );
                ?>
            </div>
        </div>
    </div>

    <?php do_action( 'front_blog_grid_loop_post_after' ); ?>
    
</article><!-- #post-## -->