/**
 * Loads our app controllers using Require JS.
 * 
 * @package Ninja Forms builder
 * @subpackage App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define(
	[
		/*
		 * Application controllers
		 */
		'controllers/app/drawer',
		'controllers/app/drawerConfig',		
		'controllers/app/domainConfig',
		'controllers/app/data',		
		'controllers/app/drawerToggleSettingGroup',
		'controllers/app/updateDB',
		'controllers/app/previewLink',
		'controllers/app/menuButtons',
		'controllers/app/trackChanges',
		'controllers/app/undoChanges',
		'controllers/app/publishResponse',
		'controllers/app/changeDomain',
		'controllers/app/hotkeys',
		'controllers/app/cleanState',
		'controllers/app/coreUndo',
		'controllers/app/cloneModelDeep',
		'controllers/app/getSettingChildView',
		'controllers/app/changeSettingDefault',
		'controllers/app/fieldset',
		'controllers/app/toggleSetting',
		'controllers/app/itemControls'
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
		PreviewLink,
		AppMenuButtons,
		AppTrackChanges,
		AppUndoChanges,
		AppPublishResponse,
		AppChangeDomain,
		Hotkeys,
		CleanState,
		CoreUndo,
		CloneModelDeep,
		DrawerSettingChildView,
		ChangeSettingDefault,
		Fieldset,
		ToggleSetting,
		ItemControls
		
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
				new CleanState();
				new CoreUndo();
				new CloneModelDeep();
				new DrawerSettingChildView();
				new ChangeSettingDefault();
				new Fieldset();
				new ToggleSetting();
				new ItemControls();
				new AppData();

			}
		});

		return controller;
} );
