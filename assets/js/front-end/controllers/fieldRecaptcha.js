define([], function() {
    var controller = Marionette.Object.extend({

        initialize: function () {
            this.listenTo( nfRadio.channel( 'recaptcha' ), 'init:model', this.initRecaptcha );
        },

        initRecaptcha: function ( model ) {
            
        }

    });

    return controller;
});