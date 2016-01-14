/**
 * Controller responsible for keeping up with calculations.
 */
define(['models/calcCollection'], function( CalcCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.calcs = {};

			// When our form initialises, check to see if there are any calculations that need to be tracked.
			this.listenTo( nfRadio.channel( 'form' ), 'loaded', this.registerCalcs );

			// When a calc model is initialised, run a setup function.
			this.listenTo( nfRadio.channel( 'calc' ), 'init:model', this.setupCalc );

			// When a calc model is initialised, run a setup function.
			this.listenTo( nfRadio.channel( 'calc' ), 'change:field', this.changeField );	
		},

		/**
		 * When our form loads, create a collection out of any calculations.
		 * 
		 * @since  3.0
		 * @param  backbone.model formModel
		 * @return void
		 */
		registerCalcs: function( formModel ) {
			this.calcs[ formModel.get( 'id' ) ] = new CalcCollection( formModel.get( 'settings' ).calculations, { formModel: formModel } );
		},

		/**
		 * When a calculation model is instantiated from the registerCalcs function:
		 *
		 * Use a regex to get an array of the field keys
		 * Setup an initial key/values array
		 * Set the initial value of our calculation
		 * 
		 * @since  3.0
		 * @param  backbone.model calcModel
		 * @return void
		 */
		setupCalc: function( calcModel ) {
			// Setup our that var so we can access 'this' context in our loop.
			var that = this;
			// Get our equation
			var eq = calcModel.get( 'eq' );
			// We want to keep our original eq intact, so we use a different var for string replacment.
			var eqValues = eq;
			// Check to see if we have any merge tags in our equation.
			var fields = eq.match( new RegExp( /{field:(.*?)}/g ) );
			/*
			 * fields is now an array of field keys that looks like:
			 * ['{field:key'], ['{field:key'], etc.
			 *
			 * We need to run a function with each of our field keys to setup our field key array and hook up our field change listner.
			 */
			
			fields = fields.map( function( field ) {
				// field will be {field:key}
				var key = field.replace( '}', '' ).replace( '{field:', '' ); 
				// Get our field model
				fieldModel = nfRadio.channel( 'form-' + calcModel.get( 'formID' ) ).request( 'get:fieldByKey', key );
				fieldModel.on( 'change:value', calcModel.changeField, calcModel );
				
				// Get our calc value from our field model.
				var calcValue = that.getCalcValue( fieldModel );

				// Add this field to our internal key/value object.
				that.updateCalcValue( calcModel, key, calcValue );

				// Update the string tracking our merged eq with the calc value.
				eqValues = that.replaceKey( key, calcValue, eqValues );
			} );
			
			// Evaluate the equation and update the value of this model.
			calcModel.set( 'value', math.eval( eqValues ) );

			// Debugging console statement.
			// console.log( eqValues + ' = ' + calcModel.get( 'value' ) );
		},

		/**
		 * Update an item in our key/value pair that represents our fields and calc values.
		 * 
		 * @since  3.0
		 * @param  backbone.model 	calcModel
		 * @param  string 			key
		 * @param  string 			calcValue
		 * @return void
		 */
		updateCalcValue: function( calcModel, key, calcValue ) {
			var fields = calcModel.get( 'fields' );
			fields[ key ] = calcValue;
			calcModel.set( 'fields', fields );
		},

		/**
		 * Get a calc value from a field model.
		 *
		 * Sends a request to see if there's a special calc value
		 * Uses the value of the field if there is not.
		 * 
		 * @since  3.0
		 * @param  backbone.model fieldModel
		 * @return value
		 */
		getCalcValue: function( fieldModel ) {
			/*
			 * Send out a request on the field type and parent type channel asking if they need to modify the calc value.
			 * This is helpful for fields like lists that can have a different calc_value than selected value.
			 */
			var value = nfRadio.channel( fieldModel.get( 'type' ) ).request( 'get:calcValue', fieldModel );

			// If value is 'undefined', then we got no response. Set value to field model value.
			if ( 'undefined' == typeof value ) {
				if ( jQuery.isNumeric( fieldModel.get( 'value' ) ) ) {
					value = fieldModel.get( 'value' );
				} else {
					value = 0;
				}
			}

			return ( jQuery.isNumeric( value ) ) ? value : 0;
		},

		/**
		 * Replace instances of key with calcValue. This is used to replace one key at a time.
		 *
		 * If no eq is passed, use calcModel eq.
		 *
		 * Returns a string with instances of key replaced with calcValue.
		 * 
		 * @since  version
		 * @param  string 	key       
		 * @param  string 	calcValue 
		 * @param  string 	eq        
		 * @return string 	eq      
		 */
		replaceKey: function( key, calcValue, eq ) {
			eq = eq || calcModel.get( 'eq' );
			key = '{field:' + key + '}';
			var re = new RegExp( key, 'g' );
			return eq.replace( re, calcValue );
		},

		/**
		 * Takes a calcModel and returns a string eq with all keys replaced by their appropriate calcValues.
		 * 
		 * @since  3.0
		 * @param  backbone.model 	calcModel
		 * @return string			eq
		 */
		replaceAllKeys: function( calcModel ) {
			var eq = calcModel.get( 'eq' );
			var that = this;
			_.each( calcModel.get( 'fields' ), function( value, key ) {
				eq = that.replaceKey( key, value, eq );
			} );
			return eq;
		},

		/**
		 * Function that's called when a field within the calculation changes.
		 * 
		 * @since  3.0
		 * @param  backbone.model calcModel
		 * @param  backbone.model fieldModel
		 * @return void
		 */
		changeField: function( calcModel, fieldModel ) {
			var key = fieldModel.get( 'key' );
			var value = this.getCalcValue( fieldModel );
			this.updateCalcValue( calcModel, key, value );
			var eqValues = this.replaceAllKeys( calcModel );
			
			calcModel.set( 'value', math.eval( eqValues ) );

			// Debugging console statement.
			// console.log( eqValues + ' = ' + calcModel.get( 'value' ) );		
		}
	});

	return controller;
} );