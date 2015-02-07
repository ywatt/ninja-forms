/**
 * JS that handles our fields in the admin.
 * Uses backbone data models to send only modified field data to the db.
 */

// Model to hold our field settings.
var nfField = Backbone.Model.extend( {
	toggleMetabox: function() {
		/**
		 * Open and close a field metabox.
		 * When a metabox is closed:
		 * 	- update the field collection with any values that might have changed.
		 *  - remove the HTML
		 * When a metabox is opened:
		 *  - send an ajax request to grab the HTML
		 *  - populate the field settings HTML
		 */

		 var field_id = this.id;

		// Get our current metabox state.
		var current_metabox_state = this.get( 'metabox_state' );
		if ( current_metabox_state == 1 ) { // If our current state is 1, then we are closing the metabox.
			var new_metabox_state = 0;
		} else { // If our current state is 0, then we are opening the metabox.
			var new_metabox_state = 1;
		}

		// Perform specific tasks based upon the state of the metabox.
		if ( new_metabox_state == 1 ) { // If we have opened the metabox.
			// Fetch our HTML.
			this.updateHTML();
		} else { // If we have closed the metabox.
			// Update our model data.
			this.updateData();
			// Remove any tinyMCE editors
			jQuery( '#ninja_forms_field_' + field_id + '_inside' ).find( 'div.rte' ).each( function() {
				var editor_id = jQuery( this ).find( 'textarea.wp-editor-area' ).prop( 'id' );
				tinymce.remove( '#' + editor_id );
			} );

			jQuery( '#ninja_forms_field_' + field_id + '_inside' ).slideUp('fast', function( e ) {
				// Remove the HTML contents of this metabox.
				jQuery( '#ninja_forms_field_' + field_id + '_inside' ).empty();

				// Add our no-padding class
				jQuery( '#ninja_forms_field_' + field_id + '_inside' ).addClass( 'no-padding' );
			});
		}

		// Save the state of the metabox in our data model.
		this.set( 'metabox_state', new_metabox_state );
	},
	updateHTML: function() {
		var field_id = this.id;
		jQuery( '#ninja_forms_metabox_field_' + field_id ).find( '.spinner' ).show();
		this.updateData();
		var data = JSON.stringify( this.toJSON() );

		jQuery.post( ajaxurl, { field_id: field_id, data: data, action:'nf_output_field_settings_html', nf_ajax_nonce:ninja_forms_settings.nf_ajax_nonce }, function( response ) {
			jQuery( '#ninja_forms_metabox_field_' + field_id ).find( '.spinner' ).hide();
			// Remove our no-padding class.
			jQuery( '#ninja_forms_field_' + field_id + '_inside' ).removeClass( 'no-padding' );	
			jQuery( '#ninja_forms_field_' + field_id + '_inside' ).append( response );
			if ( typeof nf_ajax_rte_editors !== 'undefined' ) {
				for (var x = nf_ajax_rte_editors.length - 1; x >= 0; x--) {
					var editor_id = nf_ajax_rte_editors[x];
					tinyMCE.init( tinyMCEPreInit.mceInit[ editor_id ] );
					try { quicktags( tinyMCEPreInit.qtInit[ editor_id ] ); } catch(e){ console.log( 'error' ); }
				};
			}

			jQuery( '#ninja_forms_field_' + field_id + '_inside' ).slideDown( 'fast' );
		} );
	},
	updateData: function() {
		var field_id = this.id;
		tinyMCE.triggerSave();
		var data = jQuery('[name^=ninja_forms_field_' + field_id + ']');
		var field_data = jQuery(data).serializeFullArray();

		if ( typeof field_data['ninja_forms_field_' + field_id] != 'undefined' ) {
			var field = field_data['ninja_forms_field_' + field_id];
			
			for( var prop in field ) {
			    if ( field.hasOwnProperty( prop ) ) {
			        nfFields.get( field_id ).set( prop, field[ prop ] );
			    }
			}
		}
	},
	remove: function() {
		var field_id = this.id;
		var answer = confirm( nf_admin.remove_field );
		if ( answer ) {
			jQuery.post(ajaxurl, { field_id: field_id, action: 'ninja_forms_remove_field', nf_ajax_nonce:ninja_forms_settings.nf_ajax_nonce }, function( response ) {
				jQuery( '#ninja_forms_field_' + field_id).remove();
				jQuery( document ).trigger( 'removeField', [ field_id ] );
			});
		}
	}

} );
// Collection to hold our fields.
var nfFields = Backbone.Collection.extend({
	model: nfField,
	updateData: function() {
		// Loop through our fields collection and update any field lis that are open
		_.each( this.models, function( field ) {
			if ( field.get( 'metabox_state' ) == 1 ) {
				field.updateData();
			}
		} );
	},
	save: function() {
		jQuery( '.nf-save-admin-fields' ).hide();
		jQuery( '.nf-save-spinner' ).show();
		this.updateData();

		var data = JSON.stringify( this.toJSON() );
		var order = {};
		var current_order = jQuery( '#ninja_forms_field_list' ).sortable( 'toArray' );
		for ( var i = 0; i < current_order.length; i++ ) {
			order[i] = current_order[i];
		};
		order = JSON.stringify( order );
		var form_id = ninja_forms_settings.form_id;

		console.log( order );

		jQuery( document ).data( 'field_order', order );
		jQuery( document ).data( 'field_data', data );

		jQuery( document ).triggerHandler( 'nfAdminSaveFields' );
		
		var order = jQuery( document ).data( 'field_order' );
		var data = jQuery( document ).data( 'field_data' );

		jQuery.post( ajaxurl, { form_id: form_id, data: data, order: order, action: 'nf_save_admin_fields', nf_ajax_nonce:ninja_forms_settings.nf_ajax_nonce }, function( response ) {
			jQuery( '.nf-save-spinner' ).hide();
			jQuery( '.nf-save-admin-fields' ).show();
			var html = '<div id="message" class="updated below-h2" style="display:none;margin-top: 20px;"><p>' + nf_admin.saved_text + '</p></div>';
			jQuery( '.nav-tab-wrapper:last' ).after( html );
			jQuery( '#message' ).fadeIn();
		} );
	},
	newField: function( button ) {
		var limit = jQuery( button ).data( 'limit' );
		var type = jQuery( button ).data( 'type' );
		var form_id = ninja_forms_settings.form_id

		if ( limit != '' ){
			var current_count = jQuery( '.' + type + '-li' ).length;
		}else{
			var current_count = '';
		}

		if ( typeof jQuery( button ).data( 'field' ) == 'undefined' ) {
			var field_id = '';
			var action = 'ninja_forms_new_field';
		} else if ( jQuery( button ).data( 'type' ) == 'fav' ) {
			var field_id = jQuery( button ).data( 'field' );
			var action = 'ninja_forms_insert_fav';
		} else {
			var field_id = jQuery( button ).data( 'field' );
			var action = 'ninja_forms_insert_def';
		}

		if ( ( limit != '' && current_count < limit ) || limit == '' || current_count == '' || current_count == 0 ) {
			
				jQuery.post( ajaxurl, { type: type, field_id: field_id, form_id: form_id, action: action, nf_ajax_nonce:ninja_forms_settings.nf_ajax_nonce }, this.newFieldResponse );

		} else {
			jQuery( button ).addClass( 'disabled' );
		}
	},
	newFieldResponse: function( response ) {
		// Fire our custom jQuery addField event.
		jQuery( document ).trigger('addField', [ response ]);
	},
	addFieldDefault: function( response ) {
		jQuery( '#ninja_forms_field_list' ).append( response.new_html ).show( 'slow' );
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

		// Add our field to our backbone data model.
		this.add( { id: response.new_id, metabox_state: 1 } );
	}
});

