define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'main' ), 'show:main', this.initDroppable );
		},

		initDroppable: function() {
			var mainEl = nfRadio.channel( 'app' ).request( 'get:mainEl' );
			var that = this;
			jQuery( mainEl ).droppable( {
				accept: function( draggable ) {
					if ( jQuery( draggable ).hasClass( 'nf-stage' ) || jQuery( draggable ).hasClass( 'nf-one-third' ) ) {
						return true;
					}
				},
				activeClass: 'nf-droppable-active',
				hoverClass: 'nf-droppable-hover',
				over: function( e, ui ) {
					var id = jQuery( ui.helper ).find( '.nf-item' ).data( 'id' );
					var fieldType = nfRadio.channel( 'data' ).request( 'get:fieldType', id );
					var label = fieldType.get( 'nicename' );
					var fieldWidth = jQuery( '#nf-main-content' ).width();
					that.currentHelper = ui.helper;
					that.currentHelperHTML = jQuery( ui.helper ).html();
					jQuery( ui.helper ).html( label );
					jQuery( ui.helper ).removeClass( 'nf-one-third' ).addClass( 'nf-field-wrap' ).css( { 'width': fieldWidth, 'height': '50px' } );
					
				},
				out: function( e, ui ) {
					jQuery( that.currentHelper ).html( that.currentHelperHTML );
					jQuery( that.currentHelper ).removeClass( 'nf-field-wrap' ).addClass( 'nf-one-third' ).css( 'width', '' );
					that.currentHelper = '';
					that.currentHelperHTML = '';
				}

			} );

		}

	});

	return controller;
} );