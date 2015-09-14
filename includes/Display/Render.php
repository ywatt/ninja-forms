<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Display_Render
{
    protected $_form = '';

    protected $_templates = array();

    public function __construct( $form_id = 1 )
    {
        $this->_form = Ninja_Forms()->form( $form_id );

        $fields = Ninja_Forms()->form( $form_id )->get_fields();

        foreach( $fields as $field ){
            $field_class = $field->get_settings( 'field_class' );
            $field_class = Ninja_Forms()->fields[ $field_class ];

            $this->template( 'fields-' . $field_class::TEMPLATE );
        }
    }

    protected function template( $file_name = '' )
    {
        if( ! $file_name ) return;

        Ninja_Forms::template( $file_name, '.html' );
    }

    /*
     * UTILITY
     */

    protected function is_template_loaded( $template_name )
    {
        return ( in_array( $template_name, array_keys( $this->_templates ) ) ) ? TRUE : FALSE ;
    }

} // End Class NF_Display_Render