// Instantiate our fields collection.
var nfFields = new nfFields();

jQuery( document ).ready( function( $ ) {

	// Loop through our field JSON that is already on the page and populate our collection with it.
	if( 'undefined' !== typeof nf_admin.fields ) {
		_.each( nf_admin.fields, function( field ) {
			nfFields.add( { id: field.id, metabox_state: field.metabox_state } );
		} );
	}

	// Open and close a field metabox.
	$( document ).on( 'click', '.metabox-item-edit', function( e ) {
		e.preventDefault();
		// Get our field id.
		var field_id = jQuery( e.target ).data( 'field' );
		nfFields.get( field_id ).toggleMetabox();
	});

	// Remove the saved message when the user clicks anywhere on the page.
	$( document ).on( 'click', function() {
		$( '#message' ).fadeOut( 'slow' );
	} );

	$( document ).on( 'click', '.nf-save-admin-fields', function( e ) {
		e.preventDefault();
		nfFields.save();
	});

	// Add New Field
	$( document ).on( 'click', '.ninja-forms-new-field', function( e ) {
		e.preventDefault();
		nfFields.newField( e.target );
	});

	// Remove Field
	$( document ).on( 'click', '.nf-remove-field', function( e ){
		e.preventDefault();
		var field_id = jQuery( e.target ).data( 'field' );
		nfFields.get( field_id ).remove();
	});

	// Hook into our add field response event
	$( document ).on( 'addField.default', function( e, response ) {
		nfFields.addFieldDefault( response );
	} );

	//Insert a Favorite Field
	$( document ).on( 'click', '.ninja-forms-insert-fav-field', function( e ){
		e.preventDefault();
		nfFields.newField( e.target );
	});

		//Insert a Defined Field
	$( document ).on( 'click', '.ninja-forms-insert-def-field', function( e ){
		e .preventDefault();
		nfFields.newField( e.target );
	});

	//Make the field list sortable
	$(".ninja-forms-field-list").sortable({
		handle: '.menu-item-handle',
		items: "li:not(.not-sortable)",
		connectWith: ".ninja-forms-field-list",
		//cursorAt: {left: -10, top: -1},
		start: function(e, ui){
			var wp_editor_count = $(ui.item).find(".wp-editor-wrap").length;
			if(wp_editor_count > 0){
				$(ui.item).find(".wp-editor-wrap").each(function(){
					var ed_id = this.id.replace("wp-", "");
					ed_id = ed_id.replace("-wrap", "");
					tinyMCE.execCommand( 'mceRemoveControl', false, ed_id );
				});
			}
		},
		stop: function(e,ui) {
			var wp_editor_count = $(ui.item).find(".wp-editor-wrap").length;
			if(wp_editor_count > 0){
				$(ui.item).find(".wp-editor-wrap").each(function(){
					var ed_id = this.id.replace("wp-", "");
					ed_id = ed_id.replace("-wrap", "");
					tinyMCE.execCommand( 'mceAddControl', true, ed_id );
				});
			}
			$(this).sortable("refresh");
		}
	});

});