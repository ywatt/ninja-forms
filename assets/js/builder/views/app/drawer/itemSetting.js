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


			var mergeTagContent = '<label class="nf-select"><select><option>- Select Tag</option>';
			var fieldCollection = nfRadio.channel( 'fields' ).request( 'get:collection' );
			if ( 0 < fieldCollection.models.length ) {
				mergeTagContent += '<optgroup label="Fields">';
				_.each( fieldCollection.models, function( field ) {
					mergeTagContent += '<option value="' + field.get( 'id' ) + '">' + field.get( 'label' ) + '</option>';
				} );
				mergeTagContent += '</optgroup>';
			}
			
			mergeTagContent += '<optgroup label="System Tags"><option>Date</option><option>Time</option><option>IP</option></optgroup><optgroup label="User Info"><option>First Name (if logged-in)</option><option>Last Name (if logged-in)</option><option>Email (if logged-in)</option></optgroup></select><div></div></label>';
			mergeTagContent += '<a href="#" class="nf-button secondary insert">Insert</a>';

			jQuery( this.el ).find( '.merge-tags' ).each(function() {
				jQuery( this ).jBox( 'Tooltip', {
					title: 'Insert Merge Tag',
					content: mergeTagContent,
					trigger: 'click',
					position: {
						x: 'right',
						y: 'center'
					},
					outside: 'x',
					closeButton: 'box',
					closeOnClick: 'body',
					theme: 'TooltipBorder'
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
