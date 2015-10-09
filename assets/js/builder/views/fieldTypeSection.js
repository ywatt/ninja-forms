define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-drawer-field-type-section',
		
		initialize: function() {
			_.bindAll( this, 'render' );
		},

		onRender: function() {
			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );

			this.dragging = false;
			var that = this;
			jQuery( this.el ).find( 'div.nf-one-third' ).draggable( {
				helper: 'clone',
				opacity: 0.9,
				start: function( event, ui ) {
					that.dragging = true;
					nfRadio.channel( 'drawer' ).trigger( 'startDrag:fieldType', ui );
				},
				stop: function( event, ui ) {
					that.dragging = false;
					nfRadio.channel( 'drawer' ).trigger( 'stopDrag:fieldType', ui );
				}

			} ).disableSelection();
		},

		events: {
			'click .nf-item': 'clickFieldType',
		},

		clickFieldType: function( el ) {
			if ( ! this.dragging ) {
				nfRadio.channel( 'drawer' ).trigger( 'click:fieldType', el );
			}
		}
	});

	return view;
} );