<?php
/**
 * Register all of our notifications settings.
 * 
 */


// Register our nofitication Table View.
function nf_notification_settings() {
	$args = array(
		'scope' => 'form',
		'id' => 'notifications',
		'label' => 'Notifications',
		'priority' => 'default',
		'desc' => __( 'This is where all form notifications are managed.', 'ninja-forms' ),
		'display_link' => true,
		'custom_backbone' => true,
		'template' => 
			'<div id="" class="tablenav top">
				<div class="alignleft" style="margin-right:15px">
					<a href="#" class="button-primary" id="nf_new_notification">'.__( 'Add New', 'ninja-forms' ).'</a>
				</div>
				<div class="alignleft actions">
					<select id="nf_notifications_bulk_actions" class="" name="bulk_action">
						<option value="">'.__( 'Bulk Actions', 'ninja-forms' ).'</option>
						<option value="activate">'.__( 'Activate', 'ninja-forms' ).'</option>
						<option value="deactivate">'.__( 'Deactivate', 'ninja-forms' ).'</option>
						<option value="delete">'.__( 'Delete', 'ninja-forms' ).'</option>
					</select>
				</div>				
				<div class="alignleft actions">
					<select id="nf_notification_type" class="" name="">
						<option value="">'.__( 'All Types', 'ninja-forms' ).'</option>
						<option value="email">'.__( 'Email', 'ninja-forms' ).'</option>
						<option value="redirect">'.__( 'URL Redirect', 'ninja-forms' ).'</option>
						<option value="success_message">'.__( 'Success Message', 'ninja-forms' ).'</option>
						<option value="pushover">'.__( 'Pushover', 'ninja-forms' ).'</option>
					</select>
					<span class="spinner"></span>
				</div>
			</div>
			<table class="wp-list-table widefat fixed posts">
				<thead>
					<tr>
						<th class="check-column"><input type="checkbox" id="" class="nf-notifications-select-all" title="ninja-forms-bulk-action"></th>
						
						<th>'.__( 'Name', 'ninja-forms' ).'</th>
						<th>'.__( 'Type', 'ninja-forms' ).'</th>
						<th>'.__( 'Date Updated', 'ninja-forms' ).'</th>
					</tr>
				</thead>
				<tbody id="nf_notification_tbody"></tbody>
				<tfoot>
					<tr>
						<th class="check-column"><input type="checkbox" id="" class="nf-notifications-select-all" title="ninja-forms-bulk-action"></th>
						
						<th>'.__( 'Name', 'ninja-forms' ).'</th>
						<th>'.__( 'Type', 'ninja-forms' ).'</th>
						<th>'.__( 'Date Updated', 'ninja-forms' ).'</th>
					</tr>
				</tfoot>
			</table>',
	);

	Ninja_Forms()->admin_settings->register_settings_group( $args );

	// Register our notification Table Body View.
	$args = array(
		'scope' => 'form',
		'id' => 'notifications_tbody',
		'label' => '',
		'priority' => '',
		'desc' => '',
		'display_link' => false,
		'custom_backbone' => true,
		'template' => 
			'<%
			if ( notifications.length > 0 ) {
				_.each(notifications, function(notification){
					if ( notification.settings.get( "active" ).get( "current_value" ) == 1 ) {
						var active_class = "active";
					} else {
						var active_class = "inactive";
					}
					%>
					<tr id="notification_tr_<%= notification.get( "id" ) %>" class="<%= active_class %>"></tr>
				<% }); 
			} else {
				%>
				<tr>
					<td></td>
					<td>' . __( 'No notifications found.', 'ninja-forms' ) .'</td>
				</tr>
			<%
			}
			%>',
	);

	Ninja_Forms()->admin_settings->register_settings_group( $args );

	// Register our notification Table Row View
	$args = array(
		'scope' => 'form',
		'id' => 'notifications_tr',
		'label' => '',
		'priority' => '',
		'desc' => '',
		'display_link' => false,
		'custom_backbone' => true,
		'template' => 
			'<%
			if ( settings.active == 1 ) {
				var active = "' . __( 'Deactivate', 'ninja-forms' ) . '";
			} else {
				var active = "' . __( 'Active', 'ninja-forms' ). '";
			}
			%>

			<th scope="row" class="check-column">
				<input type="checkbox" id="" name="" value="<%= settings.id %>" class="nf-notifications-bulk-action" data-notification-id="<%= settings.id %>">
			</th>
			<td class="post-title page-title column-title">
				<strong>
					<a href="#notification_single" class="media-menu-item notification-single" id="notification_single_<%= settings.id %>" title="" data-notification-id="<%= settings.id %>" data-object-id="<%= settings.id %>" data-scope="notification" data-group="notification_single"><%= settings.name %></a>
				</strong>
				<div class="row-actions">
					<span class="activate"><a href="" class="nf-activate-notification" data-notification-id="<%= settings.id %>"><%= active %></a> | </span>
					<span class="trash"><a class="nf-delete-notification" title="'.__( 'Delete this notification', 'ninja-forms' ).'" href="#" id="" data-notification-id="<%= settings.id %>" >'.__( 'Delete', 'ninja-forms' ).'</a> | </span>
					<span class="export"><a href="" title="'.__( 'Export Form', 'ninja-forms' ).'">'.__( 'Export', 'ninja-forms' ).'</a> | </span>
					<span class="duplicate"><a href="" title="'.__( 'Duplicate Form', 'ninja-forms' ).'">'.__( 'Duplicate', 'ninja-forms' ).'</a></span>
				</div>
			</td>
			<td>
				<%= settings.type %>
			</td>
			<td>
				<%= settings.date_updated %>
			</td>',
	);

	Ninja_Forms()->admin_settings->register_settings_group( $args );

	// Add a filter for our all-notifications table
	add_filter( 'nf_rest_get_array', 'nf_notification_rest_filter', 10, 3 );

	// Register our notification Single View
	$args = array(
		'scope' => 'notification',
		'id' => 'notification_single',
		'label' => 'Notifications',
		'display_link' => false,
		'priority' => 'default',
		'desc' => __( 'This is where all form notifications are managed.', 'ninja-forms' ),
		'settings' => array(
			'name' => array(
				'type' => 'text',
				'label' => __( 'Name', 'ninja-forms' ),
				'class' => 'widefat notification-name',
				'desc' => __( 'How would you like to identify this notification?', 'ninja-forms' ),
			),			
			'type' => array(
				'type' => 'dropdown',
				'label' => __( 'Type', 'ninja-forms' ),
				'options' => array(
					array('name' => __( '- Select One', 'ninja-forms' ), 'value' => ''),
					array('name' => __( 'Email', 'ninja-forms' ), 'value' => 'email'),
					array('name' => __( 'Success Message', 'ninja-forms' ), 'value' => 'success_message'),
					array('name' => __( 'Pushover', 'ninja-forms' ), 'value' => 'pushover'),
					array('name' => __( 'Text Message', 'ninja-forms' ), 'value' => 'text_message'),
				),
				'class' => '',
				'desc' => __( 'What kind of notification would you like to create?', 'ninja-forms' ),
			),
			'mailto' => array(
				'type' => 'radio',
				'label' => __( 'Send To', 'ninja-forms' ),
				'options' => array(
					array( 'name' => __( 'Enter Email', 'ninja-forms' ), 'value' => 'manual_email' ),
					array( 'name' => __( 'Select a Field', 'ninja-forms' ), 'value' => 'field_value' ),
				),
				'class' => '',
				'desc' => __( 'What kind of notification would you like to create?', 'ninja-forms' ),
				'depend' => array(
					'type' => 'email',
				),
			),
			'email' => array(
				'type' => 'text',
				'label' => '',
				'class' => '',
				'desc' => __( 'Enter an email address or a comma-separted list of addresses', 'ninja-forms' ),
				'depend' => array(
					'type' => 'email',
					'mailto' => 'manual_email',
				),
			),
			'email_field' => array(
				'type' => 'dropdown',
				'label' => '',
				'options' => array(
					array( 'name' => 'Your Email', 'value' => 34 ),
					array( 'name' => 'Another Email', 'value' => 45 ),
				),
				'desc' => __( 'Select an email field', 'ninja-forms' ),
				'depend' => array(
					'type' => 'email',
					'mailto' => 'field_value',
				),
			),
			'from' => array(
				'type' => 'text',
				'label' => __( 'From Address', 'ninja-forms' ),
				'desc' => __( 'Address that this email appears to be from', 'ninja-forms' ),
				'depend' => array(
					'type' => 'email',
				),
			),			
			'reply_to' => array(
				'type' => 'text',
				'label' => __( 'Reply-To Address', 'ninja-forms' ),
				'desc' => __( 'Address used when email recepients click "reply"', 'ninja-forms' ),
				'depend' => array(
					'type' => 'email',
				),
			),			
			'email_msg' => array(
				'type' => 'rte',
				'label' => __( 'Email Message', 'ninja-forms' ),
				'desc' => '',
				'depend' => array(
					'type' => 'email',
				),
			),
		),
	);
	
	$args = apply_filters( 'nf_notification_single_args', $args );

	Ninja_Forms()->admin_settings->register_settings_group( $args );	

	// Enqueue our notification-specific JS if we are on the edit-forms page.
	if ( isset( $_REQUEST['page'] ) and $_REQUEST['page'] == 'ninja-forms-edit' )
		nf_notification_js();
}

