define( ['views/fieldItem', 'views/beforeField', 'views/afterField'], function( fieldItem, beforeField, afterField ) {

    var view = Marionette.LayoutView.extend({
        tagName: "nf-field",
        template: "#nf-tmpl-field-layout",

        regions: {
            beforeField: ".nf-before-field",
            field: ".nf-field",
            afterField: ".nf-after-field",
        },

        onShow: function() {
            this.beforeField.show( new beforeField( { model: this.model } ) );
            this.field.show( new fieldItem( { model: this.model } ) );
            this.afterField.show( new afterField( { model: this.model } ) );
        },

        templateHelpers: function() {
            return {
                renderContainerClass: function() {
                    var containerClass = '';
                    // if we have a container_class field setting, add that to our wrap.
                    if ( 'undefined' != typeof this.container_class && 0 < jQuery.trim( this.container_class ).length ) {
                        containerClass += this.container_class + ' ';
                    }

                    return containerClass;
                }
            }
        }

    });

    return view;
} );
