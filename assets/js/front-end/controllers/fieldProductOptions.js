define([], function() {
    var controller = Marionette.Object.extend({

        initialize: function () {
        
            this.listenTo( nfRadio.channel( 'productoptions' ), 'init:model', this.initTemplate );
            nfRadio.channel( 'productoptions' ).reply( 'get:template', this.overrideTemplate, this );
        
        },
        
        initTemplate: function ( fieldModel ) {
            
            nfRadio.channel( fieldModel.get( 'options_display_as' ) ).trigger( 'init:model', fieldModel );
        
        },

        overrideTemplate: function ( fieldModel ) {

            return new Array( fieldModel.get( 'options_display_as' ), 'input' );

        }
    });

    return controller;
});