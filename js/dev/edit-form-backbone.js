jQuery(document).ready(function($) {
	var savedNoticeTimeout = '';

	Setting = Backbone.Model.extend({
		urlRoot: nf_rest_url + '&nf_rest=rest_api',

		defaults: {
			object_id: object_id
		},

		serverAttrs: ['current_value', 'id', 'object_id', 'meta_key'],

	    initialize: function () {
	        // Define server attributes for this model
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
		    jQuery('.updated').hide().html('Saved').fadeIn();
	        // Hide the div after 3 seconds
			savedNoticeTimeout = setTimeout( "jQuery('.updated').fadeOut();",3000 );
			settingsView.render();
		}
	});

	var Settings = Backbone.Collection.extend({
		url: nf_rest_url + '&nf_rest=rest_api',
		model: Setting,
	});

	var settings = new Settings();

	var ContentView = Backbone.View.extend({

		el: '#nf-settings-content',

		template: '#tmpl-nf-settings',

		initialize: function(){
				this.collection.bind( 'reset', this.render, this );
		},

		render: function() {

			var content = _.template( jQuery(this.template).html(), { settings: settings.models } );
			jQuery( this.el ).html( content );

			jQuery( '.spinner' ).hide();
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
							jQuery('#' + ed.editorId ).trigger('change');
						});
					};

					local_qt_init[model_id] = tinyMCEPreInit.qtInit['hidden_editor'];
					local_qt_init[model_id].id = model.get('id');

					//var tmp = jQuery('#hidden_editor_div').html();
					var tmp = '<div id="wp-hidden_editor-wrap" class="wp-core-ui wp-editor-wrap tmce-active"><link rel="stylesheet" id="editor-buttons-css" href="http://localhost:8888/wp-dev/wp-content/plugins/mp6/css/editor.css?ver=1381361301" type="text/css" media="all"><div id="wp-hidden_editor-editor-tools" class="wp-editor-tools hide-if-no-js"><a id="hidden_editor-html" class="wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">Text</a><a id="hidden_editor-tmce" class="wp-switch-editor switch-tmce" onclick="switchEditors.switchto(this);">Visual</a><div id="wp-hidden_editor-media-buttons" class="wp-media-buttons"><a href="#" id="insert-media-button" class="button insert-media add_media" data-editor="hidden_editor" title="Add Media"><span class="wp-media-buttons-icon"></span> Add Media</a></div></div><div id="wp-hidden_editor-editor-container" class="wp-editor-container"><textarea class="wp-editor-area" rows="20" cols="40" name="hidden_editor" id="hidden_editor" style="" aria-hidden="true">&lt;p&gt;test&lt;/p&gt;</textarea></div></div>';
					tmp = tmp.replace(/hidden_editor/g, model_id );

					jQuery( '#' + model_id + '_replace' ).html(tmp);
					//tinyMCE.execCommand( 'mceRemoveControl', false, model_id );
					tinyMCE.init(local_mce_init[model_id]);
					//tinyMCE.execCommand( 'mceAddControl', true, model.get('id') );
		    		try { quicktags( local_qt_init[model_id] ); } catch(e){}
		    		tinyMCE.get(model_id).setContent(model.get('current_value'));

				}
			});
			
		        return this;
		},

		changeTemplate: function( template_id ) {
			this.template = template_id;
		},

		events: {
			'change input.nf-setting': 'save',
			'change textarea': 'save',
			'change select': 'save'
		},

		save: function(e) {
			clearTimeout(savedNoticeTimeout);
			jQuery('.updated').hide().html('Saving...').fadeIn();
			var el = e.target;
			var el_id = jQuery(el).prop('id');

			if ( jQuery(el).data( 'group' ) ) {
				var el_id = jQuery(el).data( 'group' );
				var value = new Array();
				var x = 0;

				jQuery('.repeater-' + el_id).each( function() {
					value[x] = this.value;
					x++;
				});
			}

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

	var settingsView = new ContentView({ collection: settings });

	nf_settings_change_tab = function ( tab_id, title, desc, object_id, scope, group, custom ) {
		jQuery( '.spinner' ).show();
		if ( custom == 1 ) {
			settingsView.template = '#tmpl-' + tab_id;
		}
		settings.fetch({
			data: jQuery.param({ tab: tab_id, object_id: object_id, scope: scope, group: group }),
			reset: true,
			success: function() {
	            jQuery( '.media-menu-item' ).removeClass( 'active' );
	            jQuery( '#' + tab_id ).addClass( 'active' );
	           
	            jQuery( '.nf-settings-title h1' ).html( title );
	            jQuery( '.nf-settings-desc' ).html( desc );
			},
			error: function() {
				console.log('failed to get!');
			}
		});
	}

	var current_tab = jQuery( '.media-menu-item.active' ).prop('id');
	var object_id = jQuery( '.media-menu-item.active' ).data( 'object-id' );
	var scope = jQuery( '.media-menu-item.active' ).data( 'scope' );
	var group = jQuery( '.media-menu-item.active' ).data( 'group' );
	var custom = jQuery( '.media-menu-item.active' ).data( 'custom' );
	if ( typeof current_tab !== 'undefined' ) {
		nf_settings_change_tab( current_tab, jQuery( '.media-menu-item.active' ).html(), jQuery( '.media-menu-item.active' ).attr( 'title' ), object_id, scope, group, custom );
	}

	jQuery(document).on( 'click', '.media-menu-item', function(e) {
		e.preventDefault();
		if ( jQuery(this).data( 'custom' ) == 1 ) {
			settingsView.template = '#tmpl-' + this.id;
		} else {
			settingsView.template = '#tmpl-nf-settings';
		}

		var object_id = jQuery(this).data( 'object-id' );
		var scope = jQuery(this).data( 'scope' );
		var group = jQuery(this).data( 'group' );

		nf_settings_change_tab( this.id, jQuery( this ).html(), jQuery( this ).attr( 'title' ), object_id, scope, group, custom );
	});
}); //Document.ready();