define([], function() {
    var controller = Marionette.Object.extend( {

        taxModel: {},

        initialize: function() {
            this.listenTo( nfRadio.channel( 'tax' ), 'init:model', this.register );
        },

        register: function( taxModel ){
            this.taxModel = taxModel;
            nfRadio.channel( 'tax' ).reply( 'get:modelValue', this.getTax, this );
            this.listenTo( nfRadio.channel( 'subtotal' ), 'change:value', this.updateTax );
        },

        updateTax: function( subtotal ){

            var taxValue = subtotal;
            var taxRate = this.taxModel.get( 'tax_rate' ) / 100;
            taxValue *= taxRate;
            var totalValue = Number( taxValue.toFixed( 2 ) ) + Number( subtotal );
            this.taxModel.set( 'value', taxValue.toFixed( 2 ) );
            nfRadio.channel( 'tax' ).trigger( 'change:value', totalValue.toFixed( 2 ) );
            this.taxModel.trigger( 'reRender' );
        }
    });

    return controller;
});