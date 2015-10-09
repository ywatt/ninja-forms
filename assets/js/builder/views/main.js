define( ['builder/views/mainHeader', 'builder/views/mainContent'], function( mainHeaderView, mainContentView ) {

	var view = Marionette.LayoutView.extend({
		tagName: "div",
		template: "#nf-tmpl-main",

		regions: {
			header: "#nf-main-header",
			content: "#nf-main-content"
		},

		onShow: function() {
			this.header.show( new mainHeaderView() );
			this.header.show( new mainContentView() );

			jQuery( this.el ).parent().perfectScrollbar();

			jQuery( this.el ).parent().droppable( {
				accept: function( draggable ) {
					if ( jQuery( draggable ).hasClass( 'nf-stage' ) || jQuery( draggable ).hasClass( 'nf-one-third' ) ) {
						return true;
					}
				},
				activeClass: 'nf-droppable-active',
				hoverClass: 'nf-droppable-hover'
			} );
		}

	});

	return view;
} );