define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'field-radio' ), 'init:fieldModel', this.bindChange );

			this.listenTo( nfRadio.channel( 'field-list' ), 'change:option', this.changeOption );
			nfRadio.channel( 'list-repeater' ).reply( 'add:option', this.addOption );
			nfRadio.channel( 'list-repeater' ).reply( 'delete:option', this.deleteOption );
		},

		bindChange: function( model ) {
			model.get( 'options' ).on( 'change', model.changeSetting, model );
		},

		changeOption: function( e, model ) {
			var name = jQuery( e.target ).data( 'id' );
			var value = jQuery( e.target ).val();
			model.set( name, value );
		},

		addOption: function( collection ) {
			collection.add( { label: '', value: '', calcValue: '' } );
		},

		deleteOption: function( model, collection ) {
			collection.remove( model );
		}

	});

	return controller;
} );