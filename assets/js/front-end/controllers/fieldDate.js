define([], function() {
    var controller = Marionette.Object.extend({

        initialize: function () {
            this.listenTo( nfRadio.channel( 'date' ), 'render:view', this.initDatepicker );
        },

        initDatepicker: function ( view ) {
            var $el = jQuery( view.el ).find( '.nf-element' );
            var dateObject = pikadayResponsive( $el, {
                format: view.model.get( 'date_format' )
            } );
            if ( 1 == view.model.get( 'date_default' ) ) {
               dateObject.setDate( moment() ); 
            }
        }
    });

    return controller;
});