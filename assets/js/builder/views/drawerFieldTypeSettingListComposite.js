define( ['builder/views/drawerFieldTypeSettingListOption'], function( listOptionView ) {
	var view = Marionette.CompositeView.extend( {
		template: '#nf-tmpl-edit-field-setting-wrap',
		childView: listOptionView,

		initialize: function( data ) {
			this.collection = this.model.get( 'options' );
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
			jQuery( collectionView.el ).find( '.nf-list-options-tbody' ).append( childView.el );
		}

	} );

	return view;
} );