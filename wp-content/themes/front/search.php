<?php
/**
 * The template for displaying search results pages.
 *
 * @package front
 */

$post_type = get_post_type();

if ( $post_type == 'docs' && locate_template( 'archive-docs.php' ) ) {
    get_template_part( 'archive', 'docs' );
} else {
    get_template_part( 'index' );
}