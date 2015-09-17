define( ['lib/backbone.radio', 'front-end/models/fieldErrorCollection'], function( Radio, fieldErrorCollection ) {
	var model = Backbone.Model.extend( {
		defaults: {
			placeholder: '',
			value: '',
			label_pos: '',
			classes: 'nf-element',
			reRender: false,
			mirror_field: false,
			confirm_field: false
		},

		initialize: function() {
    		this.bind( 'change', this.changeModel, this );
    		this.bind( 'change:value', this.changeValue, this );
    		this.set( 'errors', new fieldErrorCollection() );
		},

		changeModel: function() {
			Radio.channel( 'field-' + this.get( 'id' ) ).trigger( 'change:model', this );
			Radio.channel( this.get( 'type' ) ).trigger( 'change:model', this );
			Radio.channel( 'fields' ).trigger( 'change:model', this );
		},

		changeValue: function() {
			Radio.channel( 'field-' + this.get( 'id' ) ).trigger( 'change:modelValue', this );
			Radio.channel( this.get( 'type' ) ).trigger( 'change:modelValue', this );
			Radio.channel( 'fields' ).trigger( 'change:modelValue', this );
		}

	} );
	
	return model;
} );