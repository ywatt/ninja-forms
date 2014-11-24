/**
 * JS that handles our fields in the admin.
 * Uses backbone data models to send only modified field data to the db.
 */

// Model to hold our field settings.
var Field = Backbone.Model.extend();
// Collection to hold our fields.
var Fields = Backbone.Collection.extend({
	model: Field
});

// Instantiate our fields collection.
var fields = new Fields();

jQuery( document ).ready( function( $ ) {

	// Loop through our field JSON that is already on the page and populate our collection with it.
	if( 'undefined' !== typeof nf_admin.fields ) {
		_.each( nf_admin.fields, function( field ) {
			fields.add( { id: field.id, metabox_state: field.metabox_state } );
		} );
	}

	/**
	 * Open and close a field metabox.
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
			// Fetch our HTML.
			nf_update_field_html( field_id );
		} else { // If we have opened the metabox.
			// Update our model data.
			nf_update_field_data( field_id );
			$( '#ninja_forms_field_' + field_id + '_inside' ).slideUp('fast', function( e ) {
				// Remove the HTML contents of this metabox.
				$( '#ninja_forms_field_' + field_id + '_inside' ).empty();				
				// Add our no-padding class
				$( '#ninja_forms_field_' + field_id + '_inside' ).addClass( 'no-padding' );
			});
		}

		// Save the state of the metabox in our data model.
		fields.get( field_id ).set( 'metabox_state', new_metabox_state );
		
	});

	$( document ).on( 'click', '.nf-save-admin-fields', function( e ) {
		e.preventDefault();

		// Loop through our fields collection and update any field lis that are open
		_.each( fields.models, function( field ) {
			if ( field.get( 'metabox_state' ) == 1 ) {
				nf_update_field_data( field.get( 'id' ) );
			}
		});

		var data = JSON.stringify( fields.toJSON() );
		var order = {};
		var current_order = $( "#ninja_forms_field_list" ).sortable( "toArray" );
		for ( var i = 0; i < current_order.length; i++ ) {
			order[i] = current_order[i];
		};
		order = JSON.stringify( order );
		var form_id = $( '#_form_id' ).val();

		$( document ).data( 'field_order', order );
		$( document ).data( 'field_data', data );

		jQuery(document).triggerHandler( 'nfAdminSaveFields' );
		
		var order = $( document ).data( 'field_order' );
		var data = $( document ).data( 'field_data' );

		$.post( ajaxurl, { form_id: form_id, data: data, order: order, action: 'nf_save_admin_fields', nf_ajax_nonce:ninja_forms_settings.nf_ajax_nonce }, function( response ) {
			console.log( response );	
		} );
	});

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
		$( '#ninja_forms_metabox_field_' + field_id ).find( '.spinner' ).show();
		$.post( ajaxurl, { field_id: field_id, action:'nf_output_field_settings_html', nf_ajax_nonce:ninja_forms_settings.nf_ajax_nonce }, function( response ) {
			$( '#ninja_forms_metabox_field_' + field_id ).find( '.spinner' ).hide();
			// Remove our no-padding class.
			$( '#ninja_forms_field_' + field_id + '_inside' ).removeClass( 'no-padding' );	
			$( '#ninja_forms_field_' + field_id + '_inside' ).append( response );
			$( '#ninja_forms_field_' + field_id + '_inside' ).slideDown('fast', function( e ) {
				
			});
		} );
	}
});

function ninja_forms_new_field_response( response ){
	jQuery("#ninja_forms_field_list").append(response.new_html).show('slow');
	if ( response.new_type == 'List' ) {
		//Make List Options sortable
		jQuery(".ninja-forms-field-list-options").sortable({
			helper: 'clone',
			handle: '.ninja-forms-drag',
			items: 'div',
			placeholder: "ui-state-highlight",
		});
	}
	if ( typeof nf_ajax_rte_editors !== 'undefined' ) {
		for (var x = nf_ajax_rte_editors.length - 1; x >= 0; x--) {
			var editor_id = nf_ajax_rte_editors[x];
			tinyMCE.init( tinyMCEPreInit.mceInit[ editor_id ] );
			try { quicktags( tinyMCEPreInit.qtInit[ editor_id ] ); } catch(e){}
		};
	}

	jQuery(".ninja-forms-field-conditional-cr-field").each(function(){
		jQuery(this).append('<option value="' + response.new_id + '">' + response.new_type + '</option>');
	});

	// Add our field to our backbone data model.
	fields.add( { id: response.new_id, metabox_state: 1 } );

	// Fire our custom jQuery addField event.
	jQuery( document ).trigger('addField', [ response ]);

}