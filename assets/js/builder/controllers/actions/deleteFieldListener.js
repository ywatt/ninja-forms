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
				} else if ( _.isObject( attr ) ) {
					if ( 'custom_meta' == key ) {
						_.each( attr, function( obj, index ) {
							obj = _.mapObject( obj, function( val, k ) {
								if ( _.isString( val ) ) {
									if ( -1 != val.indexOf( fieldMergeTag ) ) {
										delete attr[ index ];
									}
								};
								return val;
							} );
						}, this );
						this.set( 'custom_meta', attr );
					}					
				}
			}, this );
		}

	});

	return controller;
} );