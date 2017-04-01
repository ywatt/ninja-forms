/**
 * @package Ninja Forms builder
 * @subpackage Merge Tag Box
 * @copyright (c) 2017 WP Ninjas
 * @since 3.1
 */
define( [
    'models/app/mergeTagModel',
    'models/app/mergeTagLookupCollection',
    'views/app/drawer/mergeTag',
    'views/app/drawer/mergeTagList',
    'views/app/drawer/mergeTagGroup',
    'views/app/drawer/mergeTagGroupList',
    'views/app/drawer/mergeTagFilter',
    'views/app/drawer/mergeTagBox'
], function(
    MergeTagModel,
    MergeTagLookupCollection,
    MergeTagView,
    MergeTagListView,
    MergeTagGroupView,
    MergeTagGroupListView,
    MergeTagFilterView,
    MergeTagBoxLayout
) {
    var controller = Marionette.Object.extend( {

        caret: 0, // Track the caret position of the current setting's input.
        old: '', // THe old merge tag that will be replaced.

        initialize: function(){
            this.listenTo( nfRadio.channel( 'app' ), 'after:appStart', this.afterAppStart );
            this.listenTo( nfRadio.channel( 'app' ), 'before:renderSetting', this.beforeRenderSetting );
            this.listenTo( nfRadio.channel( 'drawer' ), 'before:close', this.beforeDrawerClose );

            nfRadio.channel( 'mergeTags' ).reply( 'insert:tag', this.insertTag.bind( this ) );
        },

        afterAppStart: function() {
            var mergeTagCollection = nfRadio.channel( 'mergeTags' ).request( 'get:collection' );
            var mergeTags = [];
            mergeTagCollection.each( function( section ){
                section.get( 'tags' ).each( function( tag ){
                    mergeTags.push({
                        label: tag.get( 'label' ),
                        tag:   tag.get( 'tag' ),
                        section: section.get( 'id' )
                    });
                });
            });
            var layout = new MergeTagBoxLayout();
            layout.render();
            var tagCollection = new MergeTagLookupCollection( mergeTags );
            var mergeTagListView = new MergeTagListView({
                collection: tagCollection
            });
            var mergeTagGroupListView = new MergeTagGroupListView({
                collection: mergeTagCollection
            });

            mergeTagListView.filter = function( child, index, collection ){
                return 'fields' == child.get( 'section' );
            }

            nfRadio.channel( 'merge-tags' ).reply( 'update:taglist', function( section ){
                mergeTagListView.filter = function( child, index, collection ){
                    return section == child.get( 'section' );
                }
                mergeTagListView.render();
            });

            nfRadio.channel( 'merge-tags' ).reply( 'filtersearch', function( term ){
                mergeTagListView.filter = function( child, index, collection ){
                    return child.get( 'label' ).toLowerCase().indexOf( term.toLowerCase() ) >= 0
                        || child.get( 'tag' ).toLowerCase().indexOf( term.toLowerCase() ) >= 0;
                }
                mergeTagListView.render();
            });


            layout.getRegion('tags').show(mergeTagListView);
            layout.getRegion('sections').show(mergeTagGroupListView);
            layout.getRegion('filter').show(new MergeTagFilterView);
        },

        beforeRenderSetting: function( settingModel, dataModel ){
            if( 'undefined' == typeof settingModel.get( 'use_merge_tags' ) ) return;
            if( ! settingModel.get( 'use_merge_tags' ) ) return;
            var name = settingModel.get( 'name' );
            this.listenTo( nfRadio.channel( 'setting-' + name ), 'render:setting', this.renderSetting );
        },

        renderSetting: function( settingModel, dataModel, view ){
            // On input focus, move the Merge Tag Box into position.
            jQuery( view.el ).find( 'input' ).on( 'focus', function(){
                var offset = jQuery( view.el ).find( 'input' ).closest( '.nf-setting' ).outerHeight();
                jQuery( view.el ).find( 'input' ).closest( '.nf-setting' ).append( jQuery( '#merge-tags-box' ) );
                jQuery( '#merge-tags-box' ).css( 'top', offset );
            });

            // On input keyup, maybe show Merge Tag Box.
            var that = this;
            jQuery( view.el ).find( 'input' ).on( 'keyup', function( e ){
                var $this = jQuery( this );

                // Store the current caret position.
                that.caret = $this.caret();
                console.log( that.caret );

                // Find merge tags.
                var mergetags = $this.val().match(new RegExp(/{([a-z0-9]|:|_|})*/g));

                // Filter out closed merge tags.
                mergetags = _.filter(mergetags, function(mergetag) {
                    return -1 == mergetag.indexOf( '}' ); // Filter out "closed" merge tags.
                });

                // If an open merge tag is found, show the Merge Tag Box, else hide.
                if( 0 !== mergetags.length ) {
                    that.old = mergetags[0];
                    jQuery('#merge-tags-box').show();
                    jQuery(view.el).find('input').closest('.nf-setting').addClass('merge-tag-focus');
                } else {
                    jQuery( '#merge-tags-box' ).css( 'display', 'none' );
                    jQuery( view.el ).find( 'input' ).closest( '.nf-setting' ).removeClass( 'merge-tag-focus' );
                }
            });
        },

        beforeDrawerClose: function(){
            jQuery( '#merge-tags-box' ).css( 'display', 'none' );
            jQuery( 'body' ).append( jQuery( '#merge-tags-box' ) );
        },

        insertTag: function( tag ) {

            var $input = jQuery( '#merge-tags-box' ).closest( '.nf-setting' ).find( '.setting' );

            var str = $input.val();
            var find = this.old;
            var replace = tag;
            var caretPos = this.caret;

            var patt = /{([a-z0-9]|:|_|})*/g;

            // Loop through matches to find insert/replace index range.
            // Reference: http://codepen.io/kjohnson/pen/36c3a782644dfff40fe3c1f05f8739d9?editors=0012
            while (match = patt.exec(str)) {
                if (find != match[0]) continue; // This isn't the match you are looking for...
                var string = str.slice(0, match.index) + replace + str.slice(patt.lastIndex); // Fancy replace for the specifc match, using the index/position.
                $input.val( string ); // Update input value with parsed string.
                $input.caret(caretPos - find.length + replace.length); // Update Carept Position.
            }

            jQuery( '#merge-tags-box' ).css( 'display', 'none' );
            jQuery( '#merge-tags-box' ).closest( '.nf-setting' ).removeClass( 'merge-tag-focus' );
        },

    } );

    return controller;
} );