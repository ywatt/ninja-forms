<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Display_Render
{
    public static $loaded_templates = array();

    public static function localize( $form_id )
    {
        $form = Ninja_Forms()->form( $form_id )->get();

        ?>

            <div id="nf_form_<?php echo $form_id; ?>"></div>

        <?php

        ?>
        <script>
            var form_<?php echo $form_id; ?> = JSON.parse( '<?php echo json_encode( $form->get_settings() ); ?>' );
            form_<?php echo $form_id; ?>.fields = [];
        </script>
        <?php

        $fields = Ninja_Forms()->form( $form_id )->get_fields();

        foreach( $fields as $field ){
            $field_class = $field->get_settings( 'type' );
            $field_class = Ninja_Forms()->fields[ $field_class ];

            ?>
            <script>
                var field = JSON.parse( '<?php echo json_encode( $field->get_settings() ); ?>' );
                form_<?php echo $form_id; ?>.fields.push( field );
            </script>
            <?php

            self::template( $field_class::TEMPLATE );
        }
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
