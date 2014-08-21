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
	 * 
	 * @access public
	 *
	 * @since 2.8
	 */
	function __construct() {
		add_action( 'admin_init', array( $this, 'register_tab' ) );
		add_action( 'admin_init', array( $this, 'add_js' ) );
	}

	/**
	 * Register our setting tab.
	 * 
	 * @access public
	 *
	 * @since 2.8
	 * @return void
	 */
	public function register_tab() {
		$form_id = isset ( $_REQUEST['form_id'] ) ? $_REQUEST['form_id'] : '';
		$action = isset ( $_REQUEST['notification-action'] ) ? $_REQUEST['notification-action'] : '';
		if ( 'edit' == $action || 'new' == $action ) {
			$output_form = true;
		} else {
			$output_form = false;
		}

		$args = array(
			'name' => __( 'Notifications', 'ninja-forms' ),
			'page' => 'ninja-forms',
			'display_function' => array( $this, 'output_admin' ),
			'save_function' => array( $this, 'save_admin' ),
			'disable_no_form_id' => true,
			'show_save' => true,
			'tab_reload' => false,
			'output_form' => $output_form,
		);

		ninja_forms_register_tab( 'notifications', $args );
	}

	/**
	 * Output JS
	 * 
	 * @access public
	 * @since 2.8
	 * @return void
	 */
	public function add_js() {
		global $pagenow;
		if ( 'admin.php' == $pagenow && isset ( $_REQUEST['page'] ) && $_REQUEST['page'] == 'ninja-forms' && isset ( $_REQUEST['tab'] ) && $_REQUEST['tab'] == 'notifications' ) {
			if ( defined( 'NINJA_FORMS_JS_DEBUG' ) && NINJA_FORMS_JS_DEBUG ) {
				$suffix = '';
				$src = 'dev';
			} else {
				$suffix = '.min';
				$src = 'min';
			}
			wp_enqueue_script( 'nf-notifications',
			NF_PLUGIN_URL . 'assets/js/' . $src .'/notifications' . $suffix . '.js',
			array( 'jquery' ) );
		}
	}

	/**
	 * Output our notifications admin.
	 * 
	 * @access public
	 *
	 * @since 2.8
	 * @return void
	 */
	public function output_admin() {
		$action = isset ( $_REQUEST['notification-action'] ) ? $_REQUEST['notification-action'] : '';

		?>
		<div class="wrap">
			<?php
		if ( '' == $action ) {
			?>
			<h2><?php _e( 'Notifications', 'ninja-forms' ); ?> <a href="<?php echo add_query_arg( array( 'notification-action' => 'new' ) ); ?>" class="add-new-h2"><?php _e( 'Add New', 'ninja-forms' );?></a></h2>

	        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
	      	 <form id="forms-filter" method="get">
	            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
	            <input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
	            <input type="hidden" name="tab" value="<?php echo $_REQUEST['tab']; ?>" />
	            <input type="hidden" name="form_id" value="<?php echo $_REQUEST['form_id']; ?>" />
				<?php
				//Create an instance of our package class...
			    $nf_all_forms = new NF_Notifications_List_Table();
			    //Fetch, prepare, sort, and filter our data...
			    $nf_all_forms->prepare_items();
	 			// Now we can render the completed list table
	            $nf_all_forms->display();
	            ?>
        	</form>
            <?php
		} else if ( 'edit' == $action ) {
			$id = isset ( $_REQUEST['id'] ) ? $_REQUEST['id'] : '';
			if ( '' == $id )
				return false;

			$this_type = Ninja_Forms()->notification( $id )->type;
			?>
			<h2><?php _e( 'Edit Notification', 'ninja-forms' ); ?> - ID <?php echo $_REQUEST['id']; ?> <a href="<?php echo remove_query_arg( array( 'notification-action', 'id' ) );?>" class="button-secondary"><?php _e( 'Back To List', 'ninja-forms' );?></a></h2>

			<input type="hidden" id="notification_id" name="notification_id" value="<?php echo $id; ?>" />
			<table class="form-table">
				<tbody id="notification-main">
					<tr>
						<th scope="row"><label for="setting-name"><?php _e( 'Name', 'ninja-forms' ); ?></label></th>
						<td><input name="settings[name]" type="text" id="settings-name" value="<?php echo nf_get_object_meta_value( $id, 'name' ); ?>" class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="type"><?php _e( 'Type', 'ninja-forms' ); ?></label></th>
						<td>
							<select name="settings[type]" id="settings-type">
								<?php
								foreach ( $this->get_types() as $slug => $nicename ) {
									?>
									<option value="<?php echo $slug; ?>" <?php selected ( nf_get_object_meta_value( $id, 'type' ), $slug ); ?>><?php echo $nicename; ?></option>
									<?php
								}
								?>						
							</select>
						</td>
					</tr>

				</tbody>
				<?php
				$types = $this->get_types();
				foreach ( $types as $slug => $nicename ) {
					if ( $this_type == $slug ) {
						$display = '';
					} else {
						$display = 'display:none;';
					}
					?>
					<tbody id="notification-<?php echo $slug; ?>" class="notification-type" style="<?php echo $display;?>">
						<?php
							// Call our type edit screen.
							Ninja_Forms()->notification_types->$slug->edit_screen( $id );
						?>
					</tbody>
					<?php
				}
				?>			
			</table>
			<?php
		} else if ( 'new' == $action ) {
			$this_type = 'email';
			?>
			<h2><?php _e( 'New Notification', 'ninja-forms' ); ?> <a href="<?php echo remove_query_arg( array( 'notification-action', 'id' ) );?>" class="button-secondary"><?php _e( 'Back To List', 'ninja-forms' );?></a></h2>

			<input type="hidden" name="notification_id" value="new" />
			<table class="form-table">
				<tbody id="notification-main">
					<tr>
						<th scope="row"><label for="setting-name"><?php _e( 'Name', 'ninja-forms' ); ?></label></th>
						<td><input name="settings[name]" type="text" id="settings-name" value="" class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="type"><?php _e( 'Type', 'ninja-forms' ); ?></label></th>
						<td>
							<select name="settings[type]" id="settings-type">
								<?php
								foreach ( $this->get_types() as $slug => $nicename ) {
									?>
									<option value="<?php echo $slug; ?>"><?php echo $nicename; ?></option>
									<?php
								}
								?>						
							</select>
						</td>
					</tr>

				</tbody>
				<?php
				$types = $this->get_types();
				foreach ( $types as $slug => $nicename ) {
					if ( $this_type == $slug ) {
						$display = '';
					} else {
						$display = 'display:none;';
					}
					?>
					<tbody id="notification-<?php echo $slug; ?>" class="notification-type" style="<?php echo $display;?>">
						<?php
							// Call our type edit screen.
							Ninja_Forms()->notification_types->$slug->edit_screen();
						?>
					</tbody>
					<?php
				}
				?>			
			</table>
			<?php
		}

	    ?>
    	</div>
    	<?php
	}

	/**
	 * Save our notifications admin.
	 * 
	 * @access public
	 *
	 * @since 2.8
	 * @return void
	 */
	public function save_admin( $form_id, $data ) {
		if ( ! isset ( $data['notification_id'] ) || empty ( $data['notification_id'] ) )
			return false;

		$n_id = $data['notification_id'];
		$settings = $data['settings'];

		if ( 'new' == $n_id ) {
			$type = $settings['type'];
			$n_id = nf_insert_notification( $form_id );
		} else {
			$type = Ninja_Forms()->notification( $n_id )->type;
		}

		$data = Ninja_Forms()->notification_types->$type->save_admin( $n_id, $data );

		foreach ( $settings as $meta_key => $meta_value ) {
			nf_update_object_meta( $n_id, $meta_key, $meta_value );
		}		
	}

	/**
	 * Get our registered notification types
	 * 
	 * @access public
	 * @since 2.8
	 * @return array $types
	 */
	public function get_types() {
		$types = array();
		foreach ( Ninja_Forms()->registered_notification_types as $slug => $type ) {
			$types[ $slug ] = $type['nicename'];
		}
		return $types;
	}

}