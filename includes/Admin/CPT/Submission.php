<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Admin_CPT_Submission
 */
class NF_Admin_CPT_Submission
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action( 'init', array( $this, 'custom_post_type' ), 0 );

        add_action( 'save_post', array( $this, 'save_nf_sub' ), 10, 2 );

        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10, 2 );
        add_action( 'add_meta_boxes', array( $this, 'remove_meta_boxes' ) );

    }

    /**
     * Custom Post Type
     */
    function custom_post_type() {

        $labels = array(
            'name'                => _x( 'Submissions', 'Post Type General Name', 'ninja_forms' ),
            'singular_name'       => _x( 'Submission', 'Post Type Singular Name', 'ninja_forms' ),
            'menu_name'           => __( 'Submissions', 'ninja_forms' ),
            'name_admin_bar'      => __( 'Submissions', 'ninja_forms' ),
            'parent_item_colon'   => __( 'Parent Item:', 'ninja_forms' ),
            'all_items'           => __( 'All Items', 'ninja_forms' ),
            'add_new_item'        => __( 'Add New Item', 'ninja_forms' ),
            'add_new'             => __( 'Add New', 'ninja_forms' ),
            'new_item'            => __( 'New Item', 'ninja_forms' ),
            'edit_item'           => __( 'Edit Item', 'ninja_forms' ),
            'update_item'         => __( 'Update Item', 'ninja_forms' ),
            'view_item'           => __( 'View Item', 'ninja_forms' ),
            'search_items'        => __( 'Search Item', 'ninja_forms' ),
            'not_found'           => $this->not_found_message(),
            'not_found_in_trash'  => __( 'Not found in Trash', 'ninja_forms' ),
        );
        $args = array(
            'label'               => __( 'Submission', 'ninja_forms' ),
            'description'         => __( 'Form Submissions', 'ninja_forms' ),
            'labels'              => $labels,
            'supports'            => false,
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'menu_position'       => 5,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        );
        register_post_type( 'nf_sub', $args );
    }

    public function save_nf_sub( $nf_sub_id, $nf_sub )
    {
        global $pagenow;

        if ( ! isset ( $_POST['nf_edit_sub'] ) || $_POST['nf_edit_sub'] != 1 )
            return $nf_sub_id;

        // verify if this is an auto save routine.
        // If it is our form has not been submitted, so we dont want to do anything
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $nf_sub_id;

        if ( $pagenow != 'post.php' )
            return $nf_sub_id;

        if ( $nf_sub->post_type != 'nf_sub' )
            return $nf_sub_id;

        /* Get the post type object. */
        $post_type = get_post_type_object( $nf_sub->post_type );

        /* Check if the current user has permission to edit the post. */
        if ( !current_user_can( $post_type->cap->edit_post, $nf_sub_id ) )
            return $nf_sub_id;

        $sub = Ninja_Forms()->form()->sub( $nf_sub_id )->get();

        foreach ( $_POST['fields'] as $field_id => $user_value ) {
            $user_value = apply_filters( 'nf_edit_sub_user_value', $user_value, $field_id, $nf_sub_id );
            $sub->update_field_value( $field_id, $user_value );
        }

        $sub->save();

        set_transient( 'nf_sub_edit_ref', esc_url_raw( $_REQUEST['ref'] ) );
    }

    /**
     * Meta Boxes
     */
    public function add_meta_boxes( $post_type, $post )
    {
        add_meta_box(
            'nf_sub_fields',
            __( 'User Submitted Values', 'ninja-forms' ),
            array( $this, 'fields_meta_box' ),
            'nf_sub',
            'normal',
            'default'
        );

        add_meta_box(
            'nf_sub_info',
            __( 'Submission Info', 'ninja-forms' ),
            array( $this, 'info_meta_box' ),
            'nf_sub',
            'side',
            'default'
        );
    }

    /**
     * Fields Meta Box
     *
     * @param $post
     */
    public function fields_meta_box( $post )
    {
        $sub = Ninja_Forms()->form()->get_sub( $post->ID );

        $fields = Ninja_Forms()->form( 1 )->get_fields();

        $hidden_field_types = apply_filters( 'nf_sub_hidden_field_types', array() );

        Ninja_Forms::template( 'admin-metabox-sub-fields.html.php', compact( 'fields', 'sub', 'hidden_field_types' ) );
    }

    /**
     * Info Meta Box
     *
     * @param $post
     */
    public function info_meta_box( $post )
    {
        Ninja_Forms::template( 'admin-metabox-sub-info.html.php' );
    }

    /**
     * Remove Meta Boxes
     */
    public function remove_meta_boxes()
    {
        // Remove the default Publish metabox
        remove_meta_box( 'submitdiv', 'nf_sub', 'side' );
    }

    /*
     * PRIVATE METHODS
     */

    private function not_found_message()
    {
        if ( ! isset ( $_REQUEST['form_id'] ) || empty( $_REQUEST['form_id'] ) ) {
            return __( 'Please select a form to view submissions', 'ninja-forms' );
        } else {
            return __( 'No Submissions Found', 'ninja-forms' );
        }
    }

}

