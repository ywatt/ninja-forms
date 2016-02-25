jQuery(document).ready(function($) {
    _.each(nfThreeUpgrade.forms, function (formID) {

        $.post(ajaxurl, {action: 'ninja_forms_upgrade_check', formID: formID}, function ( response ) {
            console.log( response );

            icon = ( response.can_upgrade ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-flag"></span>';

            $( '#nfThreeUpgradeTable tbody').prepend( "<tr><td>" + response.form_title + "</td><td>" + icon + "</td></tr>" );

            $( '#nfThreeUpgradeEmptyRow' ).remove();
        }, "json" );
    });
});
