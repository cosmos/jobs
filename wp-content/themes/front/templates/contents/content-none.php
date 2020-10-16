<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package front
 */
?>

<div class="article__page no-results not-found">
    <div class="container space-top-md-5 space-top-lg-4 page__header">
        <header class="mb-9">
            <h1 class="font-weight-normal page-title"><?php esc_html_e( 'Nothing Found', 'front' ); ?></h1>
        </header>
    </div>

    <div class="article__content article__content--page container">
        <div class="space-bottom-2">
            <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

                <p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'front' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

            <?php elseif ( is_search() ) : ?>

                <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'front' ); ?></p>
                <?php get_search_form(); ?>

            <?php else : ?>

                <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'front' ); ?></p>
                <?php get_search_form(); ?>

            <?php endif; ?>
        </div>
    </div><!-- .entry-content -->
</div><!-- .no-results -->