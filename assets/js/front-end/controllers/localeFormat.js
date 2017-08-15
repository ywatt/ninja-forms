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
			// Respond to requests to encode locale.
			nfRadio.channel( 'locale' ).reply( 'encode:string', this.localeEncode, this );
			// Respond to requests to decode locale.
			nfRadio.channel( 'locale' ).reply( 'decode:string', this.localeDecode, this );
		},
        
        /**
         * Function to encode locale settings of a calculation for display.
         * 
         * @since 3.1
         * @param String eq The value
         * @param String format The locale number format setting
         * @return String
         */
        localeEncode: function( value, format ) {
            var t = format.substr( 0, format.length -1 );
            var d = format.substr( -1 );
            // Split our value on the decimal point, if one exists.
            value = value.split( '.' );
            var encoded = '';
            // If we have enough numbers to need a thousand separator...
            if ( 3 < value[0].length ) {
                // Insert them where necessary.
                var i = value[0].length % 3;
                if ( i ) {
                    encoded += value[0].substr( 0, i ) + t;
                }
                for ( i; i < value[0].length; i += 3 ) {
                    encoded += value[0].substr( i, 3 ) + t;
                }
                encoded = encoded.substr( 0, encoded.length - t.length);
            } else {
                encoded = value[0];
            }
            
            // If we had a decimal point...
            if( 1 < value.length ) {
                // Add it to the string.
                encoded += d + value[1]; 
            }
            return encoded;
        },
        
        /**
         * Function to decode locale settings of a calculation equation.
         * 
         * @since 3.1
         * @param String eq The equation
         * @param String format The locale number format setting
         * @return String
         */
        localeDecode: function( eq, format ) {
            var t = format.substr( 0, format.length -1 );
            var d = format.substr( -1 );
            var decoded = eq.split( t ).join( '' );
            decoded = decoded.split( d ).join( '.' );
            return decoded;
        },
        
	});

	return controller;
} );
