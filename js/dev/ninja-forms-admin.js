if (!Array.prototype.indexOf) {
  Array.prototype.indexOf = function (searchElement , fromIndex) {
    var i,
        pivot = (fromIndex) ? fromIndex : 0,
        length;

    if (!this) {
      throw new TypeError();
    }

    length = this.length;

    if (length === 0 || pivot >= length) {
      return -1;
    }

    if (pivot < 0) {
      pivot = length - Math.abs(pivot);
    }

    for (i = pivot; i < length; i++) {
      if (this[i] === searchElement) {
        return i;
      }
    }
    return -1;
  };
}


/*!
 * jQuery serializeFullArray - v0.1 - 28/06/2010
 * http://github.com/jhogendorn/jQuery-serializeFullArray/
 *
 * Copyright (c) 2010 Joshua Hogendorn
 *
 *
 * Whereas .serializeArray() serializes a form into a key:pair array, .serializeFullArray()
 * builds it into a n-tier object, respecting form input arrays.
 *
 */

(function($){
	'$:nomunge'; // Used by YUI compressor.

	$.fn.serializeFullArray = function () {
		// Grab a set of name:value pairs from the form dom.
		var set = $(this).serializeArray();
		var output = {};

		for (var field in set)
		{
			if(!set.hasOwnProperty(field)) continue;

			// Split up the field names into array tiers
			var parts = set[field].name
				.split(/\]|\[/);

			// We need to remove any blank parts returned by the regex.
			parts = $.grep(parts, function(n) { return n != ''; });

			// Start ref out at the root of the output object
			var ref = output;

			for (var segment in parts)
			{
				if(!parts.hasOwnProperty(segment)) continue;

				// set key for ease of use.
				var key = parts[segment];
				var value = {};

				// If we're at the last part, the value comes from the original array.
				if (segment == parts.length - 1)
				{
					var value = set[field].value;
				}

				// Create a throwaway object to merge into output.
				var objNew = {};
				objNew[key] = value;

				// Extend output with our temp object at the depth specified by ref.
				$.extend(true, ref, objNew);

				// Reassign ref to point to this tier, so the next loop can extend it.
				ref = ref[key];
			}
		}

		return output;
	};
})(jQuery);

jQuery.fn.tinymce_textareas = function(){
  tinyMCE.init({
    skin : "wp_theme"
    // other options here
  });
};

jQuery.fn.nextElementInDom = function(selector, options) {
	var defaults = { stopAt : 'body' };
	options = jQuery.extend(defaults, options);

	var parent = jQuery(this).parent();
	var found = parent.find(selector);

	switch(true){
		case (found.length > 0):
			return found;
		case (parent.length === 0 || parent.is(options.stopAt)):
			return jQuery([]);
		default:
			return parent.nextElementInDom(selector);
	}
};

