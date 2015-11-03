define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		className: 'nf-table-row',
		template: '#nf-tmpl-edit-field-setting-list-option',

		initialize: function( data ) {
			this.fieldModel = data.fieldModel;
			this.collection = data.collection;
		},

		onRender: function() {
			jQuery( this.el ).prop( 'id', this.model.cid );
		},

		onShow: function() {
			jQuery( this.el ).find( 'input:first' ).focus();
		},

		events: {
			'change input': 'changeOption',
			'click .nf-delete': 'deleteOption',
			'keyup': 'maybeAddOption'
		},

		changeOption: function( e ) {
			nfRadio.channel( 'list-repeater' ).trigger( 'change:option', e, this.model, this.fieldModel );
		},

		deleteOption: function( e ) {
			nfRadio.channel( 'list-repeater' ).request( 'delete:option', this.model, this.collection, this.fieldModel );
		},

		maybeAddOption: function( e ) {
			if ( 13 == e.keyCode ) {
				nfRadio.channel( 'list-repeater' ).request( 'add:option', this.collection, this.fieldModel );
			}
		}

	});

	return view;
} );
