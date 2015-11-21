define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-edit-setting-wrap',

		initialize: function( data ) {
			this.dataModel = data.dataModel;
		},

		onShow: function() {
			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );
		},

		templateHelpers: function () {
			var that = this;
	    	return {
	    		renderSetting: function(){
	    			if ( 'undefined' != typeof that.dataModel.get( this.name ) ) {
	    				this.value = that.dataModel.get( this.name );
	    			} else {
	    				this.value = '';
	    			}

					return _.template( jQuery( '#nf-tmpl-edit-setting-' + this.type ).html(), this );
				},

				renderWidth: function() {
					if ( 'undefined' != typeof this.width ) {
						return this.width;
					} else {
						return 'one-half';
					}
				},

				renderTooltip: function() {
					return 'tooltip';
				}
			}
		},

		events: {
			'change': 'changeSetting'
		},

		changeSetting: function( e ) {
			nfRadio.channel( 'app' ).trigger( 'change:setting', e, this.model, this.dataModel );
		}

	});

	return view;
} );
