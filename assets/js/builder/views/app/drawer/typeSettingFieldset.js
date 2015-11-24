define( ['views/app/drawer/itemSetting'], function( itemSettingView ) {
	var view = Marionette.CompositeView.extend( {
		template: '#nf-tmpl-edit-setting-wrap',
		childView: itemSettingView,

		initialize: function( data ) {
			this.collection = this.model.get( 'settings' );
			this.childViewOptions = { dataModel: data.dataModel };
		},

		onRender: function() {
			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );

			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );
		},

		templateHelpers: function () {
	    	return {
	    		renderSetting: function(){
					return _.template( jQuery( '#nf-tmpl-edit-setting-' + this.type ).html(), this );
				},
				
				renderWidth: function() {
					if ( 'undefined' != typeof this.width ) {
						return this.width;
					} else {
						return 'one-half';
					}
				}
			}
		},

		attachHtml: function( collectionView, childView ) {
			jQuery( collectionView.el ).find( '.nf-field-sub-settings' ).append( childView.el );
		}

	} );

	return view;
} );