define([], function() {
    var controller = Marionette.Object.extend( {

        initialize: function() {
        	this.listenTo( nfRadio.channel( 'starrating' ), 'init:model', this.register );
            this.listenTo( nfRadio.channel( 'starrating' ), 'render:view', this.initRating );
        },

        register: function( model ) {
			model.set( 'renderRatings', this.renderRatings );
		},

        initRating: function( view ){
            jQuery( view.el ).find( '.starrating' ).rating();
        },

        renderRatings: function() {

        	var html = document.createElement( 'span' );
        	for (var i = 0; i <= this.default - 1; i++) {
                var template = nfRadio.channel( 'app' ).request( 'get:template',  '#tmpl-nf-field-starrating-star' );
                var num = i + 1;
                var htmlFragment = template( { id: this.id, classes: this.classes, num: num } );
                html.appendChild(
                    document.createRange().createContextualFragment( htmlFragment )
                );
        	}
        	return html.innerHTML;
        }

    });

    return controller;
});
