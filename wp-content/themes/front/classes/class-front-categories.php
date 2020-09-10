<?php
/**
 * Class to setup categories meta
 *
 * @package Front
 */

class Front_Categories {

    private $blog_view_options = array();

    private $blog_layout_options = array();

    public function __construct() {
        $this->blog_view_options = array(
            'classic'      => esc_html__( 'Classic', 'front' ),
            'grid'         => esc_html__( 'Grid',    'front' ),
            'list'         => esc_html__( 'List',    'front' ),
            'masonry'      => esc_html__( 'Masonry', 'front' ),
            'modern'       => esc_html__( 'Modern',  'front' ),
        );

        $this->blog_layout_options = array(
            'sidebar-right'     => esc_html__( 'Right Sidebar', 'front' ),
            'sidebar-left'      => esc_html__( 'Left Sidebar',  'front' ),
            'full-width'        => esc_html__( 'Fullwidth',     'front' ),
        );

        // Add form fields
        add_action( 'category_add_form_fields',     array( $this, 'add_category_fields' ), 10 );
        add_action( 'category_edit_form_fields',    array( $this, 'edit_category_fields' ), 10, 2 );

        // Save Values
        add_action( 'create_term',                  array( $this, 'save_category_fields' ), 10, 3 );
        add_action( 'edit_term',                    array( $this, 'save_category_fields' ), 10, 3 );
    }

    /**
     * Add Category fields.
     *
     * @return void
     */
    public function add_category_fields() {
        ?>
        <div class="form-field">
            <div class="form-group">
                <label for="blog_view"><?php esc_html_e( 'Blog View', 'front' ); ?></label>
                <select id="blog_view" class="form-control" name="blog_view">
                    <option value=""><?php echo esc_html__( 'Select a View', 'front' ); ?></option>
                    <?php foreach( $this->blog_view_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-field">
            <div class="form-group">
                <label for="blog_layout"><?php esc_html_e( 'Blog Layout', 'front' ); ?></label>
                <select id="blog_layout" class="form-control" name="blog_layout">
                    <option value=""><?php echo esc_html__( 'Select a Layout', 'front' ); ?></option>
                    <?php foreach( $this->blog_layout_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <?php
    }

    /**
     * Edit Category fields.
     *
     * @param mixed $term Term (category) being edited
     * @param mixed $taxonomy Taxonomy of the term being edited
     */
    public function edit_category_fields( $term, $taxonomy ) {

        $blog_view      = get_term_meta( $term->term_id, 'blog_view', true );
        $blog_layout    = get_term_meta( $term->term_id, 'blog_layout', true );
        ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="blog_view"><?php esc_html_e( 'Blog View', 'front' ); ?></label>
            </th>
            <td>
                <div class="form-group">
                    <select id="blog_view" class="form-control" name="blog_view">
                        <option value=""><?php echo esc_html__( 'Select a View', 'front' ); ?></option>
                        <?php foreach( $this->blog_view_options as $key => $value ) : ?>
                            <option value="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $blog_view == $key  ? 'selected' : '' ); ?>><?php echo esc_html( $value ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="clear"></div>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="blog_layout"><?php esc_html_e( 'Blog Layout', 'front' ); ?></label>
            </th>
            <td>
                <div class="form-group">
                    <select id="blog_layout" class="form-control" name="blog_layout">
                        <option value=""><?php echo esc_html__( 'Select a Layout', 'front' ); ?></option>
                        <?php foreach( $this->blog_layout_options as $key => $value ) : ?>
                            <option value="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $blog_layout == $key  ? 'selected' : '' ); ?>><?php echo esc_html( $value ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="clear"></div>
            </td>
        </tr>
        <?php
    }

    /**
     * Save Category fields.
     *
     * @param mixed $term_id Term ID being saved
     * @param mixed $tt_id
     * @param mixed $taxonomy Taxonomy of the term being saved
     * @return void
     */
    public function save_category_fields( $term_id, $tt_id, $taxonomy ) {
        if ( isset( $_POST['blog_view'] ) ) {
            update_term_meta( $term_id, 'blog_view', $_POST['blog_view'] );
        }

        if ( isset( $_POST['blog_layout'] ) ) {
            update_term_meta( $term_id, 'blog_layout', $_POST['blog_layout'] );
        }
    }
}

new Front_Categories;