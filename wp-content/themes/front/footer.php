<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package front
 */
?>
    </main><!-- #content -->

    <?php do_action( 'front_before_footer' ); ?>

    <?php do_action( 'front_footer' ); ?>

    <?php do_action( 'front_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>