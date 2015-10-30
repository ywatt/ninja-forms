define( ['builder/views/drawerFieldTypeSettingListComposite'], function( listCompositeView ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			nfRadio.channel( 'list-repeater' ).reply( 'get:settingChildView', this.getSettingChildView, this );
			nfRadio.channel( 'list-repeater' ).reply( 'update:optionSortable', this.updateOptionSortable, this );
			nfRadio.channel( 'list-repeater' ).reply( 'stop:optionSortable', this.stopOptionSortable, this );
			nfRadio.channel( 'list-repeater' ).reply( 'start:optionSortable', this.startOptionSortable, this );
		},

		getSettingChildView: function( model ) {
			return listCompositeView;
		},

		updateOptionSortable: function( sortable, setting ) {
			var newOrder = jQuery( sortable ).sortable( 'toArray' );
			_.each( newOrder, function( cid, index ) {
				setting.collection.get( { cid: cid } ).set( 'order', index );
			} );
			setting.collection.sort();
		},

		stopOptionSortable: function( ui ) {
			jQuery( ui.item ).css( 'opacity', '' );
		},

		startOptionSortable: function( ui ) {
			jQuery( ui.placeholder ).find( 'td' ).remove();
			jQuery( ui.placeholder ).append( '<td colspan="5" style="padding:0"></td>' );
			jQuery( ui.item ).css( 'opacity', '0.5' ).show();
		}

	});

	return controller;
} );