jQuery(document).ready(function($) {

    var forms = [];

    _.each( nfThreeUpgrade.forms, function ( formID ) {

        $.post( ajaxurl, { action: 'ninja_forms_upgrade_check', formID: formID }, function( response ) {
            forms.push( response );
            maybeDisplayFormsCheckTable( forms );
        }, 'json' );
    });

    $( '#goNinjaGo').click( function() {

        $( '#nfThreeFormCheck').remove();
        $( '#nfThreeFormConvert').show();

        $.post( ajaxurl, { nf2to3: 1, action: 'ninja_forms_ajax_migrate_database' }, function( response ) {

            _.each( nfThreeUpgrade.forms, function ( formID ) {

                $.post(ajaxurl, {action: 'nfThreeUpgrade_GetSerializedForm', formID: formID}, function (form) {
                    console.log(form.serialized);

                    var icon = ( false ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-flag"></span>';

                    $.post(ajaxurl, { nf2to3: 1, action: 'ninja_forms_ajax_import_form', import: form.serialized }, function (repsonse) {

                        $('#nfThreeFormConvertTable tbody').prepend("<tr><td>" + form.id + "</td><td></td><td>" + icon + "</td></tr>");
                        $('#nfThreeFormConvertTable .js-tmp-row').remove();
                    }, 'json' );
                }, 'json' );
            });
        }, 'json' );

        $( '#goToThree' ).css( 'display', 'block' );
    });

    function maybeDisplayFormsCheckTable( forms ){

        if( forms.length != nfThreeUpgrade.forms.length ) {
            var width = ( forms.length / nfThreeUpgrade.forms.length ) * 100;
            $( '#nfThreeFormCheckEmptyRow .progress-bar').css( 'width', width + '%' );
            return;
        }

        forms = _.sortBy( forms, function( form ) { return form.id; } );

        _.each( forms.reverse(), function ( form ) {
            var icon = ( form.canUpgrade ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-flag"></span>';
            $( '#nfThreeFormCheckTable tbody').prepend( "<tr><td>" + form.id + "</td><td>" + form.title + "</td><td>" + icon + "</td></tr>" );
        });

        $( '#nfThreeFormCheckEmptyRow' ).remove();
        $( '#goNinjaGo' ).css( 'display', 'block' );
    }

});
