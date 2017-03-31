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

        initialize: function(){
            this.listenTo( nfRadio.channel( 'app' ), 'after:appStart', this.afterAppStart );
            this.listenTo( nfRadio.channel( 'app' ), 'before:renderSetting', this.beforeRenderSetting );
            this.listenTo( nfRadio.channel( 'drawer' ), 'before:close', this.beforeDrawerClose );
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
            jQuery( view.el ).find( 'input' ).on( 'focus', function(){
                var offset = jQuery( view.el ).find( 'input' ).closest( '.nf-setting' ).outerHeight();
                jQuery( view.el ).find( 'input' ).closest( '.nf-setting' ).append( jQuery( '#merge-tags-box' ) );
                jQuery( '#merge-tags-box' ).css( 'top', offset );
            });

            jQuery( view.el ).find( 'input' ).on( 'keyup', function( e ){
                var text = jQuery( this ).val();
                var mergetags = text.match(new RegExp(/{([a-z0-9]|:|_|})*/g));

                // Filter out closed merge tags.
                mergetags = _.filter(mergetags, function(mergetag) {
                    return -1 == mergetag.indexOf( '}' ); // Filter out "closed" merge tags.
                });

                if( 0 !== mergetags.length ) {
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
        }

    } );

    return controller;
} );