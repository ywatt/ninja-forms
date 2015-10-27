define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'fields' ), 'click:editField', this.clickEdit );
			this.listenTo( nfRadio.channel( 'fields' ), 'click:deleteField', this.clickDelete );
			this.listenTo( nfRadio.channel( 'fields' ), 'click:duplicateField', this.clickDuplicate );
		},

		clickEdit: function( e, model ) {
			nfRadio.channel( 'app' ).request( 'open:drawer', 'editField', { model: model } );
		},

		clickDelete: function( e, model ) {
			nfRadio.channel( 'data' ).request( 'delete:field', model );
		},

		clickDuplicate: function( e, model ) {
			console.log( 'here' );
			var newModel = model.clone();
			var tmpID = nfRadio.channel( 'data' ).request( 'get:tmpFieldID' );
			newModel.set( 'id', tmpID );
			nfRadio.channel( 'data' ).request( 'add:field', newModel );
		}

	});

	return controller;
} );