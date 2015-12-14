define([], function() {
    var controller = Marionette.Object.extend( {

        products: [],

        initialize: function() {
            this.listenTo( nfRadio.channel( 'total' ), 'init:model', this.register );
            this.listenTo( nfRadio.channel( 'product' ), 'init:model', this.registerProducts );
        },

        register: function( totalModel ){
            this.totalModel = totalModel;
            this.listenTo( nfRadio.channel( 'product' ), 'change:modelValue', this.onChangeProduct );
            this.listenTo( nfRadio.channel( 'quantity' ), 'change:modelValue', this.onChangeQuantity );
        },

        registerProduct: function( productModel ){
            this.products.push( productModel );
        },

        registerTax: function( taxModel ) {
            this.taxModel = taxModel;
        },

        onChangeProduct: function( model ){
            var productPrice = Number( model.get( 'product_price' ) );
            var productQuantity = Number( model.get( 'value' ) );
            var newTotal = productQuantity * productPrice;

            this.totalModel.set( 'value', newTotal.toFixed( 2 ) );
            this.totalModel.set( 'reRender', true );
        },

        onChangeQuantity: function( model ){
            var productID = model.get( 'product_assignment' );
            var productField = nfRadio.channel( 'fields' ).request( 'get:field', productID );
            var productPrice = Number( productField.get( 'product_price' ) );

            var quantity = Number( model.get( 'value' ) );

            var newTotal = quantity * productPrice;

            this.totalModel.set( 'value', newTotal.toFixed( 2 ) );
            this.totalModel.set( 'reRender', true );
        }
    });

    return controller;
});