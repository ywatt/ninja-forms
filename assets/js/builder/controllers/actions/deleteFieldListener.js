/**
 * Listens to field deletion, removing any merge tags that reference the field.
 * 
 * @package Ninja Forms builder
 * @subpackage Main App
 * @copyright (c) 2017 WP Ninjas
 * @since 3.1.7
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			/*
			 * When we init an action model, register a listener for field deletion.
			 */
			this.listenTo( nfRadio.channel( 'actions' ), 'init:actionModel', this.registerListener );
		},

		registerListener: function( actionModel ) {
			actionModel.listenTo( nfRadio.channel( 'fields' ), 'delete:field', this.maybeUpdateSettings );
		},

		maybeUpdateSettings: function( fieldModel ) {
			_.each( this.attributes, function( attr, key ) {
				var fieldMergeTag = '{field:' + fieldModel.get( 'key' ) + '}';
				if ( _.isString( attr ) ) {
					this.set( key, attr.replace( fieldMergeTag, '' ) );
				} else if ( _.isArray( attr ) ) {
					var index = attr.indexOf( fieldMergeTag );
					if ( -1 != index ) {
						attr.splice( index, 1 );
						this.set( key, attr );
					}
				}
			}, this );
		}

	});

	return controller;
} );