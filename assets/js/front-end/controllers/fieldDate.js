define([], function() {
    var controller = Marionette.Object.extend({

        initialize: function () {
            this.listenTo( nfRadio.channel( 'date' ), 'render:view', this.initDatepicker );
        },

        initDatepicker: function ( view ) {
            console.log( view.model.get( 'date_format' ) );
            var dateObject = pikadayResponsive( jQuery( view.el ).find( '.nf-element' )[0], {
                format: view.model.get( 'date_format' ),
                classes: 'ninja-forms-field'
            } );
        }

    });

    return controller;
});