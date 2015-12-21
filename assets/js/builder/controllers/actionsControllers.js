/**
 * Loads our action controllers using Require JS.
 * 
 * @package Ninja Forms builder
 * @subpackage Actions
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define(
	[
		/*
		 * Actions domain controllers
		 */
		'controllers/actions/types',
		'controllers/actions/actionSettings',
		'controllers/actions/editActive',
		'controllers/actions/addActionTypes',
		'controllers/actions/typeDrag',
		'controllers/actions/droppable',
		'controllers/actions/filterTypes',
	],
	function(
		/*
		 * Actions domain controllers
		 */
		ActionTypes,
		ActionSettings,
		ActionEditActive,
		ActionAddTypes,
		ActionTypeDrag,
		ActionDroppable,
		ActionFilterTypes
	) {
		var controller = Marionette.Object.extend( {
			initialize: function() {
				/*
				 * Actions domain controllers
				 */
				new ActionTypes();
				new ActionSettings();
				new ActionEditActive();
				new ActionAddTypes();
				new ActionTypeDrag();
				new ActionDroppable();
				new ActionFilterTypes();
			}
		});

		return controller;
} );