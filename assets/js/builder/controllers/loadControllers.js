define(
	[
		'builder/controllers/hotkeys',
		'builder/controllers/fields/types',
		'builder/controllers/fields/fieldTypeDrag',
		'builder/controllers/fields/stagingDrag',
		'builder/controllers/fields/savedFieldsSection',
		'builder/controllers/fields/staging',
		'builder/controllers/fields/stagingSortable',
		'builder/controllers/app/drawer',
		'builder/controllers/app/drawerConfig',
		'builder/controllers/fields/filterTypes',
		'builder/controllers/app/domainConfig',
		'builder/controllers/app/data',
		'builder/controllers/mainContentFieldsSortable',
		'builder/controllers/fields/data',
		'builder/controllers/fields/itemControls',
		'builder/controllers/app/drawerToggleSettingGroup',
		'builder/controllers/fields/changeSettingDefault',
		'builder/controllers/fields/toggleSetting',
		'builder/controllers/fields/getSettingChildView',
		'builder/controllers/fields/fieldset',
		'builder/controllers/fields/listField',
		'builder/controllers/fields/submitField',
		'builder/controllers/updateDB',
		'builder/controllers/formData',
		'builder/controllers/previewLink',
		'builder/controllers/app/menuButtons',
		'builder/controllers/app/trackChanges',
		'builder/controllers/undoChanges',
		'builder/controllers/app/publishResponse',
		'builder/controllers/app/changeDomain',
		'builder/controllers/fields/editActive',
		'builder/controllers/app/pushstate'

	],
	function(
		Hotkeys,
		FieldTypes,
		FieldTypeDrag,
		FieldStagingDrag,
		SavedFields,
		StagedFieldsData,
		StagedFieldsSortable,
		Drawer,
		DrawerData,
		DrawerFilterFieldTypes,
		AppDomain,
		AppData,
		MainContentFieldsSortable,
		FieldData,
		FieldClick,
		DrawerToggleSettingGroup,
		FieldsChangeSettingDefault,
		FieldToggle,
		DrawerFieldTypeSettingChildView,
		Fieldset,
		FieldList,
		FieldSubmit,
		UpdateDB,
		FormData,
		PreviewLink,
		AppMenuButtons,
		AppTrackChanges,
		UndoChanges,
		AppPublishResponse,
		AppChangeDomain,
		EditActive,
		Pushstate
	) {
		var controller = Marionette.Object.extend( {
			initialize: function() {
				var hotkeys = new Hotkeys();
				var fieldset = new Fieldset();
				var fieldTypes = new FieldTypes();
				var fieldTypeDrag = new FieldTypeDrag();
				var fieldStagingDrag = new FieldStagingDrag();
				var savedFields = new SavedFields();
				var stagedFieldsData = new StagedFieldsData();
				var stagedFieldsSortable = new StagedFieldsSortable();
				var drawer = new Drawer();
				var drawerData = new DrawerData();
				var drawerFilterFieldTypes = new DrawerFilterFieldTypes();
				var appDomain = new AppDomain();
				var appData = new AppData();
				var mainContentFieldsSortable = new MainContentFieldsSortable();
				var fieldClick = new FieldClick();
				var drawerToggleSettingGroup = new DrawerToggleSettingGroup();
				var fieldsChangeSettingDefault = new FieldsChangeSettingDefault();
				var fieldToggle = new FieldToggle();
				var drawerFieldTypeSettingChildView = new DrawerFieldTypeSettingChildView();
				var fieldList = new FieldList();
				var fieldSubmit = new FieldSubmit();
				var fieldData = new FieldData();
				var updateDB = new UpdateDB();
				var formData = new FormData();
				var previewLink = new PreviewLink();
				var appMenuButtons = new AppMenuButtons();
				var appTrackChanges = new AppTrackChanges();
				var undoChanges = new UndoChanges();
				var appPublishResponse = new AppPublishResponse();
				var appChangeDomain = new AppChangeDomain();
				var editActive = new EditActive();
				// var pushstate = new Pushstate();
			}
		});

		return controller;
} );
