<?php
/**
 * Class to setup Brands attribute
 *
 * @package Front/WooCommerce
 */

class Front_Product_Categories {

	public function __construct() {

		// Add scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'load_wp_media_files' ), 0 );

		// Add form
		add_action( "product_cat_add_form_fields",				array( $this, 'add_category_fields' ), 10 );
		add_action( "product_cat_edit_form_fields",				array( $this, 'edit_category_fields' ), 10, 2 );
		add_action( 'create_term',								array( $this, 'save_category_fields' ), 10, 3 );
		add_action( 'edit_term',								array( $this, 'save_category_fields' ), 10, 3 );
	}

	/**
	 * Loads WP Media Files
	 *
	 * @return void
	 */
	public function load_wp_media_files() {
		wp_enqueue_media();
	}

	/**
	 * Product Category static block fields.
	 *
	 * @return void
	 */
	public function add_category_fields() {
		?>
		<div class="form-field">
			<?php 
				if( post_type_exists( 'mas_static_content' ) ) :

					$args = array(
						'posts_per_page'	=> -1,
						'orderby'			=> 'title',
						'post_type'			=> 'mas_static_content',
					);
					$static_blocks = get_posts( $args );
				endif;
			?>
			<div class="form-group">
				<label><?php esc_html_e( 'Jumbotron', 'front' ); ?></label>
				<select id="procuct_cat_static_block_id" class="form-control" name="procuct_cat_static_block_id">
					<option value=""><?php echo esc_html__( 'Select a Static Block', 'front' ); ?></option>
				<?php if( front_is_mas_static_content_activated() && ! empty( $static_block_id ) ) : ?>
				<?php foreach( $static_blocks as $static_block ) : ?>
					<option value="<?php echo esc_attr( $static_block->ID ); ?>"><?php echo get_the_title( $static_block->ID ); ?></option>
				<?php endforeach; ?>
				<?php endif; ?>
				</select>
			</div>

			<div class="form-group">
				<label><?php esc_html_e( 'Middle Jumbotron', 'front' ); ?></label>
				<select id="procuct_cat_static_block_middle_id" class="form-control" name="procuct_cat_static_block_middle_id">
					<option value=""><?php echo esc_html__( 'Select a Static Block', 'front' ); ?></option>
				<?php if( !empty( $static_blocks ) ) : ?>
				<?php foreach( $static_blocks as $static_block ) : ?>
					<option value="<?php echo esc_attr( $static_block->ID ); ?>"><?php echo get_the_title( $static_block->ID ); ?></option>
				<?php endforeach; ?>
				<?php endif; ?>
				</select>
			</div>

			<div class="form-group">
				<label><?php esc_html_e( 'Bottom Jumbotron', 'front' ); ?></label>
				<select id="procuct_cat_static_block_bottom_id" class="form-control" name="procuct_cat_static_block_bottom_id">
					<option value=""><?php echo esc_html__( 'Select a Static Block', 'front' ); ?></option>
				<?php if( !empty( $static_blocks ) ) : ?>
				<?php foreach( $static_blocks as $static_block ) : ?>
					<option value="<?php echo esc_attr( $static_block->ID ); ?>"><?php echo get_the_title( $static_block->ID ); ?></option>
				<?php endforeach; ?>
				<?php endif; ?>
				</select>
			</div>

			<div class="clear"></div>
		</div>
		<?php
	}

