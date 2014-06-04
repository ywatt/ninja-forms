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
	        this.on( 'change', this.save );
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
				items: 'tr',
				update: function( event, ui ) {
					var newOrder = $( this ).sortable( 'toArray' );
					for (var i = newOrder.length - 1; i >= 0; i--) {
						var order = i;
						var thisModel = settings.get( 'item_' + newOrder[i] + '_order' );
						thisModel.set( 'current_value', order );
					};
				}
			});

			return this;
		},
		events: {
			'change input.nf-setting': 'save',
			'change textarea': 'save',
			'change select': 'save'
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
		}
	});

	settingsView = new SettingsView({ collection: settings });

	/** Creation of new list field items **/
	$( document ).on( 'change', '.nf-new-item', function(e){
		var parent_id = $( this ).data( 'parent-id' );
		var meta = [{
			meta_key: $( this ).data( 'meta-key' ),
			meta_value: $( this ).val(),
		}, {
			meta_key: 'order',
			meta_value: $( '.nf-list-items' ).find( 'tr' ).length
		}
		];
		var opts = {
			object_type: 'list_item',
			meta: meta,
			parent_id: parent_id
		} 
		new_model = settings.newSetting( opts );
		new_model.save({ 
			success: function() {
				console.log( 'hello world' );
			},
			error: function() {
				console.log( 'error' );
			}
		});
		
	});

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

});