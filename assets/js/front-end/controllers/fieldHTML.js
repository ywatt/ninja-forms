define([], function() {
    var controller = Marionette.Object.extend({

        htmlFields: [],
        trackedMergeTags: [],

        initialize: function () {
            this.listenTo( Backbone.Radio.channel( 'fields-html' ), 'init:model', this.setupFieldMergeTagTracking );
        },

        setupFieldMergeTagTracking: function( fieldModel ) {
            this.htmlFields.push( fieldModel );

            var formID = fieldModel.get( 'formID' );

            this.listenTo( nfRadio.channel( 'form-' + formID ), 'init:model', function( formModel ){

                var mergeTags = fieldModel.get( 'default' ).match( new RegExp( /{field:(.*?)}/g ) );
                if ( ! mergeTags ) return;

                _.each( mergeTags, function( mergeTag ) {
                    var fieldKey = mergeTag.replace( '{field:', '' ).replace( '}', '' );
                    var fieldModel = formModel.get( 'fields' ).findWhere({ key: fieldKey });
                    if( 'undefined' == typeof fieldModel ) return;

                    this.trackedMergeTags.push( fieldModel );
                    this.listenTo( nfRadio.channel( 'field-' + fieldModel.get( 'id' ) ), 'change:modelValue', this.updateFieldMergeTags );
                }, this );

                // Let's get this party started!
                this.updateFieldMergeTags();
            }, this );
        },

        updateFieldMergeTags: function( fieldModel ) {
            _.each( this.htmlFields, function( htmlFieldModel ){
                var value = htmlFieldModel.get( 'default' );
               _.each( this.trackedMergeTags, function( fieldModel ){
                    var mergeTag = '{field:' + fieldModel.get( 'key' ) + '}';
                    value = value.replace( mergeTag, fieldModel.get( 'value' ) );
               }, this ) ;
               htmlFieldModel.set( 'value', value );
               htmlFieldModel.trigger( 'reRender' );
            }, this );
        }

    });

    return controller;
});
