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
define( ['builder/views/app/itemControls'], function( itemControlsView ) {
	var view = Marionette.LayoutView.extend({
		tagName: 'tr',
		template: '#nf-tmpl-action-item',
		
		regions: {
			itemControls: '.nf-item-controls'
		},

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

			if ( 0 == this.model.get( 'active' ) ) {
				jQuery( this.el ).addClass( 'deactivated' );
			} else {
				jQuery( this.el ).removeClass( 'deactivated' );
			}

			this.itemControls.show( new itemControlsView( { model: this.model } ) );
		},

		events: {
			'change input': 'changeToggle',
			'click': 'maybeClickEdit'
		},

		maybeClickEdit: function( e ) {
			if ( 'TR' == jQuery( e.target ).parent().prop( 'tagName' ) ) {
				nfRadio.channel( 'actions' ).trigger( 'click:edit', e, this.model );
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