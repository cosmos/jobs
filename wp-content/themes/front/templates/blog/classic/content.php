<?php
/**
 * Template used to display post content in Blog List
 *
 * @package front
 */

$article_class = 'article card border-0';

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $article_class ); ?>>

    <?php do_action( 'front_blog_classic_loop_post_before' ); ?>

    <div class="card-body p-0">

        <?php if ( has_post_thumbnail() ) : ?>
        <div class="mb-5 article__thumbnail-wrapper">
            <?php
                /**
                 * Image Size: 500x280-crop
                 */
                $img_sz_name = front_get_image_size( 'blog_classic_thumbnail', 'post-thumbnail' );
                the_post_thumbnail( $img_sz_name, array( 'class' => 'img-fluid w-100 rounded article__thumbnail' ) ); ?>
        </div>
        <?php endif; ?>

        <?php
            front_posted_on( '<small class="article__date d-block text-secondary mb-1">', '</small>', 'text-secondary' );
            the_title( sprintf( '<h2 class="article__title h5"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), front_sticky_indicator() . '</a></h2>' );
            the_excerpt();
        ?>
    </div>

    <?php do_action( 'front_blog_classic_loop_post_after' ); ?>

</article><!-- #post-## -->
