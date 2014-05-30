jQuery( document ).ready( function( $ ) {

    // $('#nf_loading').ajaxStart(function(){ $(this).fadeIn(); });
    // $('#nf_loading').ajaxComplete(function(){ $(this).fadeOut(); });

    $( '.media-modal-close' ).on( 'click', function( e) {
    	$.modal.close();
    });

	$( '.control-section h3' ).on( 'click', function( e ) {
		if ( $( this ).parent().hasClass( 'open' ) ) {
			$( this ).parent().removeClass( 'open' );
			$( this ).parent().addClass( 'closed' );
		} else {
			$( this ).parent().removeClass( 'closed' );
			$( this ).parent().addClass( 'open' );
		}
	});

	// Make our field list sortable
	$( '#nf_field_list' ).sortable({
		items: 'ul',
		update: function( event, ui ) {
			var order = $( '#nf_field_list' ).sortable( 'toArray' );
			var x = 0;
			_.each( order, function ( field ) {
				var field_id = field.replace( 'nf_field_', '' );
				fieldList.get( field_id ).set( 'order', x );
				x++;
			});
			fieldListOrder.set( 'order', order );
		}
	});

	/** Create the Backbone for our field list **/

	// Model that holds each field.
	// Stores the id, type, and order.
	var FieldListItem = Backbone.Model.extend({
		urlRoot: nf_rest_url
	});

	// Model that holds the field order.
	// This exists so that we don't have to update for each field when the order changes.
	var FieldListOrder = Backbone.Model.extend({
		urlRoot: nf_rest_url,
		serverAttrs: ['order'],
		defaults: {
			order: $( '#nf_field_list' ).sortable( 'toArray' )
		},
		initialize: function () {
	        // Define server attributes for this model
	        this.on( 'change', this.save );
	    },
		save: function ( attrs, options ) {
			attrs = attrs || this.toJSON();
		    options = options || {};
		    attrs = attrs.attributes;
		    // If model defines serverAttrs, replace attrs with trimmed version
		    if (this.serverAttrs) attrs = _.pick(attrs, this.serverAttrs);

		    // Move attrs to options
		    options.attrs = attrs;

		    // Call super with attrs moved to options
		    Backbone.Model.prototype.save.call(this, attrs, options);
		}
	});

	fieldListOrder = new FieldListOrder();

	var FieldList = Backbone.Collection.extend({
		url: nf_rest_url,
		model: FieldListItem
	});

	fieldList = new FieldList();

	var FieldListView = Backbone.View.extend({
		el: '#nf_field_list',
		initialize: function(){
			this.collection.bind( 'reset', this.render, this );
		},
		render: function() {
			var content = '';
			_.each( fieldList.models, function( field ){
				content += _.template( $( '#tmpl-nf-field-list' ).html(), { field: field } );
			});
			
			$( this.el ).html( content );

			return this;
		},
		delete: function( e ) {
			e.preventDefault();
			var answer = confirm( commonL10n.warnDelete );
			if ( answer ) {
				var field_id = $( e.target ).data( 'field-id' );
				fieldList.get( field_id ).destroy({ test: 'test' });
				fieldListView.render();			
			}
		},
		events: {
			'click .delete-field': 'delete'
		},
	});

	fieldListView = new FieldListView({ collection: fieldList });

	fieldList.fetch({
		reset: true,
		data: $.param({ object_type: 'field_list', object_id: nf_form_id })
	});

	/*
	Setting = Backbone.Model.extend({
		urlRoot: nf_rest_url + '&nf_rest=rest_api'
	});

	var Field = Backbone.Collection.extend({
		url: nf_rest_url + '&nf_rest=rest_api',
		model: Setting,
	});

	field = new Field();

	
	var ContentView = Backbone.View.extend({

		el: '#nf-settings-content',

		template: '#tmpl-nf-settings',

		initialize: function(){
				this.collection.bind( 'reset', this.render, this );
		},

		render: function() {
			var content = _.template( jQuery(this.template).html(), { settings: field } );
			return this;
		}

	});

	settingsView = new ContentView({ collection: field });

	field.fetch({
		reset: true, 
		data: jQuery.param({ field_id: 9 })
	 });
	*/
});