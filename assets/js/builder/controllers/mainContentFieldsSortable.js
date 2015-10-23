define( [], function() {
	var controller = Marionette.Object.extend( {
	
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer' ), 'startDrag:fieldType', this.addActiveClass );
			this.listenTo( nfRadio.channel( 'drawer' ), 'stopDrag:fieldType', this.removeActiveClass );

			nfRadio.channel( 'app' ).reply( 'receive:fieldsSortable', this.receiveFieldsSortable, this );
			nfRadio.channel( 'app' ).reply( 'over:fieldsSortable', this.overfieldsSortable, this );
			nfRadio.channel( 'app' ).reply( 'out:fieldsSortable', this.outFieldsSortable, this );
			nfRadio.channel( 'app' ).reply( 'stop:fieldsSortable', this.stopFieldsSortable, this );
			nfRadio.channel( 'app' ).reply( 'start:fieldsSortable', this.startFieldsSortable, this );
			nfRadio.channel( 'app' ).reply( 'update:fieldsSortable', this.updateFieldsSortable, this );
		},

		addActiveClass: function() {
			var sortableEl = nfRadio.channel( 'app' ).request( 'get:fieldsSortableEl' );
			jQuery( sortableEl ).addClass( 'nf-droppable-active' );
			
		},

		removeActiveClass: function() {
			console.log( 'remove active' );
			var sortableEl = nfRadio.channel( 'app' ).request( 'get:fieldsSortableEl' );
			jQuery( sortableEl ).removeClass( 'nf-droppable-active' );
		},

		receiveFieldsSortable: function( ui ) {

			if( jQuery( ui.item ).hasClass( 'nf-field-type-button' ) ) {
				var type = jQuery( ui.item ).find( '.nf-item' ).data( 'id' );
				var tmpID = this.addField( type, true );
				jQuery( ui.helper ).prop( 'id', tmpID );
				nfRadio.channel( 'data' ).request( 'sort:fields' );
				jQuery( ui.helper ).remove();
				nfRadio.channel( 'app' ).trigger( 'drop:fieldType', type );
			} else if ( jQuery( ui.item ).hasClass( 'nf-stage' ) ) {
				var that = this;

				/*
				Make sure that our staged fields are sorted properly.
				*/	
				nfRadio.channel( 'data' ).request( 'sort:stagedFields' );
				/*
				Grab our staged fields.
				 */
				var stagedFields = nfRadio.channel( 'data' ).request( 'get:stagedFields' );

				/*
				Get our current field order.
				 */
				var sortableEl = nfRadio.channel( 'app' ).request( 'get:fieldsSortableEl' );
				if ( jQuery( sortableEl ).hasClass( 'ui-sortable' ) ) {
					var order = jQuery( sortableEl ).sortable( 'toArray' );
				} else {
					var order = ['nf-staged-fields-drag'];
				}
				
				/*
				Get the index of our droped element.
				 */
				var insertedAt = order.indexOf( 'nf-staged-fields-drag' );

				/*
				Loop through each staged fields model and insert a field.
				 */
				var tmpIDs = [];
				_.each( stagedFields.models, function( field, index ) {
					/*
					Add our field.
					 */
					var tmpID = that.addField( field.get( 'slug' ) );
					/*
					Add this newly created field to our order array.
					 */
					order.splice( insertedAt + index, 0, tmpID );
				} );

				/*
				Remove our dropped element from our order array.
				 */

				var insertedAt = order.indexOf( 'nf-staged-fields-drag' );
				order.splice( insertedAt, 1 );

				nfRadio.channel( 'data' ).request( 'sort:fields', order );
				
				nfRadio.channel( 'data' ).request( 'clear:stagedFields' );

				jQuery( ui.helper ).remove();
			}
		},

		addField: function( type, silent ) {
			silent = silent || false;
			var fieldCollection = nfRadio.channel( 'data' ).request( 'get:fieldCollection' );
			var fieldType = nfRadio.channel( 'data' ).request( 'get:fieldType', type );
			var tmpNum = fieldCollection.length + 1;
			var tmpID = 'tmp-' + tmpNum;
			nfRadio.channel( 'data' ).request( 'add:fieldData',  { id: tmpID, label: fieldType.get( 'nicename' ), type: fieldType.get( 'slug' ) }, silent );
			return tmpID;
		},

		overfieldsSortable: function( ui ) {
			if( jQuery( ui.item ).hasClass( 'nf-field-type-button' ) ) {
				var type = jQuery( ui.helper ).find( '.nf-item' ).data( 'id' );
				var fieldType = nfRadio.channel( 'data' ).request( 'get:fieldType', type );
				var label = fieldType.get( 'nicename' );
				var sortableEl = nfRadio.channel( 'app' ).request( 'get:fieldsSortableEl' );
				var fieldWidth = jQuery( sortableEl ).width();
				this.currentHelper = ui.helper;
				jQuery( ui.helper ).html( label );
				jQuery( ui.helper ).removeClass( 'nf-one-third' ).addClass( 'nf-field-wrap' ).css( { 'width': fieldWidth, 'height': '50px' } );						
				if ( jQuery( sortableEl ).hasClass( 'ui-sortable' ) ) {
					jQuery( sortableEl ).addClass( 'nf-droppable-hover' );
				}
			} else if ( jQuery( ui.item ).hasClass( 'nf-stage' ) ) {

			}

		},

		outFieldsSortable: function( ui ) {
			if( jQuery( ui.item ).hasClass( 'nf-field-type-button' ) ) {
				var helperClone = nfRadio.channel( 'app' ).request( 'get:fieldTypeHelperClone' );
							
				jQuery( this.currentHelper ).html( jQuery( helperClone ).html() );
				jQuery( this.currentHelper ).removeClass( 'nf-field-wrap' ).addClass( 'nf-one-third' ).css( { 'width': '', 'height': '' } );
				var sortableEl = nfRadio.channel( 'app' ).request( 'get:fieldsSortableEl' );
				if ( jQuery( sortableEl ).hasClass( 'ui-sortable' ) ) {
					jQuery( sortableEl ).removeClass( 'nf-droppable-hover' );
				}
			} else if ( jQuery( ui.item ).hasClass( 'nf-stage' ) ) {

			}
		},

		stopFieldsSortable: function( ui ) {
			jQuery( ui.item ).css( 'opacity', '' )
			jQuery( ui.helper ).remove();
		},

		startFieldsSortable: function( ui ) {
			jQuery( ui.item ).css( 'opacity', '0.5' ).show();
		},

		updateFieldsSortable: function( ui ) {
			nfRadio.channel( 'data' ).request( 'sort:fields' );
		}
	});

	return controller;
} );