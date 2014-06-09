jQuery.fn.putCursorAtEnd = function() {

  return this.each(function() {

    jQuery(this).focus()

    // If this function exists...
    if (this.setSelectionRange) {
      // ... then use it (Doesn't work in IE)

      // Double the length because Opera is inconsistent about whether a carriage return is one character or two. Sigh.
      var len = jQuery(this).val().length * 2;

      this.setSelectionRange(len, len);
    
    } else {
    // ... otherwise replace the contents with itself
    // (Doesn't work in Google Chrome)

      jQuery(this).val(jQuery(this).val());
      
    }

    // Scroll to the bottom, in case we're in a tall textarea
    // (Necessary for Firefox and Google Chrome)
    this.scrollTop = 999999;

  });

};

jQuery( document ).ready( function( $ ) {

    $( '.media-modal-close' ).on( 'click', function( e) {
    	$.modal.close();
    });

	$( '.control-section h3' ).on( 'click', function( e ) {
		if ( $( this ).parent().hasClass( 'open' ) ) {
			$( this ).parent().removeClass( 'open' );
			$( this ).parent().addClass( 'closed' );
		} else {
			$( this ).parent().removeClass( 'closed' );
			$( this ).parent().addClass( 'open' );
		}
	});

	/** Make our field list sortable **/
	$( '#nf_field_list' ).sortable({
		items: 'ul',
		update: function( event, ui ) {
			var order = $( '#nf_field_list' ).sortable( 'toArray' );
			var x = 0;
			_.each( order, function ( field ) {
				var field_id = field.replace( 'nf_field_', '' );
				fieldList.get( field_id ).set( 'order', x );
				x++;
			});
			fieldListOrder.set( 'order', order );
		}
	});

	/** Create the Backbone for our field list **/

	// Model that holds each field.
	// Stores the id, type, and order.
	var FieldListItem = Backbone.Model.extend({
		urlRoot: nf_rest_url
	});

	// Model that holds the field order.
	// This exists so that we don't have to update for each field when the order changes.
	var FieldListOrder = Backbone.Model.extend({
		urlRoot: nf_rest_url,
		serverAttrs: ['order'],
		defaults: {
			order: $( '#nf_field_list' ).sortable( 'toArray' )
		},
		initialize: function () {
	        // Define server attributes for this model
	        this.on( 'change', this.save );
	    },
		save: function ( attrs, options ) {
			attrs = attrs || this.toJSON();
		    options = options || {};
		    attrs = attrs.attributes;
		    // If model defines serverAttrs, replace attrs with trimmed version
		    if (this.serverAttrs) attrs = _.pick(attrs, this.serverAttrs);

		    // Move attrs to options
		    options.attrs = attrs;

		    // Call super with attrs moved to options
		    Backbone.Model.prototype.save.call(this, attrs, options);
		}
	});

	fieldListOrder = new FieldListOrder();

	var FieldList = Backbone.Collection.extend({
		url: nf_rest_url,
		model: FieldListItem
	});

	fieldList = new FieldList();

	var FieldListView = Backbone.View.extend({
		el: '#nf_field_list',
		initialize: function(){
			this.collection.bind( 'reset', this.render, this );
		},
		render: function() {
			var content = '';
			_.each( fieldList.models, function( field ){
				content += _.template( $( '#tmpl-nf-field-list' ).html(), { field: field } );
			});
			
			$( this.el ).html( content );

			return this;
		},
		delete: function( e ) {
			e.preventDefault();
			var answer = confirm( commonL10n.warnDelete );
			if ( answer ) {
				var field_id = $( e.target ).data( 'field-id' );
				fieldList.get( field_id ).destroy({ test: 'test' });
				fieldListView.render();			
			}
		},
		edit: function( e ) {
			e.preventDefault();
			var fieldID = $( e.target ).data( 'field-id' );
			var fieldTitle = $( e.target ).data( 'field-title' );
			$( document ).data( 'nf-setting-h1', fieldTitle );
			settings.fetch({
				reset: true,
				data: $.param({ object_type: 'field_settings', object_id: fieldID })
			});
			menus.fetch({
				reset:true,
				data: $.param({ object_type: 'field_menu', object_id: fieldID })
			});
			
		},
		events: {
			'click .delete-field': 'delete',
			'click .edit-field': 'edit'
		},
	});

	fieldListView = new FieldListView({ collection: fieldList });

	fieldList.fetch({
		reset: true,
		data: $.param({ object_type: 'field_list', object_id: nf_form_id })
	});

	/** Create the Backbone for our form and field menus **/

	Menu = Backbone.Model.extend({
		urlRoot: nf_rest_url
	});

	var Menus = Backbone.Collection.extend({
		url: nf_rest_url,
		model: Menu
	});

	var menus = new Menus();

	var MenusView = Backbone.View.extend({
		el: '#nf-settings-menu',
		template: '#tmpl-nf-settings-menu',
		initialize: function() {
			this.collection.bind( 'reset', this.render, this );
		},
		render: function() {
			var content = _.template( $( this.template ).html(), { menus: menus.models } );
			$( this.el ).html( content );
			return this;
		},
		events: {
			'click a': 'change',
		},
		change: function( e ) {
			e.preventDefault();

			// Show our loading message;
			$( '.loading' ).fadeIn();

			// Remove our active class from all our menus.
			$( '.nf-settings-menu' ).removeClass( 'active' );

			// Change our active attribute to 0 for all our models.
			_.each( menus.models, function ( model ) {
				model.set( 'active', 0 );
			});

			// Add the active class to this menu link.
			$( e.target ).addClass( 'active' );

			var menuItem = $( e.target ).data( 'menu-item' );
			var objectType = $( e.target ).data( 'object-type' );
			var objectID = $( e.target ).data( 'object-id' );

			// Change the active attribute on this data model to 1.
			menus.get( menuItem ).set( 'active', 1 );

			// Fetch the settings for this menu link.
			settings.fetch({
				reset: true,
				data: $.param({ object_type: objectType + '_settings', object_id: objectID, menu: menuItem }),
				success: function() {
					$( '.loading' ).fadeOut();
				}
			});
		}
	});

	menusView = new MenusView({ collection: menus });

	/** Create the Backbone for our form and field settings **/
	var savedNoticeTimeout = '';

	Setting = Backbone.Model.extend({
		urlRoot: nf_rest_url,
		serverAttrs: ['current_value', 'object_id', 'meta_key'],

	    initialize: function () {
	        // Define server attributes for this model
	        this.on( 'change', this.save, this );
	    },
		save: function (attrs, options) {
			attrs = attrs || this.toJSON();
		    options = options || {};
		    attrs = attrs.attributes;

		    // Call super with attrs moved to options
		    Backbone.Model.prototype.save.call(this, attrs, options);
		    jQuery('.updated').hide().fadeIn();
	        // Hide the div after 3 seconds
			savedNoticeTimeout = setTimeout( "jQuery('.updated').fadeOut();",3000 );
		}
	});

	var Settings = Backbone.Collection.extend({
		url: nf_rest_url,
		model: Setting,
		newSetting: function( opts ) {
			newModel = this.add([ opts ]);
			return newModel[0];
		}
	});

	settings = new Settings();

	var SettingsView = Backbone.View.extend({
		el: '#nf-settings-content',
		h1_el: '#nf-settings-h1',
		template: '#tmpl-nf-settings',
		h1_template: '#tmpl-nf-settings-h1',
		initialize: function() {
			this.collection.bind( 'reset', this.render, this );
		},
		render: function() {
			var content = _.template( $( this.template ).html(), { settings: settings.models } );
			$( this.el ).html( content );

			var title = _.template( $( this.h1_template ).html(), { title: $( document ).data( 'nf-setting-h1' ) } );
			$( this.h1_el ).html( title );

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
							jQuery('#' + ed.editorId ).trigger('change');
						});
					};

					local_qt_init[model_id] = tinyMCEPreInit.qtInit['hidden_editor'];
					local_qt_init[model_id].id = model.get('id');

					//var tmp = jQuery('#hidden_editor_div').html();
					var tmp = '<div id="wp-hidden_editor-wrap" class="wp-core-ui wp-editor-wrap tmce-active"><link rel="stylesheet" id="editor-buttons-css" href="http://localhost/wp-dev/wp-content/plugins/mp6/css/editor.css?ver=1381361301" type="text/css" media="all"><div id="wp-hidden_editor-editor-tools" class="wp-editor-tools hide-if-no-js"><a id="hidden_editor-html" class="wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">Text</a><a id="hidden_editor-tmce" class="wp-switch-editor switch-tmce" onclick="switchEditors.switchto(this);">Visual</a><div id="wp-hidden_editor-media-buttons" class="wp-media-buttons"><a href="#" id="insert-media-button" class="button insert-media add_media" data-editor="hidden_editor" title="Add Media"><span class="wp-media-buttons-icon"></span> Add Media</a></div></div><div id="wp-hidden_editor-editor-container" class="wp-editor-container"><textarea class="wp-editor-area" rows="20" cols="40" name="hidden_editor" id="hidden_editor" style="" aria-hidden="true">&lt;p&gt;test&lt;/p&gt;</textarea></div></div>';
					tmp = tmp.replace(/hidden_editor/g, model_id );

					jQuery( '#' + model_id + '_replace' ).html(tmp);
					//tinyMCE.execCommand( 'mceRemoveControl', false, model_id );
					tinyMCE.init(local_mce_init[model_id]);
					//tinyMCE.execCommand( 'mceAddControl', true, model.get('id') );
		    		try { quicktags( local_qt_init[model_id] ); } catch(e){}
		    		tinyMCE.get(model_id).setContent(model.get('current_value'));

				}
			});

			/** Make our list items sortable **/
			$( '.nf-list-items' ).sortable({
				items: 'tr.nf-list-item',
				handle: 'span.drag',
				update: function( event, ui ) {
					var newOrder = $( this ).sortable( 'toArray' );
					for (var i = newOrder.length - 1; i >= 0; i--) {
						var order = i;
						var id = $( '#' + newOrder[i] ).data( 'item-id' );
						var thisModel = settings.get( 'item_' + id + '_order' );
						thisModel.set( 'current_value', order );
					};
				}
			});

			return this;
		},
		events: {
			'change input.nf-setting': 'save',
			'change textarea.nf-setting': 'save',
			'change select.nf-setting': 'save',
			'click .nf-delete-list-item': 'delete_list_item'
		},
		save: function(e) {
			clearTimeout(savedNoticeTimeout);
			jQuery('.updated').hide().fadeIn();
			var el = e.target;
			var el_id = jQuery(el).prop('id');

			var this_model = settings.get( el_id );

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
		},
		/** Deletion of list field items **/
		delete_list_item: function(e) {
			e.preventDefault();
			var answer = confirm( commonL10n.warnDelete );
			if ( answer ) {
				//var items = settings.get( 'list_items' ).get( 'items' );
				var item_id = $( e.target ).data( 'item-id' );
				var field_id = $( e.target ).data( 'field-id' );
				settings.get( item_id ).destroy({
					wait: true,
					success: function() {
						// Fetch the settings for this list.
						settings.fetch({
							reset: true,
							data: $.param({ object_type: 'field_settings', object_id: field_id, menu: 'items' })
						});
					}
				});
			}
		}
	});

	settingsView = new SettingsView({ collection: settings });

	/** Creation of new list field items **/
	$( document ).on( 'keyup', '.nf-new-item', nf_new_list_item );

	/** Handle fetching settings when the user clicks on the "Form Settings" button. **/
	$( '#form_settings' ).on( 'click', function(e) {
		e.preventDefault();
		$( document ).data( 'nf-setting-h1', 'Form Settings' );
		settings.fetch({
			reset: true,
			data: $.param({ object_type: 'form_settings', object_id: nf_form_id })
		});
		menus.fetch({
			reset:true,
			data: $.param({ object_type: 'form_menu', object_id: nf_form_id })
		});
	});

	function nf_new_list_item(e){
		if ( $( this ).val() == '' ) {
			return false;
		}

		// Unbind our new item listener.
		$( document ).off( 'keyup', '.nf-new-item' );

		var parent_id = $( this ).data( 'parent-id' );
		var meta = [{
			meta_key: $( this ).data( 'meta-key' ),
			meta_value: $( this ).val(),
		}, {
			meta_key: 'order',
			meta_value: $( '.nf-list-items' ).find( 'tr.nf-list-item' ).length
		}
		];
		var opts = {
			object_type: 'list_item',
			meta: meta,
			parent_id: parent_id
		} 
		new_model = settings.newSetting( opts );
		new_model.save({}, { 
			success: function( model, response ) {
				var new_id = response;
				var order = $( '.nf-list-items' ).find( 'tr.nf-list-item' ).length;
				// Clone our new item tr so that we can re-add it later.
				var clone = $( '.nf-list-item-new' ).clone();

				// Add our id to this tr
				$( '.nf-list-item-new' ).prop( 'id', 'item_' + new_id + '_tr' );
				// Add our id to this tr as a data attribute
				$( '.nf-list-item-new' ).data( 'item-id', new_id );



				// Add our regular item class to the new-item tr
				$( '.nf-list-item-new' ).addClass( 'nf-list-item' );

				// Remove the nf-list-item-new class from our cloning TR
				$( '.nf-list-item-new' ).removeClass( 'nf-list-item-new' );

				// Add a new item to the 'items' property of our list_items model.
				var items = settings.get( 'list_items' ).get( 'items' );
				items[ items.length ] = {
					label: $( '#item_new_label' ).val(),
					value: $( '#item_new_value' ).val(),
					calc: $( '#item_new_calc' ).val(),
					order: order,
					object_id: new_id
				}

				// Add a new model for tracking this object
				settings.newSetting({
					id: new_id
				});

				// Add a new model to hold the order of this item
				settings.newSetting({
					id: 'item_' + new_id + '_order',
					current_value: order,
					meta_key: 'order',
					object_id: new_id
				});

				// Add a new model for each of our settings.
				settings.newSetting({
					id: 'item_' + new_id + '_label',
					current_value: $( '#item_new_label' ).val(),
					meta_key: 'label',
					object_id: new_id,
				});				

				settings.newSetting({
					id: 'item_' + new_id + '_value',
					current_value: $( '#item_new_value' ).val(),
					meta_key: 'value',
					object_id: new_id
				});

				settings.newSetting({
					id: 'item_' + new_id + '_calc',
					current_value: $( '#item_new_calc' ).val(),
					meta_key: 'calc',
					object_id: new_id
				});

				// Remove the nf-new-item class
				$( '#item_new_label' ).removeClass( 'nf-new-item' );
				$( '#item_new_value' ).removeClass( 'nf-new-item' );
				$( '#item_new_calc' ).removeClass( 'nf-new-item' );

				// Add the nf-setting class
				$( '#item_new_label' ).addClass( 'nf-setting' );
				$( '#item_new_value' ).addClass( 'nf-setting' );
				$( '#item_new_calc' ).addClass( 'nf-setting' );				

				// Change our label id
				$( '#item_new_label' ).prop( 'id', 'item_' + new_id + '_label' );
				// Change our value id
				$( '#item_new_value' ).prop( 'id', 'item_' + new_id + '_value' );				
				// Change our calc id
				$( '#item_new_calc' ).prop( 'id', 'item_' + new_id + '_calc' );

				// Remove the new item th
				$( 'th.list-item-new' ).fadeOut().remove();
				// Show the actions th
				$( 'th.list-item-actions' ).fadeIn();
				// Show the selected td
				$( 'td.list-item-selected' ).fadeIn();

				// Add our item-id data attribute to the delete button
				$( 'th.list-item-actions' ).find( 'a' ).data( 'item-id', new_id );
				$( 'th.list-item-actions' ).removeClass( 'list-item-actions' );

				// Change the value of the selected radio button
				$( 'td.list-item-selected' ).find( 'input' ).val( new_id );
				$( 'td.list-item-selected' ).removeClass( 'list-item-selected' );

				// Give our cloned new TR a display:none; style
				$( clone ).css( 'display', 'none' );
				// Make sure that our textboxes are empty.
				$( clone ).find( 'input' ).val( '' );

				// Add our cloned new TR back after the list tbody
				$( 'tbody.nf-list-items' ).append( clone );

				// Fade in our new item TR
				$( '.nf-list-item-new' ).fadeIn();

				// Refresh our sorable list.
				$( '.nf-list-items' ).sortable( 'refresh' );

				$( '.nf-list-items' ).trigger('sortupdate');

				// Rebind our new item listener
				$( document ).on( 'keyup', '.nf-new-item', nf_new_list_item );

			},
			error: function() {
				console.log( 'error' );
			}
		});
	}
});