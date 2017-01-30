define([], function() {
    var controller = Marionette.Object.extend( {

        totalModel: {},

        initialize: function() {
            this.listenTo( nfRadio.channel( 'total' ), 'init:model', this.register );
            this.listenTo( nfRadio.channel( 'subtotal' ), 'change:value', this.updateTotal );
            this.listenTo( nfRadio.channel( 'tax' ), 'change:value', this.updateTotal );
            this.listenTo( nfRadio.channel( 'shipping' ), 'init:model', this.registerShipping );
        },
        
        register: function( totalModel ) {
            this.totalModel = totalModel;
        },

        registerShipping: function( shippingModel ){
            this.shippingCost = shippingModel.get( 'shipping_cost' );
        },
        
        updateTotal: function( subtotal ) {
            var newTotal = Number( subtotal );

            if( newTotal && this.shippingCost ) {
                // Only add shipping if there is a cost.
                newTotal += Number(this.shippingCost);
            }
            
            this.totalModel.set ( 'value', newTotal.toFixed( 2 ) );
            this.totalModel.trigger( 'reRender' );
        }
        
    });

    return controller;
});