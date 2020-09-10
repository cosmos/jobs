<?php
/**
 * Template used to display post content on single post classic.
 *
 * @package front
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'article article__single article__single--classic'); ?>>

    <?php do_action( 'front_single_post_classic_top' );
    /**
    * Functions hooked into front_single_post_classic action
    */
    do_action( 'front_single_post_classic' );
    /**
    * Functions hooked in to front_single_post_classic_bottom action
    */
    do_action( 'front_single_post_classic_bottom' );?>
    
</article>