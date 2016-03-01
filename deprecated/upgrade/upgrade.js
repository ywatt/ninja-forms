jQuery(document).ready(function($) {

    /*
     |--------------------------------------------------------------------------
     | Ninja Forms THREE Upgrade App
     |--------------------------------------------------------------------------
     */

    var nfUpgradeApp = {

        forms: [],

        step: 'checking',

        container: '#nfUpgradeApp',

        tmpl: {
            test: wp.template( 'test' ),
            table: wp.template( 'table' ),
            legend: wp.template( 'legend' ),
        },

        updateTable: function(){

            var data = {
                title: '',
                headers: [ 'Status', 'Title' ],
                rows: this.forms,
                step: this.step
            };

            if( 'checking' == this.step ) {

                data.title = 'Form Upgrade Compatibility';

                data.legend = this.tmpl.legend( {
                    no_issues_detected: 'No Issues Detected',
                    will_need_attention: 'Will Need Attention After Upgrade',
                }),

                data.next = 'Upgrade Forms';

                data.readyToConvert = 1;
                _.each(this.forms, function (form) {
                    if ( ! form.checked ) data.readyToConvert = 0;
                }, this);
            }

            if( 'converting' == this.step ) {
                data.title = 'Converting Forms';

                var redirectToThree = 1;
                _.each(this.forms, function (form) {
                    if ( ! form.converted ) redirectToThree = 0;
                }, this);
                if( redirectToThree ) window.location.href = nfThreeUpgrade.redirectURL;
            }

            jQuery( this.container ).html( this.tmpl.table( data ) );
        },

        checkForm: function( form ) {

            var that = this;
            $.post( ajaxurl, { action: 'ninja_forms_upgrade_check', formID: form.id }, function( response ) {

                var icon = ( response.canUpgrade ) ? 'yes' : 'flag';
                that.updateForm( form.id, 'title', response.title );
                that.updateForm( form.id, 'icon', icon );
                that.updateForm( form.id, 'checked', true );
                that.updateTable();
            }, 'json' );
        },

        updateForm: function( formID, property, value ) {
            _.each( this.forms, function( form ) {
                if( formID != form.id ) return;
                form[ property ] = value;
            });
        },

        start: function () {
            _.each( nfThreeUpgrade.forms, function( formID ) {
                this.forms[ formID ] = {
                    id: formID,
                    title: '',
                    icon: 'update',
                    checked: false,
                    converted: false
                }
            }, this );
            _.each( this.forms, this.checkForm, this );
            this.updateTable();

            var that = this;
            jQuery( '#nfUpgradeApp' ).on( 'click','.js-nfUpgrade-startConversion', function() {
                that.startConversion( that );
            } );
        },

        startConversion: function( app ) {
            console.log( 'HERE' );
            console.log( app );
            app.step = 'converting';

            $.post( ajaxurl, { nf2to3: 1, action: 'ninja_forms_ajax_migrate_database' }, function( response ) {
                _.each(app.forms, function (form) {
                    this.convertForm(form);
                }, app );
            });

            _.each(app.forms, function (form) {
                form.icon = 'update';
            }, app );
            app.updateTable();
        },

        convertForm: function( form ) {
            var app =  this;
            $.post(ajaxurl, {action: 'nfThreeUpgrade_GetSerializedForm', formID: form.id}, function ( formExport ) {
                $.post(ajaxurl, { nf2to3: 1, action: 'ninja_forms_ajax_import_form', formID: form.id, import: formExport.serialized }, function ( formImport ) {
                    form.converted = true;
                    form.icon = 'yes';
                    app.updateTable();
                }, 'json' );
            }, 'json' );
        }

    };

    nfUpgradeApp.start();

    //var forms = [];
    //var convertedFormsCount = 0;
    //
    //_.each( nfThreeUpgrade.forms, function ( formID ) {
    //
    //    $.post( ajaxurl, { action: 'ninja_forms_upgrade_check', formID: formID }, function( response ) {
    //        forms.push( response );
    //        maybeDisplayFormsCheckTable( forms );
    //    }, 'json' );
    //});
    //
    //$( '#goNinjaGo').click( function() {
    //
    //    $( '#nfThreeFormCheck').remove();
    //    $( '#nfThreeFormConvert').show();
    //
    //    $.post( ajaxurl, { nf2to3: 1, action: 'ninja_forms_ajax_migrate_database' }, function( response ) {
    //
    //        _.each( nfThreeUpgrade.forms, function ( formID ) {
    //
    //            $.post(ajaxurl, {action: 'nfThreeUpgrade_GetSerializedForm', formID: formID}, function (form) {
    //                console.log(form.serialized);
    //
    //                // TODO: Need a better check to see if the form converted successfully.
    //                var icon = '<span class="dashicons dashicons-yes"></span>';
    //
    //                $.post(ajaxurl, { nf2to3: 1, action: 'ninja_forms_ajax_import_form', import: form.serialized }, function (repsonse) {
    //
    //                    convertedFormsCount += 1;
    //                    $('#nfThreeFormConvertTable tbody').prepend("<tr><td>" + form.id + "</td><td></td><td>" + icon + "</td></tr>");
    //                    maybeDisplayGoToThreeButton();
    //                }, 'json' );
    //            }, 'json' );
    //        });
    //    }, 'json' );
    //});
    //
    //function maybeDisplayGoToThreeButton(){
    //
    //    if( forms.length != convertedFormsCount ) return;
    //
    //    $( '#goToThree' ).css( 'display', 'block' );
    //    $('#nfThreeFormConvertTable .js-tmp-row').remove();
    //}
    //
    //function maybeDisplayFormsCheckTable( forms ){
    //
    //    if( forms.length != nfThreeUpgrade.forms.length ) {
    //        var width = ( forms.length / nfThreeUpgrade.forms.length ) * 100;
    //        $( '#nfThreeFormCheckEmptyRow .progress-bar').css( 'width', width + '%' );
    //        return;
    //    }
    //
    //    forms = _.sortBy( forms, function( form ) { return form.id; } );
    //
    //    _.each( forms.reverse(), function ( form ) {
    //        var icon = ( form.canUpgrade ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-flag"></span>';
    //        $( '#nfThreeFormCheckTable tbody').prepend( "<tr><td>" + form.id + "</td><td>" + form.title + "</td><td>" + icon + "</td></tr>" );
    //    });
    //
    //    $( '#nfThreeFormCheckEmptyRow' ).remove();
    //    $( '#goNinjaGo' ).css( 'display', 'block' );
    //}

});
