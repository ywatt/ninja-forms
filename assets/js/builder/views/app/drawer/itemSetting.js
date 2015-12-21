define( ['views/app/drawer/mergeTagsContent'], function( mergeTagsContentView ) {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-edit-setting-wrap',

		initialize: function( data ) {
			this.dataModel = data.dataModel;
		},

		onBeforeRender: function() {
			nfRadio.channel( 'app' ).trigger( 'before:renderSetting', this.model, this.dataModel );
		},

		onRender: function() {
			this.mergeTagsContentView = false;
			var that = this;

			jQuery( this.el ).find( '.nf-help' ).each(function() {
				var content = jQuery(this).next('.nf-help-text');
				jQuery( this ).jBox( 'Tooltip', {
					content: content,
					maxWidth: 200,
					theme: 'TooltipBorder',
					trigger: 'click',
					closeOnClick: true
				})
		    });

			jQuery( this.el ).find( '.merge-tags' ).each(function() {
				jQuery( this ).jBox( 'Tooltip', {
					title: 'Insert Merge Tag',
					content: jQuery( '.merge-tags-content' ),
					trigger: 'click',
					position: {
						x: 'center',
						y: 'bottom'
					},
					closeOnClick: 'body',
					closeOnEsc: true,
					theme: 'TooltipBorder',
					maxHeight: 200,
					onOpen: function() {
						var currentElement = jQuery( that.el ).find( '.setting' );
						nfRadio.channel( 'mergeTags' ).request( 'update:currentElement', currentElement );
						nfRadio.channel( 'mergeTags' ).request( 'update:open', true );
						nfRadio.channel( 'drawer' ).request( 'prevent:close', 'merge-tags' );
					},
					onCloseComplete: function() {
						nfRadio.channel( 'mergeTags' ).request( 'update:open', false );
						nfRadio.channel( 'drawer' ).request( 'enable:close', 'merge-tags' );
					}
				})
		    });

		    nfRadio.channel( 'app' ).trigger( 'render:setting', this.el, this.model, this.dataModel );
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
					if ( this.help ) {
						return '<a class="nf-help" href="#"><span class="dashicons dashicons-admin-comments"></span></a><div class="nf-help-text">' + this.help + '</div>';
					} else {
						return '';
					}
				},

				renderMergeTags: function() {
					if ( this.use_merge_tags ) {
						return '<span class="dashicons dashicons-list-view merge-tags"></span>';
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
