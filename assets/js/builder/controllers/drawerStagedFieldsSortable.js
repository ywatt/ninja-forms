define( ['builder/models/stagingCollection'], function( stagingCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer' ), 'startDrag:fieldType', this.addActiveClass );
			this.listenTo( nfRadio.channel( 'drawer' ), 'stopDrag:fieldType', this.removeActiveClass );

			this.listenTo( nfRadio.channel( 'drawer' ), 'receive:stagedFields', this.receiveStagedFields );
			this.listenTo( nfRadio.channel( 'drawer' ), 'over:stagedFields', this.overStagedFields );
			this.listenTo( nfRadio.channel( 'drawer' ), 'out:stagedFields', this.outStagedFields );
			this.listenTo( nfRadio.channel( 'drawer' ), 'start:stagedFields', this.startStagedFields );
			this.listenTo( nfRadio.channel( 'drawer' ), 'stop:stagedFields', this.stopStagedFields );
		},

		receiveStagedFields: function( ui ) {
			if( jQuery( ui.item ).hasClass( 'nf-field-type-button' ) ) {
				var type = jQuery( ui.item ).data( 'id' );
				var tmpID = nfRadio.channel( 'data' ).request( 'add:stagedField', type );
				jQuery( ui.helper ).prop( 'id', tmpID );
				nfRadio.channel( 'data' ).request( 'sort:stagedFields' );
				jQuery( ui.helper ).remove();
				nfRadio.channel( 'drawer' ).trigger( 'drop:fieldType', type );				
			}
		},

		addActiveClass: function() {
			var stagedFieldsEl = nfRadio.channel( 'app' ).request( 'get:stagedFieldsEl' );
			jQuery( stagedFieldsEl ).addClass( 'nf-droppable-active' );
		},

		removeActiveClass: function() {
			var stagedFieldsEl = nfRadio.channel( 'app' ).request( 'get:stagedFieldsEl' );
			jQuery( stagedFieldsEl ).removeClass( 'nf-droppable-active' );
		},

		overStagedFields: function( e, ui ) {
			if( jQuery( ui.item ).hasClass( 'nf-field-type-button' ) ) {
				var type = jQuery( ui.item ).data( 'id' );
				var fieldType = nfRadio.channel( 'data' ).request( 'get:fieldType', type );
				var nicename = fieldType.get( 'nicename' );
				this.currentHelper = ui.helper 
				jQuery( ui.helper ).html( nicename + '<span class="dashicons dashicons-dismiss"></span>' );
				jQuery( ui.helper ).removeClass( 'nf-one-third' ).addClass( 'nf-item-dock' ).css( { 'opacity': '0.8', 'width': '', 'height': '' } );
			}
			
		},

		outStagedFields: function( ui ) {
			if( jQuery( ui.item ).hasClass( 'nf-field-type-button' ) ) {
				var helperClone = nfRadio.channel( 'app' ).request( 'get:fieldTypeHelperClone' );	
				jQuery( this.currentHelper ).html( jQuery( helperClone ).html() );
				jQuery( this.currentHelper ).removeClass( 'nf-item-dock' ).addClass( 'nf-one-third' );
			}		
		},

		startStagedFields: function( ui ) {
			jQuery( ui.item ).show();
			jQuery( ui.item ).css( { 'display': 'inline', 'opacity': '0.7' } );
			jQuery( ui.helper ).css( 'opacity', '0.5' );
		},

		stopStagedFields: function( ui ) {
			jQuery( ui.item ).css( 'opacity', '' );
			jQuery( ui.helper ).remove();
		}

	});

	return controller;
} );