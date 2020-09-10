<?php
/**
 * Class to setup jetpack portfolio taxonomies meta
 *
 * @package Front
 */

class Front_Jetpack_Portfolio_Taxonomies {

    private $portfolio_view_options = array();

    private $portfolio_layout_options = array();

    public function __construct() {
        $this->portfolio_view_options = array(
            'classic'      => esc_html__( 'Classic', 'front' ),
            'grid'         => esc_html__( 'Grid',    'front' ),
            'masonry'      => esc_html__( 'Masonry', 'front' ),
            'modern'       => esc_html__( 'Modern',  'front' ),
        );

        $this->portfolio_layout_options = array(
            'boxed'       => esc_html__( 'Boxed', 'front' ),
            'fullwidth'   => esc_html__( 'Fullwidth', 'front' ),
        );

        // Add form fields
        add_action( 'jetpack-portfolio-type_add_form_fields',     array( $this, 'add_jetpack_portfolio_type_fields' ), 10 );
        add_action( 'jetpack-portfolio-type_edit_form_fields',    array( $this, 'edit_jetpack_portfolio_type_fields' ), 10, 2 );

        // Save Values
        add_action( 'create_term',                  array( $this, 'save_jetpack_portfolio_type_fields' ), 10, 3 );
        add_action( 'edit_term',                    array( $this, 'save_jetpack_portfolio_type_fields' ), 10, 3 );
    }

    /**
     * Add Jetpack portfolio type fields.
     *
     * @return void
     */
    public function add_jetpack_portfolio_type_fields() {
        ?>
        <div class="form-field">
            <div class="form-group">
                <label for="portfolio_view"><?php esc_html_e( 'Portfolio View', 'front' ); ?></label>
                <select id="portfolio_view" class="form-control" name="portfolio_view">
                    <option value=""><?php echo esc_html__( 'Select a View', 'front' ); ?></option>
                    <?php foreach( $this->portfolio_view_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-field">
            <div class="form-group">
                <label for="portfolio_layout"><?php esc_html_e( 'Portfolio Layout', 'front' ); ?></label>
                <select id="portfolio_layout" class="form-control" name="portfolio_layout">
                    <option value=""><?php echo esc_html__( 'Select a Layout', 'front' ); ?></option>
                    <?php foreach( $this->portfolio_layout_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <?php
    }

    /**
     * Edit Jetpack portfolio type fields.
     *
     * @param mixed $term Term (jetpack-portfolio-type) being edited
     * @param mixed $taxonomy Taxonomy of the term being edited
     */
    public function edit_jetpack_portfolio_type_fields( $term, $taxonomy ) {

        $portfolio_view      = get_term_meta( $term->term_id, 'portfolio_view', true );
        $portfolio_layout    = get_term_meta( $term->term_id, 'portfolio_layout', true );
        ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="portfolio_view"><?php esc_html_e( 'Portfolio View', 'front' ); ?></label>
            </th>
            <td>
                <div class="form-group">
                    <select id="portfolio_view" class="form-control" name="portfolio_view">
                        <option value=""><?php echo esc_html__( 'Select a View', 'front' ); ?></option>
                        <?php foreach( $this->portfolio_view_options as $key => $value ) : ?>
                            <option value="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $portfolio_view == $key  ? 'selected' : '' ); ?>><?php echo esc_html( $value ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="clear"></div>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="portfolio_layout"><?php esc_html_e( 'Portfolio Layout', 'front' ); ?></label>
            </th>
            <td>
                <div class="form-group">
                    <select id="portfolio_layout" class="form-control" name="portfolio_layout">
                        <option value=""><?php echo esc_html__( 'Select a Layout', 'front' ); ?></option>
                        <?php foreach( $this->portfolio_layout_options as $key => $value ) : ?>
                            <option value="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $portfolio_layout == $key  ? 'selected' : '' ); ?>><?php echo esc_html( $value ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="clear"></div>
            </td>
        </tr>
        <?php
    }

    /**
     * Save Jetpack portfolio type fields.
     *
     * @param mixed $term_id Term ID being saved
     * @param mixed $tt_id
     * @param mixed $taxonomy Taxonomy of the term being saved
     * @return void
     */
    public function save_jetpack_portfolio_type_fields( $term_id, $tt_id, $taxonomy ) {
        if ( isset( $_POST['portfolio_view'] ) ) {
            update_term_meta( $term_id, 'portfolio_view', $_POST['portfolio_view'] );
        }

        if ( isset( $_POST['portfolio_layout'] ) ) {
            update_term_meta( $term_id, 'portfolio_layout', $_POST['portfolio_layout'] );
        }
    }
}

new Front_Jetpack_Portfolio_Taxonomies;