<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_ModelFactory
 */
class NF_Abstracts_ModelFactory
{
    protected $_db;

    protected $_object;

    protected $_fields = array();

    protected $_actions = array();

    protected $_objects = array();

    public function __construct( $db, $id )
    {
        $this->_db = $db;

        if( $id ) {
            $this->_object = new NF_Database_Models_Form( $id );
        }

        return $this;
    }

    public function get()
    {
        return $this->_object;
    }

    public function field( $id = '' )
    {
        $this->_object = new NF_Database_Models_Field( $this->_db, $id );
    }

    public function get_field( $id )
    {
        $form_id = $this->_object->get_id();

        return $this->_fields[ $id ] = new NF_Database_Models_Field( $this->_db, $id, $form_id );
    }

    public function get_fields()
    {
        return $this->_fields;
    }

    public function action( $id = '' )
    {
        $this->_object = new NF_Database_Models_Action( $this->_db, $id );
    }

    public function get_action( $id )
    {
        $form_id = $this->_object->get_id();

        return $this->_actions[ $id ] = new NF_Database_Models_Action( $this->_db, $id, $form_id );
    }

    public function get_actions()
    {
        return $this->_actions;
    }

    public function object( $id )
    {
        $this->_object = new NF_Database_Models_Object( $this->_db, $id );
    }

    public function get_object( $id )
    {
        $parent_id = $this->_object->get_id();

        return $this->_objects[ $id ] = new NF_Database_Models_Object( $this->_db, $id, $parent_id );
    }

    public function get_objects()
    {
        return $this->_objects;
    }


} // End Class NF_Abstracts_ModelFactory
