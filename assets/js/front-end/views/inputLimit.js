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
        	this.count = jQuery( el ).val().length;
        	this.render();
        },

        onRender: function() {
        	if ( this.count > this.model.get( 'input_limit' ) ) {
        		console.log( 'over' );
        	}
        },

        templateHelpers: function() {
        	var that = this;
        	return {
        		currentCount: function() {
        			console.log( that.count );
        			return that.count;
        		}
        	}
        }

    });

    return view;
} );