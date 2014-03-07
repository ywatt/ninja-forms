// let's create a namespace first
var nfnx = nfnx || {};

jQuery(document).ready(function($) {
	var savedNoticeTimeout = '';

	nfnx.notificationSetting = Backbone.Model.extend({
		urlRoot: nf_rest_url + '&nf_rest=rest_api',

		initialize : function(){
			this.setting_id = this.get( 'id' );
			this.meta_key = this.get( 'meta_key' );
			this.current_value = this.get( 'current_value' );
			this.on( 'change', this.save );
			this.on( 'add', this.save );
		},

		serverAttrs: ['current_value', 'id', 'object_id', 'meta_key'],

		save: function (attrs, options) {
			attrs = attrs || this.toJSON();
		    options = options || {};
		    attrs = attrs.attributes;
		    // If model defines serverAttrs, replace attrs with trimmed version
		    if (this.serverAttrs) attrs = _.pick(attrs, this.serverAttrs);

		    // Move attrs to options
		    options.attrs = attrs;

		    // Call super with attrs moved to options
		    Backbone.Model.prototype.save.call(this, attrs, options);
		    // Re-render our table row when the activate/deactivate is clicked.
			var settings = {
					id: attrs.object_id,
					name: notifications.get( attrs.object_id ).settings.get( 'name' ).get( 'current_value' ),
					active: notifications.get( attrs.object_id ).settings.get( 'active' ).get( 'current_value' ),
					type: notifications.get( attrs.object_id ).settings.get( 'type' ).get( 'current_value' ),
					date_updated: notifications.get( attrs.object_id ).settings.get( 'date_updated' ).get( 'current_value' )
				};
		    nfnx.notificationTrView.render( '#notification_tr_' + attrs.object_id, settings );
		}
	});

	nfnx.notificationSettings = Backbone.Collection.extend({ model : nfnx.notificationSetting });

	nfnx.notification = Backbone.Model.extend({
		initialize : function(){
			this.settings = new nfnx.notificationSettings( this.get( 'settings' ) );
			this.settings.parent = this;
			this.notificationId = this.get( 'object_id' );
    	},
		defaults: {
			object_type: 'notification',
			object_id: object_id
		}
	});

	nfnx.notifications = Backbone.Collection.extend({
		model : nfnx.notification,
		url: function() {
			if ( typeof $( '#nf_notification_type' ).val() !== 'undefined' ) {
				var type = $( '#nf_notification_type' ).val();
			} else {
				var type = '';
			}
			return nf_rest_url + '&nf_rest=rest_api&type=' + type + '&del=';
		},
		parse : function(data){
		  return data;
		}
	});

	var notifications = new nfnx.notifications();
	// This is the main view for our notifications table.
	var NotificationTableView = Backbone.View.extend({

		el: '#nf-settings-content',

		template: '#tmpl-notifications',

		initialize: function(){
			this.collection.bind( 'reset', this.render, this );
		},

		render: function() {

			var content = _.template( jQuery( this.template ).html(), { notifications: notifications.models } );
			jQuery( this.el ).html( content );

			nfnx.notificationTrView = new NotificationTrView();
			//if ( typeof notifications.models[0].settings.get( 'name' ) !== 'undefined' ) {
				$( notifications.models ).each( function() {
					
					if ( typeof this.settings.get( 'name' ) !== 'undefined' ) {
						var name = this.settings.get( 'name' ).get( 'current_value' );
					} else {
						var name = '';
					}					

					if ( typeof this.settings.get( 'active' ) !== 'undefined' ) {
						var active = this.settings.get( 'active' ).get( 'current_value' );
					} else {
						var active = '';
					}					

					if ( typeof this.settings.get( 'type' ) !== 'undefined' ) {
						var type = this.settings.get( 'type' ).get( 'current_value' );
					} else {
						var type = '';
					}					

					if ( typeof this.settings.get( 'date_updated' ) !== 'undefined' ) {
						var date_updated = this.settings.get( 'date_updated' ).get( 'current_value' );
					} else {
						var date_updated = '';
					}

					var settings = {
						id: this.get( 'id' ),
						name: name,
						active: active,
						type: type,
						date_updated: date_updated
					};

					nfnx.notificationTrView.render( '#notification_tr_' + this.get( 'id' ), settings );
					$( document ).triggerHandler( 'nf_notification_table_rendered' );
				});
			//}

			jQuery( '.spinner' ).hide();
			
	        return this;
		},

		changeTemplate: function( template_id ) {
			this.template = template_id;
		},

		events: {
			'change #nf_notification_type': 'reload'
		},

		reload: function() {
			nf_fetch_all_notifications();
		}
	});

	// This is the view for each row of our notifications table.
	var NotificationTrView = Backbone.View.extend({

		render: function( el, settings ) {

			var content = _.template( jQuery( "#tmpl-notifications_tr" ).html(), { settings: settings } );
			jQuery( el ).html( content );

			jQuery( '.spinner' ).hide();
			$( document ).triggerHandler( 'nf_notification_tr_rendered' );
	        return this;
		}
	});

	$( document ).on( 'click', '#nf_notifications_btn', function(e) {
		nfnx.notificationsTableView = new NotificationTableView({ collection: notifications });
		nf_fetch_all_notifications();
		$( '.media-menu-item' ).removeClass( 'active' );
		$( this ).addClass( 'active' );
		$( '.nf-settings-title h1' ).html( this.innerHTML );		
	});

	// Get our data.
	function nf_fetch_all_notifications() {
		$( '.spinner' ).show();
		var object_id = $( '#nf_notifications_btn' ).data( 'object-id' );
		notifications.fetch({
			data: jQuery.param({ object_id: object_id, scope: 'form', group: 'notifications' }),
			reset: true,
			success: function() {
	           // var test = notifications;
	           // var settings = test.models[0].settings;
	           // console.log( settings.get( 'name' ) );
			},
			error: function() {
				console.log('failed to get!');
			}
		});
	}

	// Handle our activation/deactivation button
	$( document ).on( 'click', '.nf-activate-notification', function(e) {
		e.preventDefault();
		$( '.spinner' ).show();
		var id = $( this ).data( 'notification-id' );
		var settings = notifications.get( id ).settings;
		var active = settings.get( "active" );
		if ( active.get( "current_value" ) == 1 ) {
			active.set( "current_value", 0 );
		} else {
			active.set( "current_value", 1 );
		}
	});

	$( document ).on( 'click', '.nf-delete-notification', function(e) {
		var del = confirm( commonL10n.warnDelete );
		if ( del ) {
			// Delete our notification model
			var tmp = notifications.get( $( this ).data( 'notification-id' ) );
			tmp.destroy({
				success: function() {
			 		// Reload our view.
					nf_fetch_all_notifications();
				}
			});
		}
	});

	$( document ).on( 'click', '#nf_new_notification', function(e) {
		e.preventDefault();
		$( '.spinner' ).show();
		if ( typeof $( '#nf_notification_type' ).val() !== 'undefined' ) {
			var type = $( '#nf_notification_type' ).val();
		} else {
			var type = '';
		}
		notifications.create({
			reset: false,
		},
			{
				success: function( response ) {
					response.settings.on( 'add', function( settings ) {
						if ( settings.get('id') == 'active' ) {
							response.set( 'empty', false );
							nfnx.notificationsTableView.render();
						}
					});
					response.settings.add([
						{
							'id': 'name',
							'object_id': response.get( 'id' ),
							'meta_key': 'name',
							'current_value': 'Untitled'
						},
						{
							'id': 'type',
							'object_id': response.get( 'id' ),
							'meta_key': 'type',
							'current_value': type
						},
						{
							'id': 'date_updated',
							'object_id': response.get( 'id' ),
							'meta_key': 'date_updated',
							'current_value': '2014-02-24'
						},
						{
							'id': 'active',
							'object_id': response.get( 'id' ),
							'meta_key': 'active',
							'current_value': 0
						}
					]);

					$( document ).on( 'nf_notification_table_rendered.new', function() {
						$( '#notification_single_' + response.get( 'id' ) ).click();
						$( document ).off( 'nf_notification_table_rendered.new' );
					});

					$( document ).on( 'nf_settings_rendered.new', function() {
						$( '#name' ).focus();
						$( document ).off( 'nf_settings_rendered.new' );
					});
				}
			}
		);
	});

	$( document ).on( 'change', '.nf-notifications-select-all', function() {
		$( '.nf-notifications-bulk-action' ).prop( 'checked', this.checked );
		$( '.nf-notifications-select-all' ).prop( 'checked', this.checked );
	});

	$( document ).on( 'change', '#nf_notifications_bulk_actions', function() {
		if ( this.value == 'delete' ) {
			var del = confirm( commonL10n.warnDelete );
			if ( del ) {
				var i = 0;
				$( '.nf-notifications-bulk-action:checked' ).each( function() {
					var id = $( this ).data( 'notification-id' );
					if ( this.checked && typeof id !== 'undefined' ) {
						// Delete our notification model
						var tmp = notifications.get( id );
						tmp.destroy({
							success: function() {
						 		// Reload our view if we're on our last notification.
						 		if ( i == ( $( '.nf-notifications-bulk-action:checked' ).length - 1 ) ) {
						 			nf_fetch_all_notifications();
						 		}
						 		i++;
							}
						});
					}
				});
			}
		} else if ( this.value !== '' ) {
			var val = this.value;
			$( '.nf-notifications-bulk-action' ).each( function() {
				var id = $( this ).data( 'notification-id' );
				if ( this.checked && typeof id !== 'undefined' ) {
					if ( val == 'activate' ) {
						var active = notifications.get( id ).settings.get( 'active' );
						active.set( 'current_value', 1 );
					} else if ( val == 'deactivate' ) {
						var active = notifications.get( id ).settings.get( 'active' );
						active.set( 'current_value', 0 );
					}
				}
			});			
		}
	});

	$( document ).on( 'click', '.notification-single', function() {
		$( document ).on( 'nf_settings_fetched.single', function() {
			$( '.media-menu-item' ).removeClass( 'active' );
			$( '#nf_notifications_btn' ).addClass( 'active' );
			var tmp = $( '.nf-settings-title' ).html();
			$( '.nf-settings-title' ).html( '<a href="#"><-Back</a>' + tmp );
			$( document ).off( 'nf_settings_fetched.single' );
		});
	});

}); //Document.ready();