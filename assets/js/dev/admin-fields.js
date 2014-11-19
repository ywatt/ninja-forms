/**
 * JS that handles our fields in the admin.
 * Uses backbone data models to send only modified field data to the db.
 */

jQuery( document ).ready( function() {
	var Field = Backbone.Model.extend();
	var Fields = Backbone.Collection.extend({
		model: Field
	});

	var fields = new Fields();

	if( 'undefined' !== typeof nf_admin.fields ) {
		_.each( nf_admin.fields, function( field ) {
			fields.add( { id: field.id } );
		} );
	}

	var test = fields.toJSON();

	console.log( JSON.stringify( test ) );
});