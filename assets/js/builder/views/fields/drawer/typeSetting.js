define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-edit-field-setting-wrap',

		initialize: function( data ) {
			this.fieldModel = data.fieldModel;
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
	    			if ( 'undefined' != typeof that.fieldModel.get( this.name ) ) {
	    				this.value = that.fieldModel.get( this.name );
	    			} else {
	    				this.value = '';
	    			}
	    			
					return _.template( jQuery( '#nf-tmpl-edit-field-setting-' + this.type ).html(), this );
				},
				
				renderWidth: function() {
					if ( 'undefined' != typeof this.width ) {
						return this.width;
					} else {
						return 'one-half';
					}
				}
			}
		},

		events: {
			'change': 'changeSetting'
		},

		changeSetting: function( e ) {
			nfRadio.channel( 'fields' ).trigger( 'change:setting', e, this.model, this.fieldModel );
		}

	});

	return view;
} );