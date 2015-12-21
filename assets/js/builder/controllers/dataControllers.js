/**
 * Loads our data controllers using Require JS.
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
		'controllers/app/formData',
		'controllers/app/mergeTags',
		'controllers/app/itemSettingFill',
		/*
		 * Fields domain controllers
		 */
		'controllers/fields/data',
		/*
		 * TODO: Actions domain controllers
		 */
		'controllers/actions/data',
		/*
		 * TODO: Settings domain controllers
		 */
		'controllers/settings/data',
	],
	function(
		/*
		 * Application controllers
		 */
		FormData,
		MergeTags,
		ItemSettingFill,
		/*
		 * Fields domain controllers
		 */
		FieldData,
		/*
		 * Actions domain controllers
		 */
		ActionData,
		/*
		 * Settings domain controllers
		 */
		SettingData		
	) {
		var controller = Marionette.Object.extend( {
			initialize: function() {
				/*
				 * Data controllers need to be set after every other controller has been setup, even if they aren't domain-specific.
				 */
				new FieldData();
				new ActionData();
				new SettingData();
				new FormData();
				new MergeTags();
				new ItemSettingFill();				
			}
		});

		return controller;
} );
