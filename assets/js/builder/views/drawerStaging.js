define( ['builder/views/drawerStagedField'], function( stagedFieldView ) {
	var view = Marionette.CollectionView.extend( {
		tagName: 'div',
		childView: stagedFieldView,

		initialize: function() {
			nfRadio.channel( 'app' ).reply( 'get:stagedFieldsEl', this.getStagedFieldsEl, this );
		},

		onDomRefresh: function() {
			jQuery( this.el ).parent().droppable( {
				accept: '.nf-one-third',
				hoverClass: 'nf-droppable-hover',

				drop: function( event, ui ) {
					var type = jQuery( ui.draggable ).find( '.nf-item' ).data( 'id' );
					nfRadio.channel( 'drawer' ).trigger( 'dropped:fieldStaging', type );
				}
				
			} );

			jQuery( this.el ).sortable( {
				update: function( event, ui ) {
					var newOrder = jQuery( this ).sortable( 'toArray' );
					for (var i = newOrder.length - 1; i >= 0; i--) {
						newOrder[i] = newOrder[i].replace( 'nf-staged-field-', '' );
					};
					nfRadio.channel( 'drawer' ).trigger( 'sorted:fieldStaging', newOrder );
				}
			} );

			jQuery( this.el ).parent().parent().draggable( {
				helper: 'clone',
				opacity: 0.9,
				connectToSortable: '.nf-fields-sortable',
				
				start: function( event, ui ) {
					nfRadio.channel( 'drawer' ).trigger( 'startDrag:fieldStaging', this, ui );
				},
				stop: function( event, ui ) {
					nfRadio.channel( 'drawer' ).trigger( 'stopDrag:fieldStaging', this, ui );
				}
			} );
		},

		getStagedFieldsEl: function() {
			return jQuery( this.el ).parent();
		}

	} );

	return view;
} );