/**
 * When a form is loaded, enable any rtes in textareas.
 */
define([], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'textarea' ), 'render:view', this.initTextareaRTEs );
		},

		initTextareaRTEs: function( view ) {
			console.log( 'init rte' )
		}
	});

	return controller;
} );