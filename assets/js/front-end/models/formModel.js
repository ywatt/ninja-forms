define( [], function() {
	var model = Backbone.Model.extend({
		defaults: {
			beforeForm: '',
			afterForm: '',
			beforeFields: '',
			afterFields: ''
		},

		initialize: function() {
			nfRadio.channel( 'form-' + this.get( 'id' ) ).reply( 'get:fieldByKey', this.getFieldByKey, this );
			nfRadio.channel( 'forms' ).trigger( 'init:model', this );
			nfRadio.channel( 'form-' + this.get( 'id' ) ).trigger( 'init:model', this );
		},

		getFieldByKey: function( key ) {
			return this.get( 'fields' ).findWhere( { key: key } );
		}
	} );

	return model;
} );