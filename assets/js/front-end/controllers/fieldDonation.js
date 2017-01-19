define([], function() {
    var controller = Marionette.Object.extend({

        initialize: function () {
            this.listenTo( nfRadio.channel( 'donation' ), 'render:view', this.initDonationformat );
        },

        initDonationformat: function ( view ) {

            jQuery.extend(jQuery.fn.autoNumeric.defaults, {
                aSep: nfi18n.thousands_sep,              
                aDec: nfi18n.decimal_point          
            });
            var el = jQuery( view.el ).find( '.nf-element' )[0];
            jQuery(el).autoNumeric('init');
        }
    });

    return controller;
});