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
		},
        
        localeEncode: function( value, format ) {
            var t = format.substr( 0, format.length -1 );
            var d = format.substr( -1 );
            value = value.split( '.' );
            var displayValue = '';
            if ( 3 < value[0].length ) {
                var i = value[0].length % 3;
                if ( i ) {
                    displayValue += value[0].substr( 0, i ) + t;
                }
                for ( i; i < value[0].length; i += 3 ) {
                    displayValue += value[0].substr( i, i + 3 ) + t;
                }
                displayValue = displayValue.substr( 0, displayValue.length - t.length);
            } else {
                displayValue = value[0]
            }
            
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
        
	});

	return controller;
} );
