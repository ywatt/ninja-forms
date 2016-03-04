define([], function() {
    var controller = Marionette.Object.extend( {
        initialize: function() {
            this.listenTo( nfRadio.channel( 'number' ), 'keyup:field', this.validateMinMax );
        },

        validateMinMax: function( el, model ) {
            var $el = jQuery( el );
            var value = parseInt( $el.val() );
            var min = $el.attr( 'min' );
            var max = $el.attr( 'max' );
            var step = $el.attr( 'step' );

            if( value < min ){
                nfRadio.channel( 'fields' ).request( 'add:error', model.get( 'id' ), 'number-min', 'Number Min Error' );
            } else {
                nfRadio.channel( 'fields' ).request( 'remove:error', model.get( 'id' ), 'number-min' );
            }

            if ( value > max ){
                nfRadio.channel( 'fields' ).request( 'add:error', model.get( 'id' ), 'number-max', 'Number Max Error' );
            } else {
                nfRadio.channel( 'fields' ).request( 'remove:error', model.get( 'id' ), 'number-max' );
            }

            if( value && 0 !== value % step ){
                nfRadio.channel( 'fields' ).request( 'add:error', model.get( 'id' ), 'number-step', 'Please increment by ' + step );
            } else {
                nfRadio.channel( 'fields' ).request( 'remove:error', model.get( 'id' ), 'number-step' );
            }
        }

    });

    return controller;
} );