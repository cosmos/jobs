<?php
/**
 * Single Post Simple template
 *
 * @package front
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'article article__single article__single--simple' ); ?>>

    <?php do_action( 'front_single_post_simple_top' );
    /**
    * Functions hooked into front_single_post_simple action
    */
    do_action( 'front_single_post_simple' );
    /**
    * Functions hooked in to front_single_post_simple_bottom action
    */
    do_action( 'front_single_post_simple_bottom' );?>
    
</article>