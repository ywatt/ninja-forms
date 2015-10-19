<div class="wrap">
    Hello, Preview!
</div>

<script>
    var data = {
        action: 'nf_preview_form',
        security: '<?php echo wp_create_nonce( 'ninja_forms_ajax_nonce' ); ?>',
        field: { "id" : 1, "settings": { "label": 'This is a field' } }
    };

    jQuery.post( ajaxurl, data, function(response){

        console.log( JSON.parse( response ) );

    });
</script>