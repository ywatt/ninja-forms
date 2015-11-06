define( [
	'builder/models/fieldTypeCollection',
	'builder/models/fieldTypeSettingCollection',
	'builder/models/fieldTypeSettingGroupCollection',
	'builder/models/fieldTypeSectionCollection'
	], function(
	fieldTypeCollection,
	fieldTypeSettingCollection,
	fieldTypeSettingGroupCollection,
	fieldTypeSectionCollection
	) {
	var controller = Marionette.Object.extend( {
		initialize: function() {

			this.collection = new fieldTypeCollection();
			this.fieldTypeSections = new fieldTypeSectionCollection( [
				{
					id: 'common',
					nicename: 'Common Fields',
					fieldTypes: []
				},
				{ 
					id: 'userinfo',
					nicename: 'User Information Fields',
					fieldTypes: []
				}
			] );

			var that = this;

			_.each( fieldTypeData, function ( type ) {
				var settingGroups = new fieldTypeSettingGroupCollection();
				_.each( type.settingGroups, function( group ) {
					var groupTmp = {
						label: group.label,
						display: group.display,
						settings: new fieldTypeSettingCollection( group.settings ), 
					}

					settingGroups.add( groupTmp );
				} );

				if ( 'undefined' != typeof that.fieldTypeSections.get( type.section ) ) {
					that.fieldTypeSections.get( type.section ).get( 'fieldTypes' ).push( type.id );
				}
				
				var fieldType = {
					id: type.id,
					nicename: type.nicename,
					alias: type.alias,
					parentType: type.parentType,
					settingGroups: settingGroups
				}

				that.collection.add( fieldType );
			} );
			
			nfRadio.channel( 'data' ).reply( 'get:fieldType', this.getFieldType, this );
			nfRadio.channel( 'data' ).reply( 'get:fieldTypes', this.getFieldTypes, this );
			nfRadio.channel( 'data' ).reply( 'get:fieldTypeSetting', this.getFieldTypeSetting, this );
			nfRadio.channel( 'drawer' ).reply( 'get:fieldTypeSections', this.getFieldTypeSections, this );
		
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:fieldType', this.addStagedField );
		},

		getFieldType: function( id ) {
        	return this.collection.get( id );
        },

		getFieldTypes: function( id ) {
        	return this.collection;
        },

        getFieldTypeSetting: function( type, search ) {
        	var setting = false;
			_.find( this.collection.get( type ).get('settingGroups' ).models, function( group ) {
				setting = group.get( 'settings' ).findWhere( { name: search } );
				if ( setting ) {
					return true;
				}
			} );
			return setting;
        },

        addStagedField: function( el ) {
        	var type = jQuery( el.target ).data( 'id' );
        	nfRadio.channel( 'fields' ).request( 'add:stagedField', type );
        },

        getFieldTypeSections: function() {
            return this.fieldTypeSections;
        }
	});

	return controller;
} );