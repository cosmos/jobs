<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<header class="woocommerce-products-header bg-light">
	<div class="container py-5">
		<div class="row align-items-sm-center">
			<div class="col-sm-6 mb-3 mb-sm-0">
			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
				<h1 class="woocommerce-products-header__title page-title h4 mb-0"><?php woocommerce_page_title(); ?></h1>
			<?php endif; ?>
			<?php
			/**
			 * Hook: woocommerce_archive_description.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
			?>
			</div>
			<div class="col-sm-6">
				<?php woocommerce_breadcrumb(); ?>
			</div>
		</div>
	</div>
</header>
	<?php if ( is_shop()) { ?>
		<div class="container space-2 space-bottom-lg-3">
	<?php } else { ?>
		<div class="container space-2">
	<?php } ?>

	<?php if ( front_shop_has_sidebar() ) : ?>

		<div class="row">
			<?php
			$content_area_classes = 'content-area col-lg-9';
			$shop_layout   = front_get_layout();

			if ( $shop_layout === 'sidebar-left' ) {
			    $content_area_classes .= ' order-lg-2';
			}
			?>
			<div class="<?php echo esc_attr( $content_area_classes ); ?>">
	<?php else : ?>

	    	<div class="content-area">
	<?php endif; ?>
				
			<?php
				if ( woocommerce_product_loop() ) {

					/**
					 * Hook: woocommerce_before_shop_loop.
					 *
					 * @hooked woocommerce_output_all_notices - 10
					 * @hooked woocommerce_result_count - 20
					 * @hooked woocommerce_catalog_ordering - 30
					 */
					do_action( 'woocommerce_before_shop_loop' );

					$class = '';

					$shop_views = front_get_shop_views();
			        foreach( $shop_views as $shop_view => $shop_view_args) {
			            if ( $shop_view_args['active'] ) {
			                $class = $shop_view;
			                break;
			            }
			        }

					woocommerce_product_loop_start( true, $class );

					if ( wc_get_loop_prop( 'total' ) ) {
						while ( have_posts() ) {
							the_post();

							/**
							 * Hook: woocommerce_shop_loop.
							 *
							 * @hooked WC_Structured_Data::generate_product_data() - 10
							 */
							do_action( 'woocommerce_shop_loop' );

							wc_get_template_part( 'content', 'product' );
						}
					}

					woocommerce_product_loop_end();

					/**
					 * Hook: woocommerce_after_shop_loop.
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
				} else {
					/**
					 * Hook: woocommerce_no_products_found.
					 *
					 * @hooked wc_no_products_found - 10
					 */
					do_action( 'woocommerce_no_products_found' );
				}

				/**
				 * Hook: woocommerce_after_main_content.
				 *
				 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				do_action( 'woocommerce_after_main_content' ); ?>
				<?php if ( front_shop_has_sidebar() ) : ?>
	    
	        </div>
			<?php
			/**
			 * Hook: woocommerce_sidebar.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action( 'woocommerce_sidebar' );  ?>

		</div>
	<?php else : ?>
    
    </div>
    
    <?php endif; ?>
	<?php if ( is_shop()) { ?>
	</div>
	<?php } else { ?>
		</div>
	<?php } ?>

<?php do_action( 'front_archive_main_content_after' ); ?>
<?php
get_footer( 'shop' );
