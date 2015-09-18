define( ['lib/backbone.radio', 'front-end/views/fieldErrorCollection'], function( Radio, fieldErrorCollection ) {
	var view = Marionette.ItemView.extend({
		tagName: 'nf-section',
		template: '#nf-tmpl-field-wrap',

		initialize: function() {
			_.bindAll( this, 'render' );
    		this.model.bind( 'change:reRender', this.maybeRender, this );
    		this.model.bind( 'change:errors', this.changeError, this );
    		this.model.bind( 'change:wrapperClasses', this.changeWrapperClasses, this );
		},

		changeError: function() {
			if ( 0 == this.model.get( 'errors' ).models.length ) {
				jQuery( this.el ).removeClass( 'nf-error' );
			} else {
				jQuery( this.el ).addClass( 'nf-error' );
			}

			this.errorCollectionView.render();
		},

		maybeRender: function() {
			if ( this.model.get( 'reRender' ) ) {
				this.render();
				this.model.set( 'reRender', false, { silent: true } );
			}
		},

		changeWrapperClasses: function( classes ) {
			
		},

		onRender: function() {
			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );

			var el = jQuery( this.el ).children( 'nf-error-wrap' );
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
			'keyup .nf-element': 'fieldKeyup'
		},

		fieldChange: function( e ) {
			var el = jQuery( e.currentTarget );
			var response = Radio.channel( 'nfAdmin' ).request( 'change:field', el, this.model );
		},

		fieldKeyup: function( e ) {
			var el = jQuery( e.currentTarget );
			var response = Radio.channel( this.model.get( 'type' ) ).trigger( 'keyup:field', el, this.model );
			var response = Radio.channel( 'fields' ).trigger( 'keyup:field', el, this.model );
		}
	});

	return view;
} );