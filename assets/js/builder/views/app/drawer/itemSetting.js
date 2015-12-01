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

			jQuery( this.el ).find( '.tooltip' ).jBox( 'Tooltip' );
		},

		onRender: function() {
			jQuery( this.el ).find( '.nf-help' ).each(function() {
		        jQuery(this).qtip({
		        	show: {
				        delay: 1500,
				    },
		        	// show: {
	        	 //    	event: 'hover',
	        	 //   	},
	        	 //   	hide: {
	        	 //   		event: 'unfocus',
	        	 //   	},
		      		position: {
		      			my: 'bottom center',
            			at: 'top center',
						adjust: {
							mouse: false,
							y: -20,
						}
				    },
		            content: {
		                text: jQuery(this).next('.nf-help-text')
		            }
		        });
		    });

		    
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

				renderLabelClasses: function() {
					return 'merge-tags';
				},

				renderWidth: function() {
					if ( 'undefined' != typeof this.width ) {
						return this.width;
					} else {
						return 'one-half';
					}
				},

				renderTooltip: function() {
					if ( 'undefined' != typeof this.help ) {
						return '<a class="nf-help" href="#"><span class="dashicons dashicons-admin-comments"></span></a><div class="nf-help-text">' + this.help + '</div>';
					} else {
						return '';
					}
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
