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
            'not_found'           => __( 'Not found', 'ninja_forms' ),
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
        register_post_type( 'nf_subs', $args );
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
            'nf_subs',
            'normal',
            'default'
        );

        add_meta_box(
            'nf_sub_info',
            __( 'Submission Info', 'ninja-forms' ),
            array( $this, 'info_meta_box' ),
            'nf_subs',
            'side',
            'default'
        );
    }

    public function fields_meta_box( $post )
    {
        $sub = Ninja_Forms()->form()->get_sub( $post->ID );

        $fields = Ninja_Forms()->form( 1 )->get_fields();

        Ninja_Forms::template( 'admin-metabox-sub-fields.html.php', compact( 'fields', 'sub' ) );
    }

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
        remove_meta_box( 'submitdiv', 'nf_subs', 'side' );
    }

}

