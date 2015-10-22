define( ['builder/views/drawerStagedField', 'builder/views/drawerStagedFieldsEmpty'], function( stagedFieldView, stagedFieldsEmptyView ) {
	var view = Marionette.CollectionView.extend( {
		tagName: 'div',
		childView: stagedFieldView,
		emptyView: stagedFieldsEmptyView,

		initialize: function() {
			nfRadio.channel( 'app' ).reply( 'get:stagedFieldsEl', this.getStagedFieldsEl, this );
		},

		onShow: function() {

			this.$el = jQuery( this.el ).parent();
			jQuery( this.$el ).find( 'span:first' ).unwrap();
			this.setElement( this.$el );

			var that = this;

			jQuery( this.el ).sortable( {
				placeholder: 'nf-staged-fields-sortable-placeholder',
				helper: 'clone',
				tolerance: 'pointer',
				over: function( e, ui ) {
					nfRadio.channel( 'drawer' ).trigger( 'over:stagedFields', e, ui );
				},

				out: function( e, ui ) {
					nfRadio.channel( 'drawer' ).trigger( 'out:stagedFields', ui );
				},

				receive: function( e, ui ) {
					nfRadio.channel( 'drawer' ).trigger( 'receive:stagedFields', ui );
				},

				update: function( e, ui ) {
					nfRadio.channel( 'data' ).request( 'sort:stagedFields' );
				},

				start: function( e, ui ) {
					nfRadio.channel( 'drawer' ).trigger( 'start:stagedFields', ui );

				},

				stop: function( e, ui ) {
					nfRadio.channel( 'drawer' ).trigger( 'stop:stagedFields', ui );
				}
			} );

			jQuery( this.el ).parent().draggable( {
				helper: 'clone',
				opacity: 0.9,
				connectToSortable: '.nf-fields-sortable',

				start: function( e, ui ) {
					nfRadio.channel( 'drawer' ).trigger( 'startDrag:fieldStaging', this, ui );
				},
				stop: function( e, ui ) {
					nfRadio.channel( 'drawer' ).trigger( 'stopDrag:fieldStaging', this, ui );
				}
			} );
		},

		getStagedFieldsEl: function() {
			return jQuery( this.el );
		}

	} );

	return view;
} );