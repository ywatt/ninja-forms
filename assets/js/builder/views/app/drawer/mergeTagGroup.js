/**
 * @package Ninja Forms builder
 * @subpackage App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
    var view = Marionette.ItemView.extend({
        template: '#tmpl-nf-merge-tag-box-section',
        events: {
            "click": "updateTags"
        },

        updateTags: function() {
            nfRadio.channel( 'merge-tags' ).request( 'update:taglist', this.model.get( 'id' ) );
        }
    });

    return view;
} );