	/**
	 * Edit Category static block fields.
	 *
	 * @param mixed $term Term (product_cat) being edited
	 * @param mixed $taxonomy Taxonomy of the term being edited
	 */
	public function edit_category_fields( $term, $taxonomy ) {

		$static_block_id 		= '';
		$static_block_middle_id = '';
		$static_block_bottom_id = '';
		$static_block_id 		= absint( get_term_meta( $term->term_id, 'static_block_id', true ) );
		$static_block_middle_id = absint( get_term_meta( $term->term_id, 'static_block_middle_id', true ) );
		$static_block_bottom_id = absint( get_term_meta( $term->term_id, 'static_block_bottom_id', true ) );
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php esc_html_e( 'Top Jumbotron', 'front' ); ?></label></th>
			<td>
				<?php 
					if( post_type_exists( 'mas_static_content' ) ) :

						$args = array(
							'posts_per_page'	=> -1,
							'orderby'			=> 'title',
							'post_type'			=> 'mas_static_content',
						);
						$static_blocks = get_posts( $args );
					endif;
				?>
				<div class="form-group">
					<select id="procuct_cat_static_block_id" class="form-control" name="procuct_cat_static_block_id">
						<option value=""><?php echo esc_html__( 'Select a Static Block', 'front' ); ?></option>
					<?php if( !empty( $static_blocks ) ) : ?>
					<?php foreach( $static_blocks as $static_block ) : ?>
						<option value="<?php echo esc_attr( $static_block->ID ); ?>" <?php echo esc_attr( $static_block_id == $static_block->ID  ? 'selected' : '' ); ?>><?php echo get_the_title( $static_block->ID ); ?></option>
					<?php endforeach; ?>
					<?php endif; ?>
					</select>
				</div>
				<div class="clear"></div>
			</td>
		</tr>

		<tr class="form-field">
			<th scope="row" valign="top"><label><?php esc_html_e( 'Middle Jumbotron', 'front' ); ?></label></th>
			<td>
				<?php 
					if( post_type_exists( 'mas_static_content' ) ) :

						$args = array(
							'posts_per_page'	=> -1,
							'orderby'			=> 'title',
							'post_type'			=> 'mas_static_content',
						);
						$static_blocks = get_posts( $args );
					endif;
				?>

				<div class="form-group">
					<select id="procuct_cat_static_block_middle_id" class="form-control" name="procuct_cat_static_block_middle_id">
						<option value=""><?php echo esc_html__( 'Select a Static Block', 'front' ); ?></option>
					<?php if( !empty( $static_blocks ) ) : ?>
					<?php foreach( $static_blocks as $static_block ) : ?>
						<option value="<?php echo esc_attr( $static_block->ID ); ?>" <?php echo esc_attr( $static_block_middle_id == $static_block->ID  ? 'selected' : '' ); ?>><?php echo get_the_title( $static_block->ID ); ?></option>
					<?php endforeach; ?>
					<?php endif; ?>
					</select>
				</div>
				<div class="clear"></div>
			</td>
		</tr>

		<tr class="form-field">
			<th scope="row" valign="top"><label><?php esc_html_e( 'Bottom Jumbotron', 'front' ); ?></label></th>
			<td>
				<?php 
					if( post_type_exists( 'mas_static_content' ) ) :

						$args = array(
							'posts_per_page'	=> -1,
							'orderby'			=> 'title',
							'post_type'			=> 'mas_static_content',
						);
						$static_blocks = get_posts( $args );
					endif;
				?>

				<div class="form-group">
					<select id="procuct_cat_static_block_bottom_id" class="form-control" name="procuct_cat_static_block_bottom_id">
						<option value=""><?php echo esc_html__( 'Select a Static Block', 'front' ); ?></option>
					<?php if( !empty( $static_blocks ) ) : ?>
					<?php foreach( $static_blocks as $static_block ) : ?>
						<option value="<?php echo esc_attr( $static_block->ID ); ?>" <?php echo esc_attr( $static_block_bottom_id == $static_block->ID  ? 'selected' : '' ); ?>><?php echo get_the_title( $static_block->ID ); ?></option>
					<?php endforeach; ?>
					<?php endif; ?>
					</select>
				</div>
				<div class="clear"></div>
			</td>
		</tr>


		<?php
	}

	/**
	 * Save Category static block fields.
	 *
	 * @param mixed $term_id Term ID being saved
	 * @param mixed $tt_id
	 * @param mixed $taxonomy Taxonomy of the term being saved
	 * @return void
	 */
	public function save_category_fields( $term_id, $tt_id, $taxonomy ) {

		if ( isset( $_POST['procuct_cat_static_block_id'] ) )
			update_woocommerce_term_meta( $term_id, 'static_block_id', absint( $_POST['procuct_cat_static_block_id'] ) );

		if ( isset( $_POST['procuct_cat_static_block_middle_id'] ) )
			update_woocommerce_term_meta( $term_id, 'static_block_middle_id', absint( $_POST['procuct_cat_static_block_middle_id'] ) );

		if ( isset( $_POST['procuct_cat_static_block_bottom_id'] ) )
			update_woocommerce_term_meta( $term_id, 'static_block_bottom_id', absint( $_POST['procuct_cat_static_block_bottom_id'] ) );

		delete_transient( 'wc_term_counts' );
	}

	/**
	 * Category column added to jumbotron admin.
	 *
	 * @param mixed $columns
	 * @return array
	 */
	public function product_category_columns( $columns ) {
		$new_columns          = array();
		$new_columns['cb']    = $columns['cb'];
		$new_columns['jumbotron'] = esc_html__( 'Jumbotron', 'front' );
		$new_columns['middle_jumbotron'] = esc_html__( 'Middle Jumbotron', 'front' );
		$new_columns['bottom_jumbotron'] = esc_html__( 'Bottom Jumbotron', 'front' );

		return array_merge( $new_columns, $columns );
	}

	/**
	 * Category column value added to jumbotron admin.
	 *
	 * @param mixed $columns
	 * @param mixed $column
	 * @param mixed $id
	 * @return array
	 */
	public function product_category_column( $columns, $column, $id ) {

		if ( $column == 'jumbotron' ) {
			$static_block_id 	= '';
			$static_block_title = '';
			$static_block_id 	= get_term_meta( $id, 'static_block_id', true );
			if ( $static_block_id ) {
				$static_block_title = get_the_title( $static_block_id );
			}

			$columns .= $static_block_title;
		}

		if ( $column == 'middle_jumbotron' ) {
			$static_block_middle_id 	= '';
			$static_block_middle_title = '';
			$static_block_middle_id 	= get_woocommerce_term_meta( $id, 'static_block_middle_id', true );
			if ( $static_block_middle_id ) {
				$static_block_middle_title = get_the_title( $static_block_middle_id );
			}

			$columns .= $static_block_middle_title;
		}

		if ( $column == 'bottom_jumbotron' ) {
			$static_block_bottom_id 	= '';
			$static_block_bottom_title = '';
			$static_block_bottom_id 	= get_woocommerce_term_meta( $id, 'static_block_bottom_id', true );
			if ( $static_block_bottom_id ) {
				$static_block_bottom_title = get_the_title( $static_block_bottom_id );
			}

			$columns .= $static_block_bottom_title;
		}

		return $columns;
	}
}

new Front_Product_Categories;