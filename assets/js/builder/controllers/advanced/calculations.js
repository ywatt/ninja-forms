/**
 * Makes sure that calculations don't reference calculations with a lower order.
 *
 * For example, our first caclulation can't reference the second, but the second can reference the first.
 * 
 * @package Ninja Forms builder
 * @subpackage Advanced
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'option-repeater' ), 'update:option', this.updateCalc );
			this.listenTo( nfRadio.channel( 'option-repeater' ), 'keyup:option', this.keyupCalc );
			this.listenTo( nfRadio.channel( 'option-repeater' ), 'sort:option', this.sortCalc );
		},

		updateCalc: function( optionModel, dataModel, settingModel ) {
			var error = this.checkCalcs( optionModel.get( 'eq' ), optionModel, settingModel );
			settingModel.set( 'error', error );
		},

		keyupCalc: function( e, optionModel, dataModel, settingModel ) {
			var error = this.checkCalcs( jQuery( e.target ).val(), optionModel, settingModel );
			settingModel.set( 'error', error );
		},

		sortCalc: function( optionModel, settingModel ) {
			var that = this;
			var error = false;
			_.each( optionModel.collection.models, function( optModel ) {
				var optError = that.checkCalcs( optModel.get( 'eq' ), optModel, settingModel );
				if( ! error ) {
					error = optError;
				}
			} );
			settingModel.set( 'error', error );
		},

		checkCalcs: function( eq, optionModel ) {
			// Find any calculations in our equation.
			// Check to see if we have any calc merge tags in our equation.
			var error = false;
			var calcs = eq.match( new RegExp( /{calc:(.*?)}/g ) );
			if ( calcs ) {
				var advancedSettings = nfRadio.channel( 'settings' ).request( 'get:settings' );
				var calculations = advancedSettings.get( 'calculations' );
				calcs = calcs.map( function( calc ) {
					// calc will be {calc:name}
					var name = calc.replace( '}', '' ).replace( '{calc:', '' );
					var targetCalc = calculations.findWhere( { name: name } );
					if ( name == optionModel.get( 'name' ) ) {
						optionModel.set( 'eq', eq );
						error = 'A calculation can\'t reference itself!';
					} else if ( targetCalc && targetCalc.get( 'order' ) > optionModel.get( 'order' ) ) {
						optionModel.set( 'eq', eq );
						error = 'Can\'t reference a future calculation!';
					}
		
				} );
			}

			optionModel.set( 'error', error );
			return error;
		}

	});

	return controller;
} );