<?php
/**
 * The Loop for Home Blog Agency
 *
 * @package front
 */
$counter = 0;
$index   = 0;

while ( have_posts() ) :

    the_post(); ?>

    <div class="cbp-item">
        <div class="cbp-caption"><?php

            if ( $counter === 0 || is_sticky() ) :

                get_template_part( 'templates/blog/home/agency/content', 'sticky' );

            elseif ( ! has_post_thumbnail() ) :

                $post_format = get_post_format();
                $slug = empty( $post_format ) ? 'standard' : $post_format;

                get_template_part( 'templates/blog/home/agency/content', $slug );

            else:

                $img_index_arr = array( 2, 2, 3, 2, 2, 2, 2 );
                $img_index = $index % 7;
                $index++;
                $img_sz_name = front_get_image_size( 'blog_agency_thumbnail_' . $img_index_arr[ $img_index ] , 'full' );
                front_get_template( 'templates/blog/home/agency/content.php', array( 'img_sz_name' => $img_sz_name ) );

            endif;

            $counter++;

        ?></div>
    </div><?php

endwhile;
