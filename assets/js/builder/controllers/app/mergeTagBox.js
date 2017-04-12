/**
 * @package Ninja Forms builder
 * @subpackage Merge Tag Box
 * @copyright (c) 2017 WP Ninjas
 * @since 3.1
 */

/*
 * TODO: Track drawer scrolling to follow focused setting.
 * TODO: Support RTE Summernote settings.
 * TODO: Add back focus overlay.
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
            
            /* CALCULATIONS */
            this.listenTo( nfRadio.channel( 'setting-calculations-option' ), 'render:setting', this.renderSetting );
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

            if( 0 == jQuery( '#merge-tags-box' ).length ){
                this.afterAppStart();
            }

            // TODO: Maybe move to view events.
            // On input focus, move the Merge Tag Box into position.
            jQuery( view.el ).find( '.setting' ).on( 'focus', function(){

                jQuery( '.merge-tag-focus' ).each(function(index, el){
                    if( this == el ) return;
                    el.removeClass( 'merge-tag-focus' );
                });

                console.log( 'FOCUS' );

                var posY = jQuery( this ).offset().top - jQuery(window).scrollTop();
                var height = jQuery( this ).outerHeight();
                jQuery( '#merge-tags-box' ).css( 'top', posY + height );

                var repeaterRow = jQuery( this ).closest( '.nf-list-options-tbody' );
                if( 0 != repeaterRow.length ){
                    var left = repeaterRow.offset().left - jQuery(window).scrollLeft();
                    jQuery( '#merge-tags-box' ).css( 'left', left );
                } else {
                    var posX = jQuery( this ).closest( '.nf-settings' ).offset().left - jQuery(window).scrollLeft();
                    jQuery( '#merge-tags-box' ).css( 'left', posX );
                    jQuery( '#merge-tags-box' ).css( 'width', jQuery( this ).closest( '.nf-settings' ).width() );
                }

               var dataID = jQuery( this ).data( 'id' );
               if( dataID && 'eq' != dataID ) return;

                nfRadio.channel( 'merge-tags' ).trigger( 'open' );
                // var offset = jQuery( view.el ).find( '.setting' ).parent().outerHeight();
                // jQuery( view.el ).find( '.setting' ).parent().append( jQuery( '#merge-tags-box' ) );
                // jQuery( '#merge-tags-box' ).css( 'top', offset );
            });

            // TODO: Maybe move to view events.
            // On input keyup, maybe show Merge Tag Box.
            var that = this;
            jQuery( view.el ).find( '.setting' ).on( 'keyup', function( e ){
                var $this = jQuery( this );

                var dataID = jQuery( this ).data( 'id' );
                if( dataID && 'eq' != dataID ) return;

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
                    $this.addClass('merge-tag-focus');

                    var value = mergetags[0].replace( '{', '' );
                    nfRadio.channel( 'merge-tags' ).request( 'filtersearch', value );

                    console.log( 'SHOW' );
                } else {
                    jQuery( '#merge-tags-box' ).css( 'display', 'none' );
                    jQuery( '#merge-tags-box' ).removeClass();
                    jQuery( '.merge-tag-focus' ).removeClass( 'merge-tag-focus' );
                    console.log( 'HIDE' );
                }
            });
        },

        // TODO: Maybe move to view class.
        beforeDrawerClose: function(){
            jQuery( '#merge-tags-box' ).css( 'display', 'none' );
            // jQuery( 'body' ).append( jQuery( '#merge-tags-box' ) );
        },

        insertTag: function( tag ) {

            var $input = jQuery( '.merge-tag-focus' );
            if( 1 < $input.length ){ $input = $input.first(); }

            console.log( $input );

            var str = $input.val();
            var find = this.old;
            var replace = tag;
            var caretPos = this.caret;

            console.log( str );
            console.log( this.old );
            console.log( replace );
            console.log( caretPos );

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
            $input.change(); // Trigger a change event after inserting the merge tag so that it saves to the model.
            $input.removeClass( 'merge-tag-focus' );
            console.log( 'REMOVE CLASS' );
        },

    } );

    return controller;
} );