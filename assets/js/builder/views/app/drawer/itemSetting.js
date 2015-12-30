define( ['views/app/drawer/mergeTagsContent'], function( mergeTagsContentView ) {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-edit-setting-wrap',

		initialize: function( data ) {
			this.dataModel = data.dataModel;
			this.dataModel.on( 'change:' + this.model.get( 'name' ), this.render, this );

			var deps = this.model.get( 'deps' );
			if ( deps ) {
				for ( var name in deps ) {
				    if ( deps.hasOwnProperty( name ) ) {
				    	this.dataModel.on( 'change:' + name, this.render, this );
				    }
				}
			}
		},

		onBeforeDestroy: function() {
			this.dataModel.off( 'change:' + this.model.get( 'name' ), this.render );

			var deps = this.model.get( 'deps' );
			if ( deps ) {
				for (var name in deps) {
				    if ( deps.hasOwnProperty( name ) ) {
				    	this.dataModel.off( 'change:' + name, this.render );
				    }
				}
			}
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

			/*
			 * Apply Setting Field Masks
			 */
			var mask = this.model.get( 'mask' );

			if( typeof mask != "undefined" ){

				var input = jQuery( this.$el ).find( 'input' );

				switch( mask.type ){
					case 'numeric':
						input.autoNumeric({
							aSep: thousandsSeparator,
							aDec: decimalPoint
						});
						break;
					case 'currency':
						input.autoNumeric({
							aSign: '$', // TODO: Use form setting
							aSep: thousandsSeparator,
							aDec: decimalPoint
						});
						break;
					case 'custom':
						if( mask.format ) input.mask( mask.format )
						break;
					default:
						// TODO: Error Logging.
						console.log( 'Notice: Mask type of "' + mask.type + '" is not supported.' );
				}
			}

			/*
			 * Send out a radio message.
			 */
			nfRadio.channel( 'setting-' + this.model.get( 'name' ) ).trigger( 'render:setting', this.model, this.dataModel, this );
		},

		templateHelpers: function () {
			var that = this;
	    	return {

	    		renderVisible: function() {
					if ( this.deps ) {
						for (var name in this.deps) {
						    if ( this.deps.hasOwnProperty( name ) ) {
						        if ( that.dataModel.get( name ) != this.deps[ name ] ) {
						        	return 'style="display:none;"';
						        }
						    }
						}
					}
	    			return '';
	    		},

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
			'change': 'changeSetting',
			'keyup': 'keyUpSetting'
		},

		changeSetting: function( e ) {
			nfRadio.channel( 'app' ).trigger( 'change:setting', e, this.model, this.dataModel );
		},

		keyUpSetting: function( e ) {
			nfRadio.channel( 'app' ).trigger( 'keyup:setting', e, this.model, this.dataModel );
			nfRadio.channel( 'setting-' + this.model.get( 'name' ) ).trigger( 'keyup:setting', e, this.model, this.dataModel );
		}

	});

	return view;
} );
