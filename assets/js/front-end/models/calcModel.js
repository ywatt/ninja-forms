define( [], function() {
	var model = Backbone.Model.extend( {
		initialize: function() {
			// Set our form id
			this.set( 'formID', this.collection.options.formModel.get( 'id' ) );
			this.fields = {};
			var that = this;
			var eq = this.get( 'eq' );
			var eqValues = eq;
			// Check to see if we have any merge tags in our equation.
			var fields = eq.match( new RegExp( /{field:(.*?)}/g ) );
			fields = fields.map( function( field ) {
				var key = field;
				key = key.replace( '}', '' ).replace( '{field:', '' ); 
				fieldModel = nfRadio.channel( 'form-' + that.get( 'formID' ) ).request( 'get:fieldByKey', key );
				fieldModel.on( 'change:value', that.changeField, that );
				var value = ( jQuery.isNumeric( fieldModel.get( 'value' ) ) ) ? fieldModel.get( 'value' ): 0;
				that.fields[ key ] = value;
				eqValues = eqValues.replace( field, value );
			} );

			this.set( 'value', math.eval( eqValues ) );
			console.log( this.get( 'value' ) );
			// Send a message out on our form channel asking for the fieldModel that corresponds to any merge tags found in this equation.
			
		},

		changeField: function( fieldModel ) {
			var key = fieldModel.get( 'key' );
			var value = ( jQuery.isNumeric( fieldModel.get( 'value' ) ) ) ? fieldModel.get( 'value' ): 0;
			this.fields[ key ] = value;
			var eqValues = this.get( 'eq' );
			_.each( this.fields, function( value, key ) {
				eqValues = eqValues.replace( '{field:' + key + '}', value );
			} );
			this.set( 'value', math.eval( eqValues ) );
			console.log( this.get( 'value' ) );
		}
	} );

	return model;
} );
