jQuery(document).ready(function($) {

	var nf_columns = {
		init: function() {
			//this.move_row_actions();
			// Remove our "ID" checkbox.
			$( '#id-hide' ).parent().remove();
			var that = this;
			$( document ).on( 'click', '.hide-column-tog', that.save_hidden_columns );
		},
		save_hidden_columns: function() {
			// Send our hidden columns to our backend for saving.
			var hidden = columns.hidden();
			$.post(
				ajaxurl,
				{ 
					form_id: nf_sub.form_id,
			 		hidden: hidden,
			 		action:'nf_hide_columns'
			 	}
			);
			// Move our row-actions
			//nf_columns.move_row_actions();
		},
		move_row_actions: function() {
			// Move our row-actions class to our first column.
			$( "#the-list tr" ).each( function( e ) {
				var first_column = $( this ).find( 'td:visible' ).eq(0);
				if ( typeof $( first_column ).html() == 'undefined' ) {
					first_column = $( this ).find( 'td:first' );
				}
				$( this ).find( 'td div.row-actions' ).detach().appendTo( first_column );
			});
		}
	}

	nf_columns.init();

	$( '.datepicker' ).datepicker( { dateFormat: nf_sub.date_format } );

	$( document ).on( 'change', '.nf-form-jump', function( e ) {
		$( '#posts-filter' ).submit();
	});

	$( document ).on( 'submit', function( e ) {
		$( '.spinner' ).show();
	});

	$( 'li#toplevel_page_ninja-forms' ).children( 'a' ).removeClass( 'wp-not-current-submenu' );
	$( 'li#toplevel_page_ninja-forms' ).removeClass( 'wp-not-current-submenu' );
	$( 'li#toplevel_page_ninja-forms' ).addClass( 'wp-menu-open wp-has-current-submenu' );
	$( 'li#toplevel_page_ninja-forms' ).children( 'a' ).addClass( 'wp-menu-open wp-has-current-submenu' );

});