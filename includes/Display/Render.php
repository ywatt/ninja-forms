<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Display_Render
{
    protected static $field_templates = array(
        'wrap',
        'label',
        'error',
    );

    protected static $app_templates = array(
        'layout',
        'before-form',
        'after-form',
    );

    protected static $form_templates = array(
        'layout',
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
            $field_class = $field->get_settings( 'type' );
            $field_class = Ninja_Forms()->fields[ $field_class ];

            $field->update_setting( 'value', time() );
            $field->update_setting( 'id', $field->get_id() );

            $fields[] = $field->get_settings();

            self::load_field_template( $field_class::TEMPLATE );

        }

        // Output Form Container
        ?>
            <div id="nf-form-<?php echo $form_id; ?>-cont">
                Form Container, Ya'll!
            </div>
        <?php

        ?>
        <script>
            // Maybe initialize nfForms object
            var nfForms = nfForms || [];

            // Build Form Data
            var form = [];
            form.id = <?php echo $form_id; ?>;
            form.settings = JSON.parse( '<?php echo wp_json_encode( $form->get_settings() ); ?>' );

            form.fields = JSON.parse( '<?php echo wp_json_encode( $fields ); ?>' );

            // Add Form Data to nfForms object
            nfForms.push( form );
        </script>

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

            .nf-file-progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
            .nf-file-bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
            .nf-file-percent { position:absolute; display:inline-block; top:3px; left:48%; }

        </style>
        <?php

        wp_enqueue_script( 'backbone-marionette', Ninja_Forms::$url . 'assets/js/lib/backbone.marionette.min.js', array( 'jquery', 'backbone' ) );
        wp_enqueue_script( 'backbone-radio', Ninja_Forms::$url . 'assets/js/lib/backbone.radio.min.js', array( 'jquery', 'backbone' ) );
        
        wp_enqueue_script( 'requirejs', Ninja_Forms::$url . 'assets/js/lib/require.js', array( 'jquery', 'backbone' ) );
        wp_enqueue_script( 'nf-front-end', Ninja_Forms::$url . 'assets/js/front-end/main.js', array( 'jquery', 'backbone', 'requirejs', 'jquery-form' ) );

        wp_localize_script( 'nf-front-end', 'nfFrontEnd', array( 'ajaxNonce' => wp_create_nonce( 'ninja_forms_ajax_nonce' ), 'adminAjax' => admin_url( 'admin-ajax.php' ), 'requireBaseUrl' => Ninja_Forms::$url . 'assets/js/' ) );
    }

    public static function output_templates()
    {
        $file_paths = apply_filters( 'ninja_forms_field_template_file_paths', array(
            get_template_directory() . '/ninja-forms/templates/',
        ));

        $file_paths[] = Ninja_Forms::$dir . 'includes/Templates/';

        self::output_app_templates( $file_paths );

        self::output_form_templates( $file_paths );

        self::output_field_templates( $file_paths );

        do_action( 'nf_output_templates' );
    }

    protected  static function output_app_templates( $file_paths )
    {
        foreach( self::$app_templates as $name ) {

            foreach( $file_paths as $path ){

                if( file_exists( $path . "app-$name.html" ) ){
                    echo file_get_contents( $path . "app-$name.html" );
                    break;
                }
            }
        }
    }

    protected  static function output_form_templates( $file_paths )
    {
        foreach( self::$form_templates as $name ) {

            foreach( $file_paths as $path ){

                if( file_exists( $path . "form-$name.html" ) ){
                    echo file_get_contents( $path . "form-$name.html" );
                    break;
                }
            }
        }
    }

    protected  static function output_field_templates( $file_paths )
    {
        foreach( self::$field_templates as $name ) {

            foreach( $file_paths as $path ){

                if( file_exists( $path . "fields-$name.html" ) ){
                    echo file_get_contents( $path . "fields-$name.html" );
                    break;
                }
            }
        }
    }

    protected static function load_field_template( $file_name = '' )
    {
        if( ! $file_name ) return;

        if( self::is_field_template_loaded( $file_name ) ) return;

        self::$field_templates[] = $file_name;
    }

    /*
     * UTILITY
     */

    protected static function is_field_template_loaded( $template_name )
    {
        return ( in_array( $template_name, self::$field_templates ) ) ? TRUE : FALSE ;
    }

} // End Class NF_Display_Render
