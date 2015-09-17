define(
	[
		'front-end/controllers/fieldError',
		'front-end/controllers/changeField',
		'front-end/controllers/changeEmail',
		'front-end/controllers/changeCheckbox',
		'front-end/controllers/changeRadio',
		'front-end/controllers/mirrorField',
		'front-end/controllers/confirmField',
		'front-end/controllers/updateFieldModel'
	],
	function(
		FieldError,
		ChangeField,
		ChangeEmail,
		ChangeCheckbox,
		ChangeRadio,
		MirrorField,
		ConfirmField,
		UpdateFieldModel
	) {
		var controller = Marionette.Object.extend( {
			initialize: function() {
				var fieldError = new FieldError();
				var changeField = new ChangeField();
				var changeEmail = new ChangeEmail();
				var changeCheckbox = new ChangeCheckbox();
				var changeRadio = new ChangeRadio();
				var mirrorField = new MirrorField();
				var confirmField = new ConfirmField();
				var updateFieldModel = new UpdateFieldModel();
			}
		});

		return controller;
} );