/**
 * Button to add an action to the form.
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
		tagName: 'div',
		template: '#nf-tmpl-drawer-action-type-button',

		events: {
			'click': 'clickAddAction'
		},

		clickAddAction: function( e ) {
			console.log( this.model );
			if ( 'installed' == this.model.get( 'section' ) ) { // Is this an installed action?
				// console.log( 'installed' );
			} else { // This isn't an installed action
				// console.log( 'available' );
			}
		},

		templateHelpers: function() {
			return {
				renderClasses: function() {
					var classes = 'nf-item';
					if ( '' != jQuery.trim( this.image ) ) {
						classes += ' nf-has-img';
					}
					return classes;
				},

				renderStyle: function() {
					if ( '' != jQuery.trim( this.image ) ) {
						return "style=\"background-image: url('https://ninjaforms.com/wp-content/uploads/2015/11/custom-action.png');\""
					} else {
						return '';
					}
				}
			}
		}
	});

	return view;
} );