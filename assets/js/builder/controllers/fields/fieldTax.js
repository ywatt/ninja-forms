/**
 * Listens to our app channel for settings views being rendered.
 *
 * If we're rendering a product_assignment setting, add our products to the data model.
 * 
 * @package Ninja Forms builder
 * @subpackage Main App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'setting-tax_rate' ), 'render:setting', this.addMask );
			this.listenTo( nfRadio.channel( 'setting-tax_rate-option' ), 'render:setting', this.addMask );
		},

		addMask: function( settingModel, dataModel, view ) {
				jQuery( view.el ).find( '#tax_rate' ).autoNumeric({
					aSep: thousandsSeparator,
					aDec: decimalPoint
				});
		}
	});

	return controller;
} );