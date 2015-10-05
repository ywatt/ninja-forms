define(
	[
		'front-end/controllers/fieldError',
		'front-end/controllers/changeField',
		'front-end/controllers/changeEmail',
		'front-end/controllers/fieldCheckbox',
		'front-end/controllers/fieldRadio',
		'front-end/controllers/mirrorField',
		'front-end/controllers/confirmField',
		'front-end/controllers/updateFieldModel',
		'front-end/controllers/submitInit',
		'front-end/controllers/getFormErrors',
		'front-end/controllers/selectFile',
		'front-end/controllers/validateRequired',
		'front-end/controllers/submitError',
		'front-end/controllers/actionRedirect'
	],
	function(
		FieldError,
		ChangeField,
		ChangeEmail,
		FieldCheckbox,
		FieldRadio,
		MirrorField,
		ConfirmField,
		UpdateFieldModel,
		SubmitInit,
		GetFormErrors,
		SelectFile,
		ValidateRequired,
		SubmitError,
		ActionRedirect
	) {
		var controller = Marionette.Object.extend( {
			initialize: function() {
				var fieldError = new FieldError();
				var changeField = new ChangeField();
				var changeEmail = new ChangeEmail();
				var fieldCheckbox = new FieldCheckbox();
				var fieldRadio = new FieldRadio();
				var mirrorField = new MirrorField();
				var confirmField = new ConfirmField();
				var updateFieldModel = new UpdateFieldModel();
				var submitInit = new SubmitInit();
				var getFormErrors = new GetFormErrors();
				var selectFile = new SelectFile();
				var validateRequired = new ValidateRequired();
				var submitError = new SubmitError();
				var actionRedirect = new ActionRedirect();
			}
		});

		return controller;
} );