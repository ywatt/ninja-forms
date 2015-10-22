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
				helper: function( e ) {
					var width = jQuery( e.target ).parent().width();
					var height = jQuery( e.target ).parent().height();
					var element = jQuery( e.target ).parent().clone();
					var left = width / 4;
					var top = height / 2;
					jQuery( this ).draggable( 'option', 'cursorAt', { top: top, left: left } );

					return element;
				},
				opacity: 0.9,
				tolerance: 'pointer',
				
				start: function( e, ui ) {
					that.dragging = true;
					jQuery( '.nf-reservoir' ).click();
					nfRadio.channel( 'drawer' ).trigger( 'startDrag:fieldType', this, ui );
				},

				stop: function( e, ui ) {
					that.dragging = false;
					nfRadio.channel( 'drawer' ).trigger( 'stopDrag:fieldType', this, ui );
				},

				connectToSortable: '.nf-field-type-droppable'

			} ).disableSelection();

			jQuery( this.el ).find( '.nf-item' ).focus( function() {
		    	jQuery( this ).addClass( 'active' );
		    } ).blur( function() {
		    	jQuery( this ).removeClass( 'active' );
		    } );
		},

		events: {
			'click .nf-item': 'clickFieldType',
			'keydown .nf-item': 'maybeClickFieldType'
		},

		clickFieldType: function( e ) {
			if ( ! this.dragging ) {
				nfRadio.channel( 'drawer' ).trigger( 'click:fieldType', e );
			}
		},

		maybeClickFieldType: function( e ) {
			if ( 13 == e.keyCode ) {
				this.clickFieldType( e );
				nfRadio.channel( 'drawer' ).request( 'clear:filter' );
			}
		}
	});

	return view;
} );