/**
 * Enqueue our notification JS
 * 
 * @since 3.0
 * @return void
 */

function nf_notification_js() {
	wp_enqueue_script( 'nf-notifications',
		NF_PLUGIN_URL .'js/dev/notifications-admin.js',
		array( 'nf-admin' ) );	
}


/**
 * This is our filter for getting all the notifications for a form.
 * 
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
	
	// Check to see if we're trying to filter the notifications
	if ( isset( $_REQUEST['type'] ) and $_REQUEST['type'] != '' ) {
		$type = $_REQUEST['type'];
		if ( is_array( $notifications ) ) {
			$tmp_array = array();
			foreach( $notifications as $id => $n ) {
				if ( $n['type'] == $type ) {
					$tmp_array[ $id ] = $n;
				}
			}
			$notifications = $tmp_array;
		}
	} else {
		$type = '';
	}
	
	$tmp_array = array();
	$x = 0;
	foreach( $notifications as $object_id => $settings ) {
		$tmp_array[$x]['id'] = $object_id;
		foreach( $settings as $meta_key => $current_value ) {
			$setting['id'] = $meta_key;
            $setting['current_value'] = $current_value;
            $setting['meta_key'] = $meta_key;		
            $setting['object_id'] = $object_id;		
            $tmp_array[$x]['nf_request_notification_type'] = $type;
			$tmp_array[$x]['settings'][] = $setting;
		}
		$x++;
	}

	return $tmp_array;
}