<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_ModelFactory
 */
class NF_Abstracts_ModelFactory
{
    protected $_db;

    protected $_form;

    protected $_fields = array();

    protected $_actions = array();

    public function __construct( $db )
    {
        $this->_db = $db;
    }

    public function form( $id )
    {
        $this->_form = new NF_Database_Models_Form( $id );

        return $this;
    }

    public function get_form( $id )
    {
        return $this->_form = new NF_Database_Models_Form( $id );
    }

    public function get_field( $id )
    {
        $form_id = $this->_form->get_id();

        return $this->_fields[ $id ] = new NF_Database_Models_Field( $id, $form_id );
    }

    public function get_fields()
    {
        return $this->_fields;
    }

    public function get_action( $id )
    {
        $form_id = $this->_form->get_id();

        return $this->_actions[ $id ] = new NF_Database_Models_Action( $id, $form_id );
    }

    public function get_actions()
    {
        return $this->_actions;
    }

} // End Class NF_Abstracts_ModelFactory

//function NF()
//{
//    return new NF_ModelFactory();
//}

// NF()->get_form( 1 );
// NF()->form( 1 )->get_fields();
// NF()->form( 1 )->get_field( 2 );
// NF()->form( 1 )->get_actions();
// NF()->form( 1 )->get_action( 3 );