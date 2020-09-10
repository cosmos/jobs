<?php
/**
 * The Loop for Home Blog Startup
 *
 */
global $wp_query;

$total   = $wp_query->post_count;
$counter = 0;

while ( have_posts() ) :

    the_post();

    get_template_part( 'templates/blog/home/startup/content' );

    if ( $counter < ( $total - 1 ) ) :

    ?><div class="space-2 px-4">
        <hr class="my-0">
    </div><?php

    else : 

        ?><div class="space-bottom-2"></div><?php

    endif;

    $counter++;

endwhile;