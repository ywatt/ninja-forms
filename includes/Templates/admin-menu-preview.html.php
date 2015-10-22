<div class="wrap">
    Hello, Preview!
</div>

<script>
    var data = {
        action: 'nf_preview_update',
        security: '<?php echo wp_create_nonce( 'ninja_forms_ajax_nonce' ); ?>',
        form_id: 1,
        field: {
            "id" : 1,
            "settings": {
                "type": 'textbox',
                "label": 'Another Name',
                "label_pos": 'inside',
                "required": 1
            }
        }
    };

    jQuery.post( ajaxurl, data, function(response){

        console.log( JSON.parse( response ) );

    });
</script>