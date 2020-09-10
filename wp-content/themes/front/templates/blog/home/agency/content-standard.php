<?php
/**
 * Template for displaying Content Standard in Blog Agency
 *
 * @package front
 */
$dark_bg = array( 'bg-dark', 'bg-primary', 'bg-danger' );
shuffle( $dark_bg );
?>
<article class="card border-0<?php echo esc_attr( ' ' . $dark_bg[0] ); ?>">
    <div class="card-body p-5">
        <!-- Post Info -->
        <ul class="list-inline small text-white-70 mb-1">
            <li class="list-inline-item mr-0"><?php 
                printf(
                    '<a href="%1$s" class="text-white-70" rel="author">%2$s</a>',
                    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                    esc_html( get_the_author() )
                ); 
            ?></li>
            <li class="list-inline-item mx-2">&#8211;</li>
            <li class="list-inline-item"><?php front_posted_on( '', '', 'text-white-70', true, true ); ?></li>
        </ul>
        <!-- End Post Info -->

        <!-- Info -->
        <div class="mb-4">
            <?php the_title( sprintf( '<h3 class="h5 text-white mb-0"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
        </div>
        <!-- End Info -->

        <!-- Labels -->
        <?php front_blog_agency_tag_list(); ?>
        <!-- End Labels -->
    </div>
</article>