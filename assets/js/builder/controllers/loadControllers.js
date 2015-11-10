/**
 * Loads all of our controllers.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define(
	[
		/*
		 * Application controllers
		 */
		'builder/controllers/app/drawer',
		'builder/controllers/app/drawerConfig',		
		'builder/controllers/app/domainConfig',
		'builder/controllers/app/data',		
		'builder/controllers/app/drawerToggleSettingGroup',
		'builder/controllers/app/updateDB',
		'builder/controllers/app/formData',
		'builder/controllers/app/previewLink',
		'builder/controllers/app/menuButtons',
		'builder/controllers/app/trackChanges',
		'builder/controllers/app/publishResponse',
		'builder/controllers/app/changeDomain',
		'builder/controllers/app/pushstate',
		'builder/controllers/app/hotkeys',
		/*
		 * Fields domain controllers
		 */
		'builder/controllers/fields/types',
		'builder/controllers/fields/fieldTypeDrag',
		'builder/controllers/fields/stagingDrag',
		'builder/controllers/fields/savedFieldsSection',
		'builder/controllers/fields/staging',
		'builder/controllers/fields/stagingSortable',
		'builder/controllers/fields/filterTypes',
		'builder/controllers/fields/sortable',
		'builder/controllers/fields/data',
		'builder/controllers/fields/itemControls',
		'builder/controllers/fields/changeSettingDefault',
		'builder/controllers/fields/toggleSetting',
		'builder/controllers/fields/getSettingChildView',
		'builder/controllers/fields/fieldset',
		'builder/controllers/fields/listField',
		'builder/controllers/fields/submitField',
		'builder/controllers/fields/editActive',		
		/*
		 * TODO: Actions domain controllers
		 */
		
		/*
		 * TODO: Settings domain controllers
		 */
	],
	function(
		/*
		 * Application controllers
		 */
		Drawer,
		DrawerConfig,
		DomainConfig,
		AppData,
		DrawerToggleSettingGroup,
		UpdateDB,
		FormData,
		PreviewLink,
		AppMenuButtons,
		AppTrackChanges,
		AppPublishResponse,
		AppChangeDomain,
		Pushstate,
		Hotkeys,
		/*
		 * Fields domain controllers
		 */
		FieldTypes,
		FieldTypeDrag,
		FieldStagingDrag,
		SavedFields,
		StagedFieldsData,
		StagedFieldsSortable,
		DrawerFilterFieldTypes,
		MainContentFieldsSortable,
		FieldData,
		FieldItemControls,
		FieldsChangeSettingDefault,
		FieldToggle,
		DrawerFieldTypeSettingChildView,
		Fieldset,
		FieldList,
		FieldSubmit,
		EditActive
		/*
		 * TODO: Actions domain controllers
		 */
		
		/*
		 * TODO: Settings domain controllers
		 */
		
	) {
		var controller = Marionette.Object.extend( {
			initialize: function() {
				/*
				 * Application controllers
				 */
				
				/*
				 * Fields domain controllers
				 */
				
				/*
				 * TODO: Actions domain controllers
				 */
				
				/*
				 * TODO: Settings domain controllers
				 */
				var hotkeys = new Hotkeys();
				var fieldset = new Fieldset();
				var fieldTypes = new FieldTypes();
				var fieldTypeDrag = new FieldTypeDrag();
				var fieldStagingDrag = new FieldStagingDrag();
				var savedFields = new SavedFields();
				var stagedFieldsData = new StagedFieldsData();
				var stagedFieldsSortable = new StagedFieldsSortable();
				var drawer = new Drawer();
				var drawerConfig = new DrawerConfig();
				var drawerFilterFieldTypes = new DrawerFilterFieldTypes();
				var domainConfig = new DomainConfig();
				var appData = new AppData();
				var mainContentFieldsSortable = new MainContentFieldsSortable();
				var fieldItemControls = new FieldItemControls();
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
				var appPublishResponse = new AppPublishResponse();
				var appChangeDomain = new AppChangeDomain();
				var editActive = new EditActive();
				// var pushstate = new Pushstate();
			}
		});

		return controller;
} );
