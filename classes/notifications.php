<?php
/**
 * Notifications
 *
 * Adds our notifications to the form edit page.
 * Gets notification types
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Notifications
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.8
*/

class NF_Notifications
{
	/**
	 * Get things rolling
<<<<<<< HEAD
	 * 
	 * @access public
=======
	 *
>>>>>>> 1e39991356b9cbed695fbe02926e013c9afdd003
	 * @since 2.8
	 */
	function __construct() {
		add_action('admin_init', array( $this, 'register_tab' ) );
	}

	/**
	 * Register our setting tab.
<<<<<<< HEAD
	 * 
	 * @access public
=======
	 *
>>>>>>> 1e39991356b9cbed695fbe02926e013c9afdd003
	 * @since 2.8
	 * @return void
	 */
	public function register_tab() {
		$form_id = isset ( $_REQUEST['form_id'] ) ? $_REQUEST['form_id'] : '';

		$args = array(
			'name' => __( 'Notifications', 'ninja-forms' ),
			'page' => 'ninja-forms',
			'display_function' => array( $this, 'output_admin' ),
			'save_function' => array( $this, 'save_admin' ),
			'disable_no_form_id' => true,
			'show_save' => true,
			'tab_reload' => false,
		);

		ninja_forms_register_tab( 'notifications', $args );
	}

	/**
	 * Output our notifications admin.
<<<<<<< HEAD
	 * 
	 * @access public
=======
	 *
>>>>>>> 1e39991356b9cbed695fbe02926e013c9afdd003
	 * @since 2.8
	 * @return void
	 */
	public function output_admin() {
		$action = isset ( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';
		?>
		<div class="wrap">
	        <h2><?php _e( 'Notifications', 'ninja-forms' ); ?> <?php echo sprintf('<a href="?page=%s&tab=%s&action=%s" class="add-new-h2">',$_REQUEST['page'], 'notifications','new' ); _e( 'Add New', 'ninja-forms' );?></a></h2>

	        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
	        <form id="forms-filter" method="get">
	            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
	            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><label for="blogname">Site Title</label></th>
							<td><input name="blogname" type="text" id="blogname" value="WordPress 3.9" class="regular-text"></td>
						</tr>
					</tbody>
				</table>
			<?php
		if ( '' == $action ) {

			//Create an instance of our package class...
		    $nf_all_forms = new NF_Notifications_List_Table();
		    //Fetch, prepare, sort, and filter our data...
		    $nf_all_forms->prepare_items();
 			// Now we can render the completed list table
            $nf_all_forms->display();
		} else if ( 'edit' == $action ) {

		}

	    ?>
        	</form>
    	</div>
    	<?php
	}

	/**
	 * Save our notifications admin.
<<<<<<< HEAD
	 * 
	 * @access public
=======
	 *
>>>>>>> 1e39991356b9cbed695fbe02926e013c9afdd003
	 * @since 2.8
	 * @return void
	 */
	public function save_admin( $data ) {

	}

	/**
	 * Get our registered notification types
	 * 
	 * @access public
	 * @since 2.8
	 * @return void
	 */
	public function get_types() {

<<<<<<< HEAD
	}
	
}
=======
}
>>>>>>> 1e39991356b9cbed695fbe02926e013c9afdd003
