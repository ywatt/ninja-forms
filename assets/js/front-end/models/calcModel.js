define( [], function() {
	var model = Backbone.Model.extend( {
		initialize: function() {
			// Set our form id
			this.set( 'formID', this.collection.options.formModel.get( 'id' ) );
			this.fields = {};
			var that = this;
			var eq = this.get( 'eq' );
			var eqValues = eq;
			// Check to see if we have any merge tags in our equation.
			var fields = eq.match( new RegExp( /{field:(.*?)}/g ) );
			var process = true;
			fields = fields.map( function( field ) {
				var key = field;
				key = key.replace( '}', '' ).replace( '{field:', '' ); 
				fieldModel = nfRadio.channel( 'form-' + that.get( 'formID' ) ).request( 'get:fieldByKey', key );
				fieldModel.on( 'change:value', that.changeField, that );
				/*
				 * Send out a request on the field type and parent type channel asking if they need to modify the calc value.
				 * This is helpful for fields like lists that can have a different calc_value than selected value.
				 */
				var value = nfRadio.channel( fieldModel.get( 'type' ) ).request( 'get:calcValue', fieldModel );

				if ( 'undefined' == typeof value ) {
					if ( jQuery.isNumeric( fieldModel.get( 'value' ) ) ) {
						value = fieldModel.get( 'value' );
					} else {
						value = 0;
					}
				}

				value = ( jQuery.isNumeric( value ) ) ? value : 0;

				that.fields[ key ] = value;
				eqValues = eqValues.replace( field, value );
			} );

			console.log( eqValues + ' = ' );
			this.set( 'value', math.eval( eqValues ) );
			console.log( this.get( 'value' ) );
		},

		changeField: function( fieldModel ) {
			var key = fieldModel.get( 'key' );

			/*
			 * Send out a request on the field type and parent type channel asking if they need to modify the calc value.
			 * This is helpful for fields like lists that can have a different calc_value than selected value.
			 */
			var value = nfRadio.channel( fieldModel.get( 'type' ) ).request( 'get:calcValue', fieldModel );

			if ( 'undefined' == typeof value ) {
				if ( jQuery.isNumeric( fieldModel.get( 'value' ) ) ) {
					value = fieldModel.get( 'value' );
				} else {
					value = 0;
				}
			}

			value = ( jQuery.isNumeric( value ) ) ? value : 0;

			this.fields[ key ] = value;

			var eqValues = this.get( 'eq' );
			var process = true;
			_.each( this.fields, function( value, key ) {
				eqValues = eqValues.replace( '{field:' + key + '}', value );
				if ( 'undefined' == value ) {
					process = false;
				}				
			} );
			if ( process ) {
				console.log( eqValues + ' = ' );
				this.set( 'value', math.eval( eqValues ) );
				console.log( this.get( 'value' ) );				
			}
		}
	} );

	return model;
} );
