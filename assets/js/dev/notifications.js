jQuery(document).ready(function($) {
	$( '#settings-type' ).change( function() {
		var val = this.value;
		$( '.notification-type' ).hide();
		$( '#notification-' + val ).show();
	});

	$( document ).on( 'click', '.notification-delete', function(e) {
		e.preventDefault();
		var answer = confirm( commonL10n.warnDelete );
		var tr = $( this ).parent().parent().parent().parent();
		var n_id = $( this ).data( 'n_id' );
		console.log( n_id );
		if(answer){
			$.post( ajaxurl, { n_id: n_id, action: 'nf_delete_notification' }, function( response ) {
				$( tr ).css( 'background-color', '#FF0000' ).fadeOut( 'slow', function() {
					$(this).remove();
				} );
			});
		}
	});

	$( document ).on( 'click', '.notification-activate', function(e) {
		e.preventDefault();
		var tr = $( this ).parent().parent().parent().parent();
		var activate_action = $( this ).data( 'action' );
		var n_id = $( this ).data( 'n_id' );
		var that = this;
		$.post( ajaxurl, { n_id: n_id, activate_action: activate_action, action: 'nf_' + activate_action + '_notification' }, function( response ) {
			$( tr ).removeClass( 'nf-notification-active' );
			$( tr ).removeClass( 'nf-notification-inactive' );

			if ( activate_action == 'activate' ) {
				$( tr ).addClass( 'nf-notification-active' );
				$( that ).html( nf_notifications.deactivate );
				$( that ).data( 'action', 'deactivate' );
			} else {
				$( tr ).addClass( 'nf-notification-inactive' );
				$( that ).html( nf_notifications.activate );
				$( that ).data( 'action', 'activate' );
			}
		});
	});

	$( '.nf-tokenize' ).each( function() {
		var limit = $( this ).data( 'token-limit' );
		var key = $( this ).data( 'key' );
		var type = $( this ).data( 'type' );
		$( this ).tokenfield({
			autocomplete: {
				source: nf_notifications.search_fields[ type ],
				delay: 100,
			},
			tokens: nf_notifications.tokens[ key ],
			delimiter: [ ',' ],
			showAutocompleteOnFocus: true,
			beautify: false,
			limit: limit,
			createTokensOnBlur: true
		});
	});

	$( document ).on( 'click', '#nf-insert-field', function(e) {
		e.preventDefault();
		var field_id = $( '#nf-field' ).val();
		var shortcode = '[ninja_forms_field id=' + field_id + ']';
		window.parent.send_to_editor( shortcode );
	});

	$( document ).on( 'click', '#nf-insert-all-fields', function(e) {
		e.preventDefault();
		var shortcode = '<table><tbody>';

		for ( x = 0; x < nf_notifications.fields.length ; x++ ) {
			shortcode += '<tr><td>' + nf_notifications.fields[x].label + '</td><td>[ninja_forms_field id=' + nf_notifications.fields[x].field_id + ']</td></tr>';
		};
		shortcode += '</tbody></table>';
		window.parent.send_to_editor( shortcode );
	});

});