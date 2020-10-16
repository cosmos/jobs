<?php
/**
 * The template used for displaying projects on index view
 *
 * @package front
 */
?>
<div id="portfolio-<?php the_ID(); ?>" <?php post_class( 'cbp-item' ); ?>>
    <a class="cbp-caption" href="<?php echo esc_url( get_permalink() ); ?>">
        <?php 
        /**
         * Functions hooked into front_loop_porfolio
         *
         */
        do_action( 'front_loop_portfolio' );
        ?>
    </a>
</div>