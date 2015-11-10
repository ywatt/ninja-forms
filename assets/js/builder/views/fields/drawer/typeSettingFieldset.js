define( ['builder/views/fields/drawer/typeSetting'], function( fieldTypeSettingView ) {
	var view = Marionette.CompositeView.extend( {
		template: '#nf-tmpl-edit-field-setting-wrap',
		childView: fieldTypeSettingView,

		initialize: function( data ) {
			this.collection = this.model.get( 'settings' );
			this.childViewOptions = { fieldModel: data.fieldModel };
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
					return _.template( jQuery( '#nf-tmpl-edit-field-setting-' + this.type ).html(), this );
				},

			};
		},

		attachHtml: function( collectionView, childView ) {
			jQuery( collectionView.el ).find( '.nf-field-sub-settings' ).append( childView.el );
		}

	} );

	return view;
} );