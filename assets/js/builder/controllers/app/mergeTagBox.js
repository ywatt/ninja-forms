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
            this.listenTo( nfRadio.channel( 'drawer' ), 'opened', function(){
                jQuery( '.merge-tags' ).on( 'click', function( e ){
                    var $this = jQuery( this );
                    if( $this.siblings().hasClass( 'merge-tag-focus' ) ){
                        jQuery( '#merge-tags-box' ).css( 'display', 'none' );
                        jQuery( '.merge-tag-focus' ).removeClass( 'merge-tag-focus' );
                        jQuery( '.merge-tag-focus-overlay' ).removeClass( 'merge-tag-focus-overlay' );
                        return;
                    }
                    var text = $this.closest( '.nf-setting' ).find( '.setting' ).val();
                    if( undefined != text ) {
                        $this.closest( '.nf-setting' ).find( '.setting' ).val( text + '{' ).change();
                        nfRadio.channel('mergeTags').request('set:caret', text.length + 1 );
                    } else {
                        $this.closest( '.nf-setting' ).find( '.setting' ).val( '{' ).change();
                        nfRadio.channel('mergeTags').request('set:caret', 1 );
                    }

                    nfRadio.channel('mergeTags').request('set:old', '{' );

                    // $this.closest( '.nf-setting' ).find( '.setting' ).focus(); //.addClass( 'merge-tag-focus' );
                    $this.closest( '.nf-setting' ).find( '.setting' ).addClass( 'merge-tag-focus' ); //.addClass( 'merge-tag-focus' );

                    // Disable browser autocomplete.
                    var autocomplete = $this.attr( 'autocomplete' );
                    $this.attr( 'autocomplete', 'off' );
                    $this.data( 'autocomplete', autocomplete );

                    var $overlayElement = $this.closest( '.nf-setting, .nf-table-row' );
                    if( 0 != $overlayElement.find( '.note-editor' ).length ){
                        $overlayElement.find('.note-editor' ).addClass('merge-tag-focus-overlay');
                    } else {
                        $overlayElement.addClass('merge-tag-focus-overlay');
                    }

                    jQuery( '#merge-tags-box' ).css( 'display', 'block' );
                    setTimeout(function(){
                        jQuery( '#merge-tags-box' ).find( '.merge-tag-filter' ).find( 'input' ).focus();
                    }, 500 );
                });
            } );

            var that = this;
            nfRadio.channel( 'mergeTags' ).reply( 'set:caret', function( position ){
               that.caret = position;
            });
            nfRadio.channel( 'mergeTags' ).reply( 'get:caret', function(){
                return that.caret;
            });

            var that = this;
            nfRadio.channel( 'mergeTags' ).reply( 'set:old', function( value ){
                that.old = value;
            });
            nfRadio.channel( 'mergeTags' ).reply( 'get:old', function(){
                return that.old;
            });

            nfRadio.channel( 'mergeTags' ).reply( 'insert:tag', this.insertTag.bind( this ) );
            
            /* CALCULATIONS */
            this.listenTo( nfRadio.channel( 'setting-calculations-option' ), 'render:setting', this.renderSetting );

            /* SUMMERNOTE */
            this.listenTo( nfRadio.channel( 'summernote' ), 'focus', function( e, selector ) {
                that.focusCallback( false, selector );
            } );
            this.listenTo( nfRadio.channel( 'summernote' ), 'keydown', function( e, selector ){
                jQuery( selector ).closest( '.nf-setting' ).find( '.setting' ).summernote( 'saveRange' );
            } );
            this.listenTo( nfRadio.channel( 'summernote' ), 'keyup', function( e, selector ){
                that.keyupCallback( e, selector );
            } );
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

            var that = this;
            this.listenTo( nfRadio.channel( 'mergeTags' ), 'open', function(){
                // layout.destroy();
                that.afterAppStart();
            });
        },

        beforeRenderSetting: function( settingModel, dataModel ){
            if( 'undefined' == typeof settingModel.get( 'use_merge_tags' ) ) return;
            if( ! settingModel.get( 'use_merge_tags' ) ) return;
            var name = settingModel.get( 'name' );
            this.listenTo( nfRadio.channel( 'setting-' + name ), 'render:setting', this.renderSetting );
        },

        renderSetting: function( settingModel, dataModel, view ){

            if( 0 == jQuery( '#merge-tags-box' ).length ) this.afterAppStart();

            // Track Scrolling.
            jQuery( '#nf-drawer' ).on( 'scroll', function(){
               // COPIED AND MODIFIED FROM FOCUS
                if( 0 == jQuery( '.merge-tag-focus' ).length ) return;

                var rteEditor = jQuery( '.merge-tag-focus' ).closest( '.nf-setting' ).find( '.note-editor' );
                if( 0 != rteEditor.length ){
                    var posY = rteEditor.offset().top - jQuery(window).scrollTop();
                    var height = rteEditor.outerHeight();
                } else {
                    var posY = jQuery('.merge-tag-focus').offset().top - jQuery(window).scrollTop();
                    var height = jQuery('.merge-tag-focus').outerHeight();
                }
                jQuery( '#merge-tags-box' ).css( 'top', posY + height );

                var repeaterRow = jQuery( '.merge-tag-focus' ).closest( '.nf-list-options-tbody' );
                if( 0 != repeaterRow.length ){
                    var left = repeaterRow.offset().left - jQuery(window).scrollLeft();
                    jQuery( '#merge-tags-box' ).css( 'left', left );
                } else {
                    var posX = jQuery( '.merge-tag-focus' ).closest( '.nf-settings' ).offset().left - jQuery(window).scrollLeft();
                    jQuery( '#merge-tags-box' ).css( 'left', posX );
                    jQuery( '#merge-tags-box' ).css( 'width', jQuery( '.merge-tag-focus' ).closest( '.nf-settings' ).width() );
                }
            });

            // On input focus, move the Merge Tag Box into position.
            jQuery( view.el ).find( '.setting' ).on( 'focus', this.focusCallback );

            // TODO: Maybe move to view events.
            // On input keyup, maybe show Merge Tag Box.
            jQuery( view.el ).find( '.setting' ).on( 'keyup', this.keyupCallback );
        },

        // TODO: Maybe move to view class.
        beforeDrawerClose: function(){
            jQuery( '#merge-tags-box' ).css( 'display', 'none' );
            // jQuery( 'body' ).append( jQuery( '#merge-tags-box' ) );
            nfRadio.channel( 'mergeTags' ).trigger( 'open' );
        },

        insertTag: function( tag ) {

            var $input = jQuery( '.merge-tag-focus' );

            if( 0 != $input.closest( '.nf-setting' ).first().find( '.note-editable' ).length ){
                $input = $input.closest( '.nf-setting' ).first().find( '.note-editable' );
            }

            if( 1 < $input.length ){ $input = $input.first(); }

            if( $input.hasClass( 'note-editable' ) ){
                var str = $input.closest( '.nf-setting' ).find( '.setting' ).summernote( 'code' );
            } else {
                var str = $input.val();
            }

            var find = nfRadio.channel( 'mergeTags' ).request( 'get:old' );
            var replace = tag;
            var caretPos = nfRadio.channel( 'mergeTags' ).request( 'get:caret' );

            var patt = /{([a-z0-9]|:|_|})*/g;

            // Loop through matches to find insert/replace index range.
            // Reference: http://codepen.io/kjohnson/pen/36c3a782644dfff40fe3c1f05f8739d9?editors=0012
            while (match = patt.exec(str)) {
                if (find != match[0]) continue; // This isn't the match you are looking for...
                var string = str.slice(0, match.index) + replace + str.slice(patt.lastIndex); // Fancy replace for the specifc match, using the index/position.

                if( $input.hasClass( 'note-editable' ) ){
                    $input.closest( '.nf-setting' ).find( '.setting' ).summernote( 'code', string );

                    // Reposition the caret. http://stackoverflow.com/a/6249440 TODO: Determine the appropriate childNode.
                    var el = $input;
                    var childNode = null; // Default to first childNode.
                    _.each( el[0].childNodes, function( node, index ){
                        if( childNode ) return;
                        if( ! node.nodeValue && ! node.innerHTML ) return;
                        if( node.nodeValue ) {
                            var position = node.nodeValue.indexOf(replace) + find.length;
                        } else if( node.innerHTML ){
                            var position = node.innerHTML.indexOf(replace) + find.length;
                        }
                        if( caretPos == position ) childNode = el[0].childNodes[index];
                    });
                    if( ! childNode ) childNode = el[0].childNodes[0];
                    var offset = caretPos - find.length + replace.length;
                    var range = document.createRange();
                    var sel = window.getSelection();
                    if( 0 != childNode.childNodes.length ) {
                        range.setStart(childNode.childNodes[0], offset);
                    } else {
                        range.setStart(childNode, offset);
                    }
                    range.collapse(true);
                    sel.removeAllRanges();
                    sel.addRange(range);


                } else {
                    $input.val(string); // Update input value with parsed string.
                    $input.change(); // Trigger a change event after inserting the merge tag so that it saves to the model.
                    $input.caret(caretPos - find.length + replace.length); // Update Carept Position.
                }

            }

            jQuery( '#merge-tags-box' ).css( 'display', 'none' );
            $input.removeClass( 'merge-tag-focus' );
            $input.closest( '.merge-tag-focus-overlay' ).removeClass( 'merge-tag-focus-overlay' );
        },

        focusCallback: function( e, target ){

            jQuery( '.merge-tag-focus' ).each(function(index, el){
                if( this == el ) return;
                el.removeClass( 'merge-tag-focus' );
            });

            if( 'undefined' != typeof target ) {
                var posY = jQuery( target ).closest( '.nf-setting' ).find( '.note-editor' ).offset().top - jQuery(window).scrollTop();
                var height = jQuery( target ).closest( '.nf-setting' ).find( '.note-editor' ).outerHeight();
            } else {
                var posY = jQuery(this).offset().top - jQuery(window).scrollTop();
                var height = jQuery(this).outerHeight();
            }
            jQuery( '#merge-tags-box' ).css( 'top', posY + height );

            var repeaterRow = jQuery( this ).closest( '.nf-list-options-tbody' );
            if( 0 != repeaterRow.length ) {
                var left = repeaterRow.offset().left - jQuery(window).scrollLeft();
                jQuery( '#merge-tags-box' ).css( 'left', left );
            } else if( 'undefined' != typeof target ) {
                var posX = jQuery( target ).closest( '.nf-setting' ).find( '.note-editor' ).offset().left - jQuery(window).scrollLeft();
                jQuery( '#merge-tags-box' ).css( 'left', posX );
                jQuery( '#merge-tags-box' ).css( 'width', jQuery( target ).closest( '.nf-setting' ).find( '.note-editor' ).width() );
            }
            else
            {
                var posX = jQuery( this ).closest( '.nf-settings' ).offset().left - jQuery(window).scrollLeft();
                jQuery( '#merge-tags-box' ).css( 'left', posX );
                jQuery( '#merge-tags-box' ).css( 'width', jQuery( this ).closest( '.nf-settings' ).width() );
            }

            var dataID = jQuery( this ).data( 'id' );
            if( dataID && 'eq' != dataID ) return;

            // var offset = jQuery( view.el ).find( '.setting' ).parent().outerHeight();
            // jQuery( view.el ).find( '.setting' ).parent().append( jQuery( '#merge-tags-box' ) );
            // jQuery( '#merge-tags-box' ).css( 'top', offset );
        },

        keyupCallback: function( event, target ){

            if( /* ENTER */ 13 == event.keyCode ){

                // Get top listed merge tag.
                var firstFilteredTag = jQuery( '#merge-tags-box .merge-tag-list ul li span' ).first().data( 'tag' );

                nfRadio.channel( 'mergeTags' ).request( 'insert:tag', firstFilteredTag );

                // COPIED FROM BELOW
                jQuery( '#merge-tags-box' ).css( 'display', 'none' );
                jQuery( '#merge-tags-box' ).removeClass();
                jQuery( '.merge-tag-focus' ).removeClass( 'merge-tag-focus' );
                jQuery( '.merge-tag-focus-overlay' ).removeClass( 'merge-tag-focus-overlay' );

                return;
            }

            // Get the value.
            // var value = jQuery( summernote ).summernote( 'code' );
            // Update the value.
            // jQuery( summernote ).closest( '.nf-setting' ).find( '.note-editable' ).html( value );

            if( 'undefined' != typeof target ) {
                var $this = jQuery(target);
            } else {
                var $this = jQuery( this );
            }

            // TODO: Disable Browser Autocomplete
            // $this.attr()


            var dataID = jQuery( this ).data( 'id' );
            if( dataID && 'eq' != dataID ) return;

            // Store the current caret position.
            if( 'undefined' != typeof target ){
                var range = $this.summernote('createRange');
                if( range ) {
                    var caretPos = range.so; // or .eo?
                } else {
                    var caretPos = 0;
                }
                $this.closest( '.nf-setting' ).find( '.setting' ).summernote( 'saveRange' );
            } else {
                var caretPos = $this.caret();
            }
            nfRadio.channel( 'mergeTags' ).request( 'set:caret', caretPos );

            // Find merge tags.
            if( 'undefined' == typeof target ) {
                var mergetags = $this.val().match(new RegExp(/{([a-z0-9]|:|_|})*/g));
            } else {
                var mergetags = $this.summernote( 'code' ).match(new RegExp(/{([a-z0-9]|:|_|})*/g));
            }

            // Filter out closed merge tags.
            mergetags = _.filter(mergetags, function(mergetag) {
                return -1 == mergetag.indexOf( '}' ); // Filter out "closed" merge tags.
            });

            // If an open merge tag is found, show the Merge Tag Box, else hide.
            if( 0 !== mergetags.length ) {

                nfRadio.channel( 'mergeTags' ).request( 'set:old', mergetags[0] );

                jQuery('#merge-tags-box').css( 'display', 'block' );
                $this.addClass('merge-tag-focus');

                // Disable browser autocomplete.
                var autocomplete = $this.attr( 'autocomplete' );
                $this.attr( 'autocomplete', 'off' );
                $this.data( 'autocomplete', autocomplete );

                var $overlayElement = $this.closest( '.nf-setting, .nf-table-row' );
                if( 0 != $overlayElement.find( '.note-editor' ).length ){
                    $overlayElement.find('.note-editor' ).addClass('merge-tag-focus-overlay');
                } else {
                    $overlayElement.addClass('merge-tag-focus-overlay');
                }

                $overlayElement.on( 'click', function( event ){
                    if( -1 !== jQuery( event.target ).attr( 'class' ).indexOf( 'merge-tag-focus-overlay' ) ){
                        jQuery( '#merge-tags-box' ).css( 'display', 'none' );
                        jQuery( '#merge-tags-box' ).removeClass();
                        jQuery( '.merge-tag-focus' ).removeClass( 'merge-tag-focus' );
                        jQuery( '.merge-tag-focus-overlay' ).removeClass( 'merge-tag-focus-overlay' );
                    }
                });

                var value = mergetags[0].replace( '{', '' );
                nfRadio.channel( 'merge-tags' ).request( 'filtersearch', value );
            } else {
                jQuery( '#merge-tags-box' ).css( 'display', 'none' );
                jQuery( '#merge-tags-box' ).removeClass();
                jQuery( '.merge-tag-focus' ).removeClass( 'merge-tag-focus' );
                jQuery( '.merge-tag-focus-overlay' ).removeClass( 'merge-tag-focus-overlay' );
            }
        }

    } );

    return controller;
} );