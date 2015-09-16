<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Admin_CPT_Submission
{
    public function __construct()
    {
        add_action( 'init', array( $this, 'custom_post_type' ), 0 );
    }

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
            'supports'            => array( ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
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

}

