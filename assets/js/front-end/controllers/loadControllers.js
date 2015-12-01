define(
	[
		'controllers/fieldError',
		'controllers/changeField',
		'controllers/changeEmail',
		'controllers/fieldCheckbox',
		'controllers/fieldRadio',
		'controllers/mirrorField',
		'controllers/confirmField',
		'controllers/updateFieldModel',
		'controllers/submitInit',
		'controllers/getFormErrors',
		'controllers/selectFile',
		'controllers/validateRequired',
		'controllers/submitError',
		'controllers/actionRedirect',
		'controllers/actionSuccess',
		'controllers/fieldSelect',
		'controllers/coreSubmitResponse'
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
		ActionRedirect,
		ActionSuccess,
		FieldSelect,
		CoreSubmitResponse
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
				var actionSuccess = new ActionSuccess();
				var fieldSelect = new FieldSelect();
				var coreSubmitResponse = new CoreSubmitResponse();
			}
		});

		return controller;
} );