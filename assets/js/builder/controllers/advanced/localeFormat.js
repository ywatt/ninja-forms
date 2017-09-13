/**
 * Handles locale encoding and decoding for formatted numbers.
 * 
 * @package Ninja Forms builder
 * @subpackage Advanced
 * @copyright (c) 2017 WP Ninjas
 * @since 3.1
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// Respond to requests to format numbers.
			nfRadio.channel( 'locale' ).reply( 'format:number', this.localeEncode, this );
			// Respond to requests to unformat numbers.
			nfRadio.channel( 'locale' ).reply( 'unformat:number', this.localeDecode, this );
            
			this.listenTo( nfRadio.channel( 'setting' ), 'update:numberFormat', this.updateNumberFormat );
		},
        
        localeEncode: function( value, format ) {
            var t = format.substr( 0, format.length -1 );
            var d = format.substr( -1 );
            value = value.split( '.' );
            var displayValue = value[0];
            if( 1 < value.length ) {
                displayValue += d + value[1]; 
            }
            return displayValue;
        },
        
        localeDecode: function( value, format ) {
            var t = format.substr( 0, format.length -1 );
            var d = format.substr( -1 );
            value = value.split( d );
            var realValue = value[0].replace( t, '' );
            if( 1 < value.length ) {
                realValue += '.' + value[1]; 
            }
            return realValue;
        },
        
        updateNumberFormat: function( settingModel ) {
            var updated = settingModel.changed.numberFormat;
            var outdated = settingModel.previousAttributes().numberFormat;
            console.log(updated);
            console.log(outdated);
            _.each( nfRadio.channel( 'app' ).request( 'get:formModel' ).get( 'fields' ).models, function( fieldModel ) {
                if ( 'product' != fieldModel.get( 'type' ) ) return;
                var value = fieldModel.get('product_price');
                var newT = updated.substr( 0, updated.length -1 );
                var newD = updated.substr( -1 );
                var oldT = outdated.substr( 0, outdated.length -1 );
                var oldD = outdated.substr( -1 );
            });
        }
        
	});

	return controller;
} );
