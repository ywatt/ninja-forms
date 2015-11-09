define( [], function() {
	var controller = Marionette.Object.extend( {
	
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer-addField' ), 'startDrag:type', this.addActiveClass );
			this.listenTo( nfRadio.channel( 'drawer-addField' ), 'stopDrag:type', this.removeActiveClass );

			this.listenTo( nfRadio.channel( 'drawer-addField' ), 'startDrag:fieldStaging', this.addActiveClass );
			this.listenTo( nfRadio.channel( 'drawer-addField' ), 'stopDrag:fieldStaging', this.removeActiveClass );

			nfRadio.channel( 'app' ).reply( 'receive:fieldsSortable', this.receiveFieldsSortable, this );
			nfRadio.channel( 'app' ).reply( 'over:fieldsSortable', this.overfieldsSortable, this );
			nfRadio.channel( 'app' ).reply( 'out:fieldsSortable', this.outFieldsSortable, this );
			nfRadio.channel( 'app' ).reply( 'stop:fieldsSortable', this.stopFieldsSortable, this );
			nfRadio.channel( 'app' ).reply( 'start:fieldsSortable', this.startFieldsSortable, this );
			nfRadio.channel( 'app' ).reply( 'update:fieldsSortable', this.updateFieldsSortable, this );
		},

		addActiveClass: function() {
			var sortableEl = nfRadio.channel( 'fields' ).request( 'get:sortableEl' );
			jQuery( sortableEl ).addClass( 'nf-droppable-active' );
			
		},

		removeActiveClass: function() {
			var sortableEl = nfRadio.channel( 'fields' ).request( 'get:sortableEl' );
			jQuery( sortableEl ).removeClass( 'nf-droppable-active' );
		},

		receiveFieldsSortable: function( ui ) {

			if( jQuery( ui.item ).hasClass( 'nf-field-type-button' ) ) {
				var type = jQuery( ui.item ).data( 'id' );
				var tmpID = this.addField( type, false );
				jQuery( ui.helper ).prop( 'id', tmpID );
				nfRadio.channel( 'fields' ).request( 'sort:fields' );
				jQuery( ui.helper ).remove();
				nfRadio.channel( 'fields' ).trigger( 'drop:fieldType', type );
			} else if ( jQuery( ui.item ).hasClass( 'nf-stage' ) ) {
				var that = this;

				/*
				Make sure that our staged fields are sorted properly.
				*/	
				nfRadio.channel( 'fields' ).request( 'sort:staging' );
				/*
				Grab our staged fields.
				 */
				var stagedFields = nfRadio.channel( 'fields' ).request( 'get:staging' );

				/*
				Get our current field order.
				 */
				var sortableEl = nfRadio.channel( 'fields' ).request( 'get:sortableEl' );
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

				nfRadio.channel( 'fields' ).request( 'sort:fields', order );
				
				nfRadio.channel( 'fields' ).request( 'clear:staging' );

				jQuery( ui.helper ).remove();
			}
		},

		addField: function( type, silent ) {
			silent = silent || false;
			var fieldType = nfRadio.channel( 'fields' ).request( 'get:type', type );
			var tmpID = nfRadio.channel( 'fields' ).request( 'get:tmpFieldID' );
			nfRadio.channel( 'fields' ).request( 'add:field',  { id: tmpID, label: fieldType.get( 'nicename' ), type: fieldType.get( 'id' ) }, silent );
			return tmpID;
		},

		overfieldsSortable: function( ui ) {
			if( jQuery( ui.item ).hasClass( 'nf-field-type-button' ) ) {
				var type = jQuery( ui.helper ).data( 'id' );
				var fieldType = nfRadio.channel( 'fields' ).request( 'get:type', type );
				var label = fieldType.get( 'nicename' );
				var sortableEl = nfRadio.channel( 'fields' ).request( 'get:sortableEl' );
				var fieldWidth = jQuery( sortableEl ).width();
				this.currentHelper = ui.helper;
				jQuery( ui.helper ).html( label );
				jQuery( ui.helper ).removeClass( 'nf-one-third' ).addClass( 'nf-field-wrap' ).css( { 'width': fieldWidth, 'height': '50px' } );						
				if ( jQuery( sortableEl ).hasClass( 'ui-sortable' ) ) {
					jQuery( sortableEl ).addClass( 'nf-droppable-hover' );
				}
			} else if ( jQuery( ui.item ).hasClass( 'nf-stage' ) ) {
				var sortableEl = nfRadio.channel( 'fields' ).request( 'get:sortableEl' );
				if ( jQuery( sortableEl ).hasClass( 'ui-sortable' ) ) {
					jQuery( sortableEl ).addClass( 'nf-droppable-hover' );
				}
			}
		},

		outFieldsSortable: function( ui ) {
			if( jQuery( ui.item ).hasClass( 'nf-field-type-button' ) ) {
				var helperClone = nfRadio.channel( 'drawer-addField' ).request( 'get:typeHelperClone' );
							
				jQuery( this.currentHelper ).html( jQuery( helperClone ).html() );
				jQuery( this.currentHelper ).removeClass( 'nf-field-wrap' ).addClass( 'nf-one-third' ).css( { 'width': '', 'height': '' } );
				var sortableEl = nfRadio.channel( 'fields' ).request( 'get:sortableEl' );
				if ( jQuery( sortableEl ).hasClass( 'ui-sortable' ) ) {
					jQuery( sortableEl ).removeClass( 'nf-droppable-hover' );
				}
			} else if ( jQuery( ui.item ).hasClass( 'nf-stage' ) ) {
				var sortableEl = nfRadio.channel( 'fields' ).request( 'get:sortableEl' );
				if ( jQuery( sortableEl ).hasClass( 'ui-sortable' ) ) {
					jQuery( sortableEl ).removeClass( 'nf-droppable-hover' );
				}
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
			nfRadio.channel( 'fields' ).request( 'sort:fields' );
		}
	});

	return controller;
} );