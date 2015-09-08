<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Display_Render
{
    protected $_templates = array();

    public function __construct()
    {

    }

    /*
     * UTILITY
     */

    protected function is_template_loaded( $template_name )
    {
        return ( in_array( $template_name, array_keys( $this->_templates ) ) ) ? TRUE : FALSE ;
    }

} // End Class NF_Display_Render
