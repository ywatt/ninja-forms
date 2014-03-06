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

			$( notifications.models ).each( function() {
				var settings = {
					id: this.get( 'id' ),
					name: this.settings.get( 'name' ).get( 'current_value' ),
					active: this.settings.get( 'active' ).get( 'current_value' ),
					type: this.settings.get( 'type' ).get( 'current_value' ),
					date_updated: this.settings.get( 'date_updated' ).get( 'current_value' )
				};

				nfnx.notificationTrView.render( '#notification_tr_' + this.get( 'id' ), settings );
			});

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
		notifications.create({},
			{
				success: function( response ) {
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
							'current_value': ''
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
					nfnx.notificationsTableView.render();
					$( '#notification_single_' + response.get( 'id' ) ).click();
					$( document ).on( 'nf_settings_rendered.new', function() {
						$( '#name' ).focus();
						$( document ).off( 'nf_settings_rendered.new' );
					});
				}
			}
		);
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