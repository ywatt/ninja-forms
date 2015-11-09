/**
 * Handles actions related to our submit field type. Sets the default label position.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields - New Field Drawer
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function( listOptionCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// Listen to our field model init and change the default label pos if we're dealing with a submit button
			this.listenTo( nfRadio.channel( 'fields-submit' ), 'init:fieldModel', this.setDefaultLabelPos );
		},

		/**
		 * Set our default label position to inside.
		 * 
		 * @since 3.0
		 * @param backbone.model model field model
		 */
		setDefaultLabelPos: function( model ) {
			model.set( 'label_pos', 'hidden' );
		}

	});

	return controller;
} );