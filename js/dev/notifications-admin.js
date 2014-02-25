jQuery(document).ready(function($) {

	var savedNoticeTimeout = '';

	var Notification = Backbone.Model.extend({
		urlRoot: function() {
			if ( typeof $( '#nf_notification_type' ).val() !== 'undefined' ) {
				var type = $( '#nf_notification_type' ).val();
			} else {
				var type = '';
			}
			return nf_rest_url + '&nf_rest=rest_api&type=' + type + '&del=';
		},

		defaults: {
			object_type: 'notification',
			object_id: object_id
		},

		initialize: function () {
	        // Define server attributes for this model
	        //this.on('destory', this.destroy );
	    }


	});

	var Notifications = Backbone.Collection.extend({
		url: function() {
			if ( typeof $( '#nf_notification_type' ).val() !== 'undefined' ) {
				var type = $( '#nf_notification_type' ).val();
			} else {
				var type = '';
			}
			return nf_rest_url + '&nf_rest=rest_api&type=' + type + '&del=';
		},
		model: Notification,
	});

	var notifications = new Notifications();

	var ContentView = Backbone.View.extend({

		el: '#nf-settings-content',

		template: '#tmpl-notifications',

		initialize: function(){
			this.collection.bind( 'reset', this.render, this );
		},

		render: function() {

			var content = _.template( jQuery( this.template ).html(), { notifications: notifications.models } );
			jQuery( this.el ).html( content );

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

	$( document ).on( 'click', '#nf_notifications_btn', function(e) {
		var notificationsView = new ContentView({ collection: notifications });
		nf_fetch_all_notifications();
	});

	// Get our data.
	function nf_fetch_all_notifications() {
		$( '.spinner' ).show();
		var object_id = $( '#nf_notifications_btn' ).data( 'object-id' );
		notifications.fetch({
			data: jQuery.param({ object_id: object_id, scope: 'form', group: 'notifications' }),
			reset: true,
			success: function() {
	            $( '.media-menu-item' ).removeClass( 'active' );
	            $( '#nf_notifications_btn' ).addClass( 'active' );
	            $( '.nf-settings-title h1' ).html( 'Notifications' );
	            $( document ).triggerHandler( 'notificationsFetched' );
			},
			error: function() {
				console.log('failed to get!');
			}
		});
	}

	$( document ).on( 'click', '#nf_new_notification', function(e) {
		e.preventDefault();
		if ( typeof $( '#nf_notification_type' ).val() !== 'undefined' ) {
			var type = $( '#nf_notification_type' ).val();
		} else {
			var type = '';
		}
		notifications.create({
				'name': 'untitled',
				'type': type,
			},
			{
				success: function(response) {
					var new_id = response.get( 'id' );
					nf_fetch_all_notifications();
					$( document ).on( 'notificationsFetched.new', function(e) {
						$( '#notification_single_' + new_id ).click();
						$( document ).off( 'notificationsFetched.new' );
					});
				}
			}
		);

		
	})

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

	$( document ).on( 'click', '.nf-activate-notification', function(e) {
		e.preventDefault();
		var tmp = notifications.get( $( this ).data( 'notification-id' ) );
		tmp.set( 'active', true );
		tmp.save();
	});
}); //Document.ready();