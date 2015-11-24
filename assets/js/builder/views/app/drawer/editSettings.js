define( ['views/app/drawer/itemSettingGroupCollection'], function( itemSettingGroupCollectionView ) {
	var view = Marionette.LayoutView.extend({
		tagName: 'div',
		template: '#nf-tmpl-drawer-content-edit-settings',

		regions: {
			settingGroups: '.nf-settings-groups'
		},

		initialize: function( data ) {
			this.dataModel = data.model;
			this.groupCollection = data.groupCollection;
		},

		onRender: function() {
			this.settingGroups.show( new itemSettingGroupCollectionView( { collection: this.groupCollection, dataModel: this.dataModel } ) );
		},

		templateHelpers: function () {
	    	return {
	    		renderTypeNicename: function() {
	    			var currentDomain = nfRadio.channel( 'app' ).request( 'get:currentDomain' );
					var domainID = currentDomain.get( 'id' );
	    			var type = nfRadio.channel( domainID ).request( 'get:type', this.type );
	    			return type.get( 'nicename' );
				},
			};
		},
	});

	return view;
} );