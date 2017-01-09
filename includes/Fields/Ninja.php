<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Ninja
 */
class NF_Fields_Ninja extends NF_Abstracts_Input
{
    protected $_name = 'ninja';

    protected $_type = 'ninja';

    protected $_section = '';

    // protected $_icon = '';

    protected $_templates = 'ninja';

    protected $_settings_only = array( 'classes' );

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Ninja', 'ninja-forms' );
        add_filter( 'nf_sub_hidden_field_types', array( $this, 'hide_field_type' ) );
    }

    function hide_field_type( $field_types )
    {
        $field_types[] = $this->_name;

        return $field_types;
    }

}
