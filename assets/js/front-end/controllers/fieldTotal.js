define([], function() {
    var controller = Marionette.Object.extend( {

        totalModel: {},

        productTotals: {},
        
        /* 
         * Make sure this is a predefined string to avoid process breakdown later.
         */
        shippingCost: '0',

        initialize: function() {
            this.listenTo( nfRadio.channel( 'total' ), 'init:model', this.register );
            this.listenTo( nfRadio.channel( 'shipping' ), 'init:model', this.registerShipping );
        },

        register: function( totalModel ){
            this.totalModel = totalModel;

            var formID = totalModel.get( 'formID' );
            this.listenTo( nfRadio.channel( 'form-' + formID ), 'loaded', this.onFormLoaded );

            this.listenTo( nfRadio.channel( 'product' ), 'change:modelValue', this.onChangeProduct );
            this.listenTo( nfRadio.channel( 'quantity' ), 'change:modelValue', this.onChangeQuantity );
        },

        registerShipping: function( shippingModel ){
            // TODO: Move this legacy correction to its own controller during the product rework.
            shippingModel.listenTo( nfRadio.channel( 'form' ), 'loaded', this.removeLegacyMask );
            
            this.shippingCost = shippingModel.get( 'shipping_cost' );
        },
        
        removeLegacyMask: function() {
            var price = this.get( 'shipping_cost' );
            price = nfRadio.channel( 'locale' ).request( 'remove:currency', price );
            price = nfRadio.channel( 'locale' ).request( 'add:currency', price );
            this.set( 'shipping_cost', price );  
        },

        onFormLoaded: function( formModel ){
            
            this.shippingCost = nfRadio.channel( 'locale' ).request( 'remove:currency', this.shippingCost );
            this.shippingCost = nfRadio.channel( 'locale' ).request( 'decode:string', this.shippingCost );

            var fieldModels = formModel.get( 'fields' ).models;

            var productFields = {};
            var quantityFields = {};

            for( var model in fieldModels ){

                var field = fieldModels[ model ];
                var fieldID = field.get( 'id' );

                // TODO: Maybe use switch
                if( 'product' == field.get( 'type' ) ){
                    productFields[ fieldID ] = field;
                } else if( 'quantity' == field.get( 'type' ) ){
                    var productID = field.get( 'product_assignment' );
                    quantityFields[ productID ] = field;
                }
            }

            for( var productID in productFields ){

                var product = productFields[ productID ];

                var productPrice = nfRadio.channel( 'locale' ).request( 'remove:currency', product.get( 'product_price' ) );
                productPrice = Number( nfRadio.channel( 'locale' ).request( 'decode:string', productPrice ) );

                if( quantityFields[ productID ] ){

                    productPrice *= quantityFields[ productID ].get( 'value' );

                } else if( 1 == product.get( 'product_use_quantity' ) ){

                    productPrice *= product.get( 'value' );

                }

                this.productTotals[ productID ] = productPrice;
            }

            this.updateTotal();
        },

        onChangeProduct: function( model ){
            var productID = model.get( 'id' );
            var productPrice = nfRadio.channel( 'locale' ).request( 'remove:currency', model.get( 'product_price' ) );
            productPrice = Number( nfRadio.channel( 'locale' ).request( 'decode:string', productPrice ) );
            var productQuantity = Number( model.get( 'value' ) );
            var newTotal = productQuantity * productPrice;
            this.productTotals[ productID ] = newTotal;

            this.updateTotal();
        },

        onChangeQuantity: function( model ){
            var productID = model.get( 'product_assignment' );
            var productField = nfRadio.channel( 'fields' ).request( 'get:field', productID );
            var productPrice = nfRadio.channel( 'locale' ).request( 'remove:currency', productField.get( 'product_price' ) );
            productPrice = Number( nfRadio.channel( 'locale' ).request( 'decode:string', productPrice ) );

            var quantity = Number( model.get( 'value' ) );

            var newTotal = quantity * productPrice;

            this.productTotals[ productID ] = newTotal;

            this.updateTotal();
        },

        updateTotal: function(){

            var newTotal = 0;

            for( var product in this.productTotals ){
                newTotal += Number( this.productTotals[ product ] );
            }

            if( newTotal && this.shippingCost ) {
                // Only add shipping if there is a cost.
                newTotal += Number( this.shippingCost );
            }
            newTotal = newTotal.toFixed( 2 );
            newTotal = nfRadio.channel( 'locale' ).request( 'encode:string', newTotal );
            newTotal = nfRadio.channel( 'locale' ).request( 'add:currency', newTotal );

            this.totalModel.set( 'value', newTotal );
            this.totalModel.trigger( 'reRender' );
        }
    });

    return controller;
});