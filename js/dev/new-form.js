jQuery(document).ready(function($) {
	$('#btn_new_form').click();

	$(document).on('click', '#new-form-wizard', function(e) {
		e.preventDefault();
		wizardActionsView.render();
		wizardLeftView.render();
		wizardRightView.render();
	});

	var WizardActionsView = Backbone.View.extend({
		el: '#wizard-actions',

		initialize: function() {

		},

		render: function() {
			var content = _.template( $('#tmpl-wizard-actions').html() );
			$(this.el).html(content);
		}
	});
	var wizardActionsView = new WizardActionsView();

	var WizardLeftView = Backbone.View.extend({
		el: '#wizard-left',

		initialize: function() {

		},

		render: function() {
			var content = _.template( $('#tmpl-wizard-left').html() );
			$(this.el).html(content);
		}
	});

	var wizardLeftView = new WizardLeftView();	

	var WizardRightView = Backbone.View.extend({
		el: '#wizard-right',

		initialize: function() {

		},

		render: function() {
			var content = _.template( $('#tmpl-wizard-right').html() );
			$(this.el).html(content);
		}
	});

	var wizardRightView = new WizardRightView();


});