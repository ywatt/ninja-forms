<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Display_Render
{
    protected static $loaded_templates = array(
        'app-layout',
        'app-before-form',
        'app-after-form',
        'form-layout',
        'fields-wrap',
        'fields-label',
        'fields-error',
    );

    public static function localize( $form_id )
    {

        if( ! has_action( 'wp_footer', 'NF_Display_Render::output_templates', 9999 ) ){
            add_action( 'wp_footer', 'NF_Display_Render::output_templates', 9999 );
        }
        $form = Ninja_Forms()->form( $form_id )->get();

        $form_fields = Ninja_Forms()->form( $form_id )->get_fields();

        $fields = array();

        foreach( $form_fields as $field ){

            $field = apply_filters( 'nf_localize_fields', $field );

            $field_class = $field->get_settings( 'type' );

            $field_class = Ninja_Forms()->fields[ $field_class ];

            // $field->update_setting( 'value', time() );
            $field->update_setting( 'id', $field->get_id() );

            $fields[] = $field->get_settings();

            self::load_template( 'fields-' . $field_class::TEMPLATE );
        }

        // Output Form Container
        ?>
            <div id="nf-form-<?php echo $form_id; ?>-cont"></div>
        <?php

        ?>
        <!-- TODO: Move to Template File. -->
        <script>
            // Maybe initialize nfForms object
            var nfForms = nfForms || [];

            // Build Form Data
            var form = [];
            form.id = <?php echo $form_id; ?>;
            form.settings = JSON.parse( '<?php echo WPN_Helper::addslashes( wp_json_encode( $form->get_settings() ) ); ?>' );

            form.fields = JSON.parse( '<?php echo WPN_Helper::addslashes( wp_json_encode( $fields ) ); ?>' );

            // Add Form Data to nfForms object
            nfForms.push( form );
        </script>

        <!-- TODO: Move to Stylesheet. -->
        <style>
            .nf-error input {
                border-color: red;
            }
            .nf-error-msg {
                color:red;
            }
            .nf-element.disabled {
                opacity: 0.3;
            }
            .nf-pass .nf-element {
                /*border: 2px solid green;*/
                background: url( 'https://cdn0.iconfinder.com/data/icons/round-ui-icons/512/tick_green.png' ) no-repeat;
                background-position: 99.5% 60%;
                background-size: 35px 35px;
                /*background: url( 'https://cdn0.iconfinder.com/data/icons/iconsweets2/40/email_envelope.png' ) 0 no-repeat;*/
            }
            .nf-fail .nf-element {
                /*border: 2px solid red;*/
                background: url( 'https://cdn1.iconfinder.com/data/icons/toolbar-signs/512/cancel-512.png' ) no-repeat;
                background-position: 99% 60%;
                background-size: 30px 30px;
                /*background: url( 'https://cdn0.iconfinder.com/data/icons/iconsweets2/40/email_envelope.png' ) 0 no-repeat;*/
            }
            .nf-file-progress {
                position:relative;
                width:400px;
                border: 1px solid #ddd;
                padding: 1px;
                border-radius: 3px;
            }
            .nf-file-bar {
                background-color: #B4F5B4;
                width:0%;
                height:20px;
                border-radius: 3px;
            }
            .nf-file-percent {
                position:absolute;
                display:inline-block;
                top:3px;
                left:48%;
            }
            ​.nf-files-table {
                border-collapse: collapse;
                width: 100%;
            }
            .nf-files-table td {
                border-top: 1px solid #ccc;
                padding: 10px;
            }
            .nf-files-table tr:last-child td {
                border-bottom: 1px solid #ccc;
            }
            .nf-files-table tr:nth-child(odd) td {
                background: #fff;
            }
            .nf-files-table tr:nth-child(even) td {
                background: #f1f1f1;
            }
        </style>

        <?php


        wp_enqueue_style( 'nf-display-structure', Ninja_Forms::$url . 'assets/css/display-structure,css' );
        wp_enqueue_style( 'nf-display-opinions', Ninja_Forms::$url . 'assets/css/display-opinions.css' );

        wp_enqueue_script( 'backbone-marionette', Ninja_Forms::$url . 'assets/js/lib/backbone.marionette.min.js', array( 'jquery', 'backbone' ) );
        wp_enqueue_script( 'backbone-radio', Ninja_Forms::$url . 'assets/js/lib/backbone.radio.min.js', array( 'jquery', 'backbone' ) );

        wp_enqueue_script( 'requirejs', Ninja_Forms::$url . 'assets/js/lib/require.js', array( 'jquery', 'backbone' ) );
        wp_enqueue_script( 'nf-front-end', Ninja_Forms::$url . 'assets/js/front-end/main.js', array( 'jquery', 'backbone', 'requirejs', 'jquery-form' ) );

        wp_localize_script( 'nf-front-end', 'nfFrontEnd', array( 'ajaxNonce' => wp_create_nonce( 'ninja_forms_ajax_nonce' ), 'adminAjax' => admin_url( 'admin-ajax.php' ), 'requireBaseUrl' => Ninja_Forms::$url . 'assets/js/' ) );
    }

    public static function localize_preview( $form_id )
    {
        add_action( 'wp_footer', 'NF_Display_Render::output_templates', 9999 );

        $form = get_user_option( 'nf_form_preview_' . $form_id );

        if( ! $form ){
            self::localize( $form_id );
            return;
        }

        $form[ 'settings' ][ 'is_preview' ] = TRUE;

        $fields = array();

        foreach( $form['fields'] as $field_id => $field ){

            $field['settings'][ 'id' ] = $field_id;

            $field = apply_filters( 'nf_localize_fields_preview', $field );

            $field_class = $field['settings']['type'];

            $field_class = Ninja_Forms()->fields[ $field_class ];

            $fields[] = $field['settings'];

            self::load_template( 'fields-' . $field_class::TEMPLATE );
        }

        // Output Form Container
        ?>
        <div id="nf-form-<?php echo $form_id; ?>-cont"></div>
        <?php

        ?>
        <!-- TODO: Move to Template File. -->
        <script>
            // Maybe initialize nfForms object
            var nfForms = nfForms || [];

            // Build Form Data
            var form = [];
            form.id = <?php echo $form['id']; ?>;
            form.settings = JSON.parse( '<?php echo WPN_Helper::addslashes( wp_json_encode( $form['settings'] ) ); ?>' );

            form.fields = JSON.parse( '<?php echo WPN_Helper::addslashes( wp_json_encode(  $fields ) ); ?>' );

            // Add Form Data to nfForms object
            nfForms.push( form );
        </script>

        <!-- TODO: Move to Stylesheet. -->
        <style>
            .nf-error input {
                border-color: red;
            }
            .nf-error-msg {
                color:red;
            }
            .nf-element.disabled {
                opacity: 0.3;
            }
            .nf-pass .nf-element {
                /*border: 2px solid green;*/
                background: url( 'https://cdn0.iconfinder.com/data/icons/round-ui-icons/512/tick_green.png' ) no-repeat;
                background-position: 99.5% 60%;
                background-size: 35px 35px;
                /*background: url( 'https://cdn0.iconfinder.com/data/icons/iconsweets2/40/email_envelope.png' ) 0 no-repeat;*/
            }
            .nf-fail .nf-element {
                /*border: 2px solid red;*/
                background: url( 'https://cdn1.iconfinder.com/data/icons/toolbar-signs/512/cancel-512.png' ) no-repeat;
                background-position: 99% 60%;
                background-size: 30px 30px;
                /*background: url( 'https://cdn0.iconfinder.com/data/icons/iconsweets2/40/email_envelope.png' ) 0 no-repeat;*/
            }
            .nf-file-progress {
                position:relative;
                width:400px;
                border: 1px solid #ddd;
                padding: 1px;
                border-radius: 3px;
            }
            .nf-file-bar {
                background-color: #B4F5B4;
                width:0%;
                height:20px;
                border-radius: 3px;
            }
            .nf-file-percent {
                position:absolute;
                display:inline-block;
                top:3px;
                left:48%;
            }
            ​.nf-files-table {
                border-collapse: collapse;
                width: 100%;
            }
            .nf-files-table td {
                border-top: 1px solid #ccc;
                padding: 10px;
            }
            .nf-files-table tr:last-child td {
                border-bottom: 1px solid #ccc;
            }
            .nf-files-table tr:nth-child(odd) td {
                background: #fff;
            }
            .nf-files-table tr:nth-child(even) td {
                background: #f1f1f1;
            }
        </style>

        <?php

        wp_enqueue_style( 'nf-display-structure', Ninja_Forms::$url . 'assets/css/display-structure.css' );
        wp_enqueue_style( 'nf-display-opinions', Ninja_Forms::$url . 'assets/css/display-opinions.css' );

        wp_enqueue_script( 'backbone-marionette', Ninja_Forms::$url . 'assets/js/lib/backbone.marionette.min.js', array( 'jquery', 'backbone' ) );
        wp_enqueue_script( 'backbone-radio', Ninja_Forms::$url . 'assets/js/lib/backbone.radio.min.js', array( 'jquery', 'backbone' ) );

        wp_enqueue_script( 'requirejs', Ninja_Forms::$url . 'assets/js/lib/require.js', array( 'jquery', 'backbone' ) );
        wp_enqueue_script( 'nf-front-end', Ninja_Forms::$url . 'assets/js/front-end/main.js', array( 'jquery', 'backbone', 'requirejs', 'jquery-form' ) );

        wp_localize_script( 'nf-front-end', 'nfFrontEnd', array( 'ajaxNonce' => wp_create_nonce( 'ninja_forms_ajax_nonce' ), 'adminAjax' => admin_url( 'admin-ajax.php' ), 'requireBaseUrl' => Ninja_Forms::$url . 'assets/js/' ) );

    }


    public static function output_templates()
    {
        // Build File Path Hierarchy
        $file_paths = apply_filters( 'nf_field_template_file_paths', array(
            get_template_directory() . '/ninja-forms/templates/',
        ));

        $file_paths[] = Ninja_Forms::$dir . 'includes/Templates/';

        // Search for and Output File Templates
        foreach( self::$loaded_templates as $file_name ) {

            foreach( $file_paths as $path ){

                if( file_exists( $path . "$file_name.html" ) ){
                    echo file_get_contents( $path . "$file_name.html" );
                    break;
                }
            }
        }

        ?>
        <script>
            var post_max_size = '<?php echo WPN_Helper::string_to_bytes( ini_get('post_max_size') ); ?>';
            var upload_max_filesize = '<?php echo WPN_Helper::string_to_bytes( ini_get( 'upload_max_filesize' ) ); ?>';
            var wp_memory_limit = '<?php echo WPN_Helper::string_to_bytes( WP_MEMORY_LIMIT ); ?>';
        </script>
        <?php

        // Action to Output Custom Templates
        do_action( 'nf_output_templates' );
    }

    protected static function load_template( $file_name = '' )
    {
        if( ! $file_name ) return;

        if( self::is_template_loaded( $file_name ) ) return;

        self::$loaded_templates[] = $file_name;
    }

    /*
     * UTILITY
     */

    protected static function is_template_loaded( $template_name )
    {
        return ( in_array( $template_name, self::$loaded_templates ) ) ? TRUE : FALSE ;
    }

} // End Class NF_Display_Render
