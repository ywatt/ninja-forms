define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-drawer-header',

		onRender: function() {
			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );

			nfRadio.channel( 'drawer' ).reply( 'filter:clear', this.clearFilter, this );
		},

		events: {
			'keyup .nf-type-filter': 'maybeAddField',
			'input .nf-type-filter': 'filterFields',
			'keydown .nf-type-filter': 'maybeChangeFocus'
		},

		filterFields: function( e ) {
			nfRadio.channel( 'drawer' ).trigger( 'change:fieldTypeFilter', e.target.value, e );
		},

		maybeAddField: function( e ) {
			if ( 13 == e.keyCode ) {
				e.addField = true;
				this.filterFields( e );			
			}
		},

		clearFilter: function() {
			jQuery( this.el ).find( '.nf-type-filter' ).val('');
			jQuery( this.el ).find( '.nf-type-filter' ).trigger( 'input' );
		},

		maybeChangeFocus: function( e ) {
			if ( 9 == e.keyCode ) {
				nfRadio.channel( 'drawer' ).trigger( 'focus:firstFieldType' );
			}
		}

	});

	return view;
} );