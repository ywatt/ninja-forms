define( [], function() {
	var view = Marionette.CollectionView.extend( {
		tagName: 'div',

		initialize: function( data ) {
			this.childViewOptions = { fieldModel: data.fieldModel };
		},

		getChildView: function( model ) {
			return nfRadio.channel( 'fields' ).request( 'get:settingChildView', model );
		}

	} );

	return view;
} );