/**
 * Model for our tutorial
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2017 WP Ninjas
 * @since 3.0.25
 */
define( [], function() {
	var model = Backbone.Model.extend( {
		initialize: function() {
			nfRadio.channel( 'app' ).trigger( 'init:tutorialModel', this );
		}
	} );
	
	return model;
} );