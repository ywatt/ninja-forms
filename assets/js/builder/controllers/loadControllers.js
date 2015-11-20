/**
 * Loads all of our controllers using Require JS.
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
		'builder/controllers/app/undoChanges',
		'builder/controllers/app/publishResponse',
		'builder/controllers/app/changeDomain',
		'builder/controllers/app/pushstate',
		'builder/controllers/app/hotkeys',
		'builder/controllers/app/cleanState',
		'builder/controllers/app/coreUndo',
		'builder/controllers/app/cloneModelDeep',
		'builder/controllers/app/getSettingChildView',
		'builder/controllers/app/changeSettingDefault',
		'builder/controllers/app/fieldset',
		'builder/controllers/app/toggleSetting',
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
		'builder/controllers/fields/listField',
		'builder/controllers/fields/editActive',
		'builder/controllers/fields/fieldSettings',

		/*
		 * TODO: Actions domain controllers
		 */
		'builder/controllers/actions/types',
		'builder/controllers/actions/data',
		'builder/controllers/actions/actionSettings',
		'builder/controllers/actions/itemControls',
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
		AppUndoChanges,
		AppPublishResponse,
		AppChangeDomain,
		Pushstate,
		Hotkeys,
		CleanState,
		CoreUndo,
		CloneModelDeep,
		DrawerSettingChildView,
		ChangeSettingDefault,
		Fieldset,
		ToggleSetting,
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
		ListField,
		EditActive,
		FieldSettings,
		/*
		 * TODO: Actions domain controllers
		 */
		ActionTypes,
		ActionData,
		ActionSettings,
		ActionItemControls
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
				new AppUndoChanges();
				new AppPublishResponse();
				new AppChangeDomain();
				new EditActive();
				new CleanState();
				new CoreUndo();
				new CloneModelDeep();
				// new Pushstate();
				/*
				 * Fields domain controllers
				 * 
				 * Field-specific controllers should be loaded before our field type controller.
				 * This ensures that any 'init' hooks are properly registered.
				 */
				new Fieldset();
				new ListField();

				new FieldTypes();
				new FieldTypeDrag();
				new FieldStagingDrag();
				new SavedFields();
				new StagedFieldsData();
				new StagedFieldsSortable();
				new DrawerFilterFieldTypes();
				new MainContentFieldsSortable();
				new FieldItemControls();
				new ChangeSettingDefault();
				new ToggleSetting();
				new DrawerSettingChildView();
				new FieldSettings();
				/*
				 * TODO: Actions domain controllers
				 */
				new ActionTypes();
				new ActionData();
				new ActionSettings();
				new ActionItemControls();
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
