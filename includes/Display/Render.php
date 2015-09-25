<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Display_Render
{
    public static $loaded_templates = array();

    public static function localize( $form_id )
    {
        $form = Ninja_Forms()->form( $form_id )->get();

        $form_fields = Ninja_Forms()->form( $form_id )->get_fields();

        $fields = array();

        foreach( $form_fields as $field ){
            $field_class = $field->get_settings( 'type' );
            $field_class = Ninja_Forms()->fields[ $field_class ];

            $field->update_setting( 'value', time() );
            $field->update_setting( 'id', $field->get_id() );

            $fields[] = $field->get_settings();

            self::template( $field_class::TEMPLATE );

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

    protected static function template( $file_name = '' )
    {
        if( ! $file_name ) return;

        if( self::is_template_loaded( $file_name ) ) return;

        Ninja_Forms::template( 'fields-' . $file_name, '.html' );
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
