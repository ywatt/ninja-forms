<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Display_Render
{
    protected $_templates = array();

    public function __construct()
    {
        $this->template( 'fields-input' );
        $this->template( 'fields-checkbox' );
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
