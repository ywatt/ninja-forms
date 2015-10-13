define(
	[
		'builder/controllers/fieldTypes',
		'builder/controllers/fieldTypeSections',
		'builder/controllers/drawerSavedFields',
		'builder/controllers/drawerStagedFields',
		'builder/controllers/drawer',
		'builder/controllers/drawerFilterFieldTypes',
		'builder/controllers/appMenu'
	],
	function(
		FieldTypes,
		FieldTypeSections,
		SavedFields,
		StagedFields,
		Drawer,
		DrawerFilterFieldTypes,
		AppMenu
	) {
		var controller = Marionette.Object.extend( {
			initialize: function() {
				var fieldTypes = new FieldTypes();
				var fieldTypeSections = new FieldTypeSections();
				var savedFields = new SavedFields();
				var stagedFields = new StagedFields();
				var drawer = new Drawer();
				var drawerFilterFieldTypes = new DrawerFilterFieldTypes();
				var appMenu = new AppMenu();
			}
		});

		return controller;
} );