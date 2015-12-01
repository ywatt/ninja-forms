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

		onRender: function() {
			jQuery( this.el ).find( '.nf-help' ).each(function() {
				var content = jQuery(this).next('.nf-help-text');
				jQuery( this ).jBox( 'Tooltip', {
					content: content,
					// delayOpen: 1500,
					theme: 'TooltipBorder',
					trigger: 'click',
					closeOnClick: true
				})
		    });


			var mergeTagContent = '';
			var fieldCollection = nfRadio.channel( 'fields' ).request( 'get:collection' );
			if ( 0 < fieldCollection.models.length ) {
				mergeTagContent += '<h4>Fields</h4><ul>';
				_.each( fieldCollection.models, function( field ) {
					mergeTagContent += '<li><a href="#">' + field.get( 'label' ) + '</a></li>';
				} );
				mergeTagContent += '</ul>';
			}
			
			mergeTagContent += '<h4>System Tags</h4><ul>';
			mergeTagContent += '<li><a href="#">Date</a></li><li><a href="#">Time</a></li><li><a href="#">IP</a></li></ul><h4>User Information</h4><ul><li><a href="#">First Name (if logged-in)</a></li><li><a href="#">Last Name (if logged-in)</a></li><li><a href="#">Email (if logged-in)</a></li></ul>';

			jQuery( this.el ).find( '.merge-tags' ).each(function() {
				jQuery( this ).jBox( 'Tooltip', {
					title: 'Insert Merge Tag',
					content: mergeTagContent,
					trigger: 'click',
					position: {
						x: 'center',
						y: 'bottom'
					},
					closeButton: 'box',
					closeOnClick: 'body',
					theme: 'TooltipBorder',
					maxHeight: 200
				})
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
					return 'has-merge-tags';
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
			'change': 'changeSetting',
			'click': 'insertMergeTag'
		},

		changeSetting: function( e ) {
			nfRadio.channel( 'app' ).trigger( 'change:setting', e, this.model, this.dataModel );
		}

	});

	return view;
} );
