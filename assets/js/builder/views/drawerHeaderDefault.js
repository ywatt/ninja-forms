define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-drawer-header-default',

		onRender: function() {
			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );

			nfRadio.channel( 'drawer' ).reply( 'clear:filter', this.clearFilter, this );
			nfRadio.channel( 'drawer' ).reply( 'blur:filter', this.blurFilter, this );
			nfRadio.channel( 'drawer' ).reply( 'get:filterEl', this.getEl, this );
		},

		events: {
			'keyup .nf-filter': 'maybeChangeFilter',
			'input .nf-filter': 'changeFilter'
		},

		changeFilter: function( e ) {
			nfRadio.channel( 'drawer' ).trigger( 'change:filter', e.target.value, e );
		},

		maybeChangeFilter: function( e ) {
			if ( 13 == e.keyCode ) {
				e.addField = true;
				this.changeFilter( e );			
			}
		},

		clearFilter: function() {
			var filterEl =  jQuery( this.el ).find( '.nf-filter' );
			if ( '' != jQuery.trim( filterEl.val() ) ) {
				filterEl.val('');
				filterEl.trigger( 'input' );
				filterEl.focus();			
			}
		},

		blurFilter: function() {
			jQuery( this.el ).find( '.nf-filter' ).blur();
		},

		getEl: function() {
			return jQuery( this.el ).find( '.nf-filter' );
		}
	});

	return view;
} );