/**
 * Listens to our fields channel for shipping fields being initialized.
 *
 * If we're initializing a shipping field, add a controller to update the shipping_cost mask.
 * 
 * @package Ninja Forms builder
 * @subpackage Main App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
            this.listenTo( nfRadio.channel( 'fields-shipping' ), 'init:fieldModel', this.initMasking );
		},
        
        /*
         * Listens for change to the locale display settings.
         * @param fieldModel Backbone.Model
         */
        initMasking: function( fieldModel ) {
            fieldModel.listenTo( nfRadio.channel( 'setting' ), 'update:numberFormat', this.updateNumberFormat );
            fieldModel.listenTo( nfRadio.channel( 'setting' ), 'update:currency', this.updateCurrency );
            fieldModel.listenTo( nfRadio.channel( 'setting' ), 'update:currencyAlignment', this.updateCurrencyAlignment );
        },
        
        /*
         * Updates the number formatting of the mask.
         * @param settingModel Backbone.Model
         */
        updateNumberFormat: function( settingModel ) {
            var updated = settingModel.changed.numberFormat;
            var outdated = settingModel.previousAttributes().numberFormat;
            var value = this.get( 'shipping_cost' );
            var newT = updated.substr( 0, updated.length -1 );
            var newD = updated.substr( -1 );
            var oldT = outdated.substr( 0, outdated.length -1 );
            var oldD = outdated.substr( -1 );
            value = value.split( oldT ).join( newT );
            value = value.split( oldD ).join( newD );
            this.set( 'shipping_cost', value );
        },
        
        /*
         * Updates the currency symbol of the mask.
         * @param settingModel Backbone.Model
         */
        updateCurrency: function( settingModel ) {
            var value = this.get( 'shipping_cost' );
            var node = jQuery( '<div />' );
            var updated = node.html( nfAdmin.currencySymbols[ settingModel.changed.currency ] ).text();
            var outdated = node.html( nfAdmin.currencySymbols[ settingModel.previousAttributes().currency ] ).text();
            delete node;
            value = value.replace( outdated, updated );
            this.set( 'shipping_cost', value );
        },
        
        /*
         * Updates the currency symbol alignment of the mask.
         * @param settingModel Backbone.Model
         */
        updateCurrencyAlignment: function( settingModel ) {
            var node = jQuery( '<div />' );
            var currency = node.html( nfAdmin.currencySymbols[ settingModel.get( 'currency' ) ] ).text();
            delete node;
            var value = this.get( 'shipping_cost' );
            value = value.replace( currency, '' );
            if ( 'right' == settingModel.changed.currencyAlignment ) {
                value += currency;
            } else {
                value = currency + value;
            }
            this.set( 'shipping_cost', value );
        }

	});

	return controller;
} );