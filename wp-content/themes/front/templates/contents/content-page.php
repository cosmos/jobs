<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Front
 */
$additional_class = '';
if ( function_exists( 'is_cart' ) ) {
    if ( is_cart() ) {
        $additional_class .= ' article__cart';
    } elseif ( is_checkout() ) {
        $additional_class .= ' article__checkout';
    }
}

$additional_class .= ' article__page';
?>

<div id="post-<?php the_ID(); ?>" <?php post_class( $additional_class ); ?>>
    <?php
    /**
     * Functions hooked in to front_page add_action
     *
     * @hooked front_page_header          - 10
     * @hooked front_page_content         - 20
     */
    do_action( 'front_page' );
    ?>
</div><!-- #post-## -->