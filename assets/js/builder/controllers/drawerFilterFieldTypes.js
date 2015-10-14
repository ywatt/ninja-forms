define( ['builder/models/fieldTypeSectionCollection'], function( fieldTypeSectionCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.collection = nfRadio.channel( 'data' ).request( 'get:fieldTypes' );
			this.listenTo( nfRadio.channel( 'drawer' ), 'change:filter', this.filterFieldTypes );
			this.listenTo( nfRadio.channel( 'drawer' ), 'open:drawer', this.focusFilter );
		},

		filterFieldTypes: function( search, e ) {
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
        		if ( e.addField ) {
        			if ( 0 < filtered.length ) {
        				nfRadio.channel( 'drawer' ).request( 'add:stagedField', filtered[0] );
        				nfRadio.channel( 'drawer' ).request( 'clear:filter' );
        			}
        		}
        	} else {
        		nfRadio.channel( 'drawer' ).trigger( 'clear:filter' );
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

				// If our search begins with a hash, search tags.
				if ( model.get( 'tags' ) && 0 == search.indexOf( '#' ) ) {
					_.each( model.get( 'tags' ), function( tag ) {
						if ( search.replace( '#', '' ).length > 1 ) {
							if ( tag.toLowerCase().indexOf( search.replace( '#', '' ) ) != -1 ) {
								found = true;
							}							
						}
					} );
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
        },

        focusFilter: function() {
        	var filterEl = nfRadio.channel( 'drawer' ).request( 'get:filterEl' );
        	jQuery( filterEl ).focus();
        }
	});

	return controller;
} );