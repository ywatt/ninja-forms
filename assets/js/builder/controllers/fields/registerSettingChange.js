/**
 * Register a change when a user updates a setting.
 * 
 * @package Ninja Forms builder
 * @subpackage Main App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/models/app/changeCollection'], function( changeCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			/*
			 * Set an array of field model attributes to ignore.
			 * This list will be filtered just before we ignore anything.
			 */ 
			this.ignoreAttributes = [
				'editActive',
				'order'
			];

			// Listen for the field setting update event.
			this.listenTo( nfRadio.channel( 'fields' ), 'update:setting', this.changeSetting );
		},


		/**
		 * When we hear an updated field setting event, check it's changed attribute against our ignore list.
		 * If it's not found, register the change.
		 * 
		 * @since  3.0
		 * @param  backbone.model 	model 	updated field model
		 * @return void
		 */
		changeSetting: function( model ) {
			for( var attr in model.changedAttributes() ) {
				var changedAttr = attr;
				var after = model.changedAttributes()[ attr ];
			}

			var ignoreAttributes = nfRadio.channel( 'undo-' + model.get( 'type' ) ).request( 'ignore:attributes', this.ignoreAttributes ) || this.ignoreAttributes;

			if ( -1 != this.ignoreAttributes.indexOf( changedAttr ) ) {
				return false;
			}

			if ( 'undefined' == typeof model._previousAttributes[ changedAttr ] ) {
				var before = null;
			} else {
				var before = model._previousAttributes[ changedAttr ];
			}

			var objModels = [
				{
					model: model,
					attr: changedAttr,
					before: before,
					after: after
				}
			];

			var settingModel = nfRadio.channel( 'fields' ).request( 'get:settingModel', changedAttr );
			// var label = 'Field - ' + model.get( 'label' ) + ' - ' + settingModel.get( 'label' ) + ' changed from ' + before + ' to ' + after;

			nfRadio.channel( 'changes' ).request( 'register:change', 'changeSetting', objModels, label );
		}

	});

	return controller;
} );
