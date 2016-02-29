define( [], function() {
    var view = Marionette.ItemView.extend({
        tagName: 'nf-section',
        template: '#nf-tmpl-field-input-limit',

        initialize: function() {
        	this.listenTo( nfRadio.channel( 'field-' + this.model.get( 'id' ) ), 'keyup:field', this.updateCount );
        	this.count = 0;
        	this.render();
        },

        updateCount: function( el, model ) {
            var value = jQuery( el ).val();
            var regex = /\s+/gi;
            var wordCount = value.trim().replace(regex, ' ').split(' ').length;
            var charCount = value.trim().length;

            if ( 'characters' == this.model.get( 'input_limit_type' ) ) {
                this.count = charCount;
            } else {
                this.count = wordCount;
            }

        	this.render();
        },

        templateHelpers: function() {
        	var that = this;
        	return {
        		currentCount: function() {
        			return that.count;
        		}
        	}
        }

    });

    return view;
} );