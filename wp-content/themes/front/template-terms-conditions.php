<?php
/**
 * Template name: Terms & Conditions
 *
 * @package front
 */

 get_header(); ?>

    <div class="container space-2 space-top-md-4 space-bottom-md-3">
        <div class="row">
            <div id="stickyBlockStartPoint" class="secondary col-md-4 col-lg-3 mb-7 mb-md-0" style="">
                <nav id="table-of-contents" class="js-sticky-block card shadow-sm p-4" data-parent="#stickyBlockStartPoint" data-sticky-view="md" data-start-point="#stickyBlockStartPoint" data-end-point="#stickyBlockEndPoint" data-offset-top="50" data-offset-bottom="24" style=""></nav>
            </div>
            <div class="primary col-md-8 col-lg-9">
                <?php while ( have_posts() ) : the_post();

                    do_action( 'front_terms_before' );

                    get_template_part( 'templates/contents/content', 'page' );

                    do_action( 'front_terms_after' );
                endwhile; // End of the loop. ?>   
            </div>
        </div>
    </div>
    <div id="stickyBlockEndPoint"></div>
<?php get_footer();