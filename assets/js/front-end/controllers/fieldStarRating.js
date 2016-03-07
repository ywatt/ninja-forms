define([], function() {
    var controller = Marionette.Object.extend( {

        initialize: function() {
            this.listenTo( nfRadio.channel( 'starrating' ), 'render:view', this.renderRating );
        },

        renderRating: function( view ){
            jQuery( view.el ).find( '.starrating' ).rating();
        },

    });

    return controller;
});