/**
 * Loads our field controllers using Require JS.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define(
	[
		/*
		 * Fields domain controllers
		 */
		'controllers/fields/types',
		'controllers/fields/fieldTypeDrag',
		'controllers/fields/stagingDrag',
		'controllers/fields/savedFieldsSection',
		'controllers/fields/staging',
		'controllers/fields/stagingSortable',
		'controllers/fields/filterTypes',
		'controllers/fields/sortable',
		'controllers/fields/optionRepeater',
		'controllers/fields/editActive',
		'controllers/fields/fieldSettings',
		'controllers/fields/fieldQuantity',
	],
	function(
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
		OptionRepeater,
		FieldsEditActive,
		FieldSettings,
		FieldQuantity	
	) {
		var controller = Marionette.Object.extend( {
			initialize: function() {
				/*
				 * Fields domain controllers
				 * 
				 * Field-specific controllers should be loaded before our field type controller.
				 * This ensures that any 'init' hooks are properly registered.
				 */
				new OptionRepeater();
				new FieldTypes();
				new FieldTypeDrag();
				new FieldStagingDrag();
				new SavedFields();
				new StagedFieldsData();
				new StagedFieldsSortable();
				new DrawerFilterFieldTypes();
				new MainContentFieldsSortable();
				new FieldsEditActive();
				new FieldSettings();
				new FieldQuantity();
			}
		});

		return controller;
} );
