define([], function() {
    var controller = Marionette.Object.extend({

        initialize: function () {
            this.listenTo( nfRadio.channel( 'date' ), 'render:view', this.initDatepicker );
        },

        initDatepicker: function ( view ) {

            var el = jQuery( view.el ).find( '.nf-element' )[0];
            var dateObject = pikadayResponsive( el, {
                format: view.model.get( 'date_format' ),
                outputFormat: view.model.get( 'date_format' ),
                classes: jQuery( el ).attr( "class" ),
                pikadayOptions: {
                    yearRange:  this.getYearRange( view.model ),
                    minDate: this.getMinDate( view.model ),
                    maxDate: this.getMaxDate( view.model )
                }
            } );
            if ( 1 == view.model.get( 'date_default' ) ) {
               dateObject.setDate( moment() );
            }

            nfRadio.channel( 'pikaday' ).trigger( 'init', dateObject, view.model );
        },

        getYearRange: function( fieldModel ) {
            var yearRange      = 10;
            var yearRangeStart = fieldModel.get( 'year_range_start' );
            var yearRangeEnd   = fieldModel.get( 'year_range_end'   );

            if( yearRangeStart && yearRangeEnd ){
                return [ yearRangeStart, yearRangeEnd ];
            } else if( yearRangeStart ) {
                yearRangeEnd = yearRangeStart + yearRange;
                return [ yearRangeStart, yearRangeEnd ];
            } else if( yearRangeEnd ) {
                yearRangeStart = yearRangeEnd - yearRange;
                return [ yearRangeStart, yearRangeEnd ];
            }

            return yearRange;
        },

        getMinDate: function( fieldModel ) {
            var minDate = null;
            var yearRangeStart = fieldModel.get( 'year_range_start' );

            if( yearRangeStart ) {
                return new Date( yearRangeStart, 0, 1 );
            }

            return minDate;
        },

        getMaxDate: function( fieldModel ) {
            var maxDate = null;
            var yearRangeEnd   = fieldModel.get( 'year_range_end' );

            if( yearRangeEnd ) {
                return new Date( yearRangeEnd, 11, 31 );
            }

            return maxDate;
        }
    });

    return controller;
});
