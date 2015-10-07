require.config( {
	baseUrl: nfAdmin.requireBaseUrl
} );

var nfRadio = Backbone.Radio;

jQuery( document ).ready( function( $ ) {
	require( ['builder/views/builder'], function( BuilderView ) {

		var NinjaForms = Marionette.Application.extend( {

			initialize: function( options ) {		
				
			},

			onStart: function() {
				var builderView = new BuilderView();
			},
			
		} );
	
		var ninjaForms = new NinjaForms();
		ninjaForms.start();		
	} );

    $(".nf-add-new").click(function(){
    $("#nf-builder").removeClass("nf-drawer-closed");
    $("#nf-builder").addClass("nf-drawer-opened");
    //$(".nf-field-wrap:first-child").addClass("active");
    });
    $(".nf-close-drawer").click(function(){
        $("#nf-builder").removeClass("nf-drawer-opened");
        $("#nf-builder").addClass("nf-drawer-closed");
        //$(".nf-field-wrap:first-child").removeClass("active");
    });

    $(".nf-toggle-drawer").click(function(){
        $("#nf-drawer").toggleClass("nf-drawer-expand");
    });
    $(".nf-item-expand").click(function(){
        $(".nf-group-wrap").toggleClass("expanded");
    });
    $(".nf-mobile").click(function(){
        $("#nf-builder").toggleClass("nf-menu-expand");
    });
} );