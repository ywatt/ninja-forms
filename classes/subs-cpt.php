<?php
/**
 * Submission CPT.
 * This class adds our submission CPT and handles displaying submissions in the wp-admin.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Submissions
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

class NF_Subs_CPT {

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
		add_action( 'admin_menu', array( $this, 'add_submenu' ), 11 );

		// Change our submission columns.
		add_filter( 'manage_nf_sub_posts_columns', array( $this, 'change_columns' ) );

		// Make our columns sortable.
		add_filter( 'manage_edit-nf_sub_sortable_columns', array( $this, 'sortable_columns' ) );

		// Add the appropriate data for our custom columns.
		add_action( 'manage_posts_custom_column', array( $this, 'custom_columns' ), 10, 2 );

		// Add our submission filters.
		add_action( 'restrict_manage_posts', array( $this, 'add_filters' ) );
		add_filter( 'parse_query', array( $this, 'table_filter' ) );
		add_filter( 'posts_clauses', array( $this, 'search' ), 20 );

		add_action( 'admin_footer', array( $this, 'jquery_remove_counts' ) );

		// Filter our post counts
		add_filter( 'wp_count_posts', array( $this, 'count_posts' ), 10, 3 );

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
		    'add_new' => _x( 'Add New', 'nf_sub' ),
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
			// 'capabilities' => array(
		 //    	'create_posts' => false, // Removes support for the "Add New" function
			// ),
			'hierarchical' => false,
			'menu_events' => null,
			'rewrite' => array( 'slug' => 'nf_sub' ), // Permalinks format
			//'taxonomies' => array( 'novel_genre', 'novel_series', 'novel_author', 'post_tag'),
			'supports' => array( 'custom-fields' ),
		);

		register_post_type('nf_sub',$args);
	}

	/**
	 * Add our submissions submenu
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function add_submenu() {
		// Add our submissions submenu
		$sub_page = add_submenu_page( 'ninja-forms', __( 'Submissions', 'ninja-forms' ), __( 'Submissions', 'ninja-forms' ), apply_filters( 'nf_admin_menu_subs_capabilities', 'manage_options' ), 'edit.php?post_type=nf_sub'); 

		// Remove the publish box from the submission editing page.
		remove_meta_box( 'submitdiv', 'nf_sub', 'side' );
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
			//'title' => 'Title',
		);

		if ( isset ( $_GET['form_id'] ) ) {
			$form_id = $_GET['form_id'];
			$fields = nf_get_fields_by_form_id( $form_id );
			if ( is_array ( $fields ) ) {
				foreach ( $fields as $field_id => $setting ) {
					if ( apply_filters( 'nf_add_sub_value', Ninja_Forms()->field( $field_id )->type->add_to_sub, $field_id ) )
						$cols[ 'form_' . $form_id . '_field_' . $field_id ] = $setting['label'];
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
	public function custom_columns( $column, $sub_id ) {
		global $nf_output_row_actions;
		if ( isset ( $_GET['form_id'] ) ) {
			$form_id = $_GET['form_id'];
			$field_id = str_replace( 'form_' . $form_id . '_field_', '', $column );
			if ( apply_filters( 'nf_add_sub_value', Ninja_Forms()->field( $field_id )->type->add_to_sub, $field_id ) ) {
				echo Ninja_Forms()->sub( $sub_id )->get_value( $field_id );
				if ( ! isset ( $nf_output_row_actions[ $sub_id ] ) ) {
					echo '<div class="locked-info"><span class="locked-avatar"></span> <span class="locked-text"></span></div>';
					if ( !isset ( $_GET['post_status'] ) || $_GET['post_status'] == 'all' ) {
						echo '<div class="row-actions"><span class="edit"><a href="post.php?post=' . $sub_id . '&action=edit" title="Edit this item">Edit</a> | </span> <span class="trash"><a class="submitdelete" title="Move this item to the Trash" href="' . get_delete_post_link( $sub_id ) . '">Trash</a></div>';
					} else {
						echo '<div class="row-actions"><span class="untrash"><a title="' . esc_attr( __( 'Restore this item from the Trash' ) ) . '" href="' . wp_nonce_url( sprintf( get_edit_post_link( $sub_id ) . '&amp;action=untrash', $sub_id ) , 'untrash-post_' . $sub_id ) . '">' . __( 'Restore' ) . '</a> | </span> <span class="delete"><a class="submitdelete" title="' . esc_attr( __( 'Delete this item permanently' ) ) . '" href="' . get_delete_post_link( $sub_id, '', true ) . '">' . __( 'Delete Permanently' ) . '</a></span></div>';
					}
					$nf_output_row_actions[ $sub_id ] = 1;
				}				
			}
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
		if ( $typenow != 'nf_sub' )
			return false;

		/*
		// Bail if we are looking at the trashed submissions.
		if ( isset ( $_REQUEST['post_status'] ) && $_REQUEST['post_status'] == 'trash' )
			return false;
		*/

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

	/**
	 * Filter our submission list by form_id
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function table_filter( $query ) {

		if( is_admin() AND $query->query['post_type'] == 'nf_sub' ) {

		    $qv = &$query->query_vars;
		    $qv['meta_query'] = array();

		    if( !empty( $_GET['form_id'] ) ) {
		    	$form_id = $_GET['form_id'];
		    } else {
		    	$form_id = 0;
		    }

		    $qv['meta_key'] = 'form_id';
		    $qv['meta_value'] = $form_id;

		}
	}

	/**
	 * Filter our search
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function search( $pieces ) {
		global $typenow;
	    // filter to select search query
	    if ( is_search() && is_admin() && $typenow == 'nf_sub' && isset ( $_GET['s'] ) ) { 
	        global $wpdb;

	        $keywords = explode(' ', get_query_var('s'));
	        $query = "";

	        foreach ($keywords as $word) {
	             
	             $query .= " (mypm1.meta_value  LIKE '%{$word}%') OR ";
	         }

	        if (!empty($query)) {
	            // add to where clause
	            $pieces['where'] = str_replace("(((wp_posts.post_title LIKE '%", "( {$query} ((wp_posts.post_title LIKE '%", $pieces['where']);
	 
	            $pieces['join'] = $pieces['join'] . " INNER JOIN {$wpdb->postmeta} AS mypm1 ON ({$wpdb->posts}.ID = mypm1.post_id)";
	        }
	    }
	    return ($pieces);
	}

	/**
	 * Jquery that hides some of our post-related page items.
	 * Also adds the active class to All and Trash links, and changes those
	 * links to match the current filter.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function jquery_remove_counts() {
		global $typenow, $pagenow;
		if ( $typenow == 'nf_sub' && $pagenow == 'edit.php' ) {
			if ( ! isset ( $_GET['post_status'] ) || $_GET['post_status'] == 'all' ) {
				$active = 'all';
			} else if ( $_GET['post_status'] == 'trash' ) {
				$active = 'trash';
			}

			$all_url = add_query_arg( array( 'post_status' => 'all' ) );
			$all_url = remove_query_arg( 's', $all_url );
			$trash_url = add_query_arg( array( 'post_status' => 'trash' ) );
			$trash_url = remove_query_arg( 's', $trash_url );
			if ( isset ( $_GET['form_id'] ) ) {
				$trashed_sub_count = nf_get_sub_count( $_GET['form_id'], 'trash' );	
			} else {
				$trashed_sub_count = 0;
			}
			
			?>
			<script type="text/javascript">
			jQuery(function(){
				jQuery( "li.all" ).find( "a" ).attr( "href", "<?php echo $all_url; ?>" );
				jQuery( "li.<?php echo $active; ?>" ).addClass( "current" );
				jQuery( "li.<?php echo $active; ?>" ).find( "a" ).addClass( "current" );
				jQuery( "li.trash" ).find( "a" ).attr( "href", "<?php echo $trash_url; ?>" );
				<?php
				if ( $trashed_sub_count == 0 ) {
					?>
					var text = jQuery( "li.all" ).prop( "innerHTML" );
					text = text.replace( " |", "" );
					jQuery( "li.all" ).prop( "innerHTML", text );
					<?php
				}
				?>
			});
			</script>
			<style>
				.add-new-h2 {
					display:none;
				}
				li.publish {
					display:none;
				}
				select[name=m] {
					display:none;
				}
			</style>
			<?php			
		}
	}

	/**
	 * Filter our post counts for the submission listing page
	 * 
	 * @access public
	 * @since 3.0
	 * @return int $count
	 */
	public function count_posts( $count, $post_type, $perm ) {
		// Bail if we aren't working with our custom post type.
		if ( $post_type != 'nf_sub' )
			return $count;

		if ( isset ( $_GET['form_id'] ) ) {
			$sub_count = nf_get_sub_count( $_GET['form_id'] );
			$trashed_sub_count = nf_get_sub_count( $_GET['form_id'], 'trash' );
			$count->publish = $sub_count;
			$count->trash = $trashed_sub_count;
		} else {
			$count->publish = 0;
			$count->trash = 0;
		}

		return $count;
	}
}
