<?php
/**
 * The Loop for Home Blog Business
 *
 * @package front
 */

while ( have_posts() ) :

    the_post(); ?>

    <div class="cbp-item">
        <div class="cbp-caption">

            <?php get_template_part( 'templates/blog/home/business/content', get_post_format() ); ?>

        </div>
    </div><?php

endwhile;