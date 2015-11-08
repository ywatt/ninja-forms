/**
 * Handles adding and removing the active class from a field currently being edited.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields - Edit Field Drawer
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/models/fieldTypeSectionCollection'], function( fieldTypeSectionCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			nfRadio.channel( 'fields' ).reply( 'clear:editActive', this.clearEditActive, this );	
		},

        clearEditActive: function() {
            var fieldCollection = nfRadio.channel( 'fields' ).request( 'get:fieldCollection' );
            _.each( fieldCollection.models, function( field ) {
				field.set( 'editActive', false );
            } );
        }
	});

	return controller;
} );
