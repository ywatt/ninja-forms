define([], function() {
    var controller = Marionette.Object.extend( {

        productTotals: {},

        initialize: function() {
            this.listenTo( nfRadio.channel( 'total' ), 'init:model', this.register );
            this.listenTo( nfRadio.channel( 'shipping' ), 'init:model', this.registerShipping );
        },

        register: function( totalModel ){
            this.totalModel = totalModel;
            this.listenTo( nfRadio.channel( 'product' ), 'change:modelValue', this.onChangeProduct );
            this.listenTo( nfRadio.channel( 'quantity' ), 'change:modelValue', this.onChangeQuantity );
        },

        registerShipping: function( shippingModel ){
            this.shippingCost = shippingModel.get( 'shipping_cost' );
        },

        onChangeProduct: function( model ){
            var productID = model.get( 'id' );
            var productPrice = Number( model.get( 'product_price' ) );
            var productQuantity = Number( model.get( 'value' ) );
            var newTotal = productQuantity * productPrice;
            this.productTotals[ productID ] = newTotal;

            this.updateTotal();
        },

        onChangeQuantity: function( model ){
            var productID = model.get( 'product_assignment' );
            var productField = nfRadio.channel( 'fields' ).request( 'get:field', productID );
            var productPrice = Number( productField.get( 'product_price' ) );

            var quantity = Number( model.get( 'value' ) );

            var newTotal = quantity * productPrice;

            this.productTotals[ productID ] = newTotal;

            console.log( this.productTotals );

            this.updateTotal();
        },

        updateTotal: function(){

            var newTotal = 0;

            for( var product in this.productTotals ){
                newTotal += Number( this.productTotals[ product ] );
            }

            newTotal += Number( this.shippingCost );

            this.totalModel.set( 'value', newTotal.toFixed( 2 ) );
            this.totalModel.set( 'reRender', true );
        }
    });

    return controller;
});