<?php
/**
 * Submission CPT.
 * This class handles storing, retrieving, editing submissions.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Submissions
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

class NF_Subs {

	/**
	 * Get things started
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	function __construct() {
		// Register our submission custom post type.
		add_action( 'init', array( $this, 'register_cpt' ) );

		// Add our submenu for the submissions page.
		add_action( 'admin_menu', array( $this, 'add_submenu' ) );

		// Change our submission columns.
		add_filter( 'manage_nf_subs_posts_columns', array( $this, 'change_columns' ) );

		// Make our columns sortable.
		add_filter( 'manage_edit-nf_subs_sortable_columns', array( $this, 'sortable_columns' ) );

		// Add the appropriate data for our custom columns.
		add_action( 'manage_posts_custom_column', array( $this, 'custom_columns' ), 10, 2 );

		// Add our submission filters.
		add_action( 'restrict_manage_posts', array( $this, 'add_filters' ) );

	}

	/**
	 * Register our submission CPT
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function register_cpt() {
		$labels = array(
		    'name' => _x('Submissions', 'post type general name' ),
		    'singular_name' => _x( 'Submission', 'post type singular name' ),
		    'add_new' => _x( 'Add New', 'nf_subs' ),
		    'add_new_item' => __( 'Add New Submission', 'ninja-forms' ),
		    'edit_item' => __( 'Edit Submission', 'ninja-forms' ),
		    'new_item' => __( 'New Submission', 'ninja-forms' ),
		    'view_item' => __( 'View Submission', 'ninja-forms' ),
		    'search_items' => __( 'Search Submissions', 'ninja-forms' ),
		    'not_found' =>  __( 'No Submissions Found', 'ninja-forms' ),
		    'not_found_in_trash' => __( 'No Submissions Found In The Trash', 'ninja-forms' ),
		    'parent_item_colon' => ''
	  	);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'_builtin' => false, // It's a custom post type, not built in!
			'query_var' => true,
			'capability_type' => 'post',
			'has_archive' => false,
			'show_in_menu' => false,
			'capabilities' => array(
		    	'create_posts' => false, // Removes support for the "Add New" function
			),
			'hierarchical' => false,
			'menu_events' => null,
			'rewrite' => array( 'slug' => 'nf_subs' ), // Permalinks format
			//'taxonomies' => array( 'novel_genre', 'novel_series', 'novel_author', 'post_tag'),
			'supports' => array( 'title','editor' ),
		);

		register_post_type('nf_subs',$args);
	}

	/**
	 * Add our submissions submenu
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function add_submenu() {
		add_submenu_page( 'ninja-forms', __( 'Submissions', 'ninja-forms' ), __( 'Submissions', 'ninja-forms' ), apply_filters( 'nf_admin_menu_subs_capabilities', 'manage_options' ), 'edit.php?post_type=nf_subs'); 
	}

	/**
	 * Modify the columns of our submissions table.
	 * 
	 * @access public
	 * @since 3.0
	 * @return array $cols
	 */
	public function change_columns( $cols ) {

		$cols = array(
			'cb'    => '<input type="checkbox" />',
		);

		if ( isset ( $_GET['form_id'] ) ) {
			$form_id = $_GET['form_id'];
			$fields = nf_get_fields_by_form_id( $form_id );
			if ( is_array ( $fields ) ) {
				foreach ( $fields as $field_id => $setting ) {
					$sanitized_label = sanitize_title_with_dashes( $setting['label'] );
					$cols[ $sanitized_label ] = $setting['label'];
				}
			}
		}
		

		return $cols;
	}

	/**
	 * Make our columns sortable
	 * 
	 * @access public
	 * @since 3.0
	 * @return array
	 */
	public function sortable_columns() {
		return array(
			'url'      => 'url',
			'referrer' => 'referrer',
			'host'     => 'host'
		);
	}

	/**
	 * Add our custom column data
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function custom_columns( $column, $post_id ) {
		switch ( $column ) {
		    case "url":
		      $url = get_post_meta( $post_id, 'url', true);
		      echo '<a href="' . $url . '">' . $url. '</a>';
		      break;
		    case "referrer":
		      $refer = get_post_meta( $post_id, 'referrer', true);
		      echo '<a href="' . $refer . '">' . $refer. '</a>';
		      break;
		    case "host":
		      echo get_post_meta( $post_id, 'host', true);
		      break;
		}
	}

	/**
	 * Add our submission filters
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function add_filters() {
		global $typenow;

		// Bail if we aren't in our submission custom post type.
		if ( $typenow != 'nf_subs' )
			return false;

		// Get our list of forms
		$forms = nf_get_all_forms();

		$form_id = isset( $_GET['form_id'] ) ? $_GET['form_id'] : '';

 		$html = '<select name="form_id" id="form_id">';
		$html .= '<option value="">- Select a form</option>';
		if ( is_array( $forms ) ) {
			foreach ( $forms as $form ) {
				$html .= '<option value="' . $form['id'] . '" ' . selected( $form['id'], $form_id, false ) . '>' . nf_get_form_setting( $form['id'], 'name' ) . '</option>';
			}
		}
		$html .= '</select>';
		echo $html;
	}

}
