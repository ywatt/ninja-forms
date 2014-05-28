jQuery(document).ready(function($) {
	// Add our datepicker
	$( '.datepicker' ).datepicker();
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

});