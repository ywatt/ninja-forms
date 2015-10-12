define(
	[
		'builder/controllers/fieldTypes',
		'builder/controllers/fieldTypeSections',
		'builder/controllers/savedFields',
		'builder/controllers/stagedFields',
		'builder/controllers/drawer',
		'builder/controllers/drawerFilterFieldTypes'
	],
	function(
		FieldTypes,
		FieldTypeSections,
		SavedFields,
		StagedFields,
		Drawer,
		DrawerFilterFieldTypes
	) {
		var controller = Marionette.Object.extend( {
			initialize: function() {
				var fieldTypes = new FieldTypes();
				var fieldTypeSections = new FieldTypeSections();
				var savedFields = new SavedFields();
				var stagedFields = new StagedFields();
				var drawer = new Drawer();
				var drawerFilterFieldTypes = new DrawerFilterFieldTypes();
			}
		});

		return controller;
} );