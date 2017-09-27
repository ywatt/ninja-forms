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
			// When our form initialises, grab our locale settings.
			this.listenTo( nfRadio.channel( 'form' ), 'loaded', this.registerSettings );
			// Respond to requests to encode locale.
			nfRadio.channel( 'locale' ).reply( 'encode:string', this.localeEncode, this );
			// Respond to requests to decode locale.
			nfRadio.channel( 'locale' ).reply( 'decode:string', this.localeDecode, this );
			// Respond to requests to add the currency symbol.
			nfRadio.channel( 'locale' ).reply( 'add:currency', this.addCurrency, this );
			// Respond to requests to remove the currency symbol.
			nfRadio.channel( 'locale' ).reply( 'remove:currency', this.removeCurrency, this );
		},
        
        registerSettings: function( formModel ) {
            // If we have a number format setting...
            if ( 'undefined' != typeof( formModel.get( 'numberFormat' ) ) ) {
                var numberFormat = formModel.get( 'numberFormat' );
                this.thosuands_sep = numberFormat.substr( 0, numberFormat.length -1 );
                this.decimal_point = numberFormat.substr( -1 );
            }
            // Fall back to older settings.
            else {
                this.thosuands_sep = formModel.get( 'thousands_sep' );
                this.decimal_point = formModel.get( 'decimal_point' );
            }
            
            // If we have a whitespace character for thousands...
            if ( ' ' == this.thosuands_sep ) {
                // Set it to be a non-breaking space.
                this.thosuands_sep = '&nbsp;';
            }
            
            this.currency_symbol = formModel.get( 'currencySymbol' );
            // If an alignment has been defined...
            if ( 'undefined' != typeof( formModel.get( 'currencyAlignment' ) ) ) {
                this.currency_alignment = formModel.get( 'currencyAlignment' );
            }
            // Fall back to default of left.
            else {
                this.currency_alignment = 'left';
            }
        },
        
        /**
         * Function to encode locale settings of a calculation for display.
         * 
         * @since 3.1
         * @param String eq The value
         * @param String format The locale number format setting
         * @return String
         */
        localeEncode: function( value ) {
            // Split our value on the decimal point, if one exists.
            value = value.toString().split( '.' );
            var encoded = '';
            // If we have enough numbers to need a thousand separator...
            if ( 3 < value[0].length ) {
                // Insert them where necessary.
                var i = value[0].length % 3;
                if ( i ) {
                    encoded += value[0].substr( 0, i ) + this.thosuands_sep;
                }
                for ( i; i < value[0].length; i += 3 ) {
                    encoded += value[0].substr( i, 3 ) + this.thosuands_sep;
                }
                encoded = encoded.substr( 0, encoded.length - this.thosuands_sep.length);
            } else {
                encoded = value[0];
            }
            
            // If we had a decimal point...
            if( 1 < value.length ) {
                // Add it to the string.
                encoded += this.decimal_point + value[1]; 
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
        localeDecode: function( eq ) {
            var decoded = eq.split( this.thosuands_sep ).join( '' );
            decoded = decoded.split( ' ' ).join( '' );
            decoded = decoded.split( this.decimal_point ).join( '.' );
            return decoded;
        },
        
        addCurrency: function( value ) {
            if( 'left' == this.currency_alignment ) {
                return this.currency_symbol + value;
            } else {
                return value + this.currency_symbol;
            }
        },
        
        removeCurrency: function( value ) {
            value = value.replace( this.currency_symbol, '' );
            return value.trim();
        },
        
	});

	return controller;
} );
