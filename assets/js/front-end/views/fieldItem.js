define( ['views/fieldErrorCollection', 'views/inputLimit'], function( fieldErrorCollection, InputLimitView ) {
	var view = Marionette.ItemView.extend({
		tagName: 'nf-section',

		initialize: function() {
			// _.bindAll( this, 'render' );
    		this.model.on( 'change:reRender', this.maybeRender, this );
    		this.model.on( 'change:errors', this.changeError, this );
    		this.model.on( 'change:addWrapperClass', this.addWrapperClass, this );
    		this.model.on( 'change:removeWrapperClass', this.removeWrapperClass, this );
    		// this.listenTo( nfRadio.channel( 'submit' ), 'before:submit', this.test );

    		this.template = '#nf-tmpl-field-' + this.model.get( 'wrap_template' );
		},

		onBeforeDestroy: function() {
			this.model.off( 'change:reRender', this.maybeRender );
    		this.model.off( 'change:errors', this.changeError );
    		this.model.off( 'change:addWrapperClass', this.addWrapperClass );
    		this.model.off( 'change:removeWrapperClass', this.removeWrapperClass );
		},

		test: function( model ) {
			console.log( 'firing from trigger 1' );
		},

		changeError: function() {
			if ( 0 == this.model.get( 'errors' ).models.length ) {
				this.model.removeWrapperClass( 'nf-error' );
			} else {
				this.model.addWrapperClass( 'nf-error' );
			}

			this.errorCollectionView.render();
		},

		addWrapperClass: function() {
			var cl = this.model.get( 'addWrapperClass' );
			if ( '' != cl ) {
				jQuery( this.el ).addClass( cl );
				this.model.set( 'addWrapperClass', '' );
			}
		},

		removeWrapperClass: function() {
			var cl = this.model.get( 'removeWrapperClass' );
			if ( '' != cl ) {
				jQuery( this.el ).removeClass( cl );
				this.model.set( 'removeWrapperClass', '' );
			}
		},

		maybeRender: function() {
			if ( this.model.get( 'reRender' ) ) {
				this.model.set( 'reRender', false, { silent: true } );
				this.render();
			}
		},

		onRender: function() {
			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );

			var el = jQuery( this.el ).children( '.nf-error-wrap' );
    		this.errorCollectionView = new fieldErrorCollection( { el: el, collection: this.model.get( 'errors' ), thisModel: this.model } );

    		/*
    		 * If we have an input limit set, render the view that contains our counter
    		 * TODO: Move this to a controller so that the logic isn't in the view.
    		 */
    		if ( 'undefined' != typeof this.model.get( 'input_limit' ) && '' != jQuery.trim( this.model.get( 'input_limit' ) ) ){
    			el = jQuery( this.el ).children( '.nf-input-limit');
    			this.inputLimitView = new InputLimitView( { el: el, model: this.model } );
    		}

    		/*
    		 * If we have an input mask, init that mask.
    		 * TODO: Move this to a controller so that the logic isn't in the view.
    		 */
    		if ( 'undefined' != typeof this.model.get( 'mask' ) && '' != jQuery.trim( this.model.get( 'mask' ) ) ) {
    			if ( 'custom' == this.model.get( 'mask') ) {
    				var mask = this.model.get( 'custom_mask' );
    			} else {
    				var mask = this.model.get( 'mask' );
    			}
    			jQuery( this.el ).find( '.nf-element' ).mask( mask );
    		}

			nfRadio.channel( this.model.get( 'type' ) ).trigger( 'render:view', this );
			nfRadio.channel( 'fields' ).trigger( 'render:view', this );
		},

		templateHelpers: function () {
	    	return {

				renderElement: function(){
					this.setPlaceholder();
					this.setClasses();
					var tmpl = _.find( this.element_templates, function( tmpl ) {
						if ( 0 < jQuery( '#nf-tmpl-field-' + tmpl ).length ) {
							return true;
						}
					} );
					var template = _.template( jQuery( '#nf-tmpl-field-' + tmpl ).html() );
					return template( this );
				},

				renderLabel: function() {
					var template = _.template( jQuery( '#nf-tmpl-field-label' ).html() );
					return template( this );
				},

				setPlaceholder: function() {
					if ( 'inside' == this.label_pos ) {
						this.placeholder = this.label;
					}
				},

				renderPlaceholder: function() {
					if( '' != jQuery.trim( this.placeholder ) ) {
						return 'placeholder="' + this.placeholder + '"';
					} else {
						return '';
					}
				},

				renderWrapClass: function() {
					var wrapClass = 'field-wrap ' + this.type + '-wrap label-' + this.label_pos;

					// if we have a wrapper_class field setting, add that to our wrap.
					if ( 'undefined' != typeof this.wrapper_class && 0 < jQuery.trim( this.wrapper_class ).length ) {
						wrapClass += ' ' + this.wrapper_class;
					}

					// If we have an old_classname defined, output wrap class for backward compatibility
					if ( 'undefined' != typeof this.old_classname && 0 < jQuery.trim( this.old_classname ).length ) {
						wrapClass += ' ' + this.old_classname + '-wrap';
					}

					return wrapClass;

				},

				setClasses: function() {
					if ( this.error ) {
						this.classes += ' nf-error';
					} else {
						this.classes = this.classes.replace( 'nf-error', '' );
					}

					if ( 'undefined' != typeof this.element_class && 0 < jQuery.trim( this.element_class ).length ) {
						this.classes += ' ' + this.element_class;
					}
				},

				maybeDisabled: function() {
					if ( 1 == this.disable_input ) {
						return 'disabled';
					} else {
						return '';
					}
				},

				maybeDisableAutocomplete: function() {
					if ( 1 == this.disable_browser_autocomplete ) {
						return 'autocomplete="off"';
					} else {
						return '';
					}
				},

				maybeInputLimit: function() {
					if ( '' != jQuery.trim( this.input_limit ) ) {
						return 'maxlength="' + this.input_limit + '"';
					} else {
						return '';
					}
				},

				getHelpText: function() {
					this.help_text = jQuery( this.help_text ).html();
					return this.help_text.replace( /"/g, "&quot;" );
				}
			};
		},

		events: {
			'change .nf-element': 'fieldChange',
			'keyup .nf-element': 'fieldKeyup',
			'click .nf-element': 'fieldClick',
			'blur .nf-element': 'fieldBlur'
		},

		fieldChange: function( e ) {
			var el = jQuery( e.currentTarget );
			var response = nfRadio.channel( 'nfAdmin' ).request( 'change:field', el, this.model );
		},

		fieldKeyup: function( e ) {
			var el = jQuery( e.currentTarget );
			var keyCode = e.keyCode;
			nfRadio.channel( 'field-' + this.model.get( 'id' ) ).trigger( 'keyup:field', el, this.model );
			nfRadio.channel( this.model.get( 'type' ) ).trigger( 'keyup:field', el, this.model, keyCode );
			nfRadio.channel( 'fields' ).trigger( 'keyup:field', el, this.model, keyCode );
		},

		fieldClick: function( e ) {
			var el = jQuery( e.currentTarget );
			nfRadio.channel( 'field-' + this.model.get( 'id' ) ).trigger( 'click:field', el, this.model );
			nfRadio.channel( this.model.get( 'type' ) ).trigger( 'click:field', el, this.model );
			nfRadio.channel( 'fields' ).trigger( 'click:field', el, this.model );
		},

		fieldBlur: function( e ) {
			var el = jQuery( e.currentTarget );
			nfRadio.channel( 'field-' + this.model.get( 'id' ) ).trigger( 'blur:field', el, this.model );
			nfRadio.channel( this.model.get( 'type' ) ).trigger( 'blur:field', el, this.model );
			nfRadio.channel( 'fields' ).trigger( 'blur:field', el, this.model );
		}
	});

	return view;
} );
