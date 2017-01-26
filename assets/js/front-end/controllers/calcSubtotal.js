define([], function() {
    var controller = Marionette.Object.extend( {

        productTotals: {},
        donationTotals: {},
        productFields: {},
        donationFields: {},
        quantityFields: {},
        productoptionsFields: {},
        
        initialize: function() {
            this.listenTo( nfRadio.channel( 'form' ), 'render:view', this.register );
        },

        register: function( form ){

            this.listenTo( nfRadio.channel( 'product' ), 'change:modelValue', this.onChangeProduct );
            this.listenTo( nfRadio.channel( 'quantity' ), 'change:modelValue', this.onChangeQuantity );
            this.listenTo( nfRadio.channel( 'productoptions' ), 'change:modelValue', this.onChangeProductOptions );
            this.listenTo( nfRadio.channel( 'donation' ), 'change:modelValue', this.onChangeDonation );
            this.onFormLoaded( form.model );
            
            
        },

        onFormLoaded: function( formModel ){

            var fieldModels = formModel.get( 'fields' ).models;

            for( var model in fieldModels ){

                var field = fieldModels[ model ];
                var fieldID = field.get( 'id' );
                
                switch ( field.get( 'type' ) ) {
                    case 'product':
                        this.productFields[ fieldID ] = field;
                        break;
                    case 'donation':
                        this.donationFields[ fieldID ] = field;
                        break;
                    case 'quantity':
                        var productID = field.get( 'product_assignment' );
                        productID = productID.slice(7, -1);
                        productID = nfRadio.channel( 'form-' + formModel.get( 'id' ) ).request( 'get:fieldByKey', productID ).get( 'id' );
                        this.quantityFields[ productID ] = field;
                        break;
                    case 'productoptions':
                        var productID = field.get( 'product_assignment' );
                        productID = productID.slice(7, -1);
                        productID = nfRadio.channel( 'form-' + formModel.get( 'id' ) ).request( 'get:fieldByKey', productID ).get( 'id' );
                        if( ! this.productoptionsFields[ productID ] ) this.productoptionsFields[ productID ] = [];
                        this.productoptionsFields[ productID ][ field.get( 'id' ) ] = field;
                        break;
                    default:
                        break;
                }
            }

            for( var productID in this.productFields ){

                var product = this.productFields[ productID ];

                var productPrice = Number( product.get( 'product_price' ) );
                
                _.each( _.values( this.productoptionsFields[ productID ] ), function( productOption, optionID ){
                    if( Array.isArray( productOption.get( 'value' ) ) ){
                        _.each( productOption.get( 'value' ), function ( option ){
                            var selectedOption = _.findWhere( productOption.get( 'options' ), { value:option } );
                            productPrice += Number(selectedOption['calc']);
                        });
                    } else {
                        var selectedOption = _.findWhere( productOption.get( 'options' ), { value:productOption.get( 'value' ) } );
                        productPrice += Number(selectedOption['calc']);
                    }
                });
                
                if( this.quantityFields[ productID ] ){

                    productPrice *= this.quantityFields[ productID ].get( 'value' ) || 0;

                } else if( 1 == product.get( 'product_use_quantity' ) ){

                    productPrice *= product.get( 'value' ) || 0;

                }

                this.productTotals[ productID ] = productPrice;
            }
            for( var donationID in this.donationFields ){
                
                var donation = this.donationFields[ donationID ];
                
                var donationAmount = Number( donation.get( 'value' ) );
                
                this.donationTotals[ donationID ] = donationAmount;
            }

            this.updateSubtotal();
        },

        onChangeProduct: function( model ){
            var productID = model.get( 'id' );
            this.productFields[ productID ] = model;
            this.updateProductTotals( productID );
        },

        onChangeQuantity: function( model ){
            var productTag = model.get( 'product_assignment' );
            productTag = productTag.slice(7, -1);
            var productField = nfRadio.channel( 'form-' + model.get('formID') ).request( 'get:fieldByKey', productTag );
            var productPrice = Number( productField.get( 'product_price' ) );
            var productID = productField.get( 'id' );
            this.quantityFields[ productID ] = model;
            this.updateProductTotals( productID );
            
        },
        
        onChangeProductOptions: function ( model ) {
            var selectedOption = _.findWhere( model.get('options'), { value:model.get( 'value' ) } );
            var productTag = model.get( 'product_assignment' );
            productTag = productTag.slice(7, -1);
            var productField = nfRadio.channel( 'form-' + model.get('formID') ).request( 'get:fieldByKey', productTag );
            var productID = productField.get( 'id' );
            this.productoptionsFields[ productID ][ model.get('id') ] = model;
            this.updateProductTotals( productID );
        },
        
        onChangeDonation: function ( model ) {
            var donationID = model.get( 'id' );
            var donationAmount = Number( model.get( 'value' ) );
            this.donationTotals[ donationID ] = donationAmount;
            
            this.updateSubtotal();
        },
        
        updateProductTotals: function ( productID ) {
            
            var productPrice = Number( this.productFields[ productID ].get( 'product_price' ) );
            _.each( _.values( this.productoptionsFields[ productID ] ), function( productOption ){
                //var selectedOption = _.findWhere( productOption.get( 'options' ), { value:productOption.get( 'value' ) } );
                //productPrice += Number( selectedOption[ 'calc' ] );
                if( Array.isArray( productOption.get( 'value' ) ) ){
                    _.each( productOption.get( 'value' ), function ( option ){
                        var selectedOption = _.findWhere( productOption.get( 'options' ), { value:option } );
                        productPrice += Number(selectedOption['calc']);
                    });
                } else {
                    var selectedOption = _.findWhere( productOption.get( 'options' ), { value:productOption.get( 'value' ) } );
                    productPrice += Number(selectedOption['calc']);
                }
            });
            if( this.quantityFields[ productID ]) productPrice *= Number( this.quantityFields[ productID ].get( 'value' ) );
            else productPrice *= Number( this.productFields[ productID ].get( 'value' ) );
            this.productTotals[ productID ] = productPrice;
            this.updateSubtotal();
            
        },

        updateSubtotal: function(){

            var newTotal = 0;

            for( var product in this.productTotals ){
                newTotal += Number( this.productTotals[ product ] );
            }
            for( var donation in this.donationTotals ){
                newTotal += Number( this.donationTotals[ donation ] );
            }

            nfRadio.channel( 'subtotal' ).trigger( 'change:value', newTotal.toFixed( 2 ) );
        }
    });

    return controller;
});