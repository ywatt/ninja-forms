jQuery( document ).ready( function( $ ) {

	$( '.control-section h3' ).on( 'click', function( e ) {
		if ( $( this ).parent().hasClass( 'open' ) ) {
			$( this ).parent().removeClass( 'open' );
			$( this ).parent().addClass( 'closed' );
		} else {
			$( this ).parent().removeClass( 'closed' );
			$( this ).parent().addClass( 'open' );
		}
	});

	// Listen for our Delete Field event
	$( document ).on( 'click', '.delete-field', function( e ) {
		e.preventDefault();
		var field_id = $( this ).data( 'field-id' );
		$.post( ajaxurl, { field_id: field_id, action:'nf_delete_field' }, function( response ){
			$( '#nf_field_' + field_id ).fadeOut( function() {
				$( this ).remove();
			});
		});
	});

	// Make our field list sortable
	$( '#nf_fields' ).sortable({
		items: 'ul',
		update: function( event, ui ) {
			console.log( 'update' );
		}
	});

	/** Create a model for our field list **/

	var FieldListItem = Backbone.Model.extend({
		urlRoot: nf_rest_url
	});

	var FieldList = Backbone.Collection.extend({
		url: nf_rest_url,
		model: FieldListItem
	});

	fieldList = new FieldList();
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