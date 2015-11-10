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
		toggleFieldSetting,
		DrawerFieldTypeSettingChildView,
		Fieldset,
		ListField,
		SubmitField,
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
				new Hotkeys();
				new Drawer();
				new DrawerConfig();
				new DomainConfig();
				new DrawerToggleSettingGroup();
				new UpdateDB();
				new PreviewLink();
				new AppMenuButtons();
				new AppTrackChanges();
				new AppPublishResponse();
				new AppChangeDomain();
				new EditActive();
				// new Pushstate();
				/*
				 * Fields domain controllers
				 * 
				 * Field-specific controllers should be loaded before our field type controller.
				 * This ensures that any 'init' hooks are properly registered.
				 */
				new Fieldset();
				new ListField();
				new SubmitField();

				new FieldTypes();
				new FieldTypeDrag();
				new FieldStagingDrag();
				new SavedFields();
				new StagedFieldsData();
				new StagedFieldsSortable();
				new DrawerFilterFieldTypes();
				new MainContentFieldsSortable();
				new FieldItemControls();
				new FieldsChangeSettingDefault();
				new toggleFieldSetting();
				new DrawerFieldTypeSettingChildView();

				/*
				 * TODO: Actions domain controllers
				 */
				
				/*
				 * TODO: Settings domain controllers
				 */
				
				/*
				 * Data controllers need to be set after every other controller has been setup, even if they aren't domain-specific.
				 * We load them from domains to app specificity.
				 */
				new FieldData();
				new FormData();
				new AppData();
			}
		});

		return controller;
} );
