/**
 * Single action table row
 *
 * TODO: make dynamic
 * 
 * @package Ninja Forms builder
 * @subpackage Actions
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'tr',
		template: '#nf-tmpl-action-item',
		
		initialize: function() {
			this.model.on( 'change', this.render, this );
		},

		onBeforeDestroy: function() {
			this.model.off( 'change', this.render );
		},
		
		onRender: function() {
			if ( this.model.get( 'editActive' ) ) {
				jQuery( this.el ).addClass( 'active' );
			} else {
				jQuery( this.el ).removeClass( 'active' );
			}
		},

		events: {
			'click .nf-edit-settings': 'clickEdit',
			'click .nf-delete': 'clickDelete',
			'click .nf-duplicate': 'clickDuplicate',
			'click': 'maybeClickEdit'
		},

		clickEdit: function( e ) {
			nfRadio.channel( 'actions' ).trigger( 'click:edit', e, this.model );
		},

		clickDelete: function( e ) {
			nfRadio.channel( 'actions' ).trigger( 'click:delete', e, this.model );
		},

		clickDuplicate: function( e ) {
			nfRadio.channel( 'actions' ).trigger( 'click:duplicate', e, this.model );
		},

		maybeClickEdit: function( e ) {
			if ( 'TR' == jQuery( e.target ).parent().prop( 'tagName' ) ) {
				this.clickEdit();
			}
		},

		templateHelpers: function() {
			return {
				renderToggle: function() {
					this.label = '';
					this.value = this.active;
					var actionName = this.name;
					this.toggleName = this.id + '-active';
					this.name = this.toggleName;
					var html = _.template( jQuery( '#nf-tmpl-edit-setting-toggle' ).html(), this );
					this.name = actionName;
					return html;
				}
			}
		}
	});

	return view;
} );