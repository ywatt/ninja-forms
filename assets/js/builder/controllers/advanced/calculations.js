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
define( ['models/advanced/settingsModel'], function( settingsModel ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'option-repeater' ), 'update:option', this.checkCalcs );
			this.listenTo( nfRadio.channel( 'option-repeater' ), 'sort:option', this.checkCalcs );
		},

		checkCalcs: function( optionModel ) {
			// Find any calculations in our equation.
			// Check to see if we have any calc merge tags in our equation.
			var eq = optionModel.get( 'eq' );
			var calcs = eq.match( new RegExp( /{calc:(.*?)}/g ) );
			if ( calcs ) {
				var advancedSettings = nfRadio.channel( 'settings' ).request( 'get:settings' );
				var calculations = advancedSettings.get( 'calculations' );
				calcs = calcs.map( function( calc ) {
					// calc will be {calc:name}
					var name = calc.replace( '}', '' ).replace( '{calc:', '' );
					var targetCalc = calculations.findWhere( { name: name } );
					if ( name == optionModel.get( 'name' ) || targetCalc.get( 'order' ) > optionModel.get( 'order' ) ) {
						console.log( 'error!' );
					}
				} );
			}
		}
	});

	return controller;
} );