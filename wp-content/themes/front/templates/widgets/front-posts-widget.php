<?php
/**
 * Front Posts Widget Template
 *
 */
global $post;

if ( $fpw_query->have_posts() ) :

    while ( $fpw_query->have_posts () ) : $fpw_query->the_post (); ?>

    <article class="card border-0 mb-5">
        <div class="card-body p-0">
            <div class="media">
                <div class="u-avatar mr-3">
                    <a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_post_thumbnail(); ?><span class="icn-more"></span></a>
                </div>
                <div class="media-body">
                    <h4 class="h6 font-weight-normal mb-0">
                      <a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
                    </h4>
                </div>
            </div>
        </div>
    </article>

<?php endwhile;

else : ?>

<article class="fpw-not-found">
    <?php esc_html_e( 'No posts found.', 'front' ); ?>
</article><?php 

endif;