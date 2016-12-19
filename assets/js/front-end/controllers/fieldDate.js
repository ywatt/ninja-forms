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
                    minDate:  new Date( view.model.get( 'date_range_start' ) + ' 00:00:00' ),
                    maxDate: new Date( view.model.get( 'date_range_end' ) + ' 00:00:00' ),
                    i18n: {
                        previousMonth : 'FUCK YOU',
                        nextMonth     : 'Next Month',
                        months        : ['FUCK','YOU','March','April','May','June','July','August','September','October','November','December'],
                        weekdays      : ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
                        weekdaysShort : ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']
                    }
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
        }
    });

    return controller;
});