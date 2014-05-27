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
});