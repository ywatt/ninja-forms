define( ['builder/models/fieldTypeSectionCollection'], function( fieldTypeSectionCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.collection = nfRadio.channel( 'data' ).request( 'get:fieldTypes' );
			this.listenTo( nfRadio.channel( 'drawer' ), 'change:fieldTypeFilter', this.filterFieldTypes );
		},

		filterFieldTypes: function( search ) {
			if ( '' != jQuery.trim( search ) ) {
        		var filtered = [];
        		_.each( this.filterCollection( search ), function( model ) {
        			filtered.push( model.get( 'id' ) );
        		} );

        		var filteredSectionCollection = new fieldTypeSectionCollection( [
				{ 
					id: 'filtered',
					nicename: 'Filtered Fields',
					fieldTypes: filtered
				}
				] );

        		nfRadio.channel( 'drawer' ).trigger( 'filter:fieldTypes', filteredSectionCollection );
        	} else {
        		nfRadio.channel( 'drawer' ).trigger( 'remove:fieldTypeFilter' );
        	}
        },

        filterCollection: function( search ) {
        	search = search.toLowerCase();
			var filtered = this.collection.filter( function( model ) {
				var found = false;
				
				if ( model.get( 'id' ).toLowerCase().indexOf( search ) != -1 ) {
					found = true;
				} else if ( model.get( 'nicename' ).toLowerCase().indexOf( search ) != -1 ) {
					found = true;
				}

				if ( model.get( 'alias' ) ) {
					_.each( model.get( 'alias' ), function( alias ) {
						if ( alias.toLowerCase().indexOf( search ) != -1 ) {
							found = true;
						}
					} );
				}

				return found;
			} );
			return filtered;
        }
	});

	return controller;
} );