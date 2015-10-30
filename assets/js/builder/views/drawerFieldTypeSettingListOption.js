define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'tr',
		template: '#nf-tmpl-edit-field-setting-list-option',

		initialize: function( data ) {
			this.fieldModel = data.fieldModel;
		},

		onRender: function() {
			jQuery( this.el ).prop( 'id', this.model.cid );
		},

		onShow: function() {
			jQuery( this.el ).find( 'input:first' ).focus();
		},

		events: {
			'change input': 'changeSetting',
			'click .nf-delete': 'deleteOption',
			'keyup': 'maybeAddOption'
		},

		changeSetting: function( e ) {
			nfRadio.channel( 'field-list' ).trigger( 'change:option', e, this.model );
		},

		deleteOption: function( e ) {
			nfRadio.channel( 'list-repeater' ).request( 'delete:option', this.model, this.model.collection );
		},

		maybeAddOption: function( e ) {
			if ( 13 == e.keyCode ) {
				nfRadio.channel( 'list-repeater' ).request( 'add:option', this.model.collection );
			}
		}

	});

	return view;
} );