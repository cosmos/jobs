<?php
/**
 * Template used to display post content in Blog List
 *
 * @package front
 */

$article_class = 'article d-block card border-0 mb-7';

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $article_class ); ?>>
    <div class="card-body p-0">
        <div class="row">
    
            <?php
            /**
             * Functions hooked in to front_loop_post action.
             *
             * @hooked front_post_header          - 10
             * @hooked front_post_content         - 30
             */
            do_action( 'front_blog_list_loop_post' );
            ?>
    
        </div>
    </div>
</article><!-- #post-## -->