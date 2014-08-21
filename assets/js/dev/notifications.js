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
		if(answer){
			$.post( ajaxurl, { n_id: notification_id, action: 'nf_delete_notification' }, function( response ) {
				$( tr ).css( 'background-color', '#FF0000' ).fadeOut( 'slow', function() {
					$(this).remove();
				} );
			});
		}
	});

});