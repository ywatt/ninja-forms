jQuery( document ).ready( function( $ ) {

	$( '.control-section h3' ).on( 'click', function( e ) {
		if ( $( this ).parent().hasClass( 'open' ) ) {
			$( this ).parent().removeClass( 'open' );
			$( this ).parent().addClass( 'closed' );
		} else {
			$( this ).parent().removeClass( 'closed' );
			$( this ).parent().addClass( 'open' );
		}
	});

	// Listen for our Delete Field event
	$( document ).on( 'click', '.delete-field', function( e ) {
		e.preventDefault();
		var field_id = $( this ).data( 'field-id' );
		$.post( ajaxurl, { field_id: field_id, action:'nf_delete_field' }, function( response ){
			$( '#nf_field_' + field_id ).fadeOut( function() {
				$( this ).remove();
			});
		});
	});

	// Make our field list sortable
	$( '#nf_fields' ).sortable({
		items: 'ul',
		update: function( event, ui ) {
			console.log( 'update' );
		}
	});

	Field = Backbone.Model.extend({
		urlRoot: nf_rest_url + '&nf_rest=rest_api'
	});

	var Fields = Backbone.Collection.extend({
		url: nf_rest_url + '&nf_rest=rest_api&form_id=' + nf_form_id,
		model: Field,
	});

	fields = new Fields();
	fields.fetch();

});