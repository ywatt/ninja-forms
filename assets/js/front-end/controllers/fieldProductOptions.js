define([], function() {
    var controller = Marionette.Object.extend({

        initialize: function () {
        
            this.listenTo( nfRadio.channel( 'productoptions' ), 'init:model', this.initTemplate );
            nfRadio.channel( 'productoptions' ).reply( 'get:template', this.overrideTemplate, this );
        
        },
        
        initTemplate: function ( fieldModel ) {
            
            nfRadio.channel( fieldModel.get( 'options_display_as' ) ).trigger( 'init:model', fieldModel );
            nfRadio.channel( 'productoptions' ).reply( 'before:updateField', this.beforeUpdateField, this );
            
        
        },

        overrideTemplate: function ( fieldModel ) {

            return new Array( fieldModel.get( 'options_display_as' ), 'input' );

        },
        
        beforeUpdateField: function ( el, model ) {
            if( 'listcheckbox' == model.get( 'options_display_as' ) ) {
                var selected = model.get( 'value' ) || [];
                if ( typeof selected == 'string' ) selected = [ selected ];

                var value = jQuery( el ).val();
                var checked = jQuery( el ).attr( 'checked' );
                if ( checked ) {
                    selected.push( value );
                    jQuery( el ).addClass( 'nf-checked' );
                    jQuery( el ).parent().find( 'label[for="' + jQuery( el ).prop( 'id' ) + '"]' ).addClass( 'nf-checked-label' );
                } else {
                    jQuery( el ).removeClass( 'nf-checked' );
                    jQuery( el ).parent().find( 'label[for="' + jQuery( el ).prop( 'id' ) + '"]' ).removeClass( 'nf-checked-label' );
                    var i = selected.indexOf( value );
                    if( -1 != i ){
                        selected.splice( i, 1 );
                    }
                }

                // if ( 1 == model.get( 'show_other' ) ) {
                //     model.set( 'reRender', true );
                // }

                return _.clone( selected );
            } else {
                return jQuery( el ).val();
            }
        }
        
    });

    return controller;
});