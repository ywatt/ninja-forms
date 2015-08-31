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

    public function __construct( $db, $id )
    {
        $this->_db = $db;

        $this->_form = new NF_Database_Models_Form( $id );

        return $this;
    }

    public function get()
    {
        return $this->_form;
    }

    public function get_field( $id )
    {
        $form_id = $this->_form->get_id();

        return $this->_fields[ $id ] = new NF_Database_Models_Field( $this->_db, $id, $form_id );
    }

    public function get_fields()
    {
        return $this->_fields;
    }

    public function get_action( $id )
    {
        $form_id = $this->_form->get_id();

        return $this->_actions[ $id ] = new NF_Database_Models_Action( $this->_db, $id, $form_id );
    }

    public function get_actions()
    {
        return $this->_actions;
    }

} // End Class NF_Abstracts_ModelFactory
