jQuery(document).ready(function($) {

    var forms = [];

    _.each(nfThreeUpgrade.forms, function ( formID ) {

        $.post( ajaxurl, { action: 'ninja_forms_upgrade_check', formID: formID }, function( response ) {
            forms.push( response );
            maybe();
        }, 'json' );
    });

    function maybe(){

        if( forms.length != nfThreeUpgrade.forms.length ) {
            var width = ( forms.length / nfThreeUpgrade.forms.length ) * 100;
            $( '#nfThreeUpgradeEmptyRow .progress-bar').css( 'width', width + '%' );
            return;
        }

        forms = _.sortBy( forms, function( form ) { return form.id; } );

        _.each( forms.reverse(), function ( form ) {
            var icon = ( form.canUpgrade ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-flag"></span>';
            $( '#nfThreeUpgradeTable tbody').prepend( "<tr><td>" + form.id + "</td><td>" + form.title + "</td><td>" + icon + "</td></tr>" );
        });

        $( '#nfThreeUpgradeEmptyRow' ).remove();
        $( '#goNinjaGo' ).css( 'display', 'block' );
    }

});
