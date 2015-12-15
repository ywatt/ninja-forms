/**
 * Config file for our merge tags.
 *
 * this.collection represents all of our registered merge tags.
 * 
 * @package Ninja Forms builder
 * @subpackage Main App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [
	'models/app/mergeTagCollection'
	], function(
	mergeTagCollection
	) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.tagSectionCollection = new mergeTagCollection();
			var that = this;
			_.each( mergeTags, function( tagSection ) {
				if ( tagSection.tags ) {
					var tags = new mergeTagCollection( tagSection.tags );
				} else {
					var tags = '';
				}

				that.tagSectionCollection.add( {
					id: tagSection.id,
					label: tagSection.label,
					tags: tags
				} );
			} );

			var tags = new mergeTagCollection();

			var fieldCollection = nfRadio.channel( 'fields' ).request( 'get:collection' );
			_.each( fieldCollection.models, function( field ) {
				tags.add( {
					id: field.get( 'id' ),
					label: field.get( 'label' ),
					tag: '{field:' + field.get( 'id' ) + '}'
				} );
			} );

			this.tagSectionCollection.get( 'fields' ).set( 'tags', tags );

			this.currentElement = {};
			this.open = false;

			this.listenTo( nfRadio.channel( 'mergeTags' ), 'click:mergeTag', this.clickMergeTag );
			/*
			 * TODO: Hotkey support for adding tags.
			 *
			
			this.listenTo( nfRadio.channel( 'hotkeys' ), 'open:mergeTags', this.openMergeTags );
			this.listenTo( nfRadio.channel( 'hotkeys' ), 'up:mergeTags', this.upMergeTags );
			this.listenTo( nfRadio.channel( 'hotkeys' ), 'down:mergeTags', this.downMergeTags );
			this.listenTo( nfRadio.channel( 'hotkeys' ), 'return:mergeTags', this.returnMergeTags );
			*/
			nfRadio.channel( 'mergeTags' ).reply( 'update:currentElement', this.updateCurrentElement, this );

			// Listen for requests for our mergeTag collection.
			nfRadio.channel( 'mergeTags' ).reply( 'get:mergeTags', this.getMergeTags, this );

			/*
			 * TODO: Hotkey support for adding tags.
			 *
			
			nfRadio.channel( 'mergeTags' ).reply( 'update:open', this.updateOpen, this );
			*/
		},

		clickMergeTag: function( e, tagModel ) {
			var currentValue = jQuery( this.currentElement ).val();
			var currentPos = jQuery( this.currentElement ).caret();
			var newPos = currentPos + tagModel.get( 'tag' ).length;
			currentValue = currentValue.substr( 0, currentPos ) + tagModel.get( 'tag' ) + currentValue.substr( currentPos );
			jQuery( this.currentElement ).val( currentValue ).caret( newPos ).trigger( 'change' );
		},

		openMergeTags: function( e ) {
			if ( 'TEXTAREA' == jQuery( e.target )[0].tagName || 'INPUT' == jQuery( e.target )[0].tagName ) {
				jQuery( e.target ).parent().find( '.merge-tags' ).click();
			}
		},

		returnMergeTags: function( e ) {
			if ( this.open ) {
				e.preventDefault();
				var currentModel = this.fields.where( { 'active': true } )[0];
				if ( currentModel ) {
					this.clickMergeTag( e, currentModel );
				}
			}
		},

		upMergeTags: function( e ) {
			if ( this.open ) {
				e.preventDefault();
				this.changeActiveTag( 'up' );
			}
		},

		downMergeTags: function( e ) {
			if ( this.open ) {
				e.preventDefault();
				this.changeActiveTag( 'down' );
			}
		},

		changeActiveTag: function( dir ) {
			if ( 'down' == dir ) {
				var inc = 1;
			} else {
				var inc = -1
			}
			// First, check to see if a field is currently active.
			if( 0 < this.fields.where( { 'active': true } ).length ) {
				var currentModel = this.fields.where( { 'active': true } )[0];
				var currentIndex = this.fields.indexOf( currentModel );
				currentModel.set( 'active', false );

				var nextModel = this.fields.models[ currentIndex + inc ];
				if ( nextModel ) {
					nextModel.set( 'active', true );
				} else {

				}
				
			} else if ( 0 < this.fields.where( { 'active': true } ) ) { // There aren't any active fields. Check for active system tags.
				console.log( 'system' );
			} else if ( 0 < this.userInfo.where( { 'active': true } ) ) { // No active user info LIs.
				console.log( 'userinfo' );
			} else { // No active LIs. We haven't made any active yet, or we've gotten to the bottom of the list.
				// Make sure that we have fields
				if ( 0 < this.fields.models.length ) {
					// Set our first field to active.
					this.fields.models[0].set( 'active', true );
				} else {
					// Set our first system model to active.
					this.system.models[0].set( 'active', true );
				}
			}
		},

		updateCurrentElement: function( element ) {
			this.currentElement = element;
		},

		getMergeTags: function() {
			return this.tagSectionCollection;
		},

		updateOpen: function( open ) {
			this.open = open;
			_.each( this.tagSectionCollection.get( 'fields' ).models, function( model ) {
				model.set( 'active', false );
			} );
		}

	});

	return controller;
} );