<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package front
 */
$page_args = apply_filters( 'front_404_page_args', array(
    'page_title'      => wp_kses_post( __( 'Page not <span class="font-weight-semi-bold">found</span>', 'front' ) ),
    'sub_titles'  => array(
        esc_html__( 'Oops! Looks like you followed a bad link.', 'front' ),
        wp_kses_post( 'If you think this is a problem with us, please <a href="#">let us know</a>', 'front' ),
    ),
    'contact_text' => esc_html__( 'Go Back', 'front'),
    'contact_link' => home_url( '/' ),
    'footer_version'  => 'footer-v1',
) );

get_header(); ?>

    <div id="primary" class="content-area">
        <!-- Hero Section -->
        <div class="d-lg-flex">
            <div class="container d-lg-flex align-items-lg-center min-height-lg-100vh space-4">
                <div class="w-lg-60 w-xl-50">
                    <!-- Title -->
                    <div class="mb-5">
                        <h1 class="page-404__title text-primary font-weight-normal"><?php echo wp_kses_post( $page_args['page_title'] ); ?></h1>
                        <?php 

                        $subtitles_count = count( $page_args['sub_titles'] );
                        $p_class         = 'page-404__subtitle';
                        foreach( $page_args['sub_titles'] as $key => $subtitle ) {
                            if( $key < ( $subtitles_count - 1 ) ) {
                               $p_class .= ' mb-0';
                            }
                            echo wp_kses_post( sprintf( '<p class="%s">%s</p>', $p_class, $subtitle ) );
                        } 

                        ?>
                    </div>
                    <!-- End Title -->
                    <a class="btn btn-primary btn-wide transition-3d-hover" href="<?php echo esc_url( $page_args['contact_link'] ); ?>"><?php echo esc_html( $page_args['contact_text'] ); ?></a>
                </div>
            </div>
        </div>
        <!-- End Hero Section -->
    </div><!-- #primary -->

<?php get_footer();