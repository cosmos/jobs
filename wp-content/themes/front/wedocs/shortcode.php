<?php if ( $docs ) :
    foreach ($docs as $key => $main_doc) : ?>

        <?php 
        $total_sections = 0;
        $author_ids     = array();
        $more_than_6    = 0;
        $author_names   = array();
        if ( $main_doc['sections'] ) :
            foreach ( $main_doc['sections'] as $section ) :
                $total_sections++;

                if ( array_key_exists( $section->post_author, $author_ids ) ) {
                    continue;
                }

                $author_name = get_the_author_meta( 'display_name', $section->post_author );
                $author_names[ $section->post_author ] = $author_name;
                
                $author_ids[ $section->post_author ] = array(
                    'id'           => $section->post_author,
                    'display_name' => $author_name,
                    'gravatar'     => get_avatar_url( $section->post_author )
                );
            endforeach;
        endif; ?>

        <a class="card card-frame mb-3" href="<?php echo get_permalink( $main_doc['doc']->ID ); ?>">
            <div class="card-body p-4">
                <!-- Icon Block -->
                <div class="media">
                    
                    <?php front_wedocs_entry_thumbnail( $main_doc['doc'] ); ?>
                    
                    <div class="media-body">
                        <h2 class="h5"><?php echo wp_kses_post( $main_doc['doc']->post_title ); ?></h2>
                        <p class="font-size-1"><?php echo wp_kses_post( $main_doc['doc']->post_excerpt ); ?></p>

                        <div class="media">
                            <?php if ( count( $author_ids ) ) : ?>
                            <!-- Contributors List -->
                            <ul class="list-inline mr-2 mb-0">
                                <?php $i = 0; foreach ( $author_ids as $author ) : ?>
                                <li class="list-inline-item mr-0<?php if ( $i++ > 0 ) : ?> ml-n3<?php endif; ?>">
                                    <div class="u-sm-avatar u-sm-avatar--bordered rounded-circle">
                                        <img class="img-fluid rounded-circle" src="<?php echo esc_url( $author['gravatar']); ?>" alt="<?php echo esc_attr( $author['display_name'] ); ?>">
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <!-- End Contributors List -->
                            <?php endif; ?>

                            <div class="media-body">

                                <!-- Article Authors -->
                                <?php if ( $total_sections ) : ?>
                                <small class="d-block text-dark"><?php printf( _n( '%s section in this topic', '%s sections in this topic', $total_sections, 'front' ), number_format_i18n( $total_sections ) ); ?></small>
                                <?php endif; ?>
                                <?php if ( $author_names ) : ?>
                                <small class="d-block text-dark">
                                    <?php 
                                        $author_names = front_natural_language_join( $author_names, '<span class="text-muted">' . esc_html__( 'and', 'front' ) . '</span>' );
                                        printf( '<span class="text-muted">%s</span> %s', esc_html__( 'Written by', 'front' ), $author_names ); 
                                    ?>
                                </small>
                                <?php endif; ?>
                                <!-- End Article Authors -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Icon Block -->
            </div>
        </a>
    <?php endforeach;
endif;