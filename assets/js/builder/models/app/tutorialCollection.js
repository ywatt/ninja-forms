/**
 * Collection that holds our tutorial models. 
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2017 WP Ninjas
 * @since 3.0.25
 */
define( ['models/app/tutorialModel'], function( TutorialModel ) {
	var collection = Backbone.Collection.extend( {
		model: TutorialModel,
		url: nfAdmin.rest_url
	} );
	return collection;
} );