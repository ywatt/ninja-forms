define( [], function( listOptionCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'fields-submit' ), 'init:fieldModel', this.setDefaultLabelPos );
		},

		setDefaultLabelPos: function( model ) {
			model.set( 'label_pos', 'hidden' );
		},

		changeOption: function( e, model, fieldModel ) {
			var name = jQuery( e.target ).data( 'id' );
			var value = jQuery( e.target ).val();
			model.set( name, value );
			this.triggerFieldModel( model.collection, fieldModel );
		},

		addOption: function( collection, fieldModel ) {
			collection.add( { label: '', value: '', calc: '' } );
			this.triggerFieldModel( collection, fieldModel );
		},

		deleteOption: function( model, collection, fieldModel ) {
			collection.remove( model );
			this.triggerFieldModel( collection, fieldModel );
		},

		triggerFieldModel: function( collection, fieldModel ) {
			if ( ! collection.arb ) {
				collection.arb = true;
			} else {
				collection.arb = false;
			}
			var optionsClone = _.clone( collection );
			fieldModel.set( 'options', optionsClone );			
		}

	});

	return controller;
} );