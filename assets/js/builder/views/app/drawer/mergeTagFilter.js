/**
 * @package Ninja Forms builder
 * @subpackage App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
    var view = Marionette.ItemView.extend({
        template: '#tmpl-nf-merge-tag-box-filter',
        events: {
            "keyup input": "updateFilter",
        },
        updateFilter: function( e ) {
            var value = this.$el.find( 'input' ).val();
            nfRadio.channel( 'merge-tags' ).request( 'filtersearch', value );
        }
    });

    return view;
} );