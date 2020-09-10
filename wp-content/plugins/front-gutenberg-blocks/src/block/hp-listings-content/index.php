<?php
/**
 * Server-side rendering of the `fgb/hp-listings-content` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/hp-listings-content` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_hp_listings_block' ) ) {
    function frontgb_render_hp_listings_block( $attributes ) {
        // Set query.
        $listing_query = HivePress\Models\Listing::query()->filter(
            [
                'status' => 'publish',
            ]
        )->order( 'random' )
        ->limit( $attributes['limit'] );

        $listing_query->order( [ 'created_date' => 'desc' ] );

        switch ( $attributes['type'] ) {
            case 'featured':
                $listing_query->filter( [ 'featured' => true ] );
                break;

            case 'verified':
                $listing_query->filter( [ 'verified' => true ] );
                break;

            case 'random':
                $listing_query->order( 'random' );
                break;

            case 'categories':
                if ( ! empty( $attributes['categories'] ) && is_array( $attributes['categories'] ) ) {
                    $cat_ids = [];

                    foreach ( $attributes['categories'] as $slug ) {
                        $term = get_term_by( 'slug', $slug, 'hp_listing_category' );
                        if( ! empty( $term ) && ! is_wp_error( $term ) ) {
                            $cat_ids[] = $term->term_id;
                        }
                    }

                    $listing_query->filter( [ 'categories__in' => $cat_ids ] );
                }
                break;

            case 'specific':
                if ( ! empty( $attributes['posts'] ) && is_array( $attributes['posts'] ) ) {
                    $listing_query->filter( [ 'id__in' => array_column( $attributes['posts'], 'id' ) ] );
                    $listing_query->order( 'id__in' );
                }
                break;

            default:
                break;
        }

        $posts = new \WP_Query( $listing_query->get_args() );

        $content = '';

        if ( $posts->have_posts() ) {
            ob_start();
            ?>
            <div class="row mx-n2 mb-7<?php if( isset( $attributes['className'] ) && ! empty( $attributes['className'] ) ) echo esc_attr( ' ' . $attributes['className'] ); ?>">
                <?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
                    <div class="col-sm-6 col-md-4 px-2 mb-3">
                    <?php
                        $_listing = HivePress\Models\Listing::query()->get_by_id( get_post() );

                        if( $attributes['style'] == 'v2' ) {
                            front_get_template( 'hivepress/listing/view/content-listing-v2.php', array( 'listing' => $_listing ) );
                        } else {
                            front_get_template( 'hivepress/listing/view/content-listing.php', array( 'listing' => $_listing ) );
                        }
                    ?>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php
            wp_reset_postdata();
            $content = ob_get_clean();
        }

        return apply_filters( 'frontgb_render_hp_listings_block_content', $content, $posts, $attributes );
    }
}

if ( ! function_exists( 'frontgb_register_hp_listings_block' ) ) {
    /**
     * Registers the `fgb/hp-listings-content` block on server.
     */
    function frontgb_register_hp_listings_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/hp-listings-content',
            array(
                'attributes'      => array(
                    'style' => array(
                        'type'      => 'string',
                        'default'   => 'v1'
                    ),
                    'limit' => array(
                        'type'      => 'number',
                        'default'   => 6
                    ),
                    'type' => array(
                        'type'      => 'string',
                        'default'   => 'recent'
                    ),
                    'posts'=> array(
                        'type' => 'array',
                        'items' => array(
                            'type' => 'object'
                        ),
                        'default' => [],
                    ),
                    'categories'=> array(
                        'type' => 'array',
                        'default' => [],
                    ),
                    'className' =>array(
                        'type'      => 'string',
                        'default'   => ''
                    ),
                ),
                'render_callback' => 'frontgb_render_hp_listings_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_hp_listings_block' );
}