define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-main-content-field',

		initialize: function() {
			this.model.on( 'change', this.render, this );
		},

		onBeforeDestroy: function() {
			this.model.off( 'change', this.render );
		},

		onRender: function() {
			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );
		},

		events: {
			'click .nf-edit-settings': 'clickEditField',
			'click .nf-delete': 'clickDeleteField',
			'click .nf-duplicate': 'clickDuplicateField'
		},

		clickEditField: function( e ) {
			nfRadio.channel( 'fields' ).trigger( 'click:editField', e, this.model );
		},

		clickDeleteField: function( e ) {
			nfRadio.channel( 'fields' ).trigger( 'click:deleteField', e, this.model );
		},

		clickDuplicateField: function( e ) {
			nfRadio.channel( 'fields' ).trigger( 'click:duplicateField', e, this.model );
		},

		templateHelpers: function () {
	    	return {
	    		renderClasses: function() {
	    			var classes = 'nf-field-wrap';
	    			if ( this.editActive ) {
	    				classes += ' active';
	    			}
	    			return classes;
	    		}
			};
		},


	});

	return view;
} );