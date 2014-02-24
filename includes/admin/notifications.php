<?php
/**
 * Register all of our notifications settings.
 * 
 */

function nf_notification_settings() {
	$args = array(
		'scope' => 'form',
		'id' => 'notifications',
		'label' => 'Notifications',
		'priority' => 'default',
		'desc' => __( 'This is where all form notifications are managed.', 'ninja-forms' ),
		'display_link' => true,
		'template' => 
			'<div id="" class="tablenav top">
				<div class="alignleft" style="margin-right:15px">
					<a href="#" class="button-primary">'.__( 'Add New', 'ninja-forms' ).'</a>
				</div>
				<div class="alignleft actions">
					<select id="" class="" name="bulk_action">
						<option value="">'.__( 'Bulk Actions', 'ninja-forms' ).'</option>
						<option value="activate">'.__( 'Activate', 'ninja-forms' ).'</option>
						<option value="deactivate">'.__( 'Deactivate', 'ninja-forms' ).'</option>
						<option value="delete">'.__( 'Delete', 'ninja-forms' ).'</option>
					</select>
				</div>				
				<div class="alignleft actions">
					<select id="" class="" name="notification_type">
						<option value="">'.__( 'All Types', 'ninja-forms' ).'</option>
						<option value="email">'.__( 'Email', 'ninja-forms' ).'</option>
						<option value="redirect">'.__( 'URL Redirect', 'ninja-forms' ).'</option>
						<option value="success_message">'.__( 'Success Message', 'ninja-forms' ).'</option>
						<option value="pushover">'.__( 'Pushover', 'ninja-forms' ).'</option>
					</select>
				</div>
			</div>
			<table class="wp-list-table widefat fixed posts">
				<thead>
					<tr>
						<th class="check-column"><input type="checkbox" id="" class="ninja-forms-select-all" title="ninja-forms-bulk-action"></th>
						<th>'.__( 'Name', 'ninja-forms' ).'</th>
						<th>'.__( 'Type', 'ninja-forms' ).'</th>
						<th>'.__( 'Date Updated', 'ninja-forms' ).'</th>
					</tr>
				</thead>
				<tbody>
				<% _.each(settings, function(setting){ %>
					<tr>
						<th scope="row" class="check-column">
							<input type="checkbox" id="" name="notification_ids[]" value="" class="ninja-forms-bulk-action">
						</th>

						<td class="post-title page-title column-title">
							<strong>
								<a href="#notification_single" class="media-menu-item" id="notification_single" title="" data-notification-id="<%= setting.get( "id" ) %>" data-object-id="<%= setting.get( "id" ) %>" data-scope="notification" data-group="notification_single"><%= setting.get( "name" ) %></a>
							</strong>
							<div class="row-actions">
								<span class="activate"><a href="">'.__( 'Activate', 'ninja-forms' ).'</a> | </span>
								<span class="trash"><a class="ninja-forms-delete-form" title="'.__( 'Delete this notification', 'ninja-forms' ).'" href="#" id="">'.__( 'Delete', 'ninja-forms' ).'</a> | </span>
								<span class="export"><a href="" title="'.__( 'Export Form', 'ninja-forms' ).'">'.__( 'Export', 'ninja-forms' ).'</a> | </span>
								<span class="duplicate"><a href="" title="'.__( 'Duplicate Form', 'ninja-forms' ).'">'.__( 'Duplicate', 'ninja-forms' ).'</a></span>
							</div>
						</td>
						<td>
							<%= setting.get( "type" ) %>
						</td>
						<td>
							<%= setting.get( "date_updated" ) %>
						</td>
					</tr>
					<% }); %>
				</tbody>
				<tfoot>
					<tr>
						<th class="check-column"><input type="checkbox" id="" class="ninja-forms-select-all" title="ninja-forms-bulk-action"></th>
						<th>'.__( 'Name', 'ninja-forms' ).'</th>
						<th>'.__( 'Type', 'ninja-forms' ).'</th>
						<th>'.__( 'Date Updated', 'ninja-forms' ).'</th>
					</tr>
				</tfoot>
			</table>',
	);

	Ninja_Forms()->admin_settings->register_settings_group( $args );

	// Add a filter for our all-notifications table
	add_filter( 'nf_rest_get_array', 'nf_notification_rest_filter', 10, 3 );

	$args = array(
		'scope' => 'notification',
		'id' => 'notification_single',
		'label' => 'Notifications',
		'display_link' => false,
		'priority' => 'default',
		'desc' => __( 'This is where all form notifications are managed.', 'ninja-forms' ),
		'settings' => array(
			'type' => array(
				'type' => 'dropdown',
				'label' => __( 'Type', 'ninja-forms' ),
				'options' => array(
					array('name' => __( 'Email', 'ninja-forms' ), 'value' => 'email'),
					array('name' => __( 'Success Message', 'ninja-forms' ), 'value' => 'success_message'),
					array('name' => __( 'Pushover', 'ninja-forms' ), 'value' => 'pushover'),
					array('name' => __( 'Text Message', 'ninja-forms' ), 'value' => 'text_message'),
				),
				'class' => '',
				'desc' => __( 'What kind of notification would you like to create?', 'ninja-forms' ),
			),
			'name' => array(
				'type' => 'text',
				'label' => __( 'Name', 'ninja-forms' ),
				'class' => 'widefat',
				'desc' => __( 'How would you like to identify this notification?', 'ninja-forms' ),
			),
			'mailto' => array(
				'type' => 'radio',
				'label' => __( 'Send To', 'ninja-forms' ),
				'options' => array(
					array('name' => __( 'Enter Email', 'ninja-forms' ), 'value' => 'manual_email'),
					array('name' => __( 'Select a Field', 'ninja-forms' ), 'value' => 'field_value'),
					array('name' => __( 'Configure Routing', 'ninja-forms' ), 'value' => 'configure_routing'),
				),
				'class' => '',
				'desc' => __( 'What kind of notification would you like to create?', 'ninja-forms' ),
			),
		),
	);

	Ninja_Forms()->admin_settings->register_settings_group( $args );	
}



/**
 * This is our filter for getting all the notifications for a form.
 * 
 * @access public
 * @param array $args
 * @param int $object_id
 * @param string $group
 * @since 3.0
 */

function nf_notification_rest_filter( $args, $object_id, $group ) {
	// Bail if we aren't filtering a notification.
	if ( $group != 'notifications' )
		return $args;

	$notifications = nf_get_notifications_by_form_id( $object_id );
	
	$tmp_array = array();
	$x = 0;
	foreach( $notifications as $id => $settings ) {
		$tmp_array[$x]['id'] = $id;
		foreach( $settings as $key => $value ) {
			$tmp_array[$x][$key] = $value;
		}
		$x++;
	}

	return $tmp_array;
}