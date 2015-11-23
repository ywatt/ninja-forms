/**
 * Handles clicks and dragging for our action types.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields - New Field Drawer
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/models/actions/actionCollection', 'builder/models/actions/actionModel'], function( actionCollection, actionModel ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// Respond to requests for data about fields and to update/change/delete fields from our collection.
			this.listenTo( nfRadio.channel( 'actions' ), 'click:addAction', this.addAction, this );
		},

		/**
		 * Add a field to our collection. If silent is passed as true, no events will trigger.
		 * 
		 * @since 3.0
		 * @param Object 	data 	field data to insert
		 * @param bool 		silent 	prevent events from firing as a result of adding	 	
		 */
		addAction: function( type ) {
			var data = {
				id: nfRadio.channel( 'actions' ).request( 'get:tmpID' ),
				type: type.get( 'id' ),
				label: type.get( 'nicename' )
			}
			var newAction = nfRadio.channel( 'actions' ).request( 'add:action', data );
			var actionCollection = nfRadio.channel( 'actions' ).request( 'get:actionCollection' );
			actionCollection.sort();
			nfRadio.channel( 'actions' ).trigger( 'click:edit', {}, newAction );
		}
	});

	return controller;
} );