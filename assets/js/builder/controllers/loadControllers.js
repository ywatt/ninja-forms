define(
	[
		'builder/controllers/fieldTypes',
		'builder/controllers/fieldTypeSections',
		'builder/controllers/drawerFieldTypeDrag',
		'builder/controllers/drawerSavedFields',
		'builder/controllers/drawerStagedFields',
		'builder/controllers/drawer',
		'builder/controllers/drawerData',
		'builder/controllers/drawerFilterFieldTypes',
		'builder/controllers/appDomain',
		'builder/controllers/appData',
		'builder/controllers/mainContentFields',
		'builder/controllers/fieldData'
	],
	function(
		FieldTypes,
		FieldTypeSections,
		FieldTypeDrag,
		SavedFields,
		StagedFields,
		Drawer,
		DrawerData,
		DrawerFilterFieldTypes,
		AppDomain,
		AppData,
		MainContentFields,
		FieldData
	) {
		var controller = Marionette.Object.extend( {
			initialize: function() {
				
				var fieldTypes = new FieldTypes();
				var fieldTypeSections = new FieldTypeSections();
				var fieldTypeDrag = new FieldTypeDrag();
				var savedFields = new SavedFields();
				var stagedFields = new StagedFields();
				var drawer = new Drawer();
				var drawerData = new DrawerData();
				var drawerFilterFieldTypes = new DrawerFilterFieldTypes();
				var appDomain = new AppDomain();
				var appData = new AppData();
				var mainContentFields = new MainContentFields();
				var fieldData = new FieldData();
			}
		});

		return controller;
} );
