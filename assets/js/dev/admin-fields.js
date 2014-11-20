/**
 * JS that handles our fields in the admin.
 * Uses backbone data models to send only modified field data to the db.
 */

jQuery( document ).ready( function( $ ) {
	// Model to hold our field settings.
	var Field = Backbone.Model.extend();
	// Collection to hold our fields.
	var Fields = Backbone.Collection.extend({
		model: Field
	});

	// Instantiate our fields collection.
	var fields = new Fields();

	// Loop through our field JSON that is already on the page and populate our collection with it.
	if( 'undefined' !== typeof nf_admin.fields ) {
		_.each( nf_admin.fields, function( field ) {
			fields.add( { id: field.id, metabox_state: field.metabox_state } );
		} );
	}

	/**
	 * Open and close a field metabox.
	 * Send an ajax request to the backend to save the current state.
	 * When a metabox is closed:
	 * 	- update the field collection with any values that might have changed.
	 *  - remove the HTML
	 * When a metabox is opened:
	 *  - send an ajax request to grab the HTML
	 *  - populate the field settings HTML
	 */

	$( document ).on( 'click', '.metabox-item-edit', function( e ) {
		e.preventDefault();
		// Get our field id.
		var field_id = $( e.target ).data( 'field' );
		
		// Get our current metabox state.
		var current_metabox_state = fields.get( field_id ).get( 'metabox_state' );
		if ( current_metabox_state == 1 ) { // If our current state is 1, then we are closing the metabox.
			var new_metabox_state = 0;
		} else { // If our current state is 0, then we are opening the metabox.
			var new_metabox_state = 1;
		}

		// Perform specific tasks based upon the state of the metabox.
		if ( new_metabox_state == 1 ) { // If we have opened the metabox.
			// Remove our no-padding class.
			$( '#ninja_forms_field_' + field_id + '_inside' ).removeClass( 'no-padding' );
			// Fetch our HTML.
			nf_update_field_html( field_id );
		} else { // If we have opened the metabox.
			// Update our model data.
			nf_update_field_data( field_id );
			// Remove the HTML contents of this metabox.
			$( '#ninja_forms_field_' + field_id + '_inside' ).empty();
			// Add our no-padding class
			$( '#ninja_forms_field_' + field_id + '_inside' ).addClass( 'no-padding' );
			// var test = fields.toJSON();
		}

		// Save the state of the metabox in our database.
		nf_field_metabox_save_state( field_id, new_metabox_state );
		// Save the state of the metabox in our data model.
		fields.get( field_id ).set( 'metabox_state', new_metabox_state );
		
	});

	$( document ).on( 'submit', function( e ) {
		e.preventDefault();
		// Loop through our fields collection and update any field lis that are open
		_.each( fields.models, function( field ) {
			if ( field.get( 'metabox_state' ) == 1 ) {
				nf_update_field_data( field.get( 'id' ) );
			}
		});

		console.log( fields );
	});

	function nf_field_metabox_save_state( field_id, metabox_state ) {

		var page = $( '#_page' ).val();
		var tab = $( '#_tab' ).val();
		var slug = 'field_' + field_id;
		
		$.post( ajaxurl, { page: page, tab: tab, slug: slug, metabox_state: metabox_state, action:'ninja_forms_save_metabox_state', nf_ajax_nonce:ninja_forms_settings.nf_ajax_nonce } );
	}

	function nf_update_field_data( field_id ) {
		var data = $('[name^=ninja_forms_field_' + field_id + ']');
		var field_data = jQuery(data).serializeFullArray();

		if ( typeof field_data['ninja_forms_field_' + field_id] != 'undefined' ) {
			var field = field_data['ninja_forms_field_' + field_id];
			
			for( var prop in field ) {
			    if ( field.hasOwnProperty( prop ) ) {
			        fields.get( field_id ).set( prop, field[ prop ] );
			    }
			}
		}
	}

	function nf_update_field_html( field_id ) {
		
		$.post( ajaxurl, { field_id: field_id, action:'nf_output_field_settings_html', nf_ajax_nonce:ninja_forms_settings.nf_ajax_nonce }, function( response ) {
			console.log( response );	
		} );
	}

});