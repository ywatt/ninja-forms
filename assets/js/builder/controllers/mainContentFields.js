define( [], function() {
	var controller = Marionette.Object.extend( {
	
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer' ), 'startDrag:fieldType', this.addActiveClass );
			this.listenTo( nfRadio.channel( 'drawer' ), 'stopDrag:fieldType', this.removeActiveClass );
		},

		addActiveClass: function() {
			var sortableEl = nfRadio.channel( 'app' ).request( 'get:fieldsSortableEl' );
			jQuery( sortableEl ).addClass( 'nf-droppable-active' );
		},

		removeActiveClass: function() {
			var sortableEl = nfRadio.channel( 'app' ).request( 'get:fieldsSortableEl' );
			jQuery( sortableEl ).removeClass( 'nf-droppable-active' );
		}

	});

	return controller;
} );