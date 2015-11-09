define( ['builder/views/drawerFieldTypeSettingGroupCollection'], function( fieldTypeSettingGroupCollectionView ) {
	var view = Marionette.LayoutView.extend({
		tagName: 'div',
		template: '#nf-tmpl-drawer-content-edit-field',

		regions: {
			settingGroups: '.nf-settings-groups'
		},

		initialize: function( data ) {
			this.fieldModel = data.model;
			this.listenTo( nfRadio.channel( 'fields' ), 'click:deleteField', this.maybeCloseDrawer );
		},

		onRender: function() {
			var fieldType = nfRadio.channel( 'fields' ).request( 'get:type' , this.model.get( 'type' ) );
			this.settingGroups.show( new fieldTypeSettingGroupCollectionView( { collection: fieldType.get( 'settingGroups' ), fieldModel: this.fieldModel } ) );
		},

		maybeCloseDrawer: function( e, model ) {
			if ( model.get( 'id' ) == this.model.get( 'id' ) ) {
				nfRadio.channel( 'app' ).request( 'close:drawer' );
			}
		},

		templateHelpers: function () {
	    	return {
	    		renderTypeNicename: function() {
	    			var type = nfRadio.channel( 'fields' ).request( 'get:type', this.type );
	    			return type.get( 'nicename' );
				},
			};
		},
	});

	return view;
} );