define( ['front-end/views/fieldErrorCollection'], function( fieldErrorCollection ) {
	var view = Marionette.ItemView.extend({
		tagName: 'nf-section',
		template: '#nf-tmpl-field-wrap',

		initialize: function() {
			_.bindAll( this, 'render' );
    		this.model.bind( 'change:reRender', this.maybeRender, this );
    		this.model.bind( 'change:errors', this.changeError, this );
    		this.model.bind( 'change:addWrapperClass', this.addWrapperClass, this );
    		this.model.bind( 'change:removeWrapperClass', this.removeWrapperClass, this );
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
				this.render();
				this.model.set( 'reRender', false, { silent: true } );
			}
		},

		onRender: function() {
			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );

			var el = jQuery( this.el ).children( '.nf-error-wrap' );
    		this.errorCollectionView = new fieldErrorCollection( { el: el, collection: this.model.get( 'errors' ), thisModel: this.model } );
		},

		templateHelpers: function () {
	    	return {
	    		
				renderElement: function(){
					this.setPlaceholder();
					this.setClasses();
					return _.template( jQuery( '#nf-tmpl-field-' + this.type ).html(), this );
				},

				renderLabel: function() {
					return _.template( jQuery( '#nf-tmpl-field-label' ).html(), this );
				},

				setPlaceholder: function() {
					if ( 'inside' == this.label_pos ) {
						this.placeholder = this.label;
					}
				},

				setClasses: function() {
					if ( this.error ) {
						this.classes += ' nf-error';
					} else {
						this.classes = this.classes.replace( 'nf-error', '' );
					}
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
			nfRadio.channel( this.model.get( 'type' ) ).trigger( 'keyup:field', el, this.model, keyCode );
			nfRadio.channel( 'fields' ).trigger( 'keyup:field', el, this.model, keyCode );
		},

		fieldClick: function( e ) {
			var el = jQuery( e.currentTarget );
			nfRadio.channel( 'fields' ).trigger( 'click:field', el, this.model );
		},

		fieldBlur: function( e ) {
			var el = jQuery( e.currentTarget );
			nfRadio.channel( 'fields' ).trigger( 'blur:field', el, this.model );
		}
	});

	return view;
} );