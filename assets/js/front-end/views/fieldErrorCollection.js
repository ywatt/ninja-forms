define( ['front-end/views/fieldErrorItem'], function( fieldErrorItem ) {
	var view = Marionette.CollectionView.extend({
		tagName: "nf-errors",
		childView: fieldErrorItem,

		initialize: function() {
			_.bindAll( this, 'render' );
    		this.bind( 'add', this.render, this );
    		this.bind( 'remove', this.render, this );
    	},

    	onRender: function() {
    		// console.log( this.options.thisModel );
    	}

	});

	return view;
} );