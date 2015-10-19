define( ['builder/views/mainContentField', 'builder/views/mainContentFieldsEmpty'], function( mainContentFieldView, mainContentFieldEmptyView ) {
	var view = Marionette.CollectionView.extend( {
		tagName: 'div',
		childView: mainContentFieldView,
		emptyView: mainContentFieldEmptyView,

		initialize: function() {
			nfRadio.channel( 'app' ).reply( 'get:fieldsSortableEl', this.getFieldsSortableEl, this );
		},

		onRender: function() {
			jQuery( this.el ).hide();
		},

		onShow: function() {
			jQuery( this.el ).fadeIn();
			jQuery( this.el ).addClass( 'nf-fields-sortable' );
			var that = this;
			jQuery( this.el ).sortable( {
				containment: '#nf-main',
				helper: 'clone',
				cancel: '.nf-item-controls',
				placeholder: 'nf-fields-sortable-placeholder',
				opacity: 0.8,

				receive: function( e, ui ) {
					if( jQuery( ui.item ).hasClass( 'nf-field-type-button' ) ) {
						var id = jQuery( ui.item ).find( '.nf-item' ).data( 'id' );
						var fieldType = nfRadio.channel( 'data' ).request( 'get:fieldType', id );
						var label = fieldType.get( 'nicename' );
						var fieldWidth = jQuery( that.el ).width();
						jQuery( ui.helper ).html( label + jQuery( '.nf-field-hover' ).html() );
						jQuery( ui.helper ).removeClass( 'nf-one-third' ).removeClass( 'ui-draggable' ).removeClass( 'nf-field-type-button' ).addClass( 'nf-field-wrap' ).css( { 'width': fieldWidth, 'height': '50px' } );
						jQuery( this ).removeClass( 'nf-droppable-hover' );
						jQuery( ui.helper ).attr( 'style', '' );

						nfRadio.channel( 'app' ).trigger( 'drop:fieldType' );
					}
				},

				over: function( e, ui ) {
					if( jQuery( ui.item ).hasClass( 'nf-field-type-button' ) ) {
						var id = jQuery( ui.helper ).find( '.nf-item' ).data( 'id' );
						var fieldType = nfRadio.channel( 'data' ).request( 'get:fieldType', id );
						var label = fieldType.get( 'nicename' );
						var fieldWidth = jQuery( '.nf-fields-sortable' ).width();
						that.currentHelper = ui.helper;
						that.currentItem = ui.item;
						jQuery( ui.helper ).html( label );
						jQuery( ui.helper ).removeClass( 'nf-one-third' ).addClass( 'nf-field-wrap' ).css( { 'width': fieldWidth, 'height': '50px' } );
						jQuery( this ).addClass( 'nf-droppable-hover' );
					}
				},

				out: function( e, ui ) {
					if( jQuery( ui.item ).hasClass( 'nf-field-type-button' ) ) {
						var helperClone = nfRadio.channel( 'app' ).request( 'get:fieldTypeHelperClone' );
						
						jQuery( that.currentHelper ).html( jQuery( helperClone ).html() );
						jQuery( that.currentHelper ).removeClass( 'nf-field-wrap' ).addClass( 'nf-one-third' ).css( { 'width': '', 'height': '' } );
						jQuery( this ).removeClass( 'nf-droppable-hover' );
					}
				},

				start: function( e, ui ) {
					jQuery( ui.item ).show();
				},

				stop: function( e, ui ) {
					jQuery( ui.helper ).remove();
				}
			} );
		},

		getFieldsSortableEl: function() {
			return this.el;
		}
	} );

	return view;
} );