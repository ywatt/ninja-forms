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
		global $pagenow;

		add_action( 'admin_init', array( $this, 'register_tab' ) );
		
		if ( 'admin.php' == $pagenow && isset ( $_REQUEST['page'] ) && $_REQUEST['page'] == 'ninja-forms' && isset ( $_REQUEST['tab'] ) && $_REQUEST['tab'] == 'notifications' ) {
			add_action( 'admin_init', array( $this, 'add_js' ) );
			add_action( 'admin_init', array( $this, 'add_css' ) );
			add_action( 'admin_init', array( $this, 'bulk_actions' ) );
			add_action( 'admin_init', array( $this, 'duplicate_notification' ) );
		}

		add_action( 'wp_ajax_nf_delete_notification', array( $this, 'delete_notification' ) );
		add_action( 'wp_ajax_nf_activate_notification', array( $this, 'activate_notification' ) );
		add_action( 'wp_ajax_nf_deactivate_notification', array( $this, 'deactivate_notification' ) );
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
	 * Enqueue JS
	 * 
	 * @access public
	 * @since 2.8
	 * @return void
	 */
	public function add_js() {
		$form_id = isset ( $_REQUEST['form_id'] ) ? $_REQUEST['form_id'] : '';
		if ( empty ( $form_id ) )
			return false;

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

		wp_enqueue_script( 'nf-tokenize',
		NF_PLUGIN_URL . 'assets/js/' . $src .'/bootstrap-tokenfield' . $suffix . '.js',
		array( 'jquery', 'jquery-ui-autocomplete' ) );

		$all_fields = Ninja_Forms()->form( $form_id )->fields;
		$search_fields = array();
		$fields = array();

		foreach( $all_fields as $field_id => $field ) {
			$label = strip_tags( nf_get_field_admin_label( $field_id ) );

			$fields[] = array( 'field_id' => $field_id, 'label' => $label );

			if ( $field['type'] == '_text' && isset ( $field['data']['email'] ) && $field['data']['email'] == 1 ) {
				$search_fields['email'][] = array( 'value' => $field_id, 'label' => $label . ' - ID: ' . $field_id );
			} else if ( $field['type'] == '_text' && isset ( $field['data']['first_name'] ) && $field['data']['first_name'] == 1 ) {
				$search_fields['name'][] = array( 'value' => $field_id, 'label' => $label . ' - ID: ' . $field_id );
			} else if ( $field['type'] == '_text' && isset ( $field['data']['last_name'] ) && $field['data']['last_name'] == 1 ) {
				$search_fields['name'][] = array( 'value' => $field_id, 'label' => $label . ' - ID: ' . $field_id );
			}
		}

		$js_vars = array( 
			'activate' 		=> __( 'Activate', 'ninja-forms' ), 
			'deactivate' 	=> __( 'Deactivate', 'ninja-forms' ),
			'search_fields' => $search_fields,
			'tokens'		=> array(),
			'fields'		=> $fields,
		);

		wp_localize_script( 'nf-notifications', 'nf_notifications', $js_vars );
	
	}

	/**
	 * Enqueue CSS
	 * 
	 * @access public
	 * @since 2.8
	 * @return void
	 */
	public function add_css() {
		wp_enqueue_style( 'nf-notifications',
		NF_PLUGIN_URL . 'assets/css/notifications.css' );		

		wp_enqueue_style( 'nf-tokenize',
		NF_PLUGIN_URL . 'assets/css/bootstrap-tokenfield.css' );

		// wp_enqueue_style( 'nf-bootstrap',
		// 'http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css' );
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
			$n_id = $this->create( $form_id );
		} else {
			$type = Ninja_Forms()->notification( $n_id )->type;
		}

		$data = Ninja_Forms()->notification_types->$type->save_admin( $n_id, $data );

		foreach ( $settings as $meta_key => $meta_value ) {
			nf_update_object_meta( $n_id, $meta_key, $meta_value );
		}

		if ( 'new' == $n_id ) {
			wp_redirect( remove_query_arg( array( 'notification-action' ) ) );
			die();			
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

	/**
	 * Delete a notification.
	 * Hooked into the ajax action for nf_delete_notification
	 * 
	 * @access public
	 * @since 2.8
	 * @return void
	 */
	public function delete_notification() {
		$n_id = $_REQUEST['n_id'];
		Ninja_Forms()->notification( $n_id )->delete();
	}

	/**
	 * Activate a notification.
	 * Hooked into the ajax action for nf_activate_notification
	 * 
	 * @access public
	 * @since 2.8
	 * @return void
	 */
	public function activate_notification() {
		$n_id = $_REQUEST['n_id'];
		Ninja_Forms()->notification( $n_id )->activate();
	}

	/**
	 * Deactivate a notification.
	 * Hooked into the ajax action for nf_deactivate_notification
	 * 
	 * @access public
	 * @since 2.8
	 * @return void
	 */
	public function deactivate_notification() {
		$n_id = $_REQUEST['n_id'];
		Ninja_Forms()->notification( $n_id )->deactivate();
	}

	/**
	 * Duplicate our notification
	 * 
	 * @access public
	 * @since 2.8
	 * @return void
	 */
	public function duplicate_notification() {
		if ( ! isset ( $_REQUEST['notification-action'] ) || $_REQUEST['notification-action'] != 'duplicate' )
			return false;

		$n_id = isset ( $_REQUEST['id'] ) ? $_REQUEST['id'] : '';
		
		// Bail if we don't have an ID.
		if ( '' === $n_id )
			return false;

		Ninja_Forms()->notification( $n_id )->duplicate();

		wp_redirect( remove_query_arg( array( 'notification-action' ) ) );
		die();
	}

	/**
	 * Create a new notification
	 * 
	 * @access public
	 * @since 2.8
	 * @return int $n_id
	 */
	public function create( $form_id = '' ) {
		// Bail if we don't have a form_id
		if ( '' == $form_id )
			return false;

		$n_id = nf_insert_notification( $form_id );

		// Activate our new notification
		Ninja_Forms()->notification( $n_id )->activate();

		return $n_id;
	}

	/**
	 * Handle bulk actions
	 * 
	 * @access public
	 * @since 2.8
	 * @return void
	 */
	public function bulk_actions() {
		$action = '';

		if ( isset( $_REQUEST['action2'] ) && -1 != $_REQUEST['action2'] )
			$action = $_REQUEST['action2'];	
				
		if ( isset( $_REQUEST['action'] ) && -1 != $_REQUEST['action'] )
			$action = $_REQUEST['action'];

		$n_ids = isset ( $_REQUEST['notification'] ) ? $_REQUEST['notification'] : '';

		if ( ! is_array( $n_ids ) || empty( $n_ids ) )
			return false;

        if( 'delete' === $action ) {
        	foreach ( $n_ids as $n_id ) {
                Ninja_Forms()->notification( $n_id )->delete();
            }
        } else if ( 'activate' === $action ) {
        	foreach ( $n_ids as $n_id ) {
        		Ninja_Forms()->notification( $n_id )->activate();
        	}
        } else if ( 'deactivate' === $action ) {
        	foreach ( $n_ids as $n_id ) {
        		Ninja_Forms()->notification( $n_id )->deactivate();
        	}
        }

        wp_redirect( remove_query_arg( array( 'notification', '_wpnonce', '_wp_http_referer', 'action', 'action2' ) ) );
        die();

	}

}