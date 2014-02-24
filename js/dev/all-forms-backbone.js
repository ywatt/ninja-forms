jQuery(document).ready(function($) {

	var savedNoticeTimeout = '';

	var Form = Backbone.Model.extend({
		urlRoot: function() {
			return nf_rest_url + '&nf_rest=rest_api&type=' + $( '#nf_form_type' ).val();
		},

		defaults: {
			object_id: object_id
		},

		initialize: function () {
	        // Define server attributes for this model
	        //this.on('destory', this.destroy );
	    }


	});

	var Forms = Backbone.Collection.extend({
		url: function() {
			return nf_rest_url + '&nf_rest=rest_api&type=' + $( '#nf_form_type' ).val();
		},
		model: Form,
	});

	var forms = new Forms();

	var ContentView = Backbone.View.extend({

		el: '#nf-all-forms-content',

		template: '#tmpl-all-forms',

		initialize: function(){
			this.collection.bind( 'reset', this.render, this );
		},

		render: function() {

			var content = _.template( jQuery( this.template ).html(), { forms: forms.models } );
			jQuery( this.el ).html( content );

			jQuery( '.spinner' ).hide();
			
	        return this;
		},

		changeTemplate: function( template_id ) {
			this.template = template_id;
		}

	});

	// Initialize our stuff
	var formsView = new ContentView({ collection: forms });
	nf_fetch_all_forms();

	// Get our data.
	function nf_fetch_all_forms() {
		$( '.spinner' ).show();
		forms.fetch({
			data: jQuery.param({ object_id: 0, scope: 'all_forms', group: 'all_forms' }),
			reset: true,
			success: function() {
				//console.log( 'success' );
			},
			error: function() {
				console.log('failed to get!');
			}
		});
	}

	$( document ).on( 'change', '#nf_form_type', function(e){
		nf_fetch_all_forms();
	});

	$( document ).on( 'click', '.nf-delete-form', function(e){
		var del = confirm( commonL10n.warnDelete );
		if ( del ) {
			// Delete our form model
			var tmp = forms.get( $( this ).data( 'form_id' ) );
			tmp.destroy({
				success: function() {
					//console.log( 'test' );
				}
			});
			// Reload our view.
			nf_fetch_all_forms();
		}
	});

	$( document ).on( 'click', '#nf_create_form', function(e) {
		e.preventDefault();
		var name = $('#nf_new_form_name').val();
		$.post( ajaxurl, { action: 'nf_new_form', name: name }, function( response ) {
			window.location = admin_url + '?page=ninja-forms-edit&form_id=' + response;
		});
	});

	// Wizard JS

	var WizardSetting = Backbone.Model.extend({
		urlRoot: function() {
			return nf_rest_url + '&nf_rest=rest_api&name=' + $( '#nf_new_form_name' ).val();
		},

		defaults: {
			object_id: object_id
		},

		initialize: function () {
	        // Define server attributes for this model
	        //this.on('destory', this.destroy );
	    }


	});

	var WizardSettings = Backbone.Collection.extend({
		url: function() {
			return nf_rest_url + '&nf_rest=rest_api&name=' + $( '#nf_new_form_name' ).val();
		},
		model: WizardSetting,
	});

	var wizardSettings = new WizardSettings();

	$(document).on('click', '#nf_new_form_wizard', function(e) {
		e.preventDefault();
		if ( $( '#nf_new_form_name' ).val() == '' )
			return false;
		wizardLeftView.template = '#tmpl-nf-settings';
		wizardSettings.fetch({
			data: jQuery.param({ object_id: -1, scope: 'form', group: 'wizard' }),
			reset: true,
			success: function() {
				//console.log( 'success' );
			},
			error: function() {
				console.log('failed to get!');
			}
		});
		wizardRightView.template = '#tmpl-wizard-right';
		wizardRightView.render();
	});

	var WizardLeftView = Backbone.View.extend({

		el: '#wizard-left',

		template: '#tmpl-wizard-left-start',

		initialize: function(){
			this.collection.bind( 'reset', this.render, this );
			this.render();
		},

		render: function() {
			var content = _.template( $( this.template ).html(), { settings: wizardSettings.models } );
			jQuery( this.el ).html( content );

			// If we are on our start template, remove the "previous" and "next" buttons.
			if ( this.template == '#tmpl-wizard-left-start' ) {
				wizardActionsView.template = '#tmpl-wizard-actions-start';
			} else {
				wizardActionsView.template = '#tmpl-wizard-actions';
			}
			wizardActionsView.render();
		}
	});	

	var WizardRightView = Backbone.View.extend({

		el: '#wizard-right',

		template: '#tmpl-wizard-right-start',

		initialize: function() {
			this.render();
		},

		render: function() {
			var content = _.template( $( this.template ).html() );
			$(this.el).html(content);
		}
	});


	var WizardActionsView = Backbone.View.extend({
		el: '#wizard-actions',

		template: '#tmpl-wizard-actions-start',

		initialize: function() {
			//this.render();
		},

		render: function() {
			var content = _.template( $( this.template ).html() );
			$(this.el).html(content);
		}
	});

	var wizardActionsView = new WizardActionsView();
	var wizardRightView = new WizardRightView();	
	var wizardLeftView = new WizardLeftView({ collection: wizardSettings });

	$( document ).on( 'click', '#nf_new_form', function(e) {
		e.preventDefault();
		$( '#nf_new_form_name' ).focus();
	});

	$( document ).on( 'click', '#nf_wizard_previous', function(e) {
		if ( wizardLeftView.template == '#tmpl-nf-settings' ) {
			wizardLeftView.template = '#tmpl-wizard-left-start';
			wizardLeftView.render();
			wizardRightView.template = '#tmpl-wizard-right-start';
			wizardRightView.render();
			var name = wizardSettings.get( 'name' );
			name = name.get( 'current_value' );
			$( '#nf_new_form_name' ).val( name );
		}
	});

	$( document ).on( 'click', '#nf_wizard_next', function(e) {
		console.log( 'next' );
	});

}); //Document.ready();