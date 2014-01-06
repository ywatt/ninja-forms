jQuery(document).ready(function($) {

	var savedNoticeTimeout = '';

	FormSetting = Backbone.Model.extend({
		urlRoot: ninja_forms_rest_url + '&rest=form_settings',

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
		    $('.updated').hide().html('Saved').fadeIn();
	        // Hide the div after 3 seconds
    		savedNoticeTimeout = setTimeout( "jQuery('.updated').fadeOut();",3000 );
    		formSettingsView.render();
		}
	});

	FormSettings = Backbone.Collection.extend({
		url: ninja_forms_rest_url + '&rest=form_settings',
		model: FormSetting,
	});

	var formSettings = new FormSettings();

	var ContentView = Backbone.View.extend({
		el: '#my-content-id',

		template: '#tmpl-form-settings',

		initialize: function(){
 			this.collection.bind( 'reset', this.render, this );
		},

		render: function() {
			var content = _.template( $(this.template).html(), { settings: formSettings.models } );
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
			//this.template = '#tmpl-form-settings';
 	        return this;
		},

		changeTemplate: function( template_id ) {
			this.template = template_id;
		},

		events: {
			'change input.form-setting': 'save',
			'change textarea': 'save',
			'change select': 'save'
		},

		save: function(e) {
			clearTimeout(savedNoticeTimeout);
			$('.updated').hide().html('Saving...').fadeIn();
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

	var formSettingsView = new ContentView({ collection: formSettings });
	var current_tab = $('.media-menu-item.active').prop('id');
	change_tab( current_tab, $('.media-menu-item.active').html(), $('.media-menu-item.active').attr('title') );
	
	$('.media-menu-item').on('click', function(e) {
		if ( $(this).data('custom') == 1 ) {
			formSettingsView.template = '#tmpl-' + this.id;
		} else {
			formSettingsView.template = '#tmpl-form-settings';
		}
		change_tab( this.id, $(this).html(), $(this).attr('title') );
	});

	function change_tab( tab_id, title, desc ) {
		formSettings.fetch({
			data: $.param({ tab: tab_id, form_id: form_id }),
			reset: true,
			success: function() {
	            $('.media-menu-item').removeClass('active');
	            $('#' + tab_id).addClass('active');
	            $('.nf-settings-title h1').html(title);
	            $('.nf-settings-desc').html(desc);
			},
			error: function() {
				console.log('failed to get!');
			}
		});
	}
}); //Document.ready();