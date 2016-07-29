define( [], function() {
	var model = Backbone.Model.extend({
		defaults: {
			beforeForm: '',
			afterForm: '',
			beforeFields: '',
			afterFields: '',
			wrapper_class: '',
			element_class: '',
			hp: '',
			fieldErrors: {},
			extra: {}
		},

		initialize: function() {

			/*
			 * Loop over settings and map to attributes
			 */
			var that = this;
			_.each( this.get( 'settings' ), function( value, setting ) {
				that.set( setting, value );
			});

			nfRadio.channel( 'form-' + this.get( 'id' ) ).reply( 'get:fieldByKey', this.getFieldByKey, this );
			nfRadio.channel( 'form-' + this.get( 'id' ) ).reply( 'add:error', this.addError, this );
			nfRadio.channel( 'form-' + this.get( 'id' ) ).reply( 'remove:error', this.removeError, this );
			nfRadio.channel( 'forms' ).trigger( 'init:model', this );
			nfRadio.channel( 'form-' + this.get( 'id' ) ).trigger( 'init:model', this );

			/*
			 * Extra Data
			 */
			nfRadio.channel( 'form-' + this.get( 'id' ) ).reply( 'get:extra',    this.getExtra,    this );
			nfRadio.channel( 'form-' + this.get( 'id' ) ).reply( 'add:extra',    this.addExtra,    this );
			nfRadio.channel( 'form-' + this.get( 'id' ) ).reply( 'remove:extra', this.removeExtra, this );
		},

		getFieldByKey: function( key ) {
			return this.get( 'fields' ).findWhere( { key: key } );
		},

		addError: function( id, msg ) {
			var errors = this.get( 'errors' );
			errors.add( { id: id, msg: msg } );
			nfRadio.channel( 'form-' + this.get( 'id' ) ).trigger( 'add:error', this, id, msg );
		},

		removeError: function( id ) {
			var errors = this.get( 'errors' );
			var errorModel = errors.get( id );
			errors.remove( errorModel );
			nfRadio.channel( 'form-' + this.get( 'id' ) ).trigger( 'remove:error', this, id );
		},

		/*
		 * Extra Data
		 */

		getExtra: function( key ) {
			var extraData = this.get( 'extra' );
			if( 'undefined' == typeof key ) return extraData;
			return extraData[ key ];
		},

		addExtra: function( key, value ) {
			var extraData = this.get( 'extra' );
			extraData[ key ] = value;
			nfRadio.channel( 'form-' + this.get( 'id' ) ).trigger( 'add:extra', this, key, value );
		},

		removeExtra: function( key ) {
			var extraData = this.get( 'extra' );
			delete extraData[ key ];
			nfRadio.channel( 'form-' + this.get( 'id' ) ).trigger( 'remove:extra', this, key );
		},
	} );

	return model;
} );