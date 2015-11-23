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
			'click': 'maybeClickEdit',
			'change input': 'changeToggle'
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

		changeToggle: function( e ) {
			var settingModel = nfRadio.channel( 'actions' ).request( 'get:settingModel', 'active' );
			nfRadio.channel( 'app' ).request( 'change:setting', e, settingModel, this.model );
			nfRadio.channel( 'app' ).request( 'update:db' );
		},

		templateHelpers: function() {
			return {
				renderToggle: function() {
					var actionLabel = this.label;
					this.label = '';
					this.value = this.active;
					this.name = this.id + '-active';
					var html = _.template( jQuery( '#nf-tmpl-edit-setting-toggle' ).html(), this );
					this.label = actionLabel;
					return html;
				},

				renderTypeNicename: function() {
					var type = nfRadio.channel( 'actions' ).request( 'get:type', this.type );
					return type.get( 'nicename' );
				},

				renderTooltip: function() {
					if ( 'undefined' != typeof this.help ) {
						return '<a class="nf-help" href="#"><span class="dashicons dashicons-admin-comments"></span></a><div class="nf-help-text">' + this.help + '</div>';
					} else {
						return '';
					}
				}
			}
		}
	});

	return view;
} );