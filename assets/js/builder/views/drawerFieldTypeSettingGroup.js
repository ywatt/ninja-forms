define( ['builder/views/drawerFieldTypeSettingCollection'], function( fieldTypeSettingCollectionView ) {
	var view = Marionette.LayoutView.extend({
		tagName: 'div',
		template: '#nf-tmpl-drawer-content-edit-field-setting-group',
		
		regions: {
			settings: '.nf-field-settings'
		},

		initialize: function( data ) {
			this.model.on( 'change', this.render, this );
			this.fieldModel = data.fieldModel;
		},

		onBeforeDestroy: function() {
			this.model.off( 'change', this.render );
		},

		onRender: function() {
			if ( this.model.get( 'display' ) ) {
				this.settings.show( new fieldTypeSettingCollectionView( { collection: this.model.get( 'settings' ), fieldModel: this.fieldModel } ) );
			} else {
				this.settings.empty();
			}
		},

		events: {
			'click .toggle': 'clickToggleGroup'
		},

		clickToggleGroup: function( e ) {
			nfRadio.channel( 'drawer' ).trigger( 'click:toggleSettingGroup', e, this.model );
		},

		templateHelpers: function() {
			return {
				renderLabel: function() {
					if ( '' != this.label ) {
						this.arrowDir = 'down';
						return _.template( jQuery( '#nf-tmpl-drawer-content-edit-field-setting-group-label' ).html(), this );
					} else {
						return '';
					}
				},

				renderArrowDir: function() {
					if ( this.display ) {
						return 'up';
					} else {
						return 'down';
					}
				}
			}
		}
	});

	return view;
} );