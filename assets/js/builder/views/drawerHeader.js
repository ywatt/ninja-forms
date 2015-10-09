define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-drawer-header',
		
		onRender: function() {
			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );
		},

		events: {
			'keyup .nf-type-filter': 'filterFields',
			'change .nf-type-filter': 'filterFields'
		},

		filterFields: function( el ) {
			nfRadio.channel( 'drawer' ).trigger( 'change:fieldTypeFilter', el.target.value );
		}
	});

	return view;
} );