define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-app-menu-item',

		initialize: function() {
			this.listenTo( nfRadio.channel( 'app' ), 'change:currentDomain', this.render );
			this.model.on( 'change', this.render, this );
		},

		onRender: function() {
			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );
		},

		events: {
			'click a': 'clickAppMenu'
		},

		clickAppMenu: function( e ) {
			nfRadio.channel( 'app' ).trigger( 'click:menu', e, this.model );
		},

		templateHelpers: function() {
			return {
				renderDashicons: function() {
					if ( this.dashicons ) {
						return '<span class="dashicons ' + this.dashicons + '"></span>'
					} else {
						return '';
					}
				},

				renderClasses: function() {
					var classes = this.classes;
					var currentDomain = nfRadio.channel( 'app' ).request( 'get:currentDomain' );
					if ( currentDomain.get( 'id' ) == this.id ) {
						classes += ' active';
					}
					return classes;
				},

				renderUrl: function() {
					if ( '' != this.url ) {
						return this.url;
					} else {
						return '#';
					}
				},

				renderTarget: function() {
					if ( '' != this.url ) {
						return '_blank';
					} else {
						return '_self';
					}
				},

				renderDisabled: function() {
					if ( this.disabled ) {
						return 'disabled';
					} else {
						return '';
					}
				}
			}
		}

	});

	return view;
} );