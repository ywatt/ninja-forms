define(
	[
		'builder/controllers/hotkeys',
		'builder/controllers/fieldTypes',
		'builder/controllers/fieldTypeSections',
		'builder/controllers/drawerFieldTypeDrag',
		'builder/controllers/drawerStagingDrag',
		'builder/controllers/drawerSavedFields',
		'builder/controllers/drawerStagedFieldsData',
		'builder/controllers/drawerStagedFieldsSortable',
		'builder/controllers/drawer',
		'builder/controllers/drawerData',
		'builder/controllers/drawerFilterFieldTypes',
		'builder/controllers/appDomain',
		'builder/controllers/appData',
		'builder/controllers/mainContentFieldsSortable',
		'builder/controllers/fieldData',
		'builder/controllers/fieldClick',
		'builder/controllers/drawerToggleSettingGroup',
		'builder/controllers/changeFieldSettingDefault',
		'builder/controllers/fieldToggle',
		'builder/controllers/drawerFieldTypeSettingChildView',
		'builder/controllers/fieldset',
		'builder/controllers/fieldListOptionSortable',
		'builder/controllers/fieldList',
		'builder/controllers/updateFieldSetting'

	],
	function(
		Hotkeys,
		FieldTypes,
		FieldTypeSections,
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
		ChangeFieldSettingDefault,
		FieldToggle,
		DrawerFieldTypeSettingChildView,
		Fieldset,
		FieldListOptionSortable,
		FieldList,
		UpdateFieldSetting
	) {
		var controller = Marionette.Object.extend( {
			initialize: function() {
				var hotkeys = new Hotkeys();
				var fieldTypes = new FieldTypes();
				var fieldTypeSections = new FieldTypeSections();
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
				var changeFieldSettingDefault = new ChangeFieldSettingDefault();
				var fieldToggle = new FieldToggle();
				var drawerFieldTypeSettingChildView = new DrawerFieldTypeSettingChildView();
				var fieldset = new Fieldset();
				var fieldListOptionSortable = new FieldListOptionSortable();
				var fieldList = new FieldList();
				var fieldData = new FieldData();
				var updateFieldSetting = new UpdateFieldSetting();
			}
		});

		return controller;
} );
