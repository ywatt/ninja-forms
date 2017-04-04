define( ['views/app/itemControls'], function( itemControlsView ) {
	var view = Marionette.LayoutView.extend({
		tagName: 'div',
		template: '#tmpl-nf-main-content-field-generic',
		doingShortcut: false,

		regions: {
			itemControls: '.nf-item-controls'
		},

		initialize: function() {
			this.model.on( 'change:editActive', this.render, this );
			this.model.on( 'change:label', this.render, this );
			this.model.on( 'change:required', this.render, this );
			this.model.on( 'change:id', this.render, this );
			this.model.on( 'change:placeholder', this.render, this );
			this.model.on( 'change:label_pos', this.render, this );
			this.model.on( 'change:default', this.render, this );
			this.model.on( 'change:default_value', this.render, this );

			/**
			 * Set our field template.
			 */
			if ( 0 != jQuery( '#tmpl-nf-field-' + this.model.get( 'type' ) ).length ) {
				var wrapTmpl = nfRadio.channel( 'fields' ).request( 'get:type', this.model.get( 'type' ) ).get( 'wrap_template' );
				this.template = '#tmpl-nf-main-content-field-' + wrapTmpl;
			}

		},

		onBeforeDestroy: function() {
			this.model.off( 'change:editActive', this.render );
			this.model.off( 'change:label', this.render );
			this.model.off( 'change:required', this.render );
			this.model.off( 'change:id', this.render );
		},

		onRender: function() {
			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );

			this.itemControls.show( new itemControlsView( { model: this.model } ) );
			jQuery( this.el ).disableSelection();

			if ( nfRadio.channel( 'app' ).request( 'is:mobile' ) ) {
				jQuery( this.el ).on( 'taphold', function( e, touch ) {
					if ( ! jQuery( e.target ).hasClass( 'nf-edit-settings' ) ) {
						jQuery( this ).addClass( 'ui-sortable-helper drag-selected' );
						jQuery( this ).ClassyWiggle( 'start', { degrees: ['.65', '1', '.65', '0', '-.65', '-1', '-.65', '0'], delay: 50 } );
					}
				} );
			}

			/**
			 * Checkbox-specific changes.
			 * TODO: Move these to a checkbox-specific controller
			 */
			if ( 'checked' == this.model.get( 'default_value' ) ) {
				jQuery( this.el ).find( 'label' ).addClass( 'nf-checked-label' );
				jQuery( this.el ).find( 'input' ).addClass( 'nf-checked' );
			} else {
				jQuery( this.el ).find( 'label' ).removeClass( 'nf-checked-label' );
				jQuery( this.el ).find( 'input' ).removeClass( 'nf-checked' );
			}
		},

		templateHelpers: function () {
	    	return {
	    		renderClasses: function() {
	    			var classes = 'nf-field-wrap';
	    			if ( this.editActive ) {
	    				classes += ' active';
	    			}
	    			return classes;
	    		},
	    		renderRequired: function() {
	    			if ( 1 == this.required ) {
	    				return '<span class="required">*</span>';
	    			} else {
	    				return '';
	    			}
	    		},
	    		getFieldID: function() {
					if ( jQuery.isNumeric( this.id ) ) {
						return 'field-' + this.id;
					} else {
						return this.id;
					}
				},
				renderIcon: function() {
					var type = nfRadio.channel( 'fields' ).request( 'get:type', this.type );
					return '<span class="fa fa-' + type.get( 'icon' ) + '"></span>';
				},
				renderContainerClass: function() {
					var label_pos = this.label_pos;
					if ( 'default' == this.label_pos || 'undefined' == typeof this.label_pos ) {
						/**
						 *  Get our plugin-wide label position
						 */
						label_pos = nfRadio.channel( 'settings' ).request( 'get:setting', 'default_label_pos' );
					}
                    var containerClass = ' label-' + label_pos + ' ';
                    // If we have a description position, add that to our container.
                    if ( 'undefined' != typeof this.desc_pos ) {
                        containerClass += 'desc-' + this.desc_pos + ' ';
                    }
                    // if we have a container_class field setting, add that to our container.
                    if ( 'undefined' != typeof this.container_class && 0 < jQuery.trim( this.container_class ).length ) {
                        containerClass += this.container_class + ' ';
                    }

                    return containerClass;
                },
                renderWrapClass: function() {
					var wrapClass = 'field-wrap ' + this.type + '-wrap';

					// If we have an old_classname defined, output wrap class for backward compatibility
					if ( 'undefined' != typeof this.old_classname && 0 < jQuery.trim( this.old_classname ).length ) {
						wrapClass += ' ' + this.old_classname + '-wrap';
					}

					if ( 'undefined' != typeof customWrapClass ) {
						wrapClass = customWrapClass( wrapClass );
					}

					return wrapClass;
				},
				renderLabel: function() {
					var template = nfRadio.channel( 'app' ).request( 'get:template',  '#tmpl-nf-field-label' );
					return template( this );
				},
				renderLabelClasses: function () {
					var classes = '';
					if ( 'undefined' != typeof this.customLabelClasses ) {
						classes = this.customLabelClasses( classes );
					}
					return classes;
				},
				maybeRenderHelp: function() {
					var check_text = '<p>' + this.help_text + '</p>';
					if ( 'undefined' != typeof this.help_text && 0 != jQuery.trim( jQuery( check_text ).text() ).length ) {
						return '<span class="fa fa-info-circle nf-help" data-text="' + this.getHelpText() + '"></span>';
					} else {
						return '';
					}
				},
				renderElement: function(){
					if ( 0 < jQuery( '#tmpl-nf-field-' + this.type ).length ) {
						var tmpl = '#tmpl-nf-field-' + this.type;
					} else {
						var tmpl = '#tmpl-nf-empty';
					}
					
					var template = nfRadio.channel( 'app' ).request( 'get:template', tmpl );
					return template( this );
				},
				renderDescText: function() {
					if ( 'undefined' == typeof this.desc_text ) {
						return '';
					}
					var check_text = '<p>' + this.desc_text + '</p>';
					if ( 0 != jQuery.trim( jQuery( check_text ).text() ).length ) {
						return '<div class="nf-field-description">' + this.desc_text + '</div>';
					} else {
						return '';
					}
				},
				renderPlaceholder: function() {
					var placeholder = this.placeholder;

					if ( 'undefined' != typeof this.customPlaceholder ) {
						placeholder = this.customPlaceholder( placeholder );
					}

					if( '' != jQuery.trim( placeholder ) ) {
						return 'placeholder="' + placeholder + '"';
					} else {
						return '';
					}
				},
				maybeChecked: function() {
					if ( 'checked' == this.default_value ) {
						return ' checked';
					} else {
						return '';
					}
				},
				maybeDisabled: function() {
					return '';
				},
				maybeDisableAutocomplete: function() {
					return '';
				},
				maybeInputLimit: function() {
					return '';
				}
			};
		},

		events: {
			'mouseover .nf-item-control': 'mouseoverItemControl',
			'mousedown': 'maybeShortcut',
			'click': 'maybeClickEdit',
			'singletap': 'maybeTapEdit',
			'swipeleft': 'swipeLeft',
			'swiperight': 'swipeRight',
			'tapend': 'tapend'
		},

		maybeClickEdit: function( e ) {
			if ( this.doingShortcut ) {
				this.doingShortcut = false;
				return false;
			}

			if ( ( jQuery( e.target ).parent().hasClass( 'nf-fields-sortable' ) || jQuery( e.target ).parent().hasClass( 'nf-field-wrap' ) || jQuery( e.target ).hasClass( 'nf-field-wrap' ) ) && ! nfRadio.channel( 'app' ).request( 'is:mobile' ) ) {
				jQuery( ':focus' ).blur();
				nfRadio.channel( 'app' ).trigger( 'click:edit', e, this.model );
			}
		},

		maybeShortcut: function( e ) {
			var keys = nfRadio.channel( 'app' ).request( 'get:keydown' );
			/*
			 * If the shift key isn't held down, return.
			 */
			if ( -1 == keys.indexOf( 16 ) ) {
				return true;
			}
			/*
			 * If we are pressing D, delete this field.
			 */
			if ( -1 != keys.indexOf( 68 ) ) {
				nfRadio.channel( 'app' ).trigger( 'click:delete', e, this.model );
				this.doingShortcut = true;
				return false;
			} else if ( -1 != keys.indexOf( 67 ) ) {
				this.doingShortcut = true;
				nfRadio.channel( 'app' ).trigger( 'click:duplicate', e, this.model );
				return false;
			}
		},

		maybeTapEdit: function( e ) {
			if ( jQuery( e.target ).parent().hasClass( 'nf-fields-sortable' ) ) {
				nfRadio.channel( 'app' ).trigger( 'click:edit', e, this.model );
			}
		},

		swipeLeft: function( e, touch ) {
			jQuery( touch.startEvnt.target ).closest( 'div' ).find( '.nf-item-duplicate' ).show();
			jQuery( touch.startEvnt.target ).closest( 'div' ).find( '.nf-item-delete' ).show();
		},

		swipeRight: function( e, touch ) {
			jQuery( touch.startEvnt.target ).closest( 'div' ).find( '.nf-item-duplicate' ).hide();
			jQuery( touch.startEvnt.target ).closest( 'div' ).find( '.nf-item-delete' ).hide();
		},

		tapend: function( e, touch ) {
			jQuery( this.el ).ClassyWiggle( 'stop' );
			jQuery( this.el ).removeClass( 'ui-sortable-helper drag-selected' );
		},

		remove: function(){
			if ( nfRadio.channel( 'fields' ).request( 'get:removing' ) ) {
				this.$el.hide( 'clip', function(){
					jQuery( this ).remove();
				});
			} else {
				this.$el.remove();
			}

			nfRadio.channel( 'fields' ).request( 'set:removing', false );
		},

		mouseoverItemControl: function( e ) {
			jQuery( this.el ).find( '.nf-item-control' ).css( 'display', '' );
		}

	});

	return view;
} );