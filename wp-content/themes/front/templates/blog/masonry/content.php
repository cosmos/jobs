<?php
/**
 * Template used to display post content in Blog List
 *
 * @package front
 */

$article_class       = 'article card border-0 mb-3';
$article_title_class = 'article__title h6 mb-0';
$article_date_class  = 'article__date d-block mb-1';
$article_link_class  = '';

if ( ! has_post_thumbnail() ) {
    $article_class       .= ' bg-primary text-white';
    $article_title_class .= ' text-white';
    $article_link_class  .= 'text-white';
} else {
    $article_date_class  .= ' text-secondary';
    $article_link_class  .= 'text-secondary';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $article_class ); ?>>

    <?php do_action( 'front_blog_masonry_loop_post_before' ); ?>

    <?php the_post_thumbnail( $img_sz_name, array( 'class' => 'img-fluid w-100 rounded' ) ); ?>

    <div class="card-body p-5">
    <?php
        front_posted_on( '<small class="' . esc_attr( $article_date_class ) . '">', '</small>', $article_link_class );
        the_title( sprintf( '<h2 class="' . esc_attr( $article_title_class ) . '"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), front_sticky_indicator( 'light' ) . '</a></h2>' );
    ?>
    </div>

    <?php do_action( 'front_blog_masonry_loop_post_after' ); ?>

</article><!-- #post-## -->
