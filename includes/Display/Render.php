<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Display_Render
{
    public static $loaded_templates = array(
        'layout',
        'before-form',
        'form-layout',
        'field-wrap',
        'label',
        'error',
        'after-form',
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

            self::load_template( $field_class::TEMPLATE );

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
        <?php

    }

    public static function output_templates()
    {
        $file_paths = apply_filters( 'ninja_forms_field_template_file_paths', array(
            get_template_directory() . '/ninja-forms/templates/',
        ));

        $file_paths[] = Ninja_Forms::$dir . 'includes/Templates/';

        foreach( self::$loaded_templates as $name ) {

            foreach( $file_paths as $path ){

                if( file_exists( $path . "fields-$name.html" ) ){
                    echo file_get_contents( $path . "fields-$name.html" );
                    break;
                }
            }
        }
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
