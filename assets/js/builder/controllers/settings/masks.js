define([], function() {
    var controller = Marionette.Object.extend( {

        thousandsSeparator: ',',

        decimalPoint: '.',

        initialize: function() {
            // TODO: Allow settings to pass mask options.
            this.thousandsSeparator = nfAdmin.wp_locale.thousands_sep;
            this.decimalPoint = nfAdmin.wp_locale.decimal_point;
            this.listenTo( nfRadio.channel( 'drawer' ), 'opened', this.drawerOpened );
        },

        drawerOpened: function() {

            jQuery( "#product_price" ).autoNumeric({
                aSep: this.thousandsSeparator,
                aDec: this.decimalPoint
            });
        }

    });

    return controller;
});