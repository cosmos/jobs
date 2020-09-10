<?php
/**
 * Template used to display post in Blog Startup Home
 *
 * @package front
 */
?>
<article>
    
    <?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid rounded' ) ); ?>
    
    <div class="px-4">
        <ul class="list-inline d-flex align-items-center py-3">
            <li class="article__author list-inline-item d-flex align-items-center pr-2">
                <div class="u-sm-avatar mr-2">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 100, '', '', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
                </div>
                <?php 
                    printf(
                        '<a href="%1$s" class="text-secondary font-size-1" rel="author">%2$s</a>',
                        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                        esc_html( get_the_author() )
                    );
                ?>
            </li>
            <li class="article__comments list-inline-item ml-auto">
                <?php 
                $comment_icon  = '<span class="far fa-comment mr-2"></span>';
                $comments_icon = '<span class="far fa-comments mr-2"></span>';
                $post_title    = get_the_title();
                $zero = wp_kses_post( sprintf( __( '%s Leave a comment<span class="screen-reader-text"> on %s</span>', 'front' ), $comment_icon, $post_title ) );
                $one  = wp_kses_post( sprintf( __( '%s 1 comment<span class="screen-reader-text"> on %s</span>', 'front' ), $comment_icon, $post_title ) );
                comments_popup_link( $zero, $one, false, 'd-flex align-items-center small text-secondary' ); ?>
            </li>
        </ul>

        <!-- Info -->
        <?php 
            front_posted_on( '<small class="article__date d-block text-muted mb-1">', '</small>', 'text-secondary', true, true ); 
            the_title( sprintf( '<h2 class="article__title h4"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
            echo wp_kses_post( '<p class="article__excerpt mb-0">' . get_the_excerpt() . '</p>' );
        ?>
        <!-- End Info -->
    </div><!-- /.px-4 -->

</article>