jQuery(document).ready(function($) {

	// Listen for clicks on our "add repeater field" buttons.
	$(document).on('click', '.repeater-add', function(e){
		e.preventDefault();
		var id = this.id;
		var span_id = id + '_span';
		var this_model = formSettings.get( id );
		var current_value = this_model.get('current_value');
		current_value.push('');
		this_model.set( 'current_value', current_value );
		formSettingsView.render();
		$('#' + span_id).children('span:last').children('input').focus();
	});

	// Listen for clicks on our "remove repeater field" buttons.	
	$(document).on('click', '.repeater-remove', function(e) {
		e.preventDefault();
		var id = this.id;
		var this_model = formSettings.get( id );
		var current_value = this_model.get('current_value');
		var removeItem = $(this).prev('input').val();
		current_value = $.grep(current_value, function(value) {
		  return value != removeItem;
		});
		this_model.set( 'current_value', current_value );
		formSettingsView.render();
	});

	// Listen to our repeater text fields for the "enter" key, which should trigger adding a new, empty item.
	$(document).on('keypress', '.repeater-text', function(e){
		if (e.keyCode == 13) {
			var id = $(this).data('group');
			var span_id = id + '_span';
			var this_model = formSettings.get( id );
			var value = new Array();
			var x = 0;

			$('.repeater-' + id).each( function() {
				value[x] = this.value;
				x++;
			});
			value.push('');
			this_model.set( 'current_value', value );
			formSettingsView.render();
			$('#' + span_id).children('span:last').children('input').focus();
		}
	});

	var sender_mod = false;
	var empty_ul_html = '<ul class="ninja-row ninja-drop" data-cols="0" style="padding:10px;"></ul>';
	var sortable_options = {
		connectWith: '.ninja-drop',
		placeholder: 'ninja-placeholder',
		tolerance: 'pointer',
		start: function( event, ui ) {
			$( ".ninja-row" ).on( "sortout", test_function );
			// Get our target UL's current cols.
			var target_cols = parseInt( $(this).data( 'cols' ) );

			var placeholder_class = 'ninja-placeholder-1-' + target_cols;
			ui.placeholder[0].className = placeholder_class;
			
			sender_mod = false;
		},
		over: function( event, ui ) {
			
			// Get our current column count for the target UL, sender UL.
			var target_cols = parseInt( $(this).data( 'cols' ) );
			
			// Get the size of the element currently being dragged.
			var current_drag_size = $(ui.item).data( 'size' );


			// Increase our target UL column size by one.
			if ( target_cols < 4 ) {
				var new_target_cols = target_cols + 1;
			}

			//console.log( "OVER - new target cols: " + new_target_cols )
			
			//$(this).data( 'cols', new_target_cols );
			//$(this).data( 'old_cols', target_cols );

			// Set our placeholder to the proper size.
			var placeholder_class = 'ninja-placeholder-1-' + new_target_cols;
			ui.placeholder[0].className = placeholder_class;
			
			// Set the size of the element currently being dragged.
			$(ui.item).removeClass();
			$(ui.item).addClass( 'ninja-col-1-' + new_target_cols );

			// Loop through each LI in our target UL and set the size.
			var target_lis = $(this).children( 'li' ).not( '.' + placeholder_class ).not( ui.item );
			$(target_lis).each( function() {
				
				// Get our current size for this LI element.
				var current_size = $(this).data( 'size' );
				// Set the current size as the old size so that we can undo later.
				$(this).data( 'old_size', current_size );
				// Get the new size of the LI.
				var tmp = current_size.split( '-' );
				var colspan = tmp[0];
				var new_size = colspan + '-' + new_target_cols;
				//$(this).data( 'size', new_size );
				//console.log( 'OVER - New Target Cols: ' + new_target_cols );
				// Remove the current size class.
				$(this).removeClass();
				// Add the new size class.
				$(this).addClass( 'ninja-col-' + new_size );

			});
			
			//Set each LI within the sender UL to the proper size, but only if this is the first "over" event.

			if ( this != ui.sender[0] ) {
				var sender_cols = parseInt( $(ui.sender).data( 'cols' ) );
				var sender_lis = $(ui.sender).children( 'li' ).not( ui.item ).not( '.' + placeholder_class );

				//if ( !sender_mod ) {
					
					if ( $(sender_lis).length <= 1 ) {
						var new_sender_cols = 1;
						
					} else if ( $(sender_lis).length == 2 ) {
						// Loop through our remaining LI items. 
						// If we don't have any colspans that are greater than one, then our new column is current col - 1.
						var tmp_colspan = 1;
						$(sender_lis).each( function() {
							// Get the current size for this LI element.
							var current_size = $(this).data( 'size' );
							if ( typeof current_size !== 'undefined' ) {
								var tmp = current_size.split( '-' );
								var colspan = parseInt( tmp[0] );
								if ( colspan > 1 ) {
									tmp_colspan = colspan;
								}						
							}
						});
						// If the largest colspan is greater than one, then we can subtract one from the old col size.
						if ( tmp_colspan > 1 ) {
							// Decrease our sender UL column size by one.
							if ( sender_cols > 1 ) {
								var new_sender_cols = sender_cols - 1;
							} else {
								var new_sender_cols = 1;
							}
						} else {
							// The largest colspan is 1, and we have two items. Set the columns to two.
							var new_sender_cols = 2;
						}
					} else if ( $(sender_lis).length > 2 ) {
						// Decrease our sender UL column size by one.
						if ( sender_cols > 1 ) {
							var new_sender_cols = sender_cols - 1;
						}
					}
					sender_mod = true;
				//} else {
					//var new_sender_cols = sender_cols;
				//}

				// Update our sender UL's cols data attribute.

				//$(ui.sender).data( 'cols', new_sender_cols );
				// Set our sender Ul's old cols.
				//$(ui.sender).data( 'old_cols', sender_cols );

				// Loop through each LI in our sender UL and set the size.
				
				$(sender_lis).each( function() {
					// Get the current size for this LI element.
					var current_size = $(this).data( 'size' );
					
					if ( typeof current_size !== 'undefined' ) {
						// Get the new size of the LI.
						var tmp = current_size.split( '-' );
						var colspan = parseInt( tmp[0] );
						var new_size = colspan + '-' + new_sender_cols;
						//console.log( 'OVER - Set Sender Cols: ' + new_sender_cols );
						$(this).data( 'old_size', current_size );
						$(this).data( 'size', new_size );
						// Remove the old size class.
						$(this).removeClass();
						// Add the new size class.
						$(this).addClass( 'ninja-col-' + new_size );					
					}

				});				
			}
			
		},
		beforeStop: function( event, ui ) {
			$( ".ninja-row" ).off( "sortout", test_function );
			over_count = 0;
		},

		receive: function( event, ui) {
			//console.log( 'receive' );
			var target_cols = $(this).data( 'cols' );
			
			//$(this).removeData( 'old_cols' );
			
			// Increase our target UL column size by one.
			if ( target_cols < 4 ) {
				var new_target_cols = target_cols + 1;
			}

			if ( new_target_cols == 4 ) {
				$(this).removeClass( 'ninja-drop' );
			} else {
				$(this).addClass( 'ninja-drop' );
			}

			$(this).css('padding', '2px');
			$(this).data( 'cols', new_target_cols );

			//Set the element being dragged to the proper size.
			var new_size = '1-' + new_target_cols;
			$(ui.item).data( 'size', new_size );

			// Loop through each LI in our target UL and set the size.
			var target_lis = $(this).children( 'li' );
			$(target_lis).each( function() {
				var current_size = $(this).data( 'size' );
				// Get the new size of the LI.
				var tmp = current_size.split( '-' );
				var colspan = tmp[0];
				var new_size = colspan + '-' + new_target_cols;
				
				// Set the new size as the size setting.
				$(this).data( 'size', new_size );

			});

        },
        remove: function( event, ui ) {
        	//var sender_cols = $(this).data( 'cols' );

        	//$(this).removeData( 'old_cols' );



			var sender_cols = parseInt( $(this).data( 'cols' ) );
			var sender_lis = $(this).children( 'li' ).not( ui.item );

			
			//if ( !sender_mod ) {
				//console.log( 'mod' );
				if ( $(sender_lis).length <= 1 ) {
					var new_sender_cols = 1;
				} else if ( $(sender_lis).length == 2 ) {
					// Loop through our remaining LI items. 
					// If we don't have any colspans that are greater than one, then our new column is current col - 1.
					var tmp_colspan = 1;
					$(sender_lis).each( function() {
						// Get the current size for this LI element.
						var current_size = $(this).data( 'size' );
						if ( typeof current_size !== 'undefined' ) {
							var tmp = current_size.split( '-' );
							var colspan = parseInt( tmp[0] );
							if ( colspan > 1 ) {
								tmp_colspan = colspan;
							}						
						}
					});
					// If the largest colspan is greater than one, then we can subtract one from the old col size.
					if ( tmp_colspan > 1 ) {
						// Decrease our sender UL column size by one.
						if ( sender_cols > 1 ) {
							var new_sender_cols = sender_cols - 1;
						} else {
							var new_sender_cols = 1;
						}
					} else {
						// The largest colspan is 1, and we have two items. Set the columns to two.
						var new_sender_cols = 2;
					}
				} else if ( $(sender_lis).length > 2 ) {
					// Decrease our sender UL column size by one.
					if ( sender_cols > 1 ) {
						var new_sender_cols = sender_cols - 1;
					}
				}
				//sender_mod = true;
			//} else {
				//var new_sender_cols = sender_cols;
			//}

			$(this).data( 'cols', new_sender_cols );

			if ( new_sender_cols < 4 ) {
				$(this).addClass( 'ninja-drop' );
			}

			if ( $(this).children( 'li' ).not( ui.item ).length == 0 ) {
				$(this).data( 'cols', 0 );
			}

        	// Loop through each LI in our Sending UL and set the size.
			var sender_lis = $(this).children( 'li' );
			$(sender_lis).each( function() {
				var current_size = $(this).data( 'size' );
				// Get the new size of the LI.
				var tmp = current_size.split( '-' );
				var colspan = tmp[0];
				var new_size = colspan + '-' + new_sender_cols;
				
				// Set the new size as the size setting.
				//$(this).data( 'size', new_size );
				//console.log( 'UPDATE ' + this.id + ' SIZE TO: ' + new_size );
			});
			
        },
        stop: function( event, ui ) {
        	if ( $(ui.item).hasClass( 'ninja-forms-field-button' ) ) {
        		var label = $(ui.item[0]).html();
        		var el = $( "li.ninja-col-1-1:first" ).clone();
				$(el).children('div:first').find('label').html(label);
        		$(ui.item).replaceWith(el);
        	}
			$('.ninja-row').each( function(){
				var children = $( this ).children( 'li' ).length;
				if ( children == 0 ) {
					var prev_empty = false;
					var next_empty = true;
					// If it is empty, check to see if the previous UL is empty.
					if ( $(this).prev('.ninja-row').children('li').length == 0 ) {
						prev_empty = true;
					}
					// If it is empty, check to see if the next UL is empty.
					if ( $(this).next('.ninja-row').children('li').length == 0 ) {
						next_empty = true;
					}

					if ( prev_empty && next_empty ) {
						// If both previous and next ULs are empty, then remove the previous UL and this one.
						$(this).remove();
						$(this).prev('.ninja-row').remove();
						
					} else if ( prev_empty || next_empty ) {
						// If just one of the siblings are empty, remove this UL.
						$(this).remove();
					}
				} else {
					// Check to see that we have an empty UL on each side of our receiving UL.
					if ( $(this).prev('.ninja-row').children( 'li' ).length > 0 ) {
						// If our previous UL has children, insert an empty UL just before this one.
						$(this).before(empty_ul_html);
					}

					if ( $(this).next('.ninja-row').children( 'li' ).length > 0 ) {
						// If our next UL has children, insert an empty UL just after this one.
						$(this).after(empty_ul_html);
					}
				}
				// If this is our first UL, make sure that we insert a new empty row before it.
				if ( $(this).prev('.ninja-row').length == 0 ) {
					$(this).before(empty_ul_html);
				}

				// If this is our last UL, make sure that we insert a new empty row after it.
				if ( $(this).next('.ninja-row').length == 0 ) {
					$(this).after(empty_ul_html);
				}
			});
			$('.ninja-row').sortable( sortable_options );
			$('.ninja-row').disableSelection();
        }
	};

	$('.ninja-row').sortable( sortable_options );
	$('.ninja-row').disableSelection();

	function test_function( event, ui ) {
		
		var placeholder_class = ui.placeholder[0].className;

		//var old_cols = $(this).data( 'old_cols' );
		//$(this).data( 'cols', old_cols );
		//$(this).removeData( 'old_cols' );
		
		if ( this != ui.sender[0] ) {
			//var old_cols = $(ui.sender).data( 'old_cols' );
			//$(ui.sender).data( 'cols', old_cols );
			//$(ui.sender).removeData( 'old_cols' );
			
			// Loop through each of the children of our target UL and reset them.
			var target_lis = $(this).children( 'li' ).not( '.' + placeholder_class );
			$(target_lis).each( function() {
				// Get our previous size.
				var old_size = $(this).data( 'old_size' );
				
				if ( typeof old_size !== 'undefined' ) {
					$(this).removeData( 'old_size' );
					$(this).data( 'size', old_size );
					// Remove our current size class.
					$(this).removeClass();
					// Add our previous size class.
					//console.log( 'OUT - Set Target Cols: ' + old_size );
					$(this).addClass( 'ninja-col-' + old_size );
				}
			});
				
		}
	}

	$('.ninja-forms-field-button').draggable({
		revert: true,
		placeholder: '.ninja-col-1-1',
		connectToSortable: '.ninja-drop',
		helper: function(){
			var label = $(this).html();
			var el = $( "li.ninja-col-1-1:first" ).clone();
			$(el).children('div:first').find('label').html(label);
			return el;
		},
		start: function(e,ui){
			

		},
		stop: function(e, ui ){

		},
		zIndex:9999
	});

	var savedNoticeTimeout = '';

	FormSetting = Backbone.Model.extend({
		urlRoot: rest_url + '&rest=form_settings',
		
		defaults: {
			form_id: form_id
		},

		serverAttrs: ['current_value', 'id', 'form_id'],

	    initialize: function () {
	        // Define server attributes for this model
	        // COMMENT THIS LINE to verify all attrs are sent
	        //this.serverAttrs = ['id', 'current_value', 'form_id'];
	        this.on('change', this.save );
	    },

		save: function (attrs, options) {
			attrs = attrs || this.toJSON();
		    options = options || {};
		    attrs = attrs.attributes;
		    // If model defines serverAttrs, replace attrs with trimmed version
		    if (this.serverAttrs) attrs = _.pick(attrs, this.serverAttrs);

		    // Move attrs to options
		    options.attrs = attrs;

		    // Call super with attrs moved to options
		    Backbone.Model.prototype.save.call(this, attrs, options);
		    $('.media-frame-save').hide().html('Saved').fadeIn();
	        // Hide the div after 3 seconds
    		savedNoticeTimeout = setTimeout( "jQuery('.media-frame-save').fadeOut();",3000 );
		}
	});

	FormSettings = Backbone.Collection.extend({
		url: rest_url + '&rest=form_settings',
		model: FormSetting,
	});

	var formSettings = new FormSettings();
	
	var ContentView = Backbone.View.extend({
		el: '#my-content-id',
		
		initialize: function(){
 			this.collection.bind( 'reset', this.render, this );
		},

		render: function() {
			var content = _.template( $('#tmpl-form-settings').html(), { settings: formSettings.models } );
			$(this.el).html(content);			

			// This is a work-around for the wonky tinyMCE that might be in this settings collection.
			var rte = {};
			var local_mce_init = {};
			var local_qt_init = {};

			this.collection.each(function(model) {
				model_id = model.get('id');
				model_type = model.get('type');
				if ( model_type == 'rte' ) {
					
					//tinyMCE.execCommand( 'mceRemoveControl', false, 'hidden_editor' );
					tinyMCE.execCommand( 'mceRemoveControl', false, model_id );
					local_mce_init[model_id] = tinyMCEPreInit.mceInit['hidden_editor'];
					
					local_mce_init[model_id].body_class = model_id;
					
					local_mce_init[model_id].elements = model_id;

					local_mce_init[model_id]['setup'] =  function(ed) {
						ed.onChange.add(function(ed, l) {
							$('#' + ed.editorId ).trigger('change');
						});
					};

					local_qt_init[model_id] = tinyMCEPreInit.qtInit['hidden_editor'];
					local_qt_init[model_id].id = model.get('id');

					//var tmp = $('#hidden_editor_div').html();
					var tmp = '<div id="wp-hidden_editor-wrap" class="wp-core-ui wp-editor-wrap tmce-active"><link rel="stylesheet" id="editor-buttons-css" href="http://localhost:8888/wp-dev/wp-content/plugins/mp6/css/editor.css?ver=1381361301" type="text/css" media="all"><div id="wp-hidden_editor-editor-tools" class="wp-editor-tools hide-if-no-js"><a id="hidden_editor-html" class="wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">Text</a><a id="hidden_editor-tmce" class="wp-switch-editor switch-tmce" onclick="switchEditors.switchto(this);">Visual</a><div id="wp-hidden_editor-media-buttons" class="wp-media-buttons"><a href="#" id="insert-media-button" class="button insert-media add_media" data-editor="hidden_editor" title="Add Media"><span class="wp-media-buttons-icon"></span> Add Media</a></div></div><div id="wp-hidden_editor-editor-container" class="wp-editor-container"><textarea class="wp-editor-area" rows="20" cols="40" name="hidden_editor" id="hidden_editor" style="" aria-hidden="true">&lt;p&gt;test&lt;/p&gt;</textarea></div></div>';
					tmp = tmp.replace(/hidden_editor/g, model_id );
					
					$('#' + model_id + '_replace').html(tmp);
					//tinyMCE.execCommand( 'mceRemoveControl', false, model_id );
					tinyMCE.init(local_mce_init[model_id]);
					//tinyMCE.execCommand( 'mceAddControl', true, model.get('id') );
		    		try { quicktags( local_qt_init[model_id] ); } catch(e){}
		    		tinyMCE.get(model_id).setContent(model.get('current_value'));

				}
			});

 	        return this;
		},

		events: {
			'change input': 'save',
			'change textarea': 'save',
			'change select': 'save'
		},

		save: function(e) {
			clearTimeout(savedNoticeTimeout);
			$('.media-frame-save').hide().html('Saving...').fadeIn();
			var el = e.target;
			var el_id = jQuery(el).prop('id');

			if ( $(el).data( 'group' ) ) {
				var el_id = $(el).data( 'group' );
				var value = new Array();
				var x = 0;

				$('.repeater-' + el_id).each( function() {
					value[x] = this.value;
					x++;
				});
			}

			var this_model = formSettings.get( el_id );

			if ( this_model.get('type') == 'checkbox' ) {
				if ( el.checked ) {
					var value = 1;
				} else {
					var value = 0;
				}
			} else if ( this_model.get('type') == 'rte' ) {
				var value = tinyMCE.get(el_id).getContent();
			} else {
				var value = jQuery(el).val();
			}

			this_model.set( 'current_value', value );
		}

	});

	var current_tab = $('.media-menu-item.active').prop('id');
	change_tab( current_tab, $('.media-menu-item.active').html(), $('.media-menu-item.active').attr('title') );
	var formSettingsView = new ContentView({ collection: formSettings });

	$('.media-menu-item').on('click', function(e) {
		change_tab( this.id, $(this).html(), $(this).attr('title') );

	});

	function change_tab( tab_id, title, desc ) {
        formSettings.fetch({
			data: $.param({ tab: tab_id, form_id: form_id }),
			reset: true,
			success: function() {
	            $('.media-menu-item').removeClass('active');
	            $('#' + tab_id).addClass('active');
	            $('.media-frame-title').html('<h1>' + title + '</h1>');
	            $('.media-frame-desc').html(desc);
			},
			error: function() {
				//console.log('failed to get!');
			}
		});
	}



}); //Document.ready();

function ninja_forms_new_field_response( response ){
	jQuery("#ninja_forms_field_list").append(response.new_html).show('slow');
	if(typeof response.edit_options != 'undefined'){
		for(var i = 0; i < response.edit_options.length; i++){
			if(response.edit_options[i].type == 'rte'){
				var editor_id = 'ninja_forms_field_' + response.new_id + '[' + response.edit_options[i].name + ']';

				tinyMCE.execCommand( 'mceRemoveControl', false, editor_id );
				tinyMCE.execCommand( 'mceAddControl', true, editor_id );
			}
		}
	}
	jQuery(".ninja-forms-field-conditional-cr-field").each(function(){
		jQuery(this).append('<option value="' + response.new_id + '">' + response.new_type + '</option>');
	});
	jQuery("#ninja_forms_field_" + response.new_id + "_toggle").click();

	jQuery("#ninja_forms_field_" + response.new_id + "_label").focus();

	// Fire our custom jQuery addField event.
	jQuery(document).trigger('addField', [ response ]);

}

function ninja_forms_escape_html(html) {
	var escape = document.createElement('textarea');
    escape.innerHTML = html;
    return escape.innerHTML